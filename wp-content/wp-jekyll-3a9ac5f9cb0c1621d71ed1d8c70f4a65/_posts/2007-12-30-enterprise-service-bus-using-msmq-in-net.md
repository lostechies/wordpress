---
id: 15
title: Enterprise Service Bus using MSMQ in .NET
date: 2007-12-30T06:07:22+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2007/12/30/enterprise-service-bus-using-msmq-in-net.aspx
permalink: /2007/12/30/enterprise-service-bus-using-msmq-in-net/
dsq_thread_id:
  - "262089172"
categories:
  - .net
---
Over the past couple of weeks, I have been working on nailing down some design for a service bus to add real-time capability to one of our applications. This has led to spending some time looking at [nServiceBus](http://udidahan.weblogs.us/category/nservicebus) as well as a few other examples. I&#8217;ve also been reading [Enterprise Integration Patterns](http://www.amazon.com/Enterprise-Integration-Patterns-Designing-Addison-Wesley/dp/0321200683/ref=pd_bbs_sr_1?ie=UTF8&s=books&qid=1198998045&sr=8-1) (Hohpe/Woolf) to understand some of the established patterns in the space.

It&#8217;s interesting to see the different approaches people take to things like transactions and message recovery. From my experience with health care transactions, there is no way to have a distributed transaction across the myriad of systems involved in a health care exchange. With no clear standards and hardly any real-time communication with insurance companies, auditing and electronic reconciliation are the only plausible methods of determining the state of each transaction.

The discussion is lively at the [nServiceBus Yahoo Group](http://tech.groups.yahoo.com/group/nservicebus/), so if you have an interest in that style of integration, stop in and join the conversation.

[Dru Sellers](http://geekswithblogs.net/dsellers/Default.aspx) and I have started working on a simplified version of a service bus called [MassTransit](http://code.google.com/p/masstransit/). It&#8217;s an open-source project, Apache 2.0 License, and could use some comments and/or contributions. We&#8217;re going at it with the simplified [YAGNI](http://c2.com/xp/YouArentGonnaNeedIt.html) approach to meet some specific needs for work-related projects. We&#8217;re also focusing on an easy to configure, easy to code approach to reduce the difficulty of building systems using message-based communication.

It&#8217;s an ongoing project to find the right solution for a real business problem, so we&#8217;ll see how it goes!