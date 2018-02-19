---
id: 44
title: MassTransit Turns One Year Old, Celebrations Held Around the World
date: 2008-12-26T16:20:06+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/12/26/masstransit-turns-one-year-old-celebrations-held-around-the-world.aspx
permalink: /2008/12/26/masstransit-turns-one-year-old-celebrations-held-around-the-world/
dsq_thread_id:
  - "279708234"
categories:
  - Uncategorized
---
<img src="http://blog.phatboyg.com/wp-content/uploads/2008/12/ndf03569.jpg" alt="NDF03569.jpg" border="0" width="640" height="503" />

Today marks the one year anniversary of the first commit to the [MassTransit GoogleCode repository](http://code.google.com/p/masstransit/). While [Dru Sellers](http://blog.acuriousmind.com/) and I initially did some proof of concept work, this day marks the decision to go forward with a standalone .NET messaging framework.

MassTransit was started as a collaborative effort to provide a lightweight messaging framework on MSMQ for .NET applications. Both Dru and I needed a framework for asynchronous messaging to address some work-related application requirements. While MSMQ is provided out of the box, it doesn&#8217;t directly encourage some good distributed application practices such a loose coupling. Our goal was to abstract the messaging aspects so the services could be built to deal with plain old objects (POCOs) instead of lower level transport messages.

Originally, we both looked at [NServiceBus](http://www.nservicebus.com/) as a way to make this happen. I&#8217;ve followed Udi&#8217;s blog for a while and have really gained a lot of knowledge from his posts and presentations. However, our lack of experience in Spring.NET, along with a general lack of understanding of all the complexity of such a framework led us down the path of building our own framework.

So that&#8217;s how MassTransit got started. A year later we&#8217;re still improving the code and providing useful functionality for developers to build loosely-coupled asynchronous applications. We&#8217;ve even harvested some common functionality (such as the service host, which is now a standalone project [Topshelf](http://code.google.com/p/topshelf/)), and plan to harvest out some additional features in the near future. The great thing about building open source software is the cooperative nature &#8212; even on similar projects. We all learn from each other and build that knowledge into tools that other developers can use and learn from as well.