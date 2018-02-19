---
id: 265
title: 'Code review of a Publish/Subscribe Architecture using SignalR in Home Automation &ndash; Part 4'
date: 2012-11-12T05:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=265
permalink: /2012/11/12/code-review-of-a-publishsubscribe-architecture-using-signalr-in-home-automation-part-4/
dsq_thread_id:
  - "924313190"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - jQuery
  - jquery mobile
  - mvc
  - signalR
---
_[Part 1 – Synchronizing webpages across devices with SignalR](http://lostechies.com/erichexter/2012/10/30/synchronizing-webpages-across-devices-home-automation/)_
  
_[Part 2 – Architecture for a SignalR Synchronized Webpage Application](http://lostechies.com/erichexter/2012/11/05/architecture-for-a-signalr-synchronized-webpage-application-part-2/)_
  
_[Part 3 – Publish Subscribe using SignalR](http://lostechies.com/erichexter/2012/11/08/publish-and-subscribe-using-signalr-in-home-automation-part-3/)_
  
_[Part 4 – Front End Code Review](http://lostechies.com/erichexter/2012/11/12/code-review-of-a-publishsubscribe-architecture-using-signalr-in-home-automation-part-4/)_

Previously, I covered an example of synchronizing webpages across multiple devices in the context of a Home Automation application which can control lights in a house using any internet connected device. I also covered the architecture and went into some detail around using a publish/subscribe approach to connecting the browsers, web application, and the agent that controls the lights in the home together.

In this post, I am going to go into some more detail around the code to connect the use case together.

First, let us cover rendering the initial html page.

While it is really simple to render an html page from MVC, the real trick is when we want to support screen synchronization. In order to do this, we need to dynamically update the html. This is where we move from traditional html generation from a razor page and instead move to a javascript based templating library. In this case I used KnockoutJS to solve this problem. I mention this because if we were only going to render an html page, the code to render the page with KnockoutJS seems like more trouble than it is worth when you compare it to its razor equivalent. But as you have already seen, keeping the screens synchronized is a really nice feature that becomes really simple when bringing in KnockoutJS as part of the solution with SignalR.

Let’s start with the MVC viewmodel and show it is maps to the screenshot of the rendered page.
  

  
The viewmodel is nice and simple, to collections of objects that will be used to generate a list of push buttons and a list of toggle buttons. Below you can see the mapping of the collections to each column in the page.

[<img style="background-image: none; margin: 0px; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb5.png" alt="image" width="244" height="131" border="0" />](http://lostechies.com/erichexter/files/2012/11/image5.png)

This shows how the ViewModel maps to the User Interface

<pre>The controller is pretty straight forward as well. This is an example and for simplicity I am new’ing up the two repositories ...Don’t do this in your project, use constructor injection.  The Index action, calls to the repositories and maps the two collections to the view model. Simple .</pre>


  
Here is how the controller populates the ViewModel

Now comes the fun part. The razor file to render the page. In this page we are pulling together a number of technologies, Razor, c#, Knockout JS, Javascript, jQuery Mobile, jQuery, and SignalR. We need to spend some time going through each aspect and dissecting how we got to the mark up that is in this template. The list of push buttons, which is created by looping through the Model.Scense collection just outputs server side html. This is because we do not need to update the state of the buttons once the page is rendered, so just looping through the collection server side is simple and easy.

The next block of code renders the toggle buttons, here we are using client side binding. KnockoutJS is controlling the foreach loop in javascript and creating the html in the browser after the page loads.


  
The mvc view to create the page using knockout

Let’s dissect the markup by library.

This view has three vectors we can discuss here.

1. jQuery Mobile html tags and css classes

2. ASP.Net MVC Razor markup to generate the Scene buttons, server side

3. KnockoutJS client side templating to create the toggle buttons and support synchronization across browsers

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb6.png" alt="image" width="679" height="339" border="0" />](http://lostechies.com/erichexter/files/2012/11/image6.png)

jQuery Mobile specific code underlined

In the figure above, the jQuery Mobile css classes have been underlined. These classes are used with the html tags by jQuery Mobile framework to make style the form and elements to match the screen shot. The jQuery mobile uses a combination of class values and some html5 **data-** attributes, that are specific to the jQuery Mobile framework. In this view the only additional attribute we need for the jQuery Mobile is the **data-role**.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb7.png" alt="image" width="675" height="334" border="0" />](http://lostechies.com/erichexter/files/2012/11/image7.png)

ASP.Net MVC Razor syntax highlighted underlined

This code shows that a razor foreach loop is used to generate the html for the Scene buttons. This code is used to create the buttons server side, because the buttons do not need to be synchronized across the browsers. So writing this code using server side generation is the simplest way to create this portion of the page.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb8.png" alt="image" width="726" height="368" border="0" />](http://lostechies.com/erichexter/files/2012/11/image8.png)

KnockoutJS specific markup is underlined

KnockoutJS uses more of the **data-** attributes to implement its databinding. For this view all the attributes that we use for the KnockoutJS functionality are all the same attribute, **data-bind**. It does have some nested syntax, for example we use a foreach loop to loop over all the Devices and create the toggle switch for each device in the collection. Another interesting feature that was needed was the **attr** construct using in the select html tag. The gist of what knockout is doing is just mapping html attributes to properties values on the model. This feels similar to the Razor server side syntax but it varies just a little bit since the binding code is run in the browser rather than on the server.

We made it through the markup of the page, that is the first half of what is needed in the browser. Now let us look at the javascript to wire this page together.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb9.png" alt="image" width="714" height="678" border="0" />](http://lostechies.com/erichexter/files/2012/11/image9.png)

Razor markup used to render the javascript underlined

There is a little trick I used here to make the initial page load as fast as possible. I included the model serialized as JSON in the javascript code. See the underlined code in the figure above. Doing this eliminated an additional network call back to the webserver to load this data the first time the page loads. This will make the initial webpage load much faster, especially on mobile phones were the network connection is slower. This entire set of javascript is rendered in the Layout page’s Scripts section, using the @section construct.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb10.png" alt="image" width="697" height="662" border="0" />](http://lostechies.com/erichexter/files/2012/11/image10.png)

The KnockoutJS specific code is underlined

The Knockout specific code is underlined, in addition to the standard knockoutJS library, I also used the mapping plugin. The Mapping plugin is like AutoMapper for knockout viewmodels. It makes it a single method to convert a viewmodel with a collection of child items into the correct Observable equivalents. This mapping plugin easily saved 20-30 lines of repetitive mapping code. The mapping plugin is available from nuget or a download from the KnockoutJS site. The next line after the mapping of the view model is the standard applyBindings command which initializes KnockoutJS and then in turn lets it look at the markup and data- attributes on the page to dynamically render the client side templates. The other important to note items are underlined. In Knockout the viewmodel properties need to be set using a method of the same name, this allows the two way databinding to update the html when you change the value of the javascript in memory objects. This functionality is the magic sauce which makes the multi browser synchronization so easy to implement in a few lines of code. It also keeps the javascript code pretty clean, because in the SignalR handlers I just need to update my javascript viewmodel and I do not need to embed code to update the html document object model.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb11.png" alt="image" width="711" height="676" border="0" />](http://lostechies.com/erichexter/files/2012/11/image11.png)

The jQuery Mobile constructs are underlined.

The jQuery Mobile specific code is underlined, the most important aspect to note, is that the .slider() plugin was manually called by javascript after the knockout applyBindings. This is important because the plugin need to be initialized after knockout created the elements in the DOM. Other areas to look at are the change and click handlers that are applied to the select and button inputs. Finally the .slider(‘refresh’) is called to update the toggle buttons after knockout refreshes the DOM when the screens are synchronized.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb12.png" alt="image" width="724" height="691" border="0" />](http://lostechies.com/erichexter/files/2012/11/image12.png)

The SignalR constructs are underlined in the figure above. The initial call creates an instance of the hub, this is the javascript proxy that manages the connections to the server. The next two underlined pieces of code represent the event handler for messages which are published from the server side signalR events. The last line of the script turns on the signalR hub to connect and start receiving message from the server.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb13.png" alt="image" width="715" height="682" border="0" />](http://lostechies.com/erichexter/files/2012/11/image13.png)

In the handlers for the toggle button and the push buttons, the hub is called and this is where we send the address of the x10 device and the scene to execute on the agents. We use the jQuery data function to pull a piece of application state data that is unique to each button. This is stored in the data-x10 element in the markup. Using signalR here makes the code clean because we just publish the message to the server and we do not need to handle a response as part of this method. We handle the response in the event handler we hook up in the hub.broadcastDeviceState message. The anonymous function takes two values, there are defined in the server side portion of the signalR code (I will show that in the next post). We setup a handler for the broadcastHeartbeat message as well. Similar to the previous function.

In this post, I walked through the server side razor template and dissected it into each library that we are using in the stack. While it is complicated to pull all the pieces together from a concept count, the resulting code is simple and clean. We are using unobtrusive javascript and we have a nice clean separate of mark up and code.

In the next post I will show the server side SignalR hub.

Follow me on RSS and Twitter
  
<a href="https://twitter.com/ehexter" style="float:left;valign:top" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float:left" href="http://feeds.feedburner.com/EricHexter" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" style="border:0;padding-right:10px" /></a>