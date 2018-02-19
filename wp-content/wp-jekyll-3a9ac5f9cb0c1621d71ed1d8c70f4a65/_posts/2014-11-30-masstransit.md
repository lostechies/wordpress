---
id: 116
title: 'MassTransit ]|['
date: 2014-11-30T00:28:20+00:00
author: Chris Patterson
layout: post
guid: https://lostechies.com/chrispatterson/?p=116
permalink: /2014/11/30/masstransit/
dsq_thread_id:
  - "3852074175"
categories:
  - masstransit
---
_This article describes an upcoming release of MassTransit. This release is still under development and will be pushed in various pre-release forms before the final release is finished. Early feedback is valuable, and you are encouraged to check out the early bits, but recognize that they are just that – early bits. There will be bugs and features that are not yet complete._

# Background {#background}

MassTransit was started in 2007 after a very exciting ALT.NET meeting in Austin, TX. I met a lot of great, smart people with a lot of great ideas on how to make the .NET community a better place for software developers. It was shortly after that Dru Sellers and I started working on a messaging library for use with MSMQ to solve problems within our respective jobs. I had actually been using MSMQ since the late 90’s from C++, but was starting to make moves into C# and needed a managed solution.

Originally NServiceBus was considered, but while it was open source, it was not accepting contributions at the time and was specific to less than stellar projects like Spring.NET. Having reviewed the source code, Dru and I came to the conclusion that we could start a new project to address our requirements using frameworks with which we were both more familiar. Since that time, NServiceBus has seen tremendous growth and is now a commercial product from Particular Software (started by Udi Dahan).

In the past seven years, MassTransit has evolved as requirements for messaging in distributed systems changed. What started as an _abstraction_ layer on top of MSMQ become a comprehensive platform for creating distributed applications, including support for sagas (okay, we can call them process monitors if you prefer), message scheduling (via Quartz), and a powerful routing slip implementation that has been used as the underpinnings of a modern scaled distributed interoperability platform. Each of these features is great standalone, but when combined they make possible some really incredible system design options that are reliable, scalable, and supportable.

# In with the New {#inwiththenew}

