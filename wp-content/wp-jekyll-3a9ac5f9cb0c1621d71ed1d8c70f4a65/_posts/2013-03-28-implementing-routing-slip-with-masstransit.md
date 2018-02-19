---
id: 106
title: Implementing Routing Slip with MassTransit
date: 2013-03-28T18:49:00+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=106
permalink: /2013/03/28/implementing-routing-slip-with-masstransit/
dsq_thread_id:
  - "1171683799"
dsq_needs_sync:
  - "1"
categories:
  - masstransit
---
_This article introduces [MassTransit.Courier](https://github.com/MassTransit/MassTransit-Courier), a new project that implements the routing slip pattern on top of [MassTransit](http://masstransit-project.com/), a free, [open-source](https://github.com/MassTransit/MassTransit), and lightweight message bus for the .NET platform._

## Introduction

When sagas were originally conceived in MassTransit, they were inspired by an [excerpt](http://rgoarchitects.bit.ly/4xNwpp) from Chapter 5 in the book [SOA Patterns](http://www.manning.com/rotem/) by [Arnon Rotem-Gal Oz](http://arnon.me/). Over the past few months, the community has <s>argued</s> discussed how the use of the word saga has led to confusion and how early implementations included in both NServiceBus and MassTransit do not actually align with the [original paper](http://www.cs.cornell.edu/andru/cs711/2002fa/reading/sagas.pdf) published in 1987 by Princeton University and written by Hector Garcia-Molina and Kenneth Salem in which the term was coined.

With MassTransit Courier, the intent is to provide a mechanism for creating and executing distributed transactions with fault compensation that can be used alongside the existing MassTransit sagas for monitoring and recovery.

## Background

Over the past few years building distributed systems using MassTransit, a pattern I consistently see repeated is the orchestration of multiple services into a single business transaction. Using the existing MassTransit saga support to manage the state of the transaction, the actual processing steps are created as autonomous services that are invoked by the saga using command messages. Command completion is observed using an event or response message by the saga, at which point the next processing step is invoked. When the saga has invoked the final service the business transaction is complete.

As the processing required within a business transaction changes with evolving business requirements, a new version of the saga is required that includes the newly created processing steps. Knowledge of the new services becomes part of the saga, as well as the logic to identify which services need to be invoked for each transaction. The saga becomes rich with knowledge, and with great knowledge comes great responsibility (after all, knowledge is power right?). Now, instead of only orchestrating the transaction, the saga is responsible for identifying which services to invoke based on the content of the transaction. Another concern was the level of database contention on the saga tables. With every service invocation being initiated by the saga, combined with the saga observing service events and responses, the saga tables gets very busy.

Beyond the complexity of increasing saga responsibilities, more recently the business has requested the ability to selectively route a message through a series of services based on the content of the message. In addition to being able to dynamically route messages, the business needs to allow new services to be created and added to the inventory of available services. And this should be possible without modifying a central control point that dispatches messages to each service.

Like most things in computer science, this problem has already been solved.

## The Routing Slip Pattern

A routing slip specifies a sequence of processing steps for a message. As each processing step completes, the routing slip is forwarded to the next step. When all the processing steps have completed, the routing slip is complete.

A key advantage to using a routing slip is it allows the processing steps to vary for each message. Depending upon the content of the message, the routing slip creator can selectively add processing steps to the routing slip. This dynamic behavior is in contrast to a more explicit behavior defined by a state machine or sequential workflow that is statically defined (either through the use of code, a DSL, or something like Windows Workflow).

## MassTransit Courier

MassTransit Courier is a framework that implements the routing slip pattern. Leveraging a durable messaging transport and the advanced saga features of MassTransit, MassTransit Courier provides a powerful set of components to simplify the use of routing slips in distributed applications. Combining the routing slip pattern with a [state machine such as Automatonymous](https://github.com/phatboyg/Automatonymous) results in a reliable, recoverable, and supportable approach for coordinating and monitoring message processing across multiple services.

In addition to the basic routing slip pattern, MassTransit Courier also supports [compensations](http://en.wikipedia.org/wiki/Compensation_%28engineering%29) which allow processing steps to store process-related data so that reversible operations can be undone, using either a traditional rollback mechanism or by applying an offsetting operation. For example, a processing step that holds a seat for a patron could release the held seat when compensated.

MassTransit Courier is free software and is covered by the same open source license as MassTransit (Apache 2.0). You can install [MassTransit.Courier](https://github.com/MassTransit/MassTransit-Courier) into your existing solution using [NuGet](http://nuget.org/packages/masstransit.courier).

## Activities

In MassTransit Courier, an _Activity_ refers to a processing step that can be added to a routing slip. To create an activity, create a class that implements the _Activity_ interface.

    public class DownloadImageActivity :
        Activity<DownloadImageArguments, DownloadImageLog>
    {
    }
    

The _Activity_ interface is generic with two arguments. The first argument specifies the activity’s input type and the second argument specifies the activity’s log type. In the example shown above, _DownloadImageArguments_ is the input type and _DownloadImageLog_ is the log type. Both arguments must be interface types so that the implementations can be dynamically created.

### Implementing an Activity

An activity must implement two interface methods, _Execute_ and _Compensate_. The _Execute_ method is called while the routing slip is executing activities and the _Compensate_ method is called when a routing slip faults and needs to be compensated.

When the _Execute_ method is called, an _execution_ argument is passed containing the activity arguments, the routing slip _TrackingNumber_, and methods to mark the activity as completed or faulted. The actual routing slip message, as well as any details of the underlying infrastructure, are excluded from the _execution_ argument to prevent coupling between the activity and the implementation. An example _Execute_ method is shown below.

    ExecutionResult Execute(Execution<DownloadImageArguments> execution)
    {
        DownloadImageArguments args = execution.Arguments;
        string imageSavePath = Path.Combine(args.WorkPath, 
            execution.TrackingNumber.ToString());
    
        _httpClient.GetAndSave(args.ImageUri, imageSavePath);
    
        return execution.Completed(new DownloadImageLogImpl(imageSavePath));
    }
    

Once activity processing is complete, the activity returns an _ExecutionResult_ to the host. If the activity executes successfully, the activity can elect to store compensation data in an activity log which is passed to the _Completed_ method on the _execution_ argument. If the activity chooses not to store any compensation data, the activity log argument is not required. In addition to compensation data, the activity can add or modify variables stored in the routing slip for use by subsequent activities.

> In the example above, the activity creates an instance of a private class that implements the _DownloadImageLog_ interface and stores the log information in the object properties. The object is then passed to the _Completed_ method for storage in the routing slip before sending the routing slip to the next activity. 

When an activity fails, the _Compensate_ method is called for previously executed activities in the routing slip that stored compensation data. If an activity does not store any compensation data, the _Compensate_ method is never called. The compensation method for the example above is shown below.

    CompensationResult Compensate(Compensation<DownloadImageLog> compensation)
    {
        DownloadImageLog log = compensation.Log;
        File.Delete(log.ImageSavePath);
    
        return compensation.Compensated();
    }
    

Using the activity log data, the activity compensates by removing the downloaded image from the work directory. Once the activity has compensated the previous execution, it returns a _CompensationResult_ by calling the _Compensated_ method. If the compensating actions could not be performed (either via logic or an exception) and the inability to compensate results in a failure state, the _Failed_ method can be used instead, optionally specifying an _Exception_.

## Building a Routing Slip

Developers are discouraged from directly implementing the _RoutingSlip_ message type and should instead use a _RoutingSlipBuilder_ to create a routing slip. The _RoutingSlipBuilder_ encapsulates the creation of the routing slip and includes methods to add activities, activity logs, and variables to the routing slip. For example, to create a routing slip with two activities and an additional variable, a developer would write:

    var builder = new RoutingSlipBuilder(NewId.NextGuid());
    builder.AddActivity(“DownloadImage”, “rabbitmq://localhost/execute_downloadimage”, new
        {
            ImageUri = new Uri(“http://images.google.com/someImage.jpg”)
        });
    builder.AddActivity(“FilterImage”, “rabbitmq://localhost/execute_filterimage”);
    builder.AddVariable(“WorkPath”, “\\dfs\work”);
    
    var routingSlip = builder.Build();
    

Each activity requires a name for display purposes and a URI specifying the execution address. The execution address is where the routing slip should be sent to execute the activity. For each activity, arguments can be specified that are stored and presented to the activity via the activity arguments interface type specify by the first argument of the _Activity_ interface. The activities added to the routing slip are combined into an _Itinerary_, which is the list of activities to be executed, and stored in the routing slip.

> Managing the inventory of available activities, as well as their names and execution addresses, is the responsibility of the application and is not part of the MassTransit Courier. Since activities are application specific, and the business logic to determine which activities to execute and in what order is part of the application domain, the details are left to the application developer.

Once built, the routing slip is executed, which sends it to the first activity’s execute URI. To make it easy and to ensure that source information is included, an extension method to _IServiceBus_ is available, the usage of which is shown below.

    bus.Execute(routingSlip); // pretty exciting, eh?
    

It should be pointed out that if the URI for the first activity is invalid or cannot be reached, an exception will be thrown by the _Execute_ method.

## Hosting Activities in MassTransit

To host an activity in a MassTransit service bus instance, the configuration namespace has been extended to include two additional subscription methods (thanks to the power of extension methods and a flexible configuration syntax, no changes to MassTransit were required). Shown below is the configuration used to host an activity.

    var executeUri = new Uri(“rabbitmq://localhost/execute_example”);
    var compensateUri = new Uri(“rabbitmq://localhost/compensate_example”);
    
    IServiceBus compensateBus = ServiceBusFactory.New(x =>
        {
            x.ReceiveFrom(compensateUri);
            x.Subscribe(s => s.CompensateActivityHost<ExampleActivity, ExampleLog>(
                _ => new ExampleActivity());
        });
    
    IServiceBus executeBus = ServiceBusFactory.New(x =>
        {
            x.ReceiveFrom(executeUri);
            x.Subscribe(s => s.ExecuteActivityHost<ExampleActivity, ExampleArguments>(
                compensateUri,
                 _ => new ExampleActivity());
        });
    

In the above example two service bus instances are created, each with their own input queue. For execution, the routing slip is sent to the execution URI, and for compensation the routing slip is sent to the compensation URI. The actual URIs used are up to the application developer, the example merely shows the recommended approach so that the two addresses are easily distinguished. The URIs **must** be different!

## Monitoring Routing Slips

During routing slip execution, events are published when the routing slip completes or faults. Every event message includes the _TrackingNumber_ as well as a _Timestamp_ (in UTC, of course) indicating when the event occurred:

  * RoutingSlipCompleted
  * RoutingSlipFaulted
  * RoutingSlipCompensationFailed

Additional events are published for each activity, including:

  * RoutingSlipActivityCompleted
  * RoutingSlipActivityFaulted
  * RoutingSlipActivityCompensated
  * RoutingSlipActivityCompensationFailed

By observing these events, an application can monitor and track the state of a routing slip. To maintain the current state, an Automatonymous state machine could be created. To maintain history, events could be stored in a database and then queried using the _TrackingNumber_ of the _RoutingSlip_.

## Wrapping Up

MassTransit Courier is a great way to compose dynamic processing steps into a routing slip that can be executed, monitored, and compensated in the event of a fault. When used in combination with the existing saga features of MassTransit, it is possible to coordinate a distributed set of services into a reliable and supportable system.