---
id: 80
title: MassTransit v2.0.1 Available
date: 2011-11-16T08:28:49+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=80
permalink: /2011/11/16/masstransit-v2-0-1-available/
dsq_thread_id:
  - "473906987"
categories:
  - Uncategorized
---
At the end of October, we released MassTransit v2.0.1 to GitHub and NuGet. This release only included a few fixes that didn&#8217;t make it into the v2.0 release. Since I never made an official announcement of v2.0 on the blog, some links to the project, documentation, and mailing list are included below.

For those using the 1.x lineage of MassTransit, v2.0 includes several breaking changes in the API. This was necessary to reduce the complexity of getting new users up-to-speed, as well as eliminating some common areas of confusion. The API for v2.x should remain consistent from this point forward (well, until we start working on v3.x, which is a long ways off honestly).

[Project Site (hosted on GitHub)  
](https://github.com/MassTransit/MassTransit) [NuGet Project](http://nuget.org/List/Packages/MassTransit)  
[Documentation](http://docs.masstransit-project.com/en/latest/index.html)  
[Mailing List](http://groups.google.com/group/masstransit-discuss)  
[Ohloh Metrics](http://www.ohloh.net/p/masstransit)

It&#8217;s worth noting that the MassTransit organization on GitHub is the &#8216;official&#8217; repository. Please file any issues on that repository so that all of the MassTransit team members can help with any issues. However, you are encouraged to check the mailing list first as many first-time issues are discussed there.

This release was a long road and involved a lot of internal code cleanup, API grooming, and support for a new transport (RabbitMQ). We welcome your feedback, questions, and suggestions.

Enjoy!

 