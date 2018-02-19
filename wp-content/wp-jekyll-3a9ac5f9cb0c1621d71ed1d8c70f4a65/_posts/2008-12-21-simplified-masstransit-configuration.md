---
id: 43
title: Simplified MassTransit Configuration
date: 2008-12-21T05:26:02+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/12/21/simplified-masstransit-configuration.aspx
permalink: /2008/12/21/simplified-masstransit-configuration/
dsq_thread_id:
  - "262089303"
categories:
  - Uncategorized
---
One of the things I&#8217;ve missed since we integrated container support is the ability to quickly and easily create an instance of the ServiceBus. After Ayende agreed, I decided it was time to do something about it.

Behold the minimum amount of code necessary to create a service bus:

<img src="http://lostechies.com/chrispatterson/files/2011/03/Picture-4.png" alt="Picture 4.png" border="0" width="620" height="213" />

That&#8217;s it. In fact, you can easily mock out the container with some nifty Rhino.Mocks usage:

<img src="http://lostechies.com/chrispatterson/files/2011/03/Picture-5.png" alt="Picture 5.png" border="0" width="619" height="172" />

I&#8217;m starting to convert the tests to use the mocked container approach to reduce the runtime of the tests. But so far the HeavyLoad, Starbucks and WinFormSample samples have been verified to work with the new model. The Windsor facility is also using the new model (Dru is going to update the other two tomorrow).

I&#8217;m pretty happy with the new configuration syntax, it certainly makes it easier to setup a bus with zero XML abuse. Look for more of this style of configuration/extension in MT in the near future.