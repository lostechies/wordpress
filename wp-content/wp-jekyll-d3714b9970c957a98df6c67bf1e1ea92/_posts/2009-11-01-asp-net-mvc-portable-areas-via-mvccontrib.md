---
id: 64
title: ASP.Net MVC Portable Areas via MvcContrib
date: 2009-11-01T18:00:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/11/01/asp-net-mvc-portable-areas-via-mvccontrib.aspx
permalink: /2009/11/01/asp-net-mvc-portable-areas-via-mvccontrib/
dsq_thread_id:
  - "262051113"
categories:
  - .Net
  - Asp.Net MVC
  - mvc
  - mvccontrib
  - Open Source Software
  - OSS
---
Follow me on RSS and Twitter
  
<a class="twitter-follow-button" style="float: left; valign: top;" href="https://twitter.com/ehexter" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float: left;" title="Subscribe to my feed" type="application/rss+xml" href="http://feeds.feedburner.com/EricHexter" rel="alternate"><img style="border: 0; padding-right: 10px;" src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" /></a>

&nbsp;

This is a multi post series on ASP.Net MVC Portable Areas

  * [Part 1 – Introduction](http://lostechies.com/erichexter/2009/11/01/asp-net-mvc-portable-areas-via-mvccontrib/)
  * [Part 2 – Sample Portable Area](/blogs/hex/archive/2009/11/02/asp-net-mvc-portable-areas-part-2.aspx)
  * [Part 3 – Usage of a Portable Area](/blogs/hex/archive/2009/11/03/asp-net-mvc-portable-areas-part-3.aspx)
  * [Part 4 &#8211; IoC framework support](/blogs/hex/archive/2009/11/04/asp-net-mvc-portable-area-part-4-ioc-framework-support.aspx)
  * [Part 5 &#8211; Update for 2012 / 3 Years Later](http://lostechies.com/erichexter/2012/11/26/portable-areas-3-years-later/)

## 

## What is a Portable Area?

A Portable Area is a set of reusable multi page functionality can be dropped into an application to provide rich functionality without having to custom build functionality that is literally the same in every application. This could be considered a plug-in or add-in type of functionality.  The **portable** portion of this approach is that the area can be distributed as a single assembly rather than an assembly and a host of other files, like views or other html assets that need to be managed and maintained over time.  By making a portable area totally self contained in a single assembly, this should allow for easier reuse and upgrades to the area.  The challenge for doing something like this has been how do you allow enough control over the User Interface by the application yet still allow the actual views to be packaged with the logic.

## Why Now?

There has been some discussion in the past on the MvcContrib mailing list about creating an plug-in framework and plugins but I do not think we had enough of the pieces in place to do this properly.   I believe that with MVC 2 we have those missing pieces figured out.  The first enabler is the inclusion of Areas into the MVC 2 feature set. This includes having the Area and Controller namespace become part of the route data which is used both for Controller/Action selection but this also flows down to the selection of a view. The second enabler is some of the work that came out of MvcContrib and the Input Builders.  While implementing that feature we came up with a way to pull views from an assembly as an embedded resource.  This with the ability to override the default view engine in a way that allows an application developer to place their own version of a view in a folder so that they have the option to change the view to their needs was huge.  The last enabler really comes from what we have learned from all of the SOA greats and see how frameworks like nServiceBus and MassTransit have demonstrated that a messaging approach for integration can keep our concerns separated.

The other why now is that my company, [Headspring](http://www.headspring.com), has found that in order to make our practice more successful, we need the ability to drop in some of the essentials for an application, we would prefer to do this in a binary form that is easy to upgrade and does not leave us with copy and pasted code between our various projects.  We would like to see that if we learn something from one project that we have the potential to apply those learning&#8217;s to projects that are still in flight. We all prefer that rather than waiting for the next project to start so that we can apply what we have learned to the new project.  This approach will be much better for us as developers and our client will benefit as well.  We could take the approach of working on this in a bubble but by putting this out for the community we can learn from every else and potentially help others in the process and raise the collective bar for the industry, in our own little way.

&nbsp;

## Logical View of a Portable Area

Below is a logic view of a Portable Area.  It shows how the <span style="color: #80ff00;">Green block</span> is an application.  Inside the application the blocks in <span style="color: #004080;">dark blue</span> are framework components in ASP.Net MVC 2 and MvcContrib.  These blocks provide some minimal framework support for registration view resolution and communication between the application and the portable area.  The light blue blocks represent code the developer create.  The code in the Portable Area is created by the Portable Area developer. The code in the application block is coded by… you guessed it. The application developer.

[<img style="border-width: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_35686ED4.png" alt="image" width="614" height="480" border="0" />](//lostechies.com/erichexter/files/2011/03/image_176A60E0.png)

## Thanks for the Pictures but where is the code?

The code is currently available in the MvcContrib MVC 2 Branch.  You can get the latest binary from our (TeamCity/CodeBetter) build server here:  [http://teamcity.codebetter.com/guestAuth/repository/download/bt83/.lastSuccessful/MVCContrib.release.zip](http://teamcity.codebetter.com/guestAuth/repository/download/bt83/.lastSuccessful/MVCContrib.release.zip "http://teamcity.codebetter.com/guestAuth/repository/download/bt81/.lastPinned/MVCContrib.release.zip")

There is a sample application you can download here: [http://teamcity.codebetter.com/guestAuth/repository/download/bt83/.lastSuccessful/MVCContrib.Extras.release.zip](http://teamcity.codebetter.com/guestAuth/repository/download/bt83/.lastSuccessful/MVCContrib.Extras.release.zip "http://teamcity.codebetter.com/guestAuth/repository/download/bt83/.lastSuccessful/MVCContrib.Extras.release.zip")

or from the code repository on GitHub:  [Download the source as a zip](http://github.com/mvccontrib/MvcContrib/zipball/mvc2).  or [Fork it on GitHub](http://github.com/mvccontrib/MvcContrib/tree/mvc2).

Follow me on RSS and Twitter
  
<a class="twitter-follow-button" style="float: left; valign: top;" href="https://twitter.com/ehexter" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float: left;" title="Subscribe to my feed" type="application/rss+xml" href="http://feeds.feedburner.com/EricHexter" rel="alternate"><img style="border: 0; padding-right: 10px;" src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" /></a>