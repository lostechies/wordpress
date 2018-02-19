---
id: 79
title: Portable Area excerpt from MVC2 in Action
date: 2010-04-22T15:23:12+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2010/04/22/portable-area-excerpt-from-mvc2-in-action.aspx
permalink: /2010/04/22/portable-area-excerpt-from-mvc2-in-action/
dsq_thread_id:
  - "262526269"
categories:
  - Asp.Net MVC
  - mvccontrib
  - mvcinaction
  - Portable Area
---
If some of you want to know why I have not been blogging as much for the last few months..&#160; and this is why. I have been putting my energy into this book as a co-author.&#160; I am excited to be part of it and glad to share the results of all of this work.

The following is an excerpt from [ASP.NET MVC 2 in Action](http://manning.com/palermo2), a book from Manning appearing in bookstores in May.&#160; The early access (MEAP) edition is available now on <http://manning.com/palermo2>.&#160; Authors include [Jeffrey Palermo](http://jeffreypalermo.com), [Ben Scheirman](http://flux88.com/), [Jimmy Bogard](http://www.lostechies.com/blogs/jimmy_bogard/default.aspx), [Eric Hexter](http://www.lostechies.com/blogs/hex/) and [Matt Hinze](http://mhinze.com).&#160; Technically edited by [Jeremy Skinner](http://www.jeremyskinner.co.uk/).

### &#160;

### 22<a></a><a></a><a><font color="#000000">.1 Understanding the portable area</font></a>

The portable area is a concept that comes from the MvcContrib project. As the name describes it, it is a native MVC 2 area packaged up in a way that is easier to distribute and consume than an area built with the out of the box MVC 2 support. That is a pretty broad statement so let&#8217;s first look at what is in an area and then cover which pieces may need to be made portable.

Areas are a subset of an MVC application that are separated in a way that gives them some physical distance from other groups of functionality in an MVC application. This means that an area will have one or more routes, controllers, actions, views, partial views, master pages and content files, such as CSS, JavaScript, and image files. These are all the pieces that may be used in an area.

Of those individual elements many of them are not part of the binary distribution of a MVC application. Only the routes, controllers, and actions get compiled into an assembly. The rest of the elements are individual files that need to be copied and managed with the other assets that are part of your application. This is reasonably trivial to manage if you build an area for your application and just use it as a way of managing smaller modules of your application. But if you want to use an area as a way for packaging up and sharing/distributing a piece of multi-page user interface functionality, managing all of the individual files make this option a bad choice when integrating someone else&#8217;s component with your application. 

This is where the MvcContrib project developed the idea of a portable area. By building on top of the existing area functionality, it only takes some minor changes to your area project to make it portable. A portable area is simply an area that can be deployed as a single DLL. The process of making an area portable is pretty trivial. As an area developer, instead of leaving the file assets as content items in your project, you make them embedded resources. An embedded resource is a content file that is compiled into the assembly of a project. The file still exists and it can be programmatically extracted from the assembly at runtime. This means that a portable area only contains a single file, the assembly of the project, rather than all the individual content files. 

### 22.2 A simple portable area

A portable area is a class library project with controllers and views. It has all the trappings of an ASP.NET MVC 2 project: controllers, folders for views and the views themselves. To extract the AccountController we&#8217;ll simply move those related files from the default template to a new class library project. The overall structure of the project is the same, but it&#8217;s not a web project, as shown in figure 22.1.

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="clip_image002" src="http://lostechies.com/erichexter/files/2011/03/clip_image002_thumb_65BF8B33.jpg" width="395" height="484" />](http://lostechies.com/erichexter/files/2011/03/clip_image002_148543D6.jpg)</a>

Figure 22.1 A portable area class library project

Developers familiar with the ASP.NET MVC 2 default template will recognize most of the files in the portable area shown in figure 22.1. For the most part, it&#8217;s exactly the same and in the same structure. The views, however, are not content files like in ASP.NET MVC 2 projects; they are embedded resources. To make a view an embedded resource, highlight it in Solution Explorer and press the F4 key, or right-click it and select Properties from the context menu. The properties window (shown in figure 22.2) will appear.

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="clip_image004" src="http://lostechies.com/erichexter/files/2011/03/clip_image004_thumb_640EBF5F.jpg" width="644" height="296" />](http://lostechies.com/erichexter/files/2011/03/clip_image004_0BB53B8A.jpg)

Figure 22.2 Visual Studio&#8217;s file properties window

Select "Embedded Resource" to instruct Visual Studio to include the file as an embedded resource of the project.

Embedded resources

Embedded resources are project artifacts that are compiled into the assembly and they can be programmatically retrieved. Normally, views are set with a build action of "Content" which means they will be stored and accessed like regular files in the file system. Class files have a build action of "Compile", which compiles them into the assembly regularly. For more information on embedded resources, visit the MSDN reference page: http://msdn.microsoft.com/en-us/library/ht9h2dk8.aspx

Like a regular area, portable areas must be registered. Here we use a base class provided by MvcContib, PortableAreaRegistration.

Listing 22.1 Registering our portable area by deriving from PortableAreaRegistration

public class AreaRegistration : PortableAreaRegistration #A

{

> public override string AreaName #B

> {

> get { return "login"; }

> }

> public override void RegisterArea (AreaRegistrationContext context, IApplicationBus bus) #C

> {

> context.MapRoute(

> "login",
> 
> "login/{controller}/{action}",
> 
> new { controller = "Account", action = "index" });
> 
> base.RegisterTheViewsInTheEmbeddedViewEngine(GetType()); #1
> 
> }

}

#A Deriving from PortableAreaRegistration

#B We still provdide AreaName

#C RegisterArea is familiar&#8230;

#1 but we call a special method

In listing 22.1 we register our portable area. It&#8217;s very similar to the regular AreaRegistration classes we wrote in chapter 21, with one additional, required step: we must call base.RegisterTheViewsInTheEmbeddedViewEngine(GetType()); (#1).

That call allows us to use a special view engine (also included in MvcContrib) that makes our embedded views available to the consuming project. The embedded views are the trick behind portable areas. When our consuming project needs a view, the special embedded view engine can find them. If we didn&#8217;t use this view engine, we&#8217;d have to automate our deployments so that each portable area&#8217;s views were in the correct spot in our projects file system. Even though this can be automated, using embedded views allows us to skip this tedious and error prone step. In the next section we&#8217;ll actually use the portable area in our consuming application.