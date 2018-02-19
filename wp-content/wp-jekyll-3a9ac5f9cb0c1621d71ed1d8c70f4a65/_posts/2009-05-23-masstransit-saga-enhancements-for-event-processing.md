---
id: 51
title: MassTransit Saga Enhancements for Event Processing
date: 2009-05-23T02:32:18+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/05/22/masstransit-saga-enhancements-for-event-processing.aspx
permalink: /2009/05/23/masstransit-saga-enhancements-for-event-processing/
dsq_thread_id:
  - "270731182"
categories:
  - Uncategorized
---
In the past year, I&#8217;ve been learning about [Event Driven Architecture](http://en.wikipedia.org/wiki/Event_Driven_Architecture) and how using it in the enterprise can make adding functionality over time easier through a loosely-coupled event-based architecture. With Event Driven Architecture, business components can subscribe and react to events, using correlation and orchestration to combine those events to represent business processes. The loose-coupled nature makes it easier to add functionality without modifying existing services &#8212; reducing the risk of deploying new services over time. 

When I first added saga support to [MassTransit](http://code.google.com/p/masstransit/), the focus was purely on allowing for long-lived transactions and the orchestration of a series of events that related to a specific process. Earlier this year, the first release of a new declarative programming style for sagas using a fluent interface was put into the trunk, making it possible to design sagas using a more natural structure and language. This feature alone is one of the more compelling things about sagas in MassTransit. 

Over the past month or so, I&#8217;ve been working on extending the capabilities of sagas in MassTransit beyond the orchestration of directly correlated events (represented as messages). With the latest updates to the trunk, messages that are not directly correlated to the saga can now be observed by the saga using either the interface-based or declarative state machine based saga syntax. This makes for some very compelling functionality as sagas can now _observe_ other events and react to them! 

Let&#8217;s take a quick look at the syntax using the state machine syntax using a simple message indicating a user has signed out. 

<pre>public class UserSignedOut
{
	public string Username { get; set; }
}
</pre>

This message only contains the username of the user that signed out of the system. If we had a saga that tracked the state of an operation on a web site based on the current user, we could observe this message and release any resources that were being tracked by the saga. For example: 

<pre>public class ShoppingCartSaga : 
	SagaStateMachine
{
	static ShoppingCartSaga()
	{
		Define(()=&gt;
		{
			Correlate(UserSignedOut).By((saga,message) =&gt; saga.Username == message.Username);
	
			During(Active,
				When(UserSignedOut)
					.Then(saga =&gt; saga.ReturnCartItemsToInventory())
					.Complete());
		};
	}

	public static Event UserSignedOut { get; set; }
}
</pre>

The Correlate() method is used to define the correlation expression used to match a message to one or more sagas in the saga repository. With this addition, the [ISagaRepository](http://code.google.com/p/masstransit/source/browse/trunk/MassTransit/Saga/ISagaRepository.cs) has been changed to make it more integrated into the message pipeline, along with the new pipeline message sinks to support this enhanced functionality. The pipeline viewer has also been updated to show the contents of the message pipeline, including all the messages handled by the saga. The Correlate() method can also be used to change how a [CorrelatedBy](http://code.google.com/p/masstransit/source/browse/trunk/MassTransit/CorrelatedBy.cs) message is also correlated to the saga, making it possible to override the logic on how messages are used to create/use existing saga instances. 

The first use case for this new functionality was to improve the subscription service. By making Subscription and SubscriptionClient sagas observe messages from each other, the sagas are able to now complete when they see a node coming back online after a crash or going offline, etc. Since the saga repositories themselves are used to keep track of all the clients and subscriptions in the system, putting that responsibility within the declaration of the saga state machine itself makes for a really clean implementation. 

These bits are currently in the trunk and will be part of the next release drop of MassTransit. I encourage you to check them out and provide some feedback on any issues. Some of this may be extended soon to also allow for the custom definition of the policy associated with how messages should be applied to sagas, such as always creating a new instance or using an existing instance of a saga. Some conventions are currently in place based on the Initial state that select a default saga policy (check out [ISagaPolicy](http://code.google.com/p/masstransit/source/browse/trunk/MassTransit/Saga/ISagaPolicy.cs) and the classes that implement it for more details there). 

So check it out and keep the great feedback and comments coming on the message group. The new syntax additions should be added to the [wiki](http://masstransit.pbworks.com/) soon.