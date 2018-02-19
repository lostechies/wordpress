---
id: 208
title: 'Cool stuff in FubuCore No. 8: UrlContext'
date: 2011-06-09T22:14:01+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=208
permalink: /2011/06/09/cool-stuff-in-fubucore-no-8-urlcontext/
dsq_thread_id:
  - "327318507"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the eighth post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

You might be thinking to yourself, “Why is he doing a whole blog post on one class?” That’s because this little puppy, UrlContext, has done more to make my life better and development fun that it deserves a special place on its own. I know, I know, “Man, he gets \*really\* excited about a C# class – a little _too_ excited.” But it’s worth it, trust me.

If you were doing web development for any significant length of time before 2008, then you’ve run into this problem before. I don’t recall this problem being “easy” in any web framework I worked in (ASP, PHP, ColdFusion mostly). Perhaps some of the more recent web frameworks have better ways of solving this, but even to this day it’s still a pain in the butt in ASP.NET:&nbsp; Messing with absolute and relative URLs.

Going from absolute to app relative to relative or some other combination was always annoying. Sure, most frameworks have convenience methods (including ASP.NET), but I still found myself frequently turning around having to call those methods and dealing with the problem. It wasn’t “just solved” the way I needed it to be so I’d never have to look at another “AppRelativeToAbsolute” or “AbsoluteToAppRelative” or “IsAbsolute” type method again.

Then there’s also the problem of unit testing any code that deals with URLs.&nbsp; Even before FubuMVC or ASP.NET MVC, in WebForms I had to deal with this problem when testing code that my Page classes would call.&nbsp; Most of the built-in URL mangling methods in ASP.NET required an active HttpContext which made unit testing impossible.&nbsp; These days, HttpContext can be mocked, sort of ([if you consider this acceptable](http://code.google.com/p/mvccontrib/source/browse/trunk/src/MVCContrib.UnitTests/MvcMockHelpers.cs?r=961), which I don’t).&nbsp; I needed a way to be able to test my services and such without needing to touch anything that had anything to do with HttpContext or required mocking of HttpContext.

Two things have made these problems almost completely non-existent for me in FubuMVC:&nbsp; 1.) UrlContext and 2.) FubuMVC’s deep usage of UrlContext.

## What is UrlContext?

UrlContext is a simple static class that has all the main URL mangling methods such as: ToAbsoluteUrl(), ToServerQualifiedUrl(), and ToPhysicalPath(). It has some others, but those are the main money methods. UrlContext has two states: Live and Stubbed.&nbsp; Since all the Fubu-related components (FubuMVC, HtmlTags, FubuFastPack, etc) use UrlContext, I have a simple, easy way of stubbing out my application base URL for unit testing. I just say: UrlContext.Stub(“http://myserverbase/myapp”) in my test SetUp() method and \*BAM\*, everything works.

## The ToXYZ Methods

When I looked at all the URL mangling I was doing, I found that I was usually going from some unknown-qualified URL (it may be relative, it may be absolute, it may be a fully qualified URI with http:// and everything) to an absolute URL.&nbsp; Sometimes I wanted to go from unknown-qualified to fully server-qualified, but usually just to absolute.

In most projects I worked on, various developers had written their own one-off methods for taking a URL in an assumed state (for example, relative) and moving it to a specific state (for example, absolute).&nbsp;&nbsp; I also noticed that a large number of our URL-related bugs came from these various, duplicate, overlapping methods because they always assumed that the URL being passed to it was in a certain specific state.&nbsp; When another, unsuspecting, developer would find this method and call it (not knowing about it’s input requirements), bad things would happen. So when we started working on FubuMVC, I knew there had to be ONE way and ONE way only to avoid the URL mangling insanity by centralizing everything to one class that had a consistent, well-known way to processing URLs. You might say, “Duh, be [DRY](http://en.wikipedia.org/wiki/Don't_repeat_yourself)!” and you’d be right. But sometimes you don’t see all the duplication in your code until something gets you fed up one day.

As an aside, I’ve been coming to the conclusion over the past 4-5 years that what separates programmers from really good programmers is how quickly they can spot friction. They may not be able to remove that friction right away, but being able to spot friction is a huge leap forward for most developers. Once they get the hang of this productivity rises exponentially. Ok, I digress, back to the blog post…

The beauty of the ToXYZ methods is that it doesn’t matter what state the URL is in when you invoke the method.&nbsp; The ToXYZ methods will figure it out and move it to the desired state.

### ToAbsoluteUrl

This will move a URL from any state to be an absolute URL (i.e. it starts with “/”).

### ToServerQualifiedUrl

This will move a URL from any state to be a fully-qualified URL (i.e. that starts with “http[s]://server/”).

### ToPhysicalPath

This will take a URL and map it, using ASP.NET/IIS’s virtual file system, to the physical path on the HDD that corresponds to that URL.&nbsp; 

## Live/Stub

This concept was the real pay-off for UrlContext.&nbsp; Up until now, what I have described is just a glorified set of extension methods. But when you can pull out any controller, any service, any service in the FubuMVC framework, or even the whole FubuMVC stack itself, slap it into an isolated unit or integration test and then stub out the URLs and see everything work and your tests run _fast_, it makes you giggle like a little school girl thinking how easy it is and how ridiculously hard it would be with ASP.NET.

For example, I cringe at the thought of trying to test something like this without UrlContext: [MapWebToPhysicalPathFamilyTester.cs](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore.Testing/Binding/MapWebToPhysicalPathFamilyTester.cs)

## Best part: I don’t see it

I know at first it doesn’t make much sense but: The thing I love most about this class (that I love so much already)? I don’t have to see or use it much!&nbsp; Sounds backwards, right?&nbsp; In fact, I don’t really have to think much about URLs anymore. Since FubuCore, HtmlTags, and FubuMVC uses this so extensively, when I need an anchor/link tag to an action, it’s all taken care of.&nbsp; Very rarely, now since FubuMVC, do I really have to think about URLs in the code. I tell FubuMVC how I want my routes and URLs to look like, and then I don’t have to see or think about them again. Everything flows from my routing configuration through UrlContext into the appropriately-qualified URL.&nbsp; 

I’ve gotten pretty off-topic here, but the point was that the full power of something like UrlContext is not realized until it’s used pervasively throughout the framework to enable these kinds of scenarios.

If you’ve used FubuMVC before and thought, “Hrm, that’s odd, Chad’s making such a big deal about UrlContext and yet I’ve never noticed it’s there!” then UrlContext has done it’s job.&nbsp; The point is: You generally shouldn’t be worrying about URLs in your views and controllers and certainly not in your tests – unless you’re testing your route conventions. URLs are determined when planning your routes and URL conventions. After that, you shouldn’t be thinking much about it.