There have been many changes in the .NET framework since version 2.0 was released. The runtime and language (C#) have both evolved, adding powerful new features. The biggest changes appeared in .NET 4 with the introduction of the TPL. The new threading support has made asynchronous programming easier to understand and has greater performance with lower overhead than previous operating system threading models.

In addition, the big puffy cloud has become mainstream and many applications are being built cloud-first, leading to the use of push messaging systems. When support for RabbitMQ was added, it took a while to get it right and get it cloud-friendly. The first incarnation followed the same pull model that was used for MSMQ, which led to expensive running services with the cloud’s pay-as-you-go model. Refining the transport to support push via AMQP brought the request charges down significantly, but started to identify limitations in the underlying transport model around which MassTransit was built.

Along with the cloud came Azure and the Azure Service Bus. For many .NET developers, it’s the easiest option for systems being deployed to the cloud. Cloud services are cost effective ways to host applications, but having to run a RabbitMQ cluster in IaaS can be expensive. Support for Azure Service Bus has been limited to an external library due to the difference in messaging topology, particular the topic/queue structure that’s provided on top of SQL service broker. There is also the on-premise Service Bus option, although why somebody would run that over RabbitMQ eludes me.

RabbitMQ also got a lot more awesome, with many improvements in broker-to-client communcation, including notifications to clients as the topology of cluster nodes changes and messages flow through the broker. The client library for .NET has gone from a limited, basic functionality library to include extensive support for the new features. This again identified some seams in MassTransit that were just not clean and made it difficult to take advantage of the new features.

The term CQRS, or Command Query Responsibility Segregation, became a lot more normal, and the separation of reads from writes became obvious as more functional programming styles became commonplace. This is also true in messaging systems. For example, in RabbitMQ you send messages to exchanges and read messages from queues. Two completely separate constructs tuned to each side of the message conversation.

# So What’s New With MassTransit 3 {#sowhatsnewwithmasstransit3}

MassTransit v3 is a modern, enterprise-grade framework for creating reliable, scalable, and supportable distributed applications. Version 3 leverages the latest .NET framework features and supports current message brokers including RabbitMQ and Azure Service Bus (additional support for Event Hubs, as well as on-premise Service Bus will be available as well).

Each message broker will be fully supported at the API level, allowing the distinct advantages of each broker to be utilized. The configuration API for endpoints and consumers is specialized for each transport, while consumers remain agnostic to the transport implementation details. This retains the ability to transplant consumers from one messaging system to another without a rewrite yet take advantage of transport specific features. Message consumers have access to transport-specific parameters and settings as well, in case more specific per-message controls are needed.

Most modern frameworks provide middleware extension points, and MassTransit 3 is no exception. Full end-to-end middleware injection points, from the transport, post serialization, to handlers and consumers and everything in between, make MassTransit 3 the most customizable and extensible messaging framework. Every middleware component is asynchronous, ensuring maximum thread utilization, as well as scope owning, allowing full in/out processing and exception handling. All of this without any overhead that impacts message processing throughput. Traditional observation-style notification points are also available, including pre/post/fault consumer message handling, as well as pre/post/fault send message handling, either by a specific inbound message type or consumer type, outbound message type or endpoint address, or generic inbound and outbound message paths.

A new MassTransit Host, which was part of the original releases, but was extracted to become Topshelf, is now included. And with it comes easy “create an assembly and hit F5” approach to building autonomous services with MassTransit. All of the setup, including separate receive endpoints for each consumer, is handled by convention to make getting started easier than ever. And those services are production ready with full logging support.

Courier, the routing slip implementation for MassTransit, as well as Quartz integration are fully optimized for MassTransit 3. Both scheduling and courier are built into MassTransit, along with full container integration.

# Out with the Old {#outwiththeold}

Seven years of evolution in a framework means a lot of old code, a lot of which is old solving problems. To keep MassTransit 3 clean and tight, some things had to go.

MSMQ is no longer supported. There was extensive code in MassTransit supporting features that were not supported by MSMQ out of the box. Modern message brokers have full support for topic- and/or exchange-based routing, which can be complex and error prone. Rather than try to keep MSMQ alive, everything related to supporting publish/subscribe on MSMQ is gone, deleted, left in the archives of Git history. While a send/recieve only transport for MSMQ may be added at some future point, developers can continue to use the 2.x versions for MSMQ applications.

Magnum, is no longer a reference. Neither is Stact. Both of these poorly maintained libraries have been removed from MassTransit. A lot of the features in those libraries were there to compensate for limited .NET framework features. With .NET 4.5, the need for those extensions is no longer required. In fact, there are many code design changes that make generic support easier and more understandable, eliminating the dynamic code generation that was so heavily leveraged in previous version of MassTransit. This should lead to faster code execution and reduced process startup time.

Of course, with no Magnum, there is no Magnum state machine. For applications built today, [Automatonymous](http://www.nuget.org/packages/automatonymous) ([docs](http://automatonymous.readthedocs.org/en/latest/configuration/quickstart.html)) should be used anyway. It’s a better, more flexible, and more extensible state machine than Magnum implementation.

A lot of legacy interfaces that were never suggested to be used, as well as tiny little features that were difficult to support and not used, are gone. Some interfaces may remain to make it easier to port v2 applications to v3, but those will be for compatibility only (and, in fact, packaged in a separate MassTransit.Compatibility assembly).

# Timelines {#timelines}

The first early bits of MassTransit 3 should be available on NuGet soon. This includes support for Azure Service Bus and RabbitMQ. I’ll follow up the bits with some articles on how to get started with the new configuration API, and how to get your first message producers and consumers communicating. Details on the default conventions for RabbitMQ and Azure Service Bus will also be published (RabbitMQ is unchanged and 100% compatible with v2.x services).

Automatonymous, Courier, and Quartz integration will also have pre-release versions available that are compatible with the new MassTransit 3 bits.

# In Closing {#inclosing}

Many more developers are being pushed into building decoupled message-based applications, and those developers need a clean and modern API that aligns closely to the .NET 4.5 framework. This is even more important as we move into vNext, with .NET now being open source. A fully vNext compatible version of MassTransit is definitely coming as the vNext release approaches. MassTransit 3 is being built to target those developers, as well as those who are maxing out with MassTransit v2.x and need better asynchronous support and extensibility for their applications.

Watch for the early bits announcement soon!