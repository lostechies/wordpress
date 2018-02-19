---
id: 38
title: New MassTransit Screencast and Sample
date: 2008-10-23T04:38:02+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/10/23/new-masstransit-screencast-and-sample.aspx
permalink: /2008/10/23/new-masstransit-screencast-and-sample/
dsq_thread_id:
  - "265214436"
categories:
  - .net
---
One of the more common scenarios I hear about when talking about building a service-oriented architecture has to do with providing a web service to external customers. This is often in the context of providing information from an internal system. The problem comes with how many of these systems are built.

In many situations, a web service is created (perhaps with ASP.NET Web services, an .asmx) which accepts a request from a client, performs some query against the production database, and returns the results. This is a very tightly-coupled way of meeting the requirements. How does one go about reducing coupling? Well, all too often the answer is &#8220;just add another web service.&#8221; You can see where this is going. The control still follows a chain of web service requests up until the final connection to the database.

The new [WebServiceBridge](http://code.google.com/p/masstransit/source/browse/#svn/trunk/Samples/WebServiceBridge) sample in MassTransit demonstrates how to break this coupling using the publish/subscribe architecture. When the external web service receives a request, a message is asynchronously published. A subscription to the requested information is added at the same time. A completely insulated service then handles the request, publishing the response to the bus. The web service request that was pending is completed and the results of the query are returned to the client.

In the sample, this all happens with the least amount of load on the web server by using the asynchronous nature of web methods in ASP.NET. This reduces the load on the web servers, making it easier to handle multiple requests without extensive hardware requirements.

Last night I made a screencast that goes through this new sample and shows how it works. You can [download the screencast here](http://blog.phatboyg.com/wp-content/WebServiceBridge.mov) (please Save As to conserve bandwidth). Check it out and let me know what you think. Questions and comments are always welcome!