---
id: 34
title: MassTransit 0.4 Released
date: 2008-10-08T01:33:07+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/10/07/masstransit-0-4-released.aspx
permalink: /2008/10/08/masstransit-0-4-released/
dsq_thread_id:
  - "271878264"
categories:
  - .net
---
I&#8217;m happy to say that we&#8217;ve just tied a bow around the latest release of [MassTransit](http://code.google.com/p/masstransit/). Release 0.4 includes a number of new features and some tweaks to the internals as well. I&#8217;m going to describe a few of those features below, but you can grab the latest from the [trunk](http://code.google.com/p/masstransit/source/browse/#svn/trunk) or [download the 0.4 release](http://code.google.com/p/masstransit/downloads/list).

**Building MassTransit**

Since Visual Studio 2008 has been out for almost a year, it is now required to open the updated solution for MassTransit. In the main folder, the MassTransit-2008.sln is the one to use to build and run the unit tests. Many of the samples solutions are also 2008 solutions. The assemblies, however, are still targeting the .NET 2.0 framework, making them usable on both 2005 and 2008 projects. With only the .NET 3.5 framework installed, you should be able to run the build.bat to build the project without Visual Studio (our CI server does this).

**Timeout Service**

To enable automated support for timeouts in sagas, a new timeout service is available. This is a general service that can be used to schedule timeouts for whatever purpose may be needed. To schedule a timeout, the application should publish a ScheduleTimeout message with the duration or time when a response should be sent. The application/service can then consume the TimeoutExpired message, which will be published by the timeout service when the timeout period expires.

**Message Deferral Service**

One of the scenarios I often find in our systems is the need to poll a remote resource to determine if an operation has completed. To support this behavior without custom code in each instance, a new message deferral service has been added. This can be used to defer the delivery of a message until a period of time expires. The deferral services leverages the timeout service for scheduling and we republish a message after that timeout expires. 

For example, we have a CheckRemoteResponseStatus message in one of our systems. This is initially published after a request is submitted to a remote system and a remote transaction id is returned. The first time the consumer gets the message, it checks the remote system for a response. In most cases, the response is immediately available and the saga continues. However, sometimes the remote system is too busy to respond and returns a pending status. In this case, the same CheckRemoteResponseStatus message is published within a DeferMessage. The deferred message service handles that message and will republish the original CheckRemoteResponseStatus message when the timeout expires. The saga will then handle the message to see if a response is now available. The saga keeps track of how many times the remote status has been checked and uses a sliding interval that increases as the retry count increases. Eventually, the final retry results in a failed transaction and is handle appropriately.

The nice thing about this is there was no custom retry logic required, and a common timeout and message deferral service were used. There are likely other cases within the application that will benefit from this shared functionality.

**Transactional Queue Support**

With 0.4, the entire method of reading from the endpoints has been redesigned. Previously, a single receive thread was used to receive from the endpoint which then dispatched the message handling to the dispatcher inside the service bus. This has been redesigned to use the dispatcher threads to perform the actual receive from the endpoint, using a transaction (ala System.Transactions) to handle the message reception. This keeps the transaction to a single thread while at the same time allowing concurrent message reception. 

The transaction carries over into actions that are part of the message consumer. If a database update is part of the consumer, that database update can cause the entire message to rollback if it fails. If any exception is thrown, the entire reception of the message, any additional database operations, new messages sent, etc. will all be rolled back with the transaction.

**Performance Improvements**

Dru spent some time in NYC with [Ayende Rahien](http://ayende.com/Blog/) reviewing the MT source code and Oren recommended changing from using locks to ReaderWriterLocks to improve concurrency. The changes in the threading system, along with the elimination of a lot of locking in favor of reader/writer locks has nearly doubled the throughput of messages when using a multi-core system using MSMQ. There have been a number of other internal tweaks as well to improve the concurrency of the bus dispatcher. 

**Control Bus**

To enable competing consumer in a publish/subscribe environment, the control messages need to be on a separate bus from the data messages. To allow multiple services to compete against a single data channel (single MSMQ) in order to load balance and handle failure scenarios, the services cannot compete on the control messages such as subscriptions. The subscription client has been tweaked to allow it to operate on a separate bus from the data bus, at the same time notifying the subscription service of messages handled by the local endpoints of the service. 

It&#8217;s easy to setup a single service that consumes messages from multiple buses (which in turn each have a specific endpoint being serviced). When a component is created to consume a message, the specific bus/endpoint that received the message is injected into the component (via setter injection) so that any subsequent messages can be published to the appropriate bus. 

**Health Service**

The health service has been added making it easy to monitor endpoints and identify when an endpoint goes down. Periodic heartbeats are sent to the service and when a heartbeat hasn&#8217;t been received in a while, it marks that endpoint as down and attempts to directly ping it to get a response. The heartbeats can be subscribed, so a monitoring tool can keep track of which endpoints are there and what they are handling.

**Configuration Model**

To make it easier to use the bus in different containers, a new configuration model has been added to build and configure a service bus instance. This will ultimately result in moving a lot of the code used by build a service bus out of the container-specific facilities (such as the Windsor container).

**Host Improvements**

The ability to create and deploy Windows services has gotten easier with the updates to the Host assembly in MassTransit. With only a few files to define the lifecycle of a service, it is easy to get the ability to run, test, install and deploy a service. This includes services that are using the service bus. There is little to no coupling between the host and service bus, making it usable for a variety of purposes.

**Learning MassTransit**

A lot of requests have come for information on how to learn to use MassTransit. During [Tulsa TechFest](http://techfests.com/Tulsa/2008/default.aspx) this week, we&#8217;re going to record our presentation and make it available online within a few days. This should give at least some introduction on how to use MassTransit (the presentation is mainly on distributed architecture, but we&#8217;re using MT for the demo bits). We&#8217;re also talking about doing a couple of podcasts on how to use it as well. Depending upon how that goes, we&#8217;ll try to do a couple of screencasts on &#8220;creating your first project with MT.&#8221;

The best way to discover how to use the code is to review the samples. The WinFormSample gives an overall example of how a variety of features are used. The HeavyLoad shows how many of the pieces work as well. The samples folder has a few others that demonstrate how to use MT in other scenarios. 

So, check out the new release and give us some feedback on how the new features are working. We&#8217;ve already got a few backlog items that we&#8217;re slating for 0.5 based on some other contexts that have come up in our applications. Feel free to post on the [message group](http://groups.google.com/group/masstransit-discuss?hl=en) or send either [Dru](http://geekswithblogs.net/dsellers/Default.aspx) or I an [e-mail](http://blog.phatboyg.com/contact/) or [tweet](http://twitter.com/PhatBoyG) if you have any questions.