---
id: 351
title: using MVC Navigation Routes in Twitter.Bootstrap.MVC4
date: 2012-12-31T00:01:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=351
permalink: /2012/12/31/using-mvc-navigation-routes-in-twitter-bootstrap-mvc4/
dsq_thread_id:
  - "1000902926"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - Bootstrap.mvc
  - Open Source Software
  - OSS
---
One of the features that the Twitter.Bootstrap.MVC4 <a href="http://nuget.org" target="_blank">nuget</a> package provides is a simple route based menu system.  By adding explicit routes to your application you can control, the top menu for your application.

To learn more about the Package read these blog posts:

  * <a href="http://lostechies.com/erichexter/2012/11/20/twitter-bootstrap-mvc4-the-template-nuget-package-for-asp-net-mvc4-projects/" target="_blank">Introduction</a>
  * <a href="http://lostechies.com/erichexter/2012/12/24/twitter-bootstrap-mvc4-new-release-1-0-71/" target="_blank">Release 1.0.71</a>
  * [Bootstrap MVC &#8211; Menu System](http://lostechies.com/erichexter/2012/12/31/using-mvc-navigation-routes-in-twitter-bootstrap-mvc4/)

The concept is pretty simple, create some routes in a specific way, and your menu will light up in the application.  The recent release of the package also supports creating submenus. It was the most requested feature on the initial release. I will walk through the code that is provided using the Sample nuget package.  The first piece to look at is the Route Registration.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/12/image_thumb.png" alt="image" width="863" height="328" border="0" />](http://lostechies.com/erichexter/files/2012/12/image.png)

The code here creates to menu items: Automatic Scaffolding and Example Layouts.  The second menu item then has three child menu items.  The code is pretty simple, there are a number of defaults that happen under the hood, but the thing to know is that we are using the built in Routes from asp.net

&nbsp;

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/12/image_thumb1.png" alt="image" width="864" height="326" border="0" />](http://lostechies.com/erichexter/files/2012/12/image1.png)

You can see the menu highlights the Example Layouts as I hover over it and show the child menu items. This menu system is pretty basic but it covers most of the use cases with the support for child menus.

&nbsp;

To use the Twitter.Bootstrap.MVC4 package. just install it from nuget into a new MVC4 **Empty** project  template. And you can see the code working for yourself.

install-package Twitter.Bootstrap.Mvc4.sample

&nbsp;

The menu system also support a filter concept which you can use to show and hide specific items based on the request context. Think about using this for an authenticated users versus an anonymous user.  Another use case would be to show and hide items for a user with a specific role.  I will show how to use this feature in the next blog post.