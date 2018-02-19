---
id: 66
title: ASP.Net MVC Portable Areas – Part 3
date: 2009-11-03T17:00:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/11/03/asp-net-mvc-portable-areas-part-3.aspx
permalink: /2009/11/03/asp-net-mvc-portable-areas-part-3/
dsq_thread_id:
  - "262051658"
categories:
  - .Net
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

# Using a Portable Area

This is the third part in a series about using a Portable Area (PA) using MvcContrib.  This sample walks through the Host Application side of consuming the Login Portable area.  This example demonstrates how a portable area such as a login can send messages and recieve responses from the host application.  This allows the host application to control the core of the application and lets the Portable Area solve the User Interface portion of the Login.  While this is a pretty simple example it is important to look at the concept of what a Portable Area could solve.  A portable Area could just handling wiring up multiple user interface screens and deal with simple form validation while leaving a lot of from for the host application to control the parts that are important to the application.  Or a Portable Area could provide an entire self contained piece of functionality like a Blog engine, or mulit-instance forum.  There is a large spectrum for how much the Portable Area could provide.  This example focuses on an example where the Portable Area provides the UI and lets the host application own the domain logic.

  * [Part 1 – Introduction](/blogs/hex/archive/2009/11/01/asp-net-mvc-portable-areas-via-mvccontrib.aspx)
  * [Part 2 – Sample Portable Area](/blogs/hex/archive/2009/11/02/asp-net-mvc-portable-areas-part-2.aspx)
  * Part 3 – Using of a Portable Area  (this post)
  * [Part 4 – Using an Inversion of Control Framework.](/blogs/hex/archive/2009/11/04/asp-net-mvc-portable-area-part-4-ioc-framework-support.aspx)

&nbsp;

In order to use a Portable Area (PA), the following references need to be added to your MVC project: <a href="http://www.mvccontrib.org" target="_blank">MvcContrib</a> & the assembly of the Portable Area.

[<img style="border-width: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_3E70B3A3.png" alt="image" width="244" height="218" border="0" />](//lostechies.com/erichexter/files/2011/03/image_77F3C39A.png)

&nbsp;

Wiring up the Portable Area to the application is done at startup.  Portable Areas use the message bus as a way to communicate between the PA and the application. The main method for integrating with a portable area is to register a Message Handler. The sample below demonstrates wiring up a LogAllMessagesObserver, LoginHandler, and a ForgotPassword Handler for the Login Portable Area.

The call to the InputBuilder.Bootstrap() is required to initialize the Embedded Resource view engine used by this Portable Area infrastructure.

[<img style="border-width: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_14AD38B0.png" alt="image" width="644" height="289" border="0" />](//lostechies.com/erichexter/files/2011/03/image_1D7D40FC.png)

Here is an example of an Observer message handler.  This handler simply logs the message to the debugger. This could be used to collect metrics about the system, or log messages to a loggin framework.  The idea of an observer is that it is looking at the base message and not modifying the state of the message.

[<img style="border-width: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_2AB3A442.png" alt="image" width="644" height="198" border="0" />](//lostechies.com/erichexter/files/2011/03/image_52C65361.png)

The Login Message Handler receives the login request and than sets the result object which is part of the contract that is specified by the LoginPortableArea from Part 2.

[<img style="border-width: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_210B360C.png" alt="image" width="644" height="290" border="0" />](//lostechies.com/erichexter/files/2011/03/image_02A0F523.png)

In this example the main logic for login is still in a authentication service.  The handler is just used to wire up the message and response of the portable area to the host applications domain services.

&nbsp;

## Whats Next?

The constructor of the LoginHandler takes an IAuthenticationService as a dependency and my next post will walk through how an Inversion of Control container can be connected to the Bus to allow the framework of your choice to put your pieces together.

&nbsp;

&nbsp;

&nbsp;