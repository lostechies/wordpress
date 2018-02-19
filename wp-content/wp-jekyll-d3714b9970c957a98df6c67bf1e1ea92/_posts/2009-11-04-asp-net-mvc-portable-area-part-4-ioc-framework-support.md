---
id: 67
title: ASP.Net MVC Portable Area – Part 4 IoC framework support.
date: 2009-11-04T05:00:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/11/04/asp-net-mvc-portable-area-part-4-ioc-framework-support.aspx
permalink: /2009/11/04/asp-net-mvc-portable-area-part-4-ioc-framework-support/
dsq_thread_id:
  - "262051974"
categories:
  - Asp.Net
  - Asp.Net MVC
  - Portable Area
---
This is a multi post series on ASP.Net MVC Portable Areas

  * [Part 1 – Introduction](http://lostechies.com/erichexter/2009/11/01/asp-net-mvc-portable-areas-via-mvccontrib/)
  * [Part 2 – Sample Portable Area](/blogs/hex/archive/2009/11/02/asp-net-mvc-portable-areas-part-2.aspx)
  * [Part 3 – Usage of a Portable Area](/blogs/hex/archive/2009/11/03/asp-net-mvc-portable-areas-part-3.aspx)
  * [Part 4 &#8211; IoC framework support](/blogs/hex/archive/2009/11/04/asp-net-mvc-portable-area-part-4-ioc-framework-support.aspx)
  * [Part 5 &#8211; Update for 2012 / 3 Years Later](http://lostechies.com/erichexter/2012/11/26/portable-areas-3-years-later/)

Using an Inversion of Control Container is a common scenario that would be needed by a Message Handler.  The Bus has an extensibility point to create the handlers. The model for this should feel similar to the ControllerFactory extension point in the ASP.Net MVC framework.  The sample below shows how to create a Message Handler factory for the StructureMap framework.

&nbsp;

[<img style="border-width: 0px;" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_2CCFB735.png" alt="image" width="644" height="179" border="0" />](http://lostechies.com/erichexter/files/2011/03/image_600BF09E.png)

&nbsp;

The SetMessageHandlerFactory method should be called once at application startup.   Other than that … this is a pretty simple way to add a Dependency Injection Framework support to the Portable Area infrastructure.

&nbsp;

This makes it pretty simple for your message handlers to use constructor injection to manage their dependencies.