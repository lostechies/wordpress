---
id: 162
title: Model Based Apps and Frameworks
date: 2010-05-29T03:57:27+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2010/05/28/model-based-apps-and-frameworks.aspx
permalink: /2010/05/29/model-based-apps-and-frameworks/
dsq_thread_id:
  - "262114513"
categories:
  - Uncategorized
---
Having been involved (mostly as a user or observer) with several recent applications and frameworks, I’ve come to the conclusion that building your app/framework on an internal model is generally the best way to go.&#160; In this post I’ll explain what I mean by “on an internal model” and later describe the benefits I have seen, realized, been told about by others and still others that I’ve only imagined (but are still possible).&#160; I plan on writing a few blog posts along these lines to explore what it means to be a “model-based framework” and what are the benefits and problems with going that route.

Some of the apps/frameworks I have in mind while writing this are [AutoMapper](http://automapper.codeplex.com/) (will be model based in next version or two), [Fluent NHibernate](fluentnhibernate.org) (will be model based in next version or two), [FubuMVC](http://fubumvc.com/) (model based from the beginning), [StoryTeller](http://github.com/storyteller/storyteller) (model based from the beginning), and [StructureMap](http://structuremap.net/) (model based for quite a long time, if not from the beginning).&#160; 

While I’m going to be talking about specifically .NET-based frameworks, I have seen this technique in various ways, shapes, and forms in other languages and platforms such as Python and JavaScript and I’m willing to bet there’s a lot of this in Ruby as well – each with their own flavor corresponding to the idioms of that world.

I don’t have the whys and wherefores all locked down on my thinking in this matter yet. Patterns are starting to emerge as I gain more experience and I hope to be able to provide more concrete advise as the weeks and months go on and I explore this concept in more depth.

## What do these frameworks have in common?

To understand what I’m about to get into better, let’s look at a few of the examples (in alphabetical order so no one thinks I’m picking on them). 

Let’s look at what AutoMapper does. AutoMapper (from its home page) “uses a fluent configuration API to define an object-object mapping strategy.”&#160; It’s an object-to-object mapper with some neat tricks and conventions thrown in. We use it happily at Dovetail and love it. You use AutoMapper’s fluent API to configure it and describe how you want your models (or DTOs or projections or whatever you want to call them) assembled from your other objects.&#160; We use it at Dovetail for taking data from domain entities and other models and projecting them onto our view models for our views.&#160; AutoMapper isn’t currently model based. When you call the fluent APIs, it does stuff immediately and locks in its configuration. We’ll get back to why this is important later.

From Fluent NHibernate’s web site: “Fluent, XML-less, compile safe, automated,convention-based mappings for NHibernate._Get your fluent on._”&#160; We also use FNH at Dovetail and love it as well.&#160; It suffers from the same fundamental design issue as AutoMapper, however: When you call the API, it affects change right then and there. I promise I’ll get to why this matters in a little bit.

From FubuMVC’s web site: “Compositional, compile safe, convention-based configuration for complex web applications._The MVC framework that doesn&#8217;t get in your way._” We wrote FubuMVC at Dovetail because we had some difficulties bending our heads around ASP.NET MVC or was it bending ASP.NET MVC around our heads? Either way, we needed something different. FubuMVC \*was\* built model-based to begin with because many of the features we needed involved heavy use of conventions.&#160; Now I’m just teasing you about “I’ll get to the why-this-matters” in a bit. Please hang tight.

StoryTeller has no website currently. It’s largely a DSL tool and can be used for various sundry purposes. It’s most common use (by us at Dovetail) is for defining acceptance testing grammars and executing them using Selenium to test our web application.&#160; StoryTeller builds up grammars and lots of things that you tell it and then can execute those grammars on “fixtures” you’ve defined in code to do… well, just about anything. StoryTeller is inherently model-based.

StructureMap is an IoC container. You tell it about all your objects and their dependencies and how you want them assembled (though StructureMap can guess quite a lot and quite well) and then it serves up properly constructed concrete instances of those object graphs for you and can even manage lifetimes of your objects and all sorts of other nifty things that would be extremely tedious mundane if you had to code them yourself.&#160; StructureMap is a model-based framework.

Have you noticed anything in common with these frameworks?&#160; They all involve some sort of API that set up some initial configuration which is then “sealed” or locked in place at which point the the framework does it’s magic.&#160;&#160; AutoMapper is configured and then can start projecting your object data for you. FNH is configured and then can spit out NHibernate HBM XML all day long. FubuMVC’s is configured and then can start serving up requests for routes. StoryTeller is configured and then can start executing your grammars. Finally, but not least, StructureMap is configured and then starts creating instances of your concrete object graphs for you.

All of these frameworks have two primary activities: Configuration and Runtime

## How are model-based and non-model based frameworks different?

These frameworks operate in one of two modes:&#160; Direct configuration or model-based.&#160;&#160; Direct configuration frameworks build up instructions for how to do their job and execute them immediately without having any sort of intermediate step.&#160; The configuration is tied explicitly to the functionality and inseparable. This offers a few advantages (certainly easier to get started with, sometimes simpler code, etc), but has some major detractions.&#160;&#160; Sometimes direct configuration means building up some sort of model during configuration, but only keeping it around temporarily or just long enough to be used during it’s “runtime” behavior and then it’s not used. Sometimes it means the model is pushed deep and not exposed directly.&#160; FNH has some of this problem, too. It started out writing XML directly and has evolved some models, but wasn’t built on a model to begin with and has caused a lot of grief for the developers and has limited their ability to do some of the cool ideas they want to do.&#160;&#160; AutoMapper is having some of the same problems now (lots of cool ideas, but held back somewhat by the direct configuration constraints).&#160; Not coincidentally, both of these frameworks are in the progress of moving to model-based in some form or another.

Model-based frameworks separate the configuration-time activities from the run-time activities.&#160; This adds some complexity for the framework designer, but opens up many opportunities for some really cool features and possibilities.

## How do I design a model-based framework?

First start by thinking of the two separate activities: Configuration and Runtime. Design the framework to be separate along those lines. Design your configuration model and API separate and then consume that model in your runtime and process it according to the functionality of your framework (i.e. for Fubu, serving pages, for FNH, generating XML, etc).

Treat the model as a first class citizen (if not the most important citizen) in your framework design. The model is key. With the model, your framework and everyone else can do anything with it (scan it, manipulate it, consume it for various purposes, etc).&#160; Your configuration API is a consumer and manipulator of your configuration model. Your framework’s runtime is a consumer of the model.

Expose the model boldly to consumers of your framework. Allow them to manipulate it (provide helpers, visitors, iterators, convenience manipulators, etc for this purpose).&#160; Allow them to extend it and provide extra functionality on top of your model. Provide interfaces, convenience base classes. Make sure you follow the SOLID principles especially LSP and OCP to allow maximum flexibility and extensibility for consumers and manipulators.

## What benefits to I get from a model-based framework?

This is where I stop being purposely vague and get to the meat (sorry it took so long).&#160; The first and most awesome benefit is: Conventions.&#160; Allowing your consumers to be able to make declarative “We always do XYZ this way” statements using your framework is extremely powerful.&#160; For example, the HTML conventions in FubuMVC allows you to say things like: “DateTimes will always be displayed to the client browser in the user’s local timezone” in a few lines of code in \*one\* place instead of scattered throughout the app.&#160; In AutoMapper you can make statements like “If you see a property on a DTO whose name ends with ‘CurrentDateTime’, set it to the current date and time.”&#160; Soon, AutoMapper will be fully model-based and the conventional possibilities will be endless.&#160; Same with all the frameworks.

Conventions work by scanning through the model, looking for patterns and applying rules as they find these patterns.&#160; If the framework is not model based, then only conventions that the framework designer specifically thought of are allowed which is limiting to the consumer.

Once the runtime portion (the meat of your framework’s functionality) only depends on the configuration _model_ instead of the configuration _API_, then your flexibility is greatly increased, allowing the framework designer to concentrate on adding new features to the runtime portion (which is the funnest part) while being confident that any deficiencies in the configuration API can be surmounted by your consumers because they have full access to manipulate the model.

## Case Study: FubuMVC Debug Tracing

This may not be the best example, but it’s the one that finally drove the point home for me and cemented in my mind that model-based was definitely the way to go from now own.

In FubuMVC, Jeremy wanted to be able to provide the ability to put ?FubuDebug=true on the end of your URL or querystring to execute the web request in a special “recorded” mode. At the end of the request, FubuMVC wouldn’t dump out the normal HTML, it would dump out a special view of everything that FubuMVC did during that request and finally show you what it \*would have\* rendered to the browser if not in debug mode.

To accomplish this, Jeremy added some functionality that would essentially tear apart FubuMVC’s assembled configuration model and wrap each node in the chain of commands executed during each request with a special “Recording” node that would record everything that went on inside the node it was wrapping.

He implemented this in an extremely short time. I had a hard time believing it took such a short time. He explained to me that it was because FubuMVC was model based, so implementing this functionality was fairly easy because it mostly just involved manipulating a simple object model and chaining nodes together.

I thought that if all frameworks were like this, you could add debug tracing and “tracer rounds” and all sorts of things to frameworks like StructureMap, FNH, AutoMapper, etc.

## Case Study: StructureMap’s “What Do I Have?” 

StructureMap has the interesting ability to be configured and re-configured, even after the configuration has been “sealed” and its runtime features have already been engaged.&#160; With all the automatic, conventional, hierarchical configuration that goes on with a complex StructureMap project, it’s hard sometimes to get a feel for what’s really going on inside StructureMap. So Jeremy added the “WhatDoIHave” functionality on the ObjectFactory class.&#160; This will dump out to a string a report detailing everything that is currently configured in StructureMap and some other useful information.

While other frameworks may have similar functionality (do they?), it was relatively easy to add to StructureMap because its runtime merely consumes a configuration model and so only has to dump a report rather than trying to determine, based on some configuration API what has been configured.

## Conclusion

One of the features that I think is really killer about model-based frameworks is the ability to apply conventions and make statements about how your application or the framework will behave in \*one\* place instead of in many. This drastically lowers maintenance costs, complexity, and therefore bugs in your application. We have seen this directly in our apps at Dovetail.

I plan on going deeper on conventions in future blog posts, so stay tuned and poke me if I go too long without another follow-up blog post :)