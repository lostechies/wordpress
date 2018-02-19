---
id: 307
title: Twitter.Bootstrap.MVC4; the Bootstrap package for ASP.Net MVC4
date: 2012-11-20T23:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=307
permalink: /2012/11/20/twitter-bootstrap-mvc4-the-template-nuget-package-for-asp-net-mvc4-projects/
dsq_thread_id:
  - "934107937"
categories:
  - Asp.Net
  - Asp.Net MVC
  - Bootstrap.mvc
  - CodeProject
  - mvc
  - nuget
  - Open Source Software
  - OSS
---
**UPDATE:** To learn more about the Package read these blog posts:

  * <a href="http://lostechies.com/erichexter/2012/11/20/twitter-bootstrap-mvc4-the-template-nuget-package-for-asp-net-mvc4-projects/" target="_blank">Introduction</a>
  * <a href="http://lostechies.com/erichexter/2012/12/24/twitter-bootstrap-mvc4-new-release-1-0-71/" target="_blank">Release 1.0.71</a>
  * [Bootstrap MVC &#8211; Menu System](http://lostechies.com/erichexter/2012/12/31/using-mvc-navigation-routes-in-twitter-bootstrap-mvc4/)

[Bootstrap](http://twitter.github.com/bootstrap/) as described by the project website is:

> “Sleek, intuitive, and powerful front-end framework for faster and easier web development”.

It is open source and was written and supported by [Twitter](http://twtitter.com). Unlike most [front end frameworks](http://en.wikipedia.org/wiki/CSS_frameworks), Bootstrap is interesting because in addition to it being a full featured CSS framework, it adds javascript plugins, typography, html scaffolding and components. The best part is that I am cool with all of Bootstraps dependencies, which means I like it. An advantage that Bootstrap has over the default ASP.Net MVC template is that it is designed to be extended and changed. There are a whole host of themes for bootstrap that build on the basic html structure and css classes, so if you want to change the look you can drop these in. Check out [WrapBootstrap](https://wrapbootstrap.com/), [Bootswatch](http://bootswatch.com/), and other [Resources](http://designshack.net/articles/css/20-awesome-resources-for-twitter-bootstrap-lovers/).

## Twitter.Bootstrap.MVC4 Nuget

Introducing the [Twitter.Bootstrap.MVC4](http://nuget.org/packages/twitter.bootstrap.mvc4) nuget package; It will save you time adding bootstrap to MVC4. It combines the existing Bootstrap package with MVC 4 and makes you more productive from step one. This is the work of a spike [Matt Hinze](http://lostechies.com/matthinze/) created, I then packaged it up to share it with the world.

### Install twitter.bootstrap.mvc4 from nuget

> > Install-Package twitter.bootstrap.mvc4
  
> > Install-Package twitter.bootstrap.mvc4.sample

### 

This nuget package does the following: (so you don’t have to)

  1. **Razor Layout** template, it includes the standard sections that are in the default razor templates, like the head and scripts sections.
  2. **Bundles** the bootstrap CSS and Javascript files, for combination and minification of the default files, using the new MVC 4 bundling feature.
  3. **Navigation Routes** helper to create the top menu of your site quickly.
  4. **Default Views** for Index, Details, and Edit. You can use this for all of your admin screens. No need to write views for any of the CRUD based screens. Spend your time writing the front end of your application/website.
  5. **Alerts** are added through helper function in a controller ****base class using [tempdata](http://www.devcurry.com/2012/05/what-is-aspnet-mvc-tempdata.html) for the [Post-Redirect-Get](http://en.wikipedia.org/wiki/Post/Redirect/Get) pattern.
  6. **View Templates**, for form generation from built in MVC scaffolding.
  7. **Sample** controller (separate nuget package, twitter.bootstrap.mvc4.sample) to demonstrate the default views and alerts.

Before digging into the details of how this is implemented in the code, here are some examples of what these look like in the browser after installing the package into an empty MVC 4 application.

## Navigation

&nbsp;

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb15.png" alt="image" width="678" height="181" border="0" />](http://lostechies.com/erichexter/files/2012/11/image15.png)

By adding two routes ( Home and My Account) the routes show up in the main navigation bar. Here is a [sample](https://gist.github.com/4128989) of how to create Navigation Routes.

## **Default Views**

Three razor views are placed in the Views/Shared folder; Index, Edit, and Details. These views can act as default views, so you do not need to create views when you are just listing, displaying or editing view models. This of this as runtime scaffolding.

### **Index**

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb16.png" alt="image" width="666" height="197" border="0" />](http://lostechies.com/erichexter/files/2012/11/image16.png)

This is an example of the default Index page. Simply return a IEnumerable of your view model and a listing table will be automatically created. This page uses the default bootstrap table formatting and action button dropdown. The field headers are the Property names of the view model split into natural words, and the name of the view model is listed at the top of the page. Through some small conventions you can in crease the velocity of your back end admin screen development by only writing the controllers and models, the views come for free.

### Index – Action dropdown

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb17.png" alt="image" width="718" height="248" border="0" />](http://lostechies.com/erichexter/files/2012/11/image17.png)

The above screenshot shows the Action dropdown menu, which can be extended to add additional actions to very easily.

### **Details**

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb18.png" alt="image" width="307" height="385" border="0" />](http://lostechies.com/erichexter/files/2012/11/image18.png)

This is the default **Details** view. Just return a view model and this will be automatically generated.

### Edit/Create

The default edit/create template integrates the [bootstrap forms](http://twitter.github.com/bootstrap/base-css.html#forms) styles using the recommended markup and styles.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb19.png" alt="image" width="529" height="404" border="0" />](http://lostechies.com/erichexter/files/2012/11/image19.png)

&nbsp;

Above is the example of the default edit screen, that takes full advantage of MVC 4 Editor Templates.

### Edit Validation

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb20.png" alt="image" width="539" height="365" border="0" />](http://lostechies.com/erichexter/files/2012/11/image20.png)

&nbsp;

Above is the example of the bootstrap validation which comes in the default edit view.

## Alerts

The layout template has [bootstrap alerts](http://twitter.github.com/bootstrap/components.html#alerts) built into the template, and a base controller adds helper methods for adding data to each type of alert.

&nbsp;

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb21.png" alt="image" width="731" height="255" border="0" />](http://lostechies.com/erichexter/files/2012/11/image21.png)

The above figure shows the Success alert displayed in green above the table.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border: 0px;" title="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb22.png" alt="image" width="724" height="271" border="0" />](http://lostechies.com/erichexter/files/2012/11/image22.png)

&nbsp;

The above screenshot shows the Information and Warning alerts in yellow and blue, above the table.

&nbsp;

Want to know more about this in the mean time, look at the [bootstrap documentation](http://twitter.github.com/bootstrap/index.html) and the [bootstrap.mvc4](https://github.com/erichexter/twitter.bootstrap.mvc) project site on github. Feel free to start some discussions on the Issues list and send pull requests. If there is enough activity I will create a discussion group for the project.

&nbsp;

I will post more details about how to use each of these features, but for now, install the sample nuget into an Empty MVC4 application and look at the [HomeController](https://github.com/erichexter/twitter.bootstrap.mvc/blob/master/src/Controllers/HomeController.cs.pp), it is pretty simple and easy to digest.

Follow me on RSS and Twitter
  
<a class="twitter-follow-button" style="float: left; valign: top;" href="https://twitter.com/ehexter" data-size="large" data-show-count="false">Follow @ehexter</a><a style="float: left;" title="Subscribe to my feed" type="application/rss+xml" href="http://feeds.feedburner.com/EricHexter" rel="alternate"><img style="border: 0; padding-right: 10px;" src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" /></a>