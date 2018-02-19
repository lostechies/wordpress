---
id: 28
title: MassTransit 0.2 Now Available
date: 2008-06-14T03:20:45+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/06/13/masstransit-0-2-now-available.aspx
permalink: /2008/06/14/masstransit-0-2-now-available/
dsq_thread_id:
  - "262089239"
categories:
  - .net
  - activemq
  - masstransit
  - msmq
---
We&rsquo;ve dropped a new release of [MassTransit](http://code.google.com/p/masstransit/) today, [version 0.2](http://masstransit.googlecode.com/files/masstransit-0.2.zip) is now available on the main page. There are several new features included in this release. It was great to get some feedback from people who have tried MassTransit, along with the evolution from discussions with Greg Young, Udi Dahan, Ayende, and others at ALT.NET Seattle.

A quick summary of the changes in this release:

**Extensible Message Dispatcher**

To make it easy to add new messaging patterns to the service bus, MassTransit has an entirely rewritten message dispatcher. The new code is structured in a producer/consumer style that lends itself to easy extensibility, allowing new features such as batch messaging and correlated messages without heavy lifting.

**Component-Based Message Handling**

In the previous version, handling messages required an object to subscribe to messages types passing methods to handle the messages. Now, a class can implement interfaces to support message consumption and the class itself can be added to the service bus. The service bus will then create objects to handle each message, removing the need to use the same instance for each message received. A class can handle multiple messages types, and can also indicate whether to receive all, selected or correlated messages by implementing the Consumes.All, Consumes.Selected, or Consumes.For interface.

**Batch Messaging**

The new message dispatcher includes support for message batches. Instead of having to correlate a batch of messages at the application layer, an object or component can consume a batch instead of each individual message. Details of how to use batch messaging are [on the wiki](http://code.google.com/p/masstransit/wiki/BatchMessaging).

**Container Integration**

We finally bit the bullet and started using a container. A new assembly called MassTransit.WindsorIntegration adds a default container derived from WindsorContainer that adds facilities to create ServiceBus instances. [A new custom syntax](http://code.google.com/p/masstransit/wiki/CastleIntegration) was created to make it easy to configure multiple ServiceBus instances. All of the samples have been updated to use the new container to help understand the integration points.

**Plain Old C# Object Message Objects (POCOMOs Anyone?)**

The need to have all messages implement IMessage is gone, reducing the footprint of MassTransit in your application code. There are some new interfaces to handle things like correlated messages and batch messages, but those are only needed to use the built-in support for those message patterns.

**Better Thread Management**

To allow for more control over resources, a new thread manager has been added. While we haven&rsquo;t exposed the thread configuration yet, a dedicated thread pool for asynchronous message dispatching should allow for more efficient message handling. We also took all the threading code from the endpoint and put it in the service bus, reducing the complexity required for new endpoints. In fact, the endpoint structure has also been redesigned to be more send/receive focused.

**Publish/Subscribe Focus**

The service bus now has a pure publish/subscribe architecture compared to the previous additional methods, such as Send() and Request(). For applications that need to send messages directly to endpoints, the endpoint now has a Send() method. The publishing of messages takes advantage of the same new subscription code, allowing all messages type information to be cached for better performance (avoiding the reflection penalty on each call to Publish). With the extensibility of the message dispatcher, it&rsquo;s likely that remote endpoints may some day find there way into the dispatcher, resulting in a single dispatch engine for asynchronous publishing of messages as well.

**Request/Reply**

Requests are handled in an entirely new way, using a new fluent builder. The fluent builder allows the calling code to subscribe to any responses (directed via the Consumes.* interfaces, indicate whether an asynchronous callback should be allowed (for [WebMethod] style Begin/End usage, PageAsyncTask usage, or MonoRail asynchronous actions), and get a future object that can be used to complete the request upon receipt of a response. The responses are handled by the calling class itself, the future object is used to signal the operation complete which will release any waits or callbacks for the action.

**Distributed Subscription Cache**

A new distributed subscription cache (backed by memcached) is now available. This is mostly designed for high volume request/reply applications that need to add and remove a lot of correlated subscriptions and maintain a high level of performance. A load test will be added to the HeavyLoad sample soon, but it seems to hold up pretty well so far under regular testing.

**Dashboard**

[Dru](http://blog.acuriousmind.com/) has been hard at working making an operations dashboard part of the core product. One of the big things about messaging systems is being able to assess the health of the endpoints at any time. The goal of the dashboard is to provide that single pane of glass to find out which endpoints are alive, what messages they are handling, and indicate any problems to the viewer. There are many plans for this, including the ability to remotely control the endpoints for dynamic adjustments to load handling and perhaps even remote service restarts.

**Deployment** 

[Dru](http://blog.acuriousmind.com/) has also been working on the deployment story, making it easier to deploy MassTransit into a production system. There is much love needed there, but I&rsquo;m hoping to dig into it soon to see how things have gotten easier to manage.

I&#8217;m sure there are many more features that have been added under the covers. The main thing is that with this release (0.2) we&#8217;re pretty happy with the API experience. The consumer code is easy to understand and implement, particularly compared to the earlier version. It is unlikely that we&#8217;ll do another major overhaul to the interface like we did with this version.

So give it a shot, and blog about your experiences!