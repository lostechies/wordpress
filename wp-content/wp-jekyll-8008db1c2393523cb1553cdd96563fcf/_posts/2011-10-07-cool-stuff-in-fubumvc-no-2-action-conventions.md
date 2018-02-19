---
id: 216
title: 'Cool stuff in FubuMVC No. 2: Action Conventions'
date: 2011-10-07T17:51:19+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=216
permalink: /2011/10/07/cool-stuff-in-fubumvc-no-2-action-conventions/
dsq_thread_id:
  - "437193008"
categories:
  - .NET
  - cool-stuff-in-fubu
  - FubuMVC
---
This is the second post of the FubuMVC series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

**UPDATE:** _Josh Arnold (FubuMVC contributor) pointed out an error in a code sample (at the bottom about custom conventions) and that I missed another extension point for defining custom conventions.  If you&#8217;ve already read this post, you may want to re-read the last section again._

In the [previous post](http://lostechies.com/chadmyers/2011/06/23/cool-stuff-in-fubumvc-no-1-behaviors/), I hopefully sold you on the fact that behaviors combined with conventions are extremely powerful and enable the kinds of things that were originally intended by the Front Controller pattern (Fowler’s [PoEAA one](http://martinfowler.com/eaaCatalog/frontController.html), not [this one](http://msdn.microsoft.com/en-us/library/ff648617.aspx)).

In the next few posts, I’m going to detail some of the various types of conventions you can use when configuring your app with FubuMVC.  Actually, by the time I’m finished with this FubuMVC series, you’ll see that just about everything you can do with this framework can be conventionally applied exactly how YOU want it applied according to the rules of YOUR app.  Have I mentioned before that FubuMVC is very conventional? <img class="wlEmoticon wlEmoticon-smile" style="border-style: none;" src="http://lostechies.com/chadmyers/files/2011/09/wlEmoticon-smile.png" alt="Smile" />

In the “[Getting Started](http://readthedocs.org/docs/fubumvc/en/latest/topics/gettingstarted.html)” guide, near the end, you can see how to get a basic FubuRegistry going. Your FubuRegistry is the class where you tell FubuMVC how you want your app to behave and how things are to be wired up.  In this post, I’m going to focus on two parts of the FubuRegistry:  Action conventions and Behavior conventions.

## Action Conventions

One of the first tasks FubuRegistry has is to figure out what assemblies to scan and which types in those assemblies to scan. By default, it’ll use the “current” assembly (i.e. your web application assembly). You can tweak this if you want, but I digress.  The end result of type scanning is that FubuMVC builds up a “[type pool](https://github.com/DarthFubuMVC/fubumvc/blob/master/src/FubuMVC.Core/Registration/TypePool.cs)” of all the possible types that could contain “action” methods.  If you insist on using this language, you could say it tries to locate potential “controllers” and “controller action methods”, but as I mentioned in the previous post, the word “controller” doesn’t really make sense in the FubuMVC world.

As an aside, I’ll be referring to the thing you might normally call “controller” in other MVC frameworks as a “handler.”  That is, a type that contains one or more action methods. You might say I’m splitting hairs, but there is an important distinction in the philosophy of FubuMVC and Front Controller MVC architecture in that the “Controller” is the guts of FubuMVC, and not your class. Your class is really a command or action that gets called by the controller. Thus your action methods and the types that contain them should necessarily be small, singularly-focused, and delegate quickly to other classes to perform work.  This helps preserve [SOLID principles](http://lostechies.com/chadmyers/2008/03/08/pablo-s-topic-of-the-month-march-solid-principles/) such as the [Single](http://www.objectmentor.com/resources/articles/srp.pdf) [Responsibility](http://www.lostechies.com/blogs/sean_chambers/archive/2008/03/15/ptom-single-responsibility-principle.aspx) [Principle](http://lostechies.com/blogs/jason_meridth/archive/2008/03/26/ptom-single-responsibility-principle.aspx).

### Scanning for Types

As I said above, the first task is to locate which types may be handlers or exclude types that are explicitly _not_ handlers.

A few examples of things you can do with type conventions are:

Consider action methods in all types that end with the word “Controller” (if you insist on using the word “controller” still), or in all types that implement a specific interface (ISomeInterface), or a specific type.  Note that these are chainable, so you can define multiple conventions according to the various pieces of your application and how they are architected.

<pre class="brush:csharp">Actions.IncludeClassesSuffixedWithController()
       .IncludeTypesImplementing&lt;ISomeInterface&gt;()
       .IncludeType&lt;SomeClassWithActionMethods&gt;();</pre>

You can also define one-off, ad-hoc conventions. Though I don’t recommend doing this for large projects, it can be useful for smaller projects.  You can even exclude certain types, so you can say “Include all types whose names end in the word ‘Action’, but not ones that end with the letters ‘NotAnAction’”. For example:

<pre class="brush:csharp">Actions
       /*... other conventions ...*/
       .IncludeTypes(t =&gt; t.Name.EndsWith("Action"))
       .ExcludeTypes(t =&gt; t.Name.StartsWith("NotAnAction"));</pre>

### Scanning for Action Methods

Once you’ve defined the conventions by which FubuMVC will locate your candidate handlers, it’s time to tell FubuMVC how to find which methods to consider actions.  While it is possible for your handlers to have more methods that are not actions, it is generally ill-advised.  Having public methods on handlers that are not action methods could be a smell that your handler is doing too much and is not as focused on its responsibility as it should be.  The FubuMVC team also considers it best practice to have one or two methods (one for Get, one for Post) per handler.  There are valid cases where more methods are necessary, but they should be the exception.

Consider a few examples of how to identify action methods and filter out methods that may seem like action methods, but you don’t want them to be:

<pre class="brush:csharp">Actions
       /*... other conventions ...*/
       .IncludeMethods(c =&gt; c.HasAttribute&lt;IsAnActionAttribute&gt;())
       .ExcludeMethods(c =&gt; c.Returns&lt;SomeBadType&gt;())
       .IgnoreMethodsDeclaredBy&lt;MyUglyBaseClass&gt;()
       .ForTypesOf&lt;SomeComplexActionType&gt;(p =&gt;</pre>

<pre class="brush:csharp">p.IncludeMethods(m =&gt; m.Name.StartsWith("Foo")));</pre>

&nbsp;

## Creating custom conventions

As you may have noticed, many of these conventions I’ve demonstrated are one-off conventions that are per-application and not very reusable. As with anything in FubuMVC’s configuration, you can hook into the model underneath the FubuRegistry DSL (domain-specific language) and manipulate it significantly to bend it to your will.  You can author these conventions in separate classes which you can then reuse across projects.

As an example of how this process works, there is actually an encapsulated convention built into FubuMVC itself called the “Handler” convention.  This convention looks for all types in the namespaces you specify that end in the word “Handler” and that have a method named “Execute” which appears to be an action method (i.e. follows the zero-or-one-model-in and zero-or-one-model-out rule).

To use the out-of-box Handler convention, you can call one of the overloads for ApplyHandlerConvention method, for example (somewhere in your FubuRegistry class):

<pre class="brush:csharp">ApplyHandlerConventions&lt;MyMarkerType&gt;();</pre>

In this example, “MyMarkerType” represents a type in the namespace (or parent namespace) of the location where all your handler classes are.  Typically you’d have all your handler classes under a single folder, and then in sub-folders by functional area of your app. In that case, you’d have a marker type (just an empty class in C#) which will serve as the indicator to Fubu where to look for your handler classes.

### Really Custom Conventions

If that&#8217;s still not enough power for you, check out the [IActionSource](https://github.com/DarthFubuMVC/fubumvc/blob/master/src/FubuMVC.Core/Registration/IActionSource.cs) interface which gives you full access to define action conventions your way.  Once you&#8217;ve created your action source, you can attach it to your FubuRegistry using the FindWidth method hanging off of the &#8220;Acitons&#8221; DSL in FubuRegistry. For example, _Actions.FindWidth<MyActionSource>()_ or _Actions.FindWidth(new MyActionSource(&#8230;))_.

## Summary

In this post, we learned about how FubuMVC is conventional and we started to see what, exactly, that means.  We learned about how you can put your &#8220;controllers&#8221; (handlers) anywhere you want (even in multiple assemblies) and you can &#8220;teach&#8221; FubuMVC how to find them and discover which methods are meant to be action methods on those handlers.  We also learned about how handlers should be small, preferably with one or two public methods &#8212; each of which is an action.  Finally, we learned that FubuMVC has this &#8220;Handler&#8221; convention built in so as to make following this best practice easier.

I hope you found this post useful and I hope it gets your noodle cooking about all the ways you can organize and structure your application architecture and how FubuMVC allows you that freedom!