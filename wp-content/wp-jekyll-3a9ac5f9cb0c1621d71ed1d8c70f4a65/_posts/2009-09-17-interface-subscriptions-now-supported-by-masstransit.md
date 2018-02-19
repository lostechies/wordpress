---
id: 59
title: Interface Subscriptions Now Supported by MassTransit
date: 2009-09-17T01:46:05+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/09/16/interface-subscriptions-now-supported-by-masstransit.aspx
permalink: /2009/09/17/interface-subscriptions-now-supported-by-masstransit/
dsq_thread_id:
  - "263274320"
categories:
  - .net
  - esb
  - masstransit
  - msmq
---
Last year when we were reviewing the backlog of items that we wanted to build for MassTransit, one item that kept rising to the top of the list is a solid story for evolving message producers over the lifecycle of an enterprise system. Being able to publish events that current and down-level subscribers could consume was a key goal to avoid having to upgrade systems all at once when a publisher is updated. Fortunately, it hasn&#8217;t been a real concern in our application since we deploy the entire system as a whole with each delivery.

Nonetheless, a way to update a service that publishes messages without requiring every subscribing service to be updated at the same time was need.

### Eliminating Impediments

Before we could implement interface subscriptions, there were a few things in the way that needed to be addressed, things that were not easy to implement.

First, we were still doing binary message serialization. While we had the ability to use the .NET XML Serializer, it tends to be slow and difficult to fit into the model we had built with MT. Back in May, [XML became the default serialization format](http://blog.phatboyg.com/2009/05/27/masstransit-now-speaks-xml-by-default-2/) using an entirely new serializer built from scratch.

Second, we wanted to ensure that a publisher could publish a single message and have it delivered to all of the interested subscribers regardless of whether they had subscribed to the message class or one of the interfaces implemented by the class. In MassTransit, subscriptions are added by type a defined using a plain old CLR object (POCO). [In the 0.6 release](http://blog.phatboyg.com/2009/03/30/masstransit-06-release-candidate/), we replaced the message dispatcher with a new type-based pipeline for both inbound and outbound messages. Starting with an object and working down the type structure of the message, messages are pushed through the pipeline to interested message sinks. In the case of the outbound pipeline, it makes it easy to push a class through that has interfaces, since the interfaces can be assigned from the message object. Another hurdle eliminated.

### Implementing Interfaces

Once the hurdles were eliminated, it was actually very easy to add interface subscriptions. Since most of the internal bits had been reworked leveraging the power of expressions and generics, it was simply a matter of tweaking a few parts of the serializer and we were ready to rock and roll. Ensuring that message objects retain their type through the various pathways inside the system was also important, and resulted in fixing a couple of low hanging bugs related to message retry and fault publishing. 

The one bit of code that needed to be built was a way to provide a backing class for an interface to store the property values. At first, I looked at using something like LinFu or DynamicProxy2 to create a proxy for the interface and intercept the property accessors, but this had a problem. I did not want property setters on the interface. At that point, I started looking at using the Emit classes, AutoMapper, the FastProperty expression-based accessors, and how Udi had dealt with it inside NServiceBus. What I ended up with was a very fast, cached object builder implementation that is integrated within the message deserializer. In the words of Cartman, &#8220;It&#8217;s pretty cool.&#8221; 

There isn&#8217;t really a difference in the code between using classes and interfaces from either the producing or consuming end. While a producer will likely continue to publish a class, it just has to implement the message interface on that class, allowing the consumer to subscribe to the interface, breaking the dependency on the actual class published by the producer. The pipeline will then properly serialize out a message for that interface and send it directly to the consumer. 

I&#8217;m pretty excited about this, and hope to update some of the pre-built services to use interfaces instead of classes in the near future. In the meantime, pull down the latest trunk and check it out.