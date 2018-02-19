---
id: 48
title: 'Opinionated Input Builders  &#8211; Part 7 More on Performance / Take 2.'
date: 2009-06-14T19:15:02+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/14/opinionated-input-builders-part-7-more-on-performance-take-2.aspx
permalink: /2009/06/14/opinionated-input-builders-part-7-more-on-performance-take-2/
dsq_thread_id:
  - "262529376"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - CoC
  - continous improvement
  - mvc
  - mvccontrib
  - Open Source Software
  - OSS
  - testing
---
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx" target="_blank">Part 1 – Overview</a> 
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx" target="_blank">Part 2 – the Labe</a>l 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx" target="_blank">Part 3 – the Source Code</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx" target="_blank">Part 4 – the Partial View</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx" target="_blank">Part 5 – the Required Field Indicator</a>&#160; 
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx" target="_blank">Part 6 – the Performance</a> 
  * Part 7 – the Performance Take 2
After doing what all good developers should do on the weekend… which is enjoy life and spend some time with my family, I thought I would take another stab at the Input Builder performance and see what else I could learn about the implementation.&#160; That being said this is what I came up with.&#160; 

### Want to get a 2X increase in 5 seconds of development time?

One of the features of the Builders that I like is the ability to deliver all of the partial views from a separate assembly that would make this library and approach feel more like a component with a single package for all of its files than a Hodge-podge of files you need to copy into your project.&#160; That approach came at a cost.&#160; My own implementation of the VirtualPathProvider proved to be disastrous on performance.&#160; Below is the same performance test running against my sample page with the partial views and master pages copied into the local project and removing my implementation of the VirtualPathProvider.

<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_6B57133F.png" width="1028" height="182" />

With this small 5 second change the Maximum Requests/Second went from **442** to **1,027** .&#160; The Average Requests/Second went from **351** to **908**. Not bad huh?&#160; So after a single change to the code base and removing my custom code for pulling partial views from the embedded resources,&#160; I was able to get a huge performance increase.&#160; 

### What are the next steps?

Since I still like the approach of having the virtual path provider I will spend a little time looking into how I can change the implementation so that it renders better performance.&#160; Now that I have better performance out of the builders it will be good for me to take a 2nd pass with the profiler and see where the hot spots are.&#160; My hunch is the bottle neck in this code is something that I wrote versus something that comes out of the box with the framework.&#160;&#160; So there will be more work to do on this front but at this point I am positive that I can overcome the performance aspects of this approach and I will concentrate on a few more posts which discuss more of the opinions as well as more of the implementation.