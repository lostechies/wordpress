---
id: 51
title: Performance differences in the ASP.Net MVC View Engine when using two View Engines versus a single Composite View Engine.
date: 2009-06-19T02:01:49+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/18/performance-differences-in-the-asp-net-mvc-view-engine-when-using-two-view-engines-versus-a-single-composite-view-engine.aspx
permalink: /2009/06/19/performance-differences-in-the-asp-net-mvc-view-engine-when-using-two-view-engines-versus-a-single-composite-view-engine/
dsq_thread_id:
  - "262067992"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - IIS
  - mvc
  - testing
  - x64
---
&#160;

While I was testing out my VirtualPathProvider implementation in the Opinionated Input Builders series I ran across an interesting performance difference which was quite surprising.&#160; In fact even after looking at the source code to the MVC ViewEngineCollection it still seemed like this difference should not occur.&#160; But it does and I am sure that we will get to the bottom of this.&#160; 

**Don’t go jumping to any conclusions just yet** about how this performs because the one common piece of functionality that these engines still rely on is a VirtualPathProvider that I implemented and I can honestly say I understand very little about how the VPP is used and how to ensure that it was implemented correctly to ensure maximum performance.

The first part of this graph (the green line) shows the requests / second that I can get through my MVC view when using two ViewEngines, the default view engine to handle all requests to the /Views/{controller} and /Views{Shared} . The second view engine Handles all requests to my virtual path /Views/InputBuilders/ .&#160; At the 7:50 mark I changed the flag and recompiled the application.&#160; You see a small dip while the application restarts with the new code in place.&#160; Now the application uses a single view engine that handles all the views for the default locations and my extra virtual path.

<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_3EB3F6FC.png" width="1028" height="480" />&#160;

&#160;

Here is the part of my codebase that shows the difference between adding my ViewEngine to the collection and Clearing the Collection and adding the view engine with parameters to handle the additional view locations.

&#160;

 <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_4898E867.png" width="1028" height="388" /></p> 

The source code for the project I am testing is located here: <http://code.google.com/p/erichexter/downloads/detail?name=InputBuildersV4.zip&can=2&q=#makechanges> incase you wish to try this out yourself.&#160; The assumptions and environment settings are the same as they were in my previous post ( <http://www.lostechies.com/blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx> ).

I would love to hear from someone who has an eye for performance tuning!