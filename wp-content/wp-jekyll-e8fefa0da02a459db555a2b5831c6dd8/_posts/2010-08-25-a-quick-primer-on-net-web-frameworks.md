---
id: 166
title: A quick primer on .NET web frameworks
date: 2010-08-25T16:21:33+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2010/08/25/a-quick-primer-on-net-web-frameworks.aspx
permalink: /2010/08/25/a-quick-primer-on-net-web-frameworks/
dsq_thread_id:
  - "262933570"
categories:
  - Uncategorized
---
_Update: Much to my embarrassment, I forgot to mention OpenRasta!_

I’ve received quite a few questions in the past months and year about web frameworks for .NET (some confusion around the difference between WebForms, ASP.NET MVC, FubuMVC, ASP.NET in general, etc).&#160; So I thought I’d make a quick blog post giving some real basic explanations of these frameworks, what the intended audience is for each, and what the strengths and weaknesses are of each.

**_Note_**: This is not an exhaustive list. It does not include all the frameworks that are out there. There are many good ones for .NET each with their own particular take on the matter. If you’re shopping for a framework, please do your research and only consider this post as one of many resources.

## ASP.NET

[ASP.NET](http://www.asp.net) is more of a foundational framework. I wouldn’t recommend developing a whole app directly against ASP.NET itself. All the frameworks mentioned below are built on TOP of ASP.NET and provide greater convenience and accelerators for making web development easier.&#160; While it is possible to build an entire web application directly using ASP.NET [HttpModules](http://msdn.microsoft.com/en-us/library/system.web.ihttpmodule.aspx) and [HttpHandlers](http://msdn.microsoft.com/en-us/library/system.web.ihttphandler.aspx), I wouldn’t recommend it. It’s somewhat similar to doing [Assembly language](http://en.wikipedia.org/wiki/Assembly_language) programming, but for the web.

Knowing and being familiar with the libraries, services, and facilities that ASP.NET provides is critical for doing development with any of the frameworks mentioned below.&#160; So I highly recommend that you study ASP.NET, read documentation, examples, articles, and books on the subject.

## ASP.NET Web Forms

[ASP.NET Web Forms](http://www.asp.net/web-forms) was developed at the same time as ASP.NET and was meant to be the primary framework for developers moving from VB6 and ASP (VBScript/JScript) development to the .NET framework.&#160; Web Forms was intended to make web programming a familiar experience for VB6 developers who were used to Windows application event-driven development (i.e. Button1_Click events) and who were used to building user interfaces on designer surfaces by dragging and dropping controls.&#160; Web Forms has some strengths in that it’s been around for awhile, it’s fairly comprehensive, and it’s approachable for many developers.&#160; While you might at first thing that this is a strength, Web Forms’ greatest weakness is that it too abstracts the developer from the underlying realities of stateless HTTP-based web development.&#160; Many critical aspects of web development are managed for the developer (sometimes in sub-optimal ways) leaving the web developer into problems when trying to anything outside of the normal Web Forms development path.

Web Forms has its place (for example, in small IT shops where the developer isn’t a full-time developer and just needs to quickly assemble a forms-over-data application).&#160; For any serious web development effort, however, I would consider the friction and hand-tying effects of Web Forms too great to bear and so therefore I don’t recommend Web Forms for most development scenarios for .NET.

ASP.NET Web Forms is commercial closed-source, built by Microsoft and is still under active development. However, development has slowed recently in favor of the newer ASP.NET MVC framework.

## Castle MonoRail

[Castle MonoRail](http://www.castleproject.org/monorail/) is an open source framework that was built, in large part, due to frustrations that web developers in .NET experienced with Web Forms – especially after having worked with several non-.NET frameworks and seeing how much easier many tasks were to perform.&#160; MonoRail is still actively maintained and there are many production deployments using it as the core web framework. MonoRail can use various “view engines” including the “Web Forms” view engine, Brail, NVelocity, and others.&#160; Its strengths are that it is a comprehensive framework, it fits well within the whole [Castle family of projects](http://www.castleproject.org/castle/projects.html), and allows for much more freedom than Web Forms.&#160; It’s weaknesses include being fairly different from other forms of ASP.NET-based development (which some might consider a strength, so weigh this for your own team), and it has heavy dependence upon other Castle frameworks (which may not be an issue for all teams, but for some it is).&#160; 

In the interest of full disclosure, I admit that I don’t personally have a lot of experience with MonoRail so I cannot effectively discuss it’s strengths and weaknesses.&#160; I know that many colleagues, whom I respect, use MonoRail with great effectiveness. So it is a serious contender and worthy of investigation if you are shopping for a web framework.

MonoRail is open source (contributions welcome).&#160; It is under active development.

## OpenRasta

[OpenRasta](http://trac.caffeine-it.com/openrasta) is an open source framework. Their [doc page](http://trac.caffeine-it.com/openrasta/wiki/Doc) explains it best when it says, “OpenRasta is a resource-oriented framework for .NET enabling easy ReST-ful development of web sites and services.”&#160; OpenRasta however does have many MVC features and can serve as a full-fledge web application framework (i.e. it’s not \*just\* a REST framework).&#160; OpenRasta’s strengths lie in it’s comprehensiveness, wide range of features, active development and support community plus good documentation. OpenRasta’s weaknesses are similar to other frameworks in that is not as approachable as Web Forms and is intended for experienced developers.&#160; 

Also in the interest of full disclosure, like MonoRail, I don’t have a lot of personal experience with OpenRasta and so I cannot effectively discuss it’s strengths and weaknesses.&#160; Please investigate for yourself and engage the [OpenRasta community](http://trac.caffeine-it.com/openrasta/wiki) for more information.

&#160;

## ASP.NET MVC

[ASP.NET MVC](http://www.asp.net/mvc) is another framework built on TOP of ASP.NET (but not on top of Web Forms – MVC is parallel to Web Forms).&#160; ASP.NET MVC was developed by Microsoft in response to complaints of .NET web-based developers who complained about design problems with Web Forms.&#160; While you can mix Web Forms and MVC development in the same project, I wouldn’t recommend it unless there was a specific need to do it.&#160; MVC does away with the cumbersome “[Page Control Lifecycle](http://msdn.microsoft.com/en-us/library/ms178472.aspx)” of Web Forms and provides a much more stream-lined approach to web development.&#160; MVC is much closer to the inherent stateless request/response nature of HTTP and so therefore makes it much easier for experienced web developers (and even inexperienced ones) to develop complex web applications.&#160; MVC is less focused on designer-based drag-and-drop programming and more on code-centric programming.&#160; There sometimes is confusion about the difference between ASP.NET MVC and Web Forms because MVC can use \*some\* parts of Web Forms for presentation.&#160; This is known as the “Web Forms View Engine”. There are also other view engines for ASP.NET MVC including Spark and Razor.&#160; This allows you to use ASPX and ASCX files and some runat=”server” controls in your views, but without having to have code-behind files and Page Control Lifecycle event handling.&#160;&#160; MVC’s strengths are similar to MonoRail in that it’s fairly comprehensive, and allows a lot more freedom of development and puts the developer back in touch with the fundamentals of web/HTTP programming.&#160; It is well documented and has many guides and a great user community around it. 

It shares the same weakness as MonoRail in that MVC is less approachable for less experienced developers.&#160; For more experienced, advanced developers, certain design aspects of MVC can be cumbersome (such as the use of too much inheritance, problematic support for dependency injection and IoC tooling, and too much friction when writing unit tests). These weaknesses are not critical, however, and many good developers are using ASP.NET MVC quite effectively.&#160; ASP.NET MVC is a good contender if you’re investigating frameworks and definitely worth some time to spike out some examples.

ASP.NET MVC is commercial open-source (contributions are not accepted, but you can view the source). It is currently in active development by Microsoft and is on its 3rd version.

## FubuMVC

[FubuMVC](http://fubumvc.com/) is another framework built on top of ASP.NET and sits at the same level (“competes” with if you will) Web Forms, MonoRail, and ASP.NET MVC.&#160; FubuMVC was originally designed in response to the perceived issues (identified in the preceding section) with ASP.NET MVC.&#160; The original designers felt that ASP.NET MVC was good, but didn’t go far enough in certain areas to be truly great. FubuMVC uses various view engines like ASP.NET MVC and MonoRail. Currently FubuMVC supports Spark and Web Forms view engines and a Razor engine is being considered.&#160; FubuMVC’s strengths include being more IoC/DI and [SOLID](http://www.lostechies.com/blogs/chad_myers/archive/2008/03/07/pablo-s-topic-of-the-month-march-solid-principles.aspx) friendly than ASP.NET MVC.&#160; It’s more [compositional](http://www.lostechies.com/blogs/chad_myers/archive/2010/02/12/composition-versus-inheritance.aspx) (versus inheritance-based) which allows for greater freedom for the developer. FubuMVC also has greater support for [conventional development](http://msdn.microsoft.com/en-us/magazine/dd419655.aspx) saving developers a lot of time in both development and testing by standardizing the aspects of their application that are similar. FubuMVC’s weaknesses include the same approachability issue that MonoRail and ASP.NET MVC, but I would say FubuMVC fairs worst in this regard. FubuMVC is designed for advanced, experienced developers.&#160; FubuMVC also has a sore lack of [documentation](http://wiki.fubumvc.com) and [guides](http://guides.fubumvc.com) at the moment.&#160; FubuMVC is also not as comprehensive as ASP.NET MVC and MonoRail.&#160; In some respects, FubuMVC has more functionality, but in (many) other respects it still has a ways to go.&#160; Though FubuMVC has a small development team currently, but is gaining ground steadily and growing. 

FubuMVC is open source (contributions welcome).&#160; It is under active development.