---
id: 82
title: Using ModelMetaData in ASP.Net MVC 2 to wire up sweet jQuery awesomeness
date: 2010-06-23T16:26:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2010/06/23/using-modelmetadata-in-asp-net-mvc-2-to-wire-up-sweet-jquery-awesomeness.aspx
permalink: /2010/06/23/using-modelmetadata-in-asp-net-mvc-2-to-wire-up-sweet-jquery-awesomeness/
dsq_thread_id:
  - "262083395"
categories:
  - Asp.Net MVC
  - jQuery
  - mvc
---
I recently came up with an approach to wiring up some jquery plugins that modify the behavior of standard input text boxes.&nbsp; The approach is not original by any means.I got the idea from the built in client side validation for MVC2, which was inspired by Steve Sanderson&#8217;s xVal framework.

&nbsp;

The goal.&nbsp; I wanted a way to add both Watermark and Masked Input functionality to text boxes on my MVC views.&nbsp; I wanted to do this in an unobtrusive jQuery-ish way.&nbsp; I also did not want to reinvent the Editor templates or TextBox html helpers in the MVC framework. So I settled on this approach.

&nbsp;

I added a html extension method that takes the ModelMetaData for the current views Model class and write a JSON variable to the view.&nbsp; Its just a small data object at this point, with a well known name.&nbsp; I then wired in a generalized javascript file that would read the JSON data and then wire up the appropriate jQuery plugins. Sounds simple enough right?&nbsp; Well it really was.

Lets look at some code.

The ViewModel marked up with some custom attributes to give a declarative way of defining the values used to bind to the plugins. I have added a Watermark and EditFormat attributes that are picked up by a modified ModelMetaDataProvider. This is what I use to specify the MaskedInput format (EditFormat) and the Watermark for the jQuery plugins.

[<img height="222" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_thumb_586513C2.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_0796FF5A.png)&nbsp; 

&nbsp;

A simple extension method to drop some JSON onto your page. This is nice and simple and could be moved into the object Editor Template if you wanted to just get this functionality by default.

[<img height="143" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_thumb_1AA80639.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_50F92E48.png) 

The MetaDataForModel extension method is a bit of a mess (this is prototype code) The end result is that it. Finds all of the metadata properties that contain EditFormat data or Watermark data and serializes that to JSON. It is than put into a javascript variable so that the data can be picked up by client side javascript.

&nbsp;

[<img height="627" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_thumb_45BC2BD9.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_5C1292C5.png)

The resulting Html markup, shows the javascript and the JSON formatted data.

[<img height="325" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_thumb_567BAE89.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_026C4E13.png) 

The common javascript to autowire all plugins to the input controls.&nbsp; This function uses jQuery to run on page load.&nbsp; It first looks to make sure that the JSON variable is defined and if it is, it loops through the JSON data and properties.&nbsp; If a particular MetaData value is present (not null) than the plugins are wired up(see lines 8 and 11).&nbsp; This javascript was written so that it can be loaded onto any page and will autowire the plugins if this metadata is present, if it is not it will just do nothing.&nbsp; 

[<img height="281" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_thumb_428E2DC1.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_35C3FD70.png)

&nbsp;

The resulting page showing a Watermark plugin auto wired up.

[<img height="202" width="644" src="//lostechies.com/erichexter/files/2011/03/image_thumb_55029044.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_60984D83.png) 

The resulting page showing the Masked Input auto wired up for the Bar property. One the cursor is placed into the Bar text box the plugin hides the Watermark and applies the MaskedInput plugin.

[<img height="209" width="644" src="//lostechies.com/erichexter/files/2011/03/image_thumb_181DE8A5.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_7E2A2882.png)

&nbsp;

What do you think of the approach?&nbsp; I did not supply a sample code as I have this working for a project at work and I did not want to let getting a sample together get in the way of getting this blog post up.&nbsp; If there is interest I can put together a sample, or better yet, maybe we can fit this into mvccontrib in some way..