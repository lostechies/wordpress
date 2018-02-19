---
id: 343
title: 'Twitter.Bootstrap.MVC4&ndash; new release 1.0.71'
date: 2012-12-24T10:48:23+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=343
permalink: /2012/12/24/twitter-bootstrap-mvc4-new-release-1-0-71/
dsq_thread_id:
  - "990491085"
categories:
  - Asp.Net
  - Asp.Net MVC
  - Bootstrap.mvc
  - 'c#'
  - CodeProject
  - jQuery
tags:
  - aspnetmvc twitterbootstrap
---
To learn more about the Package read these blog posts:

  * <a href="http://lostechies.com/erichexter/2012/11/20/twitter-bootstrap-mvc4-the-template-nuget-package-for-asp-net-mvc4-projects/" target="_blank">Introduction</a>
  * <a href="http://lostechies.com/erichexter/2012/12/24/twitter-bootstrap-mvc4-new-release-1-0-71/" target="_blank">Release 1.0.71</a>
  * [Bootstrap MVC &#8211; Menu System](http://lostechies.com/erichexter/2012/12/31/using-mvc-navigation-routes-in-twitter-bootstrap-mvc4/)

Some interesting stats for the project. It has gotten a bunch of attention on the interwebs. The package has over 2,500 downloads, we have had 20 pull request(contributions) from github users. I am excited to see a number of active developers using the package from around the world. I would also like to thank the <a href="http://teamcity.codebetter.com/" target="_blank">Codebetter Teamcity</a> team for updating to the latest version of the build server, so I can add the build status icon directly to the readme page, which makes it easier for anyone using our trunk builds.

Here is the updated readme from the site [https://github.com/erichexter/twitter.bootstrap.mvc](https://github.com/erichexter/twitter.bootstrap.mvc "https://github.com/erichexter/twitter.bootstrap.mvc"):

### Overview

This is the [nuget](http://nuget.org/) package for quickly adding [Twitter Bootstrap](http://twitter.github.com/bootstrap/) to an [ASP.Net MVC 4](http://www.asp.net/mvc) application.

See the overview [blog post](http://lostechies.com/erichexter/2012/11/20/twitter-bootstrap-mvc4-the-template-nuget-package-for-asp-net-mvc4-projects/) for screen shots and features. This is a User Interface project that does not require a specific data access or architecture for you MVC applications. The author has some opinions but those are kept in another project that builds on top of this UI package.

#### Features

  * JS and CSS bundling/minification of Twitter Bootstrap files the MVC4 way
  * Incorporate a jQuery validation fix to work with the bootstrap javascript
  * Razor Layout templates using Twitter Bootstrap markup.
  * Menus using Navigation Routes, including submenus and hiding menus by context(logged in vs anonymous)
  * Runtime Scaffolding – default Index, Edit and Detail views.. You provide the [POCOs](http://en.wikipedia.org/wiki/Plain_Old_CLR_Object) and we will render the [CRUD](http://en.wikipedia.org/wiki/Create,_read,_update_and_delete)views.
  * [Post Redirect Get](http://en.wikipedia.org/wiki/Post/Redirect/Get)support using the Bootstrap Alert styles.
  * A Sample to show how to use all of this stuff

Things we are working on:

  * MVC code templates to generate new views from the mvc add view / add controller dialogs
  * Strongly typed Html Helpers to render bootstrap concepts like icons

#### Install

To view a working sample, install the [twitter.bootstrap.mvc4.sample](http://nuget.org/packages/twitter.bootstrap.mvc4.sample).

    > Install-Package twitter.bootstrap.mvc4 > Install-Package twitter.bootstrap.mvc4.sample > Install-Package twitter.bootstrap.mvc4.templates //for MVC Code Templates..(still a work in progress) 

##### Preview Releases

**Preview Releases:** The preview releases are on this nuget feed (<http://www.myget.org/F/erichexter/>)

**Build Status:** [![](https://a248.e.akamai.net/camo.github.com/6d1d23a6d36792411ed8dcc99c1b3c9379655690/687474703a2f2f7465616d636974792e636f64656265747465722e636f6d2f6170702f726573742f6275696c64732f6275696c64547970653a2869643a6274363736292f73746174757349636f6e)](http://teamcity.codebetter.com/viewType.html?buildTypeId=bt676&guest=1)

Brought to you by [Eric Hexter](http://lostechies.com/erichexter/)