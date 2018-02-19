---
id: 141
title: 'Synchronizing webpages across devices with SignalR &#8211; Part 1'
date: 2012-10-30T09:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/2012/10/30/synchronizing-webpages-across-devices-home-automation/
permalink: /2012/10/30/synchronizing-webpages-across-devices-home-automation/
dsq_thread_id:
  - "907048855"
categories:
  - Asp.Net MVC
  - azure
  - CodeProject
  - jQuery
  - jquery mobile
  - knockoutJs
  - signalR
---
After your done with this post, explore the others in this series:
  
_[Part 1 – Synchronizing webpages across devices with SignalR](http://lostechies.com/erichexter/2012/10/30/synchronizing-webpages-across-devices-home-automation/)_
  
_[Part 2 – Architecture for a SignalR Synchronized Webpage Application](http://lostechies.com/erichexter/2012/11/05/architecture-for-a-signalr-synchronized-webpage-application-part-2/)_
  
_[Part 3 – Publish Subscribe using SignalR](http://lostechies.com/erichexter/2012/11/08/publish-and-subscribe-using-signalr-in-home-automation-part-3/)_
  
_[Part 4 – Front End Code Review](http://lostechies.com/erichexter/2012/11/12/code-review-of-a-publishsubscribe-architecture-using-signalr-in-home-automation-part-4/)_

I wrote a front end to my home automation system using a newer set of technologies.  The goal of my new interface is to make it really easy to control the lights in my house with a large number of devices.  The result is that I came up with a solution that allows me to use smart phones, tablets, and pcs.   Making a application that looks good on multiple devices was pretty easy, I used the jQuery Mobile libraries to implement a simple interface.  The challenging part of this solution is that when I have a tablet sitting in my kitchen that shows the current status of the devices, it quickly became outdated when I turned on a light using a different device, like my phone or my computer.  This was an interesting problem to solve.  While the solution is not instantaneous, it is eventually consistent, in terms of seconds.  Below is an example of showing three different browser windows that are running as if they were separate devices.  The video looks best if you view it in HD.


  
&nbsp;

I was able to use a combination of the following libraries, KnockoutJS and SignalR, to add the synchronization of the pages.  The solution did not require using KnockoutJS but the code was greatly simplified using knockout.  The solution is really pretty simple. Each time the use turns a light on or off.  A message is sent to the webserver using SignalR, the command is then sent to my house to a machine that can control the lights, and at the same time an echo of the command is sent to the other user interfaces on all devices.  Then knockout models are updated which updates the jquery mobile user interface.  In the rare occurrence that the home automation system cannot change the status of the lights, a command is sent back to the webserver and the status of the light on all the devices is then reverted.

The next post in this series will dig into the architecture of how this solution is constructed.

Follow me on RSS and Twitter
  
<a href="https://twitter.com/ehexter" style="float:left;valign:top" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float:left" href="http://feeds.feedburner.com/EricHexter" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" style="border:0;padding-right:10px" /></a>