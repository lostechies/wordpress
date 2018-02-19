---
id: 218
title: Architecture for a SignalR Synchronized Webpage Application
date: 2012-11-05T06:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=218
permalink: /2012/11/05/architecture-for-a-signalr-synchronized-webpage-application-part-2/
dsq_thread_id:
  - "914692179"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - CodeProject
  - jQuery
  - jquery mobile
  - knockoutJs
  - mvc
  - Open Source Software
  - OSS
  - signalR
  - software
---
_using: signalR aspnetmvc knockoutjs javascript jquerymobile x10_

_[Part 1 – Synchronizing webpages across devices with SignalR](http://lostechies.com/erichexter/2012/10/30/synchronizing-webpages-across-devices-home-automation/)_
  
_[Part 2 – Architecture for a SignalR Synchronized Webpage Application](http://lostechies.com/erichexter/2012/11/05/architecture-for-a-signalr-synchronized-webpage-application-part-2/)_
  
_[Part 3 – Publish Subscribe using SignalR](http://lostechies.com/erichexter/2012/11/08/publish-and-subscribe-using-signalr-in-home-automation-part-3/)_
  
_[Part 4 – Front End Code Review](http://lostechies.com/erichexter/2012/11/12/code-review-of-a-publishsubscribe-architecture-using-signalr-in-home-automation-part-4/)_

<span style="font-size: medium;">I gave an overview of how I used SignalR, KnockoutJs, and jQuery Mobile to create synchronizes pages across multiple instance and devices in the last post. Next I will walk through what this looks like architecturally. Below is a diagram which shows the physical deployment of the components of this application.</span>

&nbsp;

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb1.png" alt="image" width="563" height="403" border="0" />](http://lostechies.com/erichexter/files/2012/11/image1.png)

&nbsp;

<span style="font-size: medium;">There is code that runs on all the devices, in a website and on a machine in my house. Below each of the tiers of the application the technologies are listed. </span>

<span style="font-size: medium;">An important element to note is that the devices and the home laptop are both sitting behind firewalls which make it very difficult to communicate with from the internet to the devices. That is really the problem that SignalR solves with incredible ease. </span>

<span style="font-size: medium;">The green arrows are <strong>standard web requests </strong>from the devices to the webserver, the webserver response with a webpage, html, css, and javascript to render the initial page. After that, javascript in the browsers communicate with the webserver <strong>via http using signalR</strong>, represented by the red arrows. This allows the webserver to publish messages (JSON data) back to each browser. Using the same approach, the Agent, can connect to the webserver from behind a firewall and subscribe to events that lets the agent know when it needs to turn on a light or other device in the house. </span>

<span style="font-size: medium;">The best way to look at the use of SignalR is to consider it to be an easy way to implement the Publish Subscribe pattern easily across machines using the http protocol in a firewall friendly way. </span>

&nbsp;

In the next post I will walk through synchronizing the screens in terms of this architecture.

Follow me on RSS and Twitter
  
<a href="https://twitter.com/ehexter" style="float:left;valign:top" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float:left" href="http://feeds.feedburner.com/EricHexter" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" style="border:0;padding-right:10px" /></a>