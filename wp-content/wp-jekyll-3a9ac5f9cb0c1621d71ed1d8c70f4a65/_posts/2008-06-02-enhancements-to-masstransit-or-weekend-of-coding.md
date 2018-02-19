---
id: 27
title: Enhancements to MassTransit (or Weekend of Coding)
date: 2008-06-02T12:16:21+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/06/02/enhancements-to-masstransit-or-weekend-of-coding.aspx
permalink: /2008/06/02/enhancements-to-masstransit-or-weekend-of-coding/
dsq_thread_id:
  - "270739654"
categories:
  - Uncategorized
---
This past couple of weeks I&#8217;ve been putting some serious time into [MassTransit](http://masstransit.googlecode.com/). My primary goal is to improve the internal architecture and remove some of the MSMQ leaks into the infrastructure. Our original goal was to stick purely to MSMQ, however, as we got more into messaging systems we found that there are a lot of other transports with different advantages. For example, using [ActiveMQ](http://activemq.apache.org/) would make it easy to add integration with Java applications down the line. The problem at this point was all the code designed around MSMQ was making it difficult to support other transport types. 

About two weeks ago, I started working on a completely new method of dispatching messages within the service bus. My goal was to support a pure producer/consumer model using a publish/subscribe pattern. With this in mind, I built a new message dispatcher that allowed for a new way of specifying message subscriptions. Previously to this change, a service interested in messages would do the following: 

<pre>_bus.Subscribe&lt;MyMessage&gt;(MyHandlerMethod);
public void MyHandlerMethod(IMessageContext&lt;MyMessage&gt; context) {}
</pre>

Because of this structure, there had to be an instance of the class in memory and it somehow needed to be started so that subscriptions could be added. The class also needed to be stopped so that it could remove any subscriptions from the service bus. Another goal was to be able to use an object builder to create objects as needed to handle messages. For example, we wanted to use Castle Windsor to dynamically build objects to handle messages and get all the injection benefits of the container. 

To support this new style, I added some new interfaces and made it possible to register either an object or a class with the service bus. As an actual example, compare the original subscription client code to the new version: 

Before the changes: 

<pre>public class SubscriptionClient : IHostedService
{
	public void Start()
	{
		_serviceBus.Subscribe&lt;AddSubscription&gt;(HandleAddSubscription);
		_serviceBus.Subscribe&lt;RemoveSubscription&gt;(HandleRemoveSubscription);
	}
	public void Stop()
	{
		_serviceBus.Unsubscribe&lt;AddSubscription&gt;(HandleAddSubscription);
		_serviceBus.Unsubscribe&lt;RemoveSubscription&gt;(HandleRemoveSubscription);
	}
	public void HandleAddSubscription(IMessageContext&lt;AddSubscription&gt; ctx)
	{
		_cache.Add(ctx.Message.Subscription);
	}
	public void HandleRemoveSubscription(IMessageContext&lt;RemoveSubscription&gt; ctx)
	{
		_cache.Add(ctx.Message.Subscription);
	}
}
</pre>

And now after the changes: 

<pre>public class SubscriptionClient : IHostedService, 
	Consumes&lt;AddSubscription&gt;.All, 
	Consumes&lt;RemoveSubscription&gt;.All
{
	public void Consume(AddSubscription message)
	{
		_cache.Add(message.Subscription);
	}
	public void Consume(RemoveSubscription message)
	{
		_cache.Remove(message.Subscription);
	}
	public void Start()
	{
		_serviceBus.Subscribe(this);
	}
	public void Stop()
	{
		_serviceBus.Unsubscribe(this);
	}
}
</pre>

The code just makes more sense and is easier to understand after the changes. In addition, you can also just call _bus.AddComponent<T>(); to register a type with the service bus and it will use the object builder to create an instance of the class to handle the message. If you&#8217;re using a container like Windsor, you can specify the lifestyle of the object(s) there, either singleton, transient, or pooled &#8212; depending upon your application requirements. 

Also notice that there are various types of consumers supported, indicated by the interface used in the consuming class. Consumes<T>.All will deliver any message of type T to the consumer. Consumes<T>.Selected adds an Accept(T message) method to the class to screen any messages before removing them from the endpoint (at least with MSMQ, likely not the case with ActiveMQ). 

The third option presently available is Consumes<T>.For<V> and adds support for a correlated consumer. In previous versions of MassTransit, Request/Reply was handled by using the transport message identifiers and setting a correlation identifier on the transport message. This leaked a lot of details into the service bus layer that were not pretty. Instead of using the transport correlation identifier for messages, we decided to add a new interface that messages can implement called CorrelatedBy<V>. This interface has a single method that returns the correlation identifier for the message &#8212; and it is expected that the message body itself will contain the correlation identifier. 

So now a request/reply pattern would look something like this: 

<pre>class Controller : Consumes&lt;Response&gt;.For&lt;Guid&gt;
{
	public void Consume(Response message)
	{}
	public void Action()
	{
		_actionId = Guid.NewGuid();
		_bus.Subscribe(this);
		_bus.Publish(new Request(_actionId, someValue, someValue2);
	}
}
</pre>

When the object subscribes to the bus, the correlation identifier is used to filter incoming messages so that only correlated messages are delivered to the object. This is cleaner from a interface contract perspective since you can look at a service and see what messages are produced and ensure that your controller implements all of the expected responses. 

While working on these API changes, I also made a number of other changes including:

  * Messages no longer need to implement IMessage, plain old objects can be used
  * Removed all threading from the endpoint (asynchronous message dispatching is now handled by a thread manager in the service bus
  * Added a DispatchMode so that messages could be dispatched synchronously for unit tests

I also wrote a new sample called HeavyLoad to benchmark the performance of the bus when using various transports. A variety of message per second tests are performed to see how well the system can be expected to perform based on the type of messaging being done. Early tests on my system (Windows 2003 server in VMware Fusion) show MSMQ performance to be between 950-1500 messages per second (for a 300 byte message, persistent) and around 500 messages per second doing a correlated request/response with a single thread (but using the asynchronous dispatcher). If I were to rewrite the test to use multiple message send threads I would expect performance to increase somewhat since my load test is a bit naive at the present time. 

At the same time, I managed to extend the subscription support to include correlated subscriptions. The only subscription cache that currently supports the extensions is the DistributedSubscriptionCache (which uses memcached to share subscription information across a distributed group of systems). The key goal here was to enable MassTransit to support a distributed request/reply architecture using publish/subscribe with correlated subscriptions to specifically route messages to their intended consumers. I plan to make heavy use of this in an upcoming project so I wanted to see it work. 

In addition to all the changes, I also updated a few of the samples and made various tweaks to the infrastructure to make it cleaner. There are several more tweaks on the whiteboard that I&#8217;m hoping to investigate in the next week. Once those are done, full ActiveMQ support is up next including running the tests under Mono on OSX. 

So a lot of changes since the 0.1 tag was put down a couple of weeks ago. I expect there will be some continued testing and tweaking this week as Dru seeks to understand all the changes that were made. While I&#8217;ve been doing this stuff, Dru has gotten a kick ass start on a new dashboard to monitor an application built using MassTransit. The goal there is to provide a single pane of glass view into the health of a system, including subscriptions, endpoint throughput, message counts, etc. We&#8217;ve got some cool ideas how to make the information available and hope to make this alone one of the cool features to help support distributed messaging applications. 

If you haven&#8217;t checked out MassTransit, you can get the latest source from the [GoogleCode repository](http://masstransit.googlecode.com/). There is a message board for questions, or feel free to contact Dru or myself with any questions.