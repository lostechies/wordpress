---
id: 181
title: 'Portable Areas three years later &#8211; Part 5'
date: 2012-11-26T23:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=181
permalink: /2012/11/26/portable-areas-3-years-later/
dsq_thread_id:
  - "944452714"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - mvc
  - mvccontrib
  - Portable Area
---
I have written a lot about Portable Areas in the past and thought it was a good time for an update. The purpose of a Portable Area has not changed.

This is a multi post series on ASP.Net MVC Portable Areas

  * [Part 1 – Introduction](http://lostechies.com/erichexter/2009/11/01/asp-net-mvc-portable-areas-via-mvccontrib/)
  * [Part 2 – Sample Portable Area](/blogs/hex/archive/2009/11/02/asp-net-mvc-portable-areas-part-2.aspx)
  * [Part 3 – Usage of a Portable Area](/blogs/hex/archive/2009/11/03/asp-net-mvc-portable-areas-part-3.aspx)
  * [Part 4 &#8211; IoC framework support](/blogs/hex/archive/2009/11/04/asp-net-mvc-portable-area-part-4-ioc-framework-support.aspx)
  * [Part 5 &#8211; Update for 2012 / 3 Years Later](http://lostechies.com/erichexter/2012/11/26/portable-areas-3-years-later/)

A Portable Area is a set of reusable multi page functionality can be dropped into an application to provide rich functionality without having to custom build functionality that is literally the same in every application. This could be considered a plug-in or add-in type of functionality.  The **portable** ****portion of this approach is that the area can be distributed as a single assembly rather than an assembly and a host of other files, like views or other html assets that need to be managed and maintained over time.  By making a portable area totally self contained in a single assembly, this should allow for easier reuse and upgrades to the area.  The challenge for doing something like this has been how do you allow enough control over the User Interface by the application yet still allow the actual views to be packaged with the logic.

Since the creation of Portable Areas I think the [disruptive technology](http://en.wikipedia.org/wiki/Disruptive_innovation)introduction of Nuget really changes the implementation of how a Portable Area should be created. A large portion of the challenge that Portable Areas solved was the ability to easy transport, view and assets(Css, javacript) files into an application. Nuget has made this problem go away. So the big sell of a Portable Area is the use of the Message Bus as a way to loosely couple the portable area to the application that is using it. This means the need for the Virtual Path Provider implemented by the MvcContrib project does not need to be used. That is nice because of a couple of reasons. I wrote the virtual path provider and no one has maintained but me. The code is a mess to work with and completely untestable. The use of Virtual Path Providers are discouraged by the ASP.Net team. They can cause performance problems and generally are problematic. I totally agree and I am glad that Nuget allows us to package the views, css, and javascript files into a nuget package as the method for distributing Portable Areas now.

The MessageBus in MvcContrib was good when MVC2 first came out but since then other Mediator packages are available, I would encourage you to use [ShortBus](http://nuget.org/packages/ShortBus)as the Mediator implementation and push that over the use of the MvcContrib bus. I think it is better to rely on a package that has a single purpose rather than the one in MvcContrib going forward.

&nbsp;

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/10/image_thumb4.png" alt="image" width="520" height="402" border="0" />](http://lostechies.com/erichexter/files/2012/10/image7.png)

Here is an updated diagram of how a Portable Area works with an application.

&nbsp;

Follow me on RSS and Twitter
  
<a href="https://twitter.com/ehexter" data-show-count="false" data-size="large">Follow @ehexter</a><a title="Subscribe to my feed" type="application/rss+xml" href="http://feeds.feedburner.com/EricHexter" rel="alternate"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" /></a>