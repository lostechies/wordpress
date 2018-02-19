---
id: 118
title: MassTransit 3 API Changes
date: 2015-02-24T00:28:36+00:00
author: Chris Patterson
layout: post
guid: https://lostechies.com/chrispatterson/?p=118
permalink: /2015/02/24/masstransit-3-api-changes/
dsq_thread_id:
  - "3852075261"
categories:
  - masstransit
---
[When MassTransit 3 was announced](http://blog.phatboyg.com/2014/11/30/masstransit/), it was also stated that many of the APIs have changed. This post covers some of the most data types, and describes how they are used as well as how they compare to previous version. In addition, the conceptual changes of MassTransit 3 will also be shared.

## The Bus and Receive Endpoints

In MassTransit 3, a bus is a logical construct which connects to one or more hosts via a single message transport, either RabbitMQ or Azure Service Bus. A bus may include multiple receive endpoints in which each receiving endpoint is connected to a separate queue.

> Previous versions of MassTransit only supported a single queue per service bus (which was configured using the ReceiveFrom method).

To support the configuration of receive endpoints, as well as advanced configuration specific to each transport, bus creation has changed. The shortest code to create a bus is shown below.

    var hostAddress = new Uri("rabbitmq://localhost/test_virtual_host"); IBusControl bus = Bus.Factory.CreateUsingRabbitMq(x => { x.Host(hostAddress, h => { h.Username("test"); h.Password("password"); }); }); 

> Previous versions of MassTransit created a service bus using `ServiceBusFactory.New`.

The bus created above has no receive endpoints. However, if a request is sent to an endpoint using the bus&#8217;s address as the return address, a temporary queue is created to receive the response. The bus&#8217;s queue name is assigned by the broker (in the case of RabbitMQ, for Azure the name can be specified or dynamically generated).

> HINT: Don&#8217;t write a log message to display the bus&#8217;s address! Merely accessing the address property results in the creation of the temporary queue! How&#8217;s that for an awesome side effect! This should probably change to `Task<Uri> GetBusAddress()` to signal the impact of using it!

### IBus (so long IServiceBus)

In MassTransit 3, `IBus` refers to a bus instance. A bus includes methods to obtain send endpoints, as well as publish messages.

> Previously `IServiceBus` was used, but there were significant changes to the method signatures with dangerous implications from improper use (many methods now return a `Task` and execute asynchronously). Therefore, changing the interface to `IBus` was decided to be the best approach to avoid confusing bugs when upgrading existing services.

    public interface IBus { // the address of the bus, which is dynamically created and exclusive // to the bus instance Uri Address { get; } // return a send endpoint for the specified address Task<ISendEndpoint> GetSendEndpoint(Uri address); // publish a message on the bus, using the publish conventions of the // underlying transport (8+ overloads for customizing) Task Publish<T>(T message, CancellationToken cancellationToken); } 

## Starting the Bus

Once a bus is created, an `IBusControl` interface is returned. The `IBusControl` interface includes `IBus` and adds the `Start` method.

    public interface IBusControl : IBus { // start the bus, as well as any configured receive endpoints Task<BusHandle> Start(CancellationToken cancellationToken); } 

When the application is ready to start the bus, the `Start` method should be called. This method returns a `BusHandle` which should be retained until the bus needs to be stopped.

    BusHandle busHandle = await bus.Start(cancellationToken); // application runs, then it's time to stop the service await busHandle.Stop(); 

## Consumers

A _consumer_ is a class that handles (or in this case, consumes) one or more message types. When a message is read from a queue, an instance of the consumer is created using the configured consumer factory.

The lifecycle of the consumer is managed entirely by the consumer factory. This gives control over the construction and disposal of the consumer to the consumer factory. There are integrations for most of the dependency injection containers included with MassTransit (StructureMap, Autofac, Unity, Ninject, Castle Windsor).

### Consumer Message Handlers

The consumer declares the handled message types via the `IConsumer` interface. An example consumer of two message types, `A` and `B`, is shown below.

    class AbConsumer : IConsumer<A>, IConsumer<B> { public async Task Consume(ConsumeContext<A> context) { } public async Task Consume(ConsumeContext<B> context) { } } 

> Previously, the `Consumes<T>.All` or `Consumes<T>.Context` interfaces were used to specify consumers. This was changed to simplify the consumer class definition &#8212; the original syntax was _clever_ but not very discoverable.

The `Consume` method is asynchronous, and returns a `Task` that is awaited before acknowledging the message. If the consumer runs to the completion (task status of RanToCompletion), the message is acknowledged and removed from the queue. If the consumer faults (such as throwing an exception, resulting in a task status of Faulted or Canceled), the message is nack&#8217;d and remains on the queue.

## Receive Endpoints

Within a bus, zero or more receiving endpoints can be declared. Each receiving endpoint should have a different queue name, and can also specify the host on which the receive endpoint is to be connected. To configure a receive endpoint for the consumer above, see the example below.

    IBusControl bus = Bus.Factory.CreateUsingRabbitMq(x => { var host = x.Host("rabbitmq://localhost/test_virtual_host", h => { h.Username("testuser"); h.Password("password"); }); // declare the receive endpoint on the host x.ReceiveEndpoint(host, "consumer_queue", e => { // configure the consumer using the default constructor // consumer factory. e.Consumer<AbConsumer>(); }) }); 

## Sending a message to the endpoint

To send a message to the receiving endpoint, as a quick example, the bus would be used to get the send endpoint, and then a message would be sent.

    var address = "rabbitmq://localhost/test_virtual_host/consumer_queue"; ISendEndpoint consumerEndpoint = await bus.GetSendEndpoint(address); var message = new A { Value = "Hello, World."}; await consumerEndpoint.Send(message); 

The message type, `A`, is a simple object with properties:

    public class A { public string Value { get; set; } } 

## Consuming the Message

Inside the consumer, the `Consume` method handles the message. All messages are delivered within a `ConsumeContext<T>` that is specific to the message and consumer. For example, if the consumer handled the message and then published an event it would use the context to publish the event.

    public async Task Consume(ConsumeContext<A> context) { string value = context.Message.Value; await Console.Out.WriteLineAsync(value); var thisJustHappend = new AHandled(value); // this is async, but read below why we don't have to await it context.Publish(thisJustHappened); } 

In the consumer above, the value of the message is written (using the async IO methods) to a file (in this case, just the console &#8212; I&#8217;m not actually sure if the console is open for async i/o, but roll with it). Then, an event is published using the context. The published event is also just a class.

    public class AHandled { public AHandled(string value) { Value = value; } public string Value { get; private set;} } 

Now, the publish could have been awaited &#8212; which completes once the broker acknowledges that the publish has been written to the queue. However, the context is delegating the `Publish` call, and therefore is able to capture the `Task` returned and keep track of it inside the consumer context. The message will not be acknowledged until all pending tasks have completed. So the consumer could publish a dozen events without awaiting each one (which would be silly, honestly &#8211; since they&#8217;re all async) and the framework will handle awaiting until all of the messages have been published and then acknowledge the message being consumed.

Sending endpoints work the same way.

    public async Task Consume(ConsumeContext<A> context) { var sendEndpoint = await context.GetSendEndpoint(_serviceAddress); sendEndpoint.Send(someCommand); } 

In the above example, the `Task` returned from `sendEndpoint.Send` is captured by the consume context (by inserting an intercepter in front of the `ISendEndpoint` interface) and awaited by the consumer before acknowledging the message.

## More to Come

This is just a short introduction to some of the API changes, to make it easy to migrate applications to the new version.

> It&#8217;s important to remember that if JSON or XML serialization is being used, there is complete interoperability between services using MassTransit 2.x and MassTransit 3. So there is no need to update every service simultaneously &#8212; services can be updated as needed.

There will be more content, as well as updated documentation, as MassTransit becomes ready for general use. Until then, enjoy the alpha bits and share your feedback on the changes!