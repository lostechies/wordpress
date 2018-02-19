---
id: 232
title: 'Publish and Subscribe using SignalR in Home Automation &ndash; Part 3'
date: 2012-11-08T05:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=232
permalink: /2012/11/08/publish-and-subscribe-using-signalr-in-home-automation-part-3/
dsq_thread_id:
  - "919030719"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - jQuery
  - jquery mobile
  - knockoutJs
  - Open Source Software
  - OSS
  - signalR
---
_using signalR aspnetmvc knockoutjs javascript jquerymobile x10_

_[Part 1 – Synchronizing webpages across devices with SignalR](http://lostechies.com/erichexter/2012/10/30/synchronizing-webpages-across-devices-home-automation/)_
  
_[Part 2 – Architecture for a SignalR Synchronized Webpage Application](http://lostechies.com/erichexter/2012/11/05/architecture-for-a-signalr-synchronized-webpage-application-part-2/)_
  
_[Part 3 – Publish Subscribe using SignalR](http://lostechies.com/erichexter/2012/11/08/publish-and-subscribe-using-signalr-in-home-automation-part-3/)_
  
_[Part 4 – Front End Code Review](http://lostechies.com/erichexter/2012/11/12/code-review-of-a-publishsubscribe-architecture-using-signalr-in-home-automation-part-4/)_

<span style="font-size: medium;">I previously covered the overview and architecture for a home automation application using signalR, knockoutJS, and asp.net mvc in previous posts. In this post I will dive into the sequence diagram of how a ui interaction, to turn on a light bulb sends messages through the application.</span>

<span style="font-size: medium;">I will walk through the technical portion of a simple user story.</span>

_<span style="font-size: medium;">As the home owner, I want <strong>to turn on my light</strong> from my phone before I get home and walk in the door, so that I don’t trip over the dog.</span>_

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb2.png" alt="image" width="560" height="131" border="0" />](http://lostechies.com/erichexter/files/2012/11/image2.png)

_<span style="color: #666666;">This is what the storyboard looks like in for the application.</span>_

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb3.png" alt="image" width="580" height="223" border="0" />](http://lostechies.com/erichexter/files/2012/11/image3.png)

_<span style="color: #666666;">This is the user interface interaction which starts this event in the application.</span>_

&nbsp;

<span style="font-size: medium;">Above, I have outlined the story board in which, the user navigates to the application from their phone, and they then click on a button in the application. When they walk in the door, they are delighted by how far technology has come.</span>

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb4.png" alt="image" width="551" height="648" border="0" />](http://lostechies.com/erichexter/files/2012/11/image4.png)

<span style="color: #666666; font-size: medium;"><em>Sequence diagram of the startup, page load, and light on interaction.</em></span>

<span style="font-size: medium;">The figure above shows a few interesting system interactions. </span>

  * <span style="font-size: medium;">The Agent startups and immediately subscribes to the webserver to start receiving events to turn lights on and off.</span>
  * <span style="font-size: medium;">A browser connects to the website, loads a page, then subscribes to state change events. This allows a device like a tablet to stay in sync as a light is turned on from a mobile phone.</span>
  * <span style="font-size: medium;">A browser then turns on a light by changing the toggle button on the screen. From there the webserver broadcasts the UI change to all the connected web browsers, then it sends a message to the agent to turn on the light. The agent then calls into the x10 command line and issues the on command.  Depending on the outcome of that command, the success or failure is then messaged back to the webserver.  When the updated state of the light is received it is sent to the browsers. This last step is really used for the case where the Agent not being able to change the state of the light. This is called a compensating action.  The browsers should already show the correct state, because the webserver already broadcasted the state change, assuming the agent could correctly execute the command.</span>

<span style="font-size: medium;">The use of the publish/subscribe and messaging patterns helps the application present a more cohesive and responsive feeling to users who may change the state from a phone, but also have a tablet running in their kitchen.</span>

<span style="font-size: medium;">The nature of using signalR as a message bus to publish events and allow various components of the application subscribe to those events allows the application to decouple each component in a healthy way. Making some assumptive events in addition to making corrective events in the case of a failure of a particular command, like turn on the light, are really easy and clean in terms of the implementation using SignalR.</span>

<span style="font-size: medium;">In the next post, I will walk through the code in this scenario in details.</span>

Follow me on RSS and Twitter
  
<a href="https://twitter.com/ehexter" style="float:left;valign:top" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float:left" href="http://feeds.feedburner.com/EricHexter" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" style="border:0;padding-right:10px" /></a>