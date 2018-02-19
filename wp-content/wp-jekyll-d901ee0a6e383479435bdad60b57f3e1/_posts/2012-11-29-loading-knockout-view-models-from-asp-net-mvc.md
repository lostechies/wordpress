---
id: 324
title: Loading KnockoutJS View Models from ASP.Net MVC, for faster page loads
date: 2012-11-29T23:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=324
permalink: /2012/11/29/loading-knockout-view-models-from-asp-net-mvc/
dsq_thread_id:
  - "949133224"
categories:
  - Asp.Net
  - Asp.Net MVC
  - CodeProject
  - javascript
  - knockoutJs
---
This is a little deep dive that came out of a previous post on my [SignalR Series](http://lostechies.com/erichexter/2012/11/12/code-review-of-a-publishsubscribe-architecture-using-signalr-in-home-automation-part-4/).

&nbsp;

### Background

First lets talk about a little background.  The popularity of the Single Page Application (SPA) has seen its rise and fall, as companies like twitter moved from server side page renering to loading the initial page with ajax calls back to the server. Then after a few months, they moved back to initial [server side rendering](http://www.webmonkey.com/2012/05/twitter-declares-everything-old-new-again/) because of the perceived page load to the browser. After all, the aspect of user experience that matters on the web is perceived page load.

### The Problem

Now, lets fast forward. While we can deliver a faster initial page load using server side rendering, if we want to update the web page after it has loaded with data from an ajax call we get into a dilemma of having both server side templates and client side templates to maintain.  This is the part that sucks from a code maintainability aspect. This means extra work when you add a new feature or fix a bug. Even worse, you may fix a bug in on and not realize it needed to be fixed in the other template technology.

### A Solution

The solution using [ASP.Net MVC](http://www.asp.net/mvc) and [KnockoutJS](http://knockoutjs.com/index.html) is pretty simple. Rather then loading the viewmodel from an ajax call just write the viewmodel from the server side razor template as a JSON object into the javascript of the page. Then use the [KnockoutJS Mapping plugin](http://knockoutjs.com/documentation/plugins-mapping.html) to map from the json object to the observable objects required by KnockoutJS. To install the mapping plugin, use the <a href="http://nuget.org/packages/Knockout.Mapping" target="_blank">nuget package.</a>

There are two pieces of code needed to make this solution work.


  
Access the mapping plugin by calling ko.mapping in the view and pass in the JSON representation of your server side view model.  That brings us to the .ToJson extension method. This is a small piece of code I wrote to simplify the Json serialization using [Json.Net](http://nuget.org/packages/Newtonsoft.Json).



This little trick will simplify your code maintenance and also clean up your client side view models, by reducing the amount of object initialization you need to write. This really comes into play when you have a number of collections on your viewmodel.

Follow me on RSS and Twitter
  
<a class="twitter-follow-button" style="float: left; valign: top;" href="https://twitter.com/ehexter" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float: left;" title="Subscribe to my feed" type="application/rss+xml" href="http://feeds.feedburner.com/EricHexter" rel="alternate"><img style="border: 0; padding-right: 10px;" src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" /></a>