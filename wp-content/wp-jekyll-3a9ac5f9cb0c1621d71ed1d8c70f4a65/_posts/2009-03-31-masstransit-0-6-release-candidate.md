---
id: 48
title: MassTransit 0.6 Release Candidate
date: 2009-03-31T02:17:51+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/03/30/masstransit-0-6-release-candidate.aspx
permalink: /2009/03/31/masstransit-0-6-release-candidate/
dsq_thread_id:
  - "262089326"
categories:
  - .net
---
I&#8217;m proud to announce that we are getting close to a final 0.6 release of [MassTransit](http://code.google.com/p/masstransit/). We&#8217;ve been working on this release since early December and have added a lot of new functionality. We&#8217;re also glad to have integrated a number of patches that the community has contributed &#8212; thanks for your help! 

If you are currently developing with MassTransit, please check out the new bits and give us feedback. The trunk contains all of the latest code. [A snapshot of the trunk](http://masstransit.googlecode.com/files/masstransit-0.6RC1-r1829-src.zip), along with a [0.6 RC1 build](http://masstransit.googlecode.com/files/masstransit-0.6RC1-r1829.zip) have been added to the [GoogleCode](http://code.google.com/p/masstransit/) site. If you have any problems, comments, suggestions, or patches please post them to the [Google Group for MassTransit](http://groups.google.com/group/masstransit-discuss). We&#8217;re interested in all experiences, good, bad, or otherwise. 

A quick run down of the changes includes: 

  * **Message Pipeline**
  
    The message pipeline is a replacement for the message dispatcher, as well as the cache-based publishing and subscribing bits. This new pipeline is built using a pipes-and-filter approach and is dynamically adjusted as subscriptions are added and removed &#8212; both locally and by remote services. 
  * **Saga State Machine**
  
    With the all new method of defining sagas using a state/event fluent interface, it is now even easier to describe the business logic of a process and the events from which it is built. With the new state machine, it is not necessary to have message consumers and interfaces on your saga, you can just define the events in the class and they are wired automatically by the subscription framework. The early version of the syntax was discussed [in this post](http://blog.phatboyg.com/2009/01/16/state-machine-for-managing-sagas/). 
  * **Better Request/Response Support**
  
    The old bus.Request() syntax has been replaced with a new fluent style for making requests and waiting for responses. Both synchronous and asynchronous calling conventions are supported. Look for the new bus.MakeRequest extension method for more information on this slick new syntax. 
  * **Code-based Configuration Syntax**
  
    A new, code-based method of configuring and running a service bus has been added. This syntax significantly simplifies getting started with MassTransit and has been used throughout the unit tests. The facilities for Castle have also been updated to transparently use this new syntax with the same XML-style configuration in Windsor. More details on this syntax can be [found here](http://blog.phatboyg.com/2008/12/21/simplified-masstransit-configuration/). 
  * **Message Headers**
  
    Messages are now wrapped in an envelope and headers are associated with the message. The pipeline will add certain headers, and additional headers can be added by the message publisher using an extension method to the IServiceBus.Publish and IEndpoint.Send methods. Header properties such as ResponseAddress, FaultAddress, DestinationAddress, and SourceAddress make some more advanced routing options available. All three message serializers support the message headers. Which brings me to&#8230; 
  * **Binary, XML, and JSON Message Serializers**
  
    All three serializers can now be configured for use as the wire message format. 
  * **Topshelf Integration**
  
    The old MassTransit.Host has been replaced with the easier to use [Topshelf](http://code.google.com/p/topshelf/) service hosting framework. 
  * **Unsubscribe via Delegate**
  
    The Unsubscribe methods on IServiceBus have been removed. When Subscribe is called, an UnsubscribeAction is returned instead. This delegate should be called when the subscription is no longer needed. This makes it easier to modify the state of the service bus in response to subscribe/unsubscribe actions by maintaining all of the information needed to unsubscribe in a lambda expression. The UnsubscribeAction is a delegate, and multiple unsubscribe handlers can be added together via the += operator. You can also use the extension method to get an IDisposable version of the subscription. 
  * **Redesigned Subscription Service**
  
    The subscription service and client have been rewritten to take advantage of the new saga syntax. This reduces the number of specialized components needed for each service, as well as leveraging the features of MassTransit internally. Check out the SubscriptionManagerGUI in the WinFormSample for a demonstration of the service, as well as the pre-built services for use in your production environment. 
  * **Starbucks Sample Updated**
  
    The Starbucks example has been updated to use the new saga state machines as well as some housekeeping updates to use the new features. Be sure to check it out as a starting point for understanding sagas and how to interact with them. Details on how to get the Starbucks sample running [are on the wiki](http://masstransit.pbwiki.com/starbucks). 

We&#8217;re hoping to get an official 0.6 release in the next couple of weeks, so please provide any feedback you have to help us wrap it up. You can get the bits, including a [source](http://masstransit.googlecode.com/files/masstransit-0.6RC1-r1829-src.zip) and [binary](http://masstransit.googlecode.com/files/masstransit-0.6RC1-r1829.zip) distribution [here](http://code.google.com/p/masstransit/downloads/list).