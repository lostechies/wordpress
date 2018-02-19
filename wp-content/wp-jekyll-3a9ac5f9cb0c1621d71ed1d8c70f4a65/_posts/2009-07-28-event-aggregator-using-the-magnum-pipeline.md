---
id: 57
title: Event Aggregator Using the Magnum Pipeline
date: 2009-07-28T05:11:39+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/07/28/event-aggregator-using-the-magnum-pipeline.aspx
permalink: /2009/07/28/event-aggregator-using-the-magnum-pipeline/
dsq_thread_id:
  - "262089360"
categories:
  - .net
---
In the past few weeks, both [Udi Dahan](http://www.udidahan.com/2009/06/14/domain-events-salvation/) and [Jeremy D. Miller](http://codebetter.com/blogs/jeremy.miller/archive/2009/07/23/how-i-m-using-the-event-aggregator-pattern-in-storyteller.aspx) have posted on events. Udi posted about domain events, while Jeremy posted about his use of the event aggregator pattern in StoryTeller. In each case, events are represented as messages and each message is a class in C#. And in each post, a small publish/subscribe system is described that allowed objects (be it a domain object, domain service, or a controller) to subscribe to messages. Other objects could then use that same system to publish events to the subscribed objects.

Now while you could use [MassTransit](http://code.google.com/p/masstransit/) out of the box to handle this type of event aggregation, it is a bit heavy. The in-memory message transport serializes the message, which makes it impossible to pass a continuation or an object reference as part of an event. There is also a very service-oriented thread model where each consumer runs on a different thread making synchronization an important concern for unit testing. While it would work, it is not always the shiniest hammer in the toolbox for UI-based application.

To address this, one of the things I&#8217;ve been adding to [Magnum](http://code.google.com/p/magnum/) over the past few weeks is a new version of the pipeline that handles message distribution in MassTransit. In this implementation, I wanted a way to implement the event aggregator pattern with the same flexibility that I get with MassTransit but designed for an in-process mode of execution. At the same time, I wanted to make sure that I could scale this solution via adapters to extend events to MassTransit for publishing out-of-process.

_Note, I use the word event and message interchangeably in this post._

First, I wanted it to be able to handle any object without any constraints on the type. To this end, I came up with a very narrow API that only deals with the publishing of a message.

<pre>public interface Pipe
{
	void Send(T message) where T : class;
}
</pre>

The **Send** method is fairly obvious, it is used to send a message to any consumers that are subscribed to the message. With this implementation, consumers that are subscribed to any type to which the message can be assigned will also get the message. Consider the following class structure:

<pre>public class CustomerChanged
{
	public Customer Customer { get; set; }
}

public class CustomerRatingDowngraded : 
	CustomerChanged
{
}
</pre>

A consumer that subscribed to the _CustomerChanged_ type would receive the message if a _CustomerRatingDowngraded_ message was published. It also works for interfaces, as long as the message object being published supports the interface.

An obvious omission from this API is any method of subscribing consumers to the pipeline. To subscribe to the pipeline, an extension method on the _Pipe_ interface creates a new subscription scope. A subscription scope, represented by the _ISubscriptionScope_ interface, makes changes to the pipeline resulting in the creation of a new pipeline. A series of visitors are used to create a new version of the pipeline with the consumers added, along with another visitor to remove the consumers when they unsubscribe. ISubscriptionScope implements _IDisposable_ so to unsubscribe your application can just dispose of the object.

It is interesting to note that much like the Expression class in .NET, pipelines are immutable. Since pipelines cannot be changed, the need to lock parts of the pipeline during message distribution is removed. By removing the need for locking to ensure safe operation in a concurrent environment, performance improves and blocking is eliminated. At the same time, consumers can subscribe and unsubscribe from the pipeline as needed without disrupting the system.

<pre>public void Start()
{
	// this creates an empty pipeline that accepts any object
	_eventAggregator=PipeSegment.Input(PipeSegment.End());

	_scope=_eventAggregator.NewSubscriptionScope();
	_scope.Subscribe(message=&gt;Trace.WriteLine("Customer changed: "+message.CustomerName));
}
</pre>

In this example, pipe and scope would likely be member variables that would be released when the containing object is stopped or disposed. Multiple subscriptions can be added to a single scope, each one modifying the pipeline as it is added.

When I discuss event-based programming, I often mention the need for visualization tools in order to ensure the system is performing as expected. In the example above, I could use the TracePipeVisitor to verify that the consumer was indeed subscribed to the pipeline (by calling new TracePipeVisitor() .Trace(_eventAggregator) and viewing the results in the output window).

<pre>Input: 
RecipientList: 
     Filter: Allow Magnum.Specs.Pipeline.Messages.CustomerChanged
     RecipientList: 
          MessageConsumer: 
</pre>

As consumers are added, the pipeline is built up using a series of PipeSegment classes. The Input segment is the initial entry point to the pipeline and by having the responsibility is the only segment that actually changes in the pipeline. The RecipientList is a one-to-many switch that delivers incoming messages to each consumer. The Filter segment only passes a specific type through the filter, preventing unwanted messages from receiving the consumer. The MessageConsumer actually invokes the method that was subscribed to the message.

In the above example, the message consumer was accepted using the MessageConsumer delegate type, which is analogous to Action with T being the message type. Another way to subscribe is to implement the IConsume method as shown below.

<pre>public class ListViewController :
	IConsume
{
	public ListViewController(ListView customerListView)
	{
		_customerListView = customerListView;
	}
	public void Consume(CustomerChanged message)
	{
		_customerListView.DoSomeUpdate(message.Customer);
	}
}
</pre>

A class can implement the IConsume method to indicate that it is interested in messages of type T. In this case, the CustomerChanged message is of particular interest as it is used to update the user interface in response to a customer change event. The instance of the controller can be subscribed to the pipeline by calling the Subscribe method passing the object reference itself.

<pre>public void BootstrapUserInterfaceControllers()
{
	_customerListViewController = new ListViewController(customerListView);

	_scope=_eventAggregator.NewSubscriptionScope();
	_scope.Subscribe(_customerListViewController);
}
</pre>

This is the first in a series of posts about the pipeline in Magnum. As I add the remaining functionality, including asynchronous message consumers, aggregate consumers, and automatic binding to the Magnum StateMachine (similar to how sagas are done using MassTransit), I&#8217;ll post about how they are used. I encourage you to [take a look at the code](http://code.google.com/p/magnum/) and particularly the unit tests to see the different ways the pipeline can be used.