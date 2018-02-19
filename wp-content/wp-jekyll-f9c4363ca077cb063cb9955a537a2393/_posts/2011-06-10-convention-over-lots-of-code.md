---
id: 293
title: Convention over lots of code
date: 2011-06-10T16:06:20+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/2011/06/10/convention-over-lots-of-code/
permalink: /2011/06/10/convention-over-lots-of-code/
dsq_thread_id:
  - "328100063"
categories:
  - .NET
  - Conventions
  - FubuMVC
---
I’m in the middle of writing my last FubuCore series post before I proceed to the FubuMVC series of posts.   The post is called “Stringification” (String-eh-feh-k-shun) and it’s about using conventions to remove a lot of code that deals with properly displaying values/models/entities in different contexts.  We have a localized, multi-time zone application and displaying data gets tricky when you realize it has to be localized and all dates and times must be in the correct time zone and local format.  There’s a lot of stuff built into .NET to do this, of course, and it’s great, but you still have a lot of code to write to call it and wire it up and yadda yadda.

Anyhow, as I was writing that “Stringification” post, I started by writing the “Why” part (i.e. how we came to the conclusion that we needed conventional-based “ToString”-like support throughout our app).  As I was writing it, it became a blog post all by itself. So I’m breaking it out here and making this post about why conventions are important and how they can save you tons of time and effort and speed up your development.

Lots of people throw around the words “convention over configuration” and it’s important.  But a lot of people who aren’t “thinking conventionally” don’t really get the power or value of it.  What I’m about to share was part of my “ah-hah!” moment of appreciation.

## The Date/Time/TimeZone Problem

Let me start by explaining a specific problem we had, how we solved it originally, the problems we ran into, and how IDisplayFormatter/Stringifier made things much easier and better.  Our app, like most, tracks a lot of dates and times with our entities.  We display these dates, times, and date/times often in our app. The trick is that we could have users in different time zones using the system. We need to display the dates and times in the user’s current time-zone.

Both Josh and I have written about this particular problem before: Josh wrote “[Helpful DateTime extension methods for dealing with Time Zones](http://lostechies.com/joshuaflanagan/2011/02/04/helpful-datetime-extension-methods-for-dealing-with-time-zones/)” and I wrote “[How we do Internationalization](http://lostechies.com/chadmyers/2011/02/04/how-we-do-internationalization/)” (scroll down to the Date/Time part).

When we started, we had created a bunch of extension methods for dealing with the problem. Most of the time, we were displaying date/times in our views, so this worked somewhat well.  Eventually we started needing to display them in non-view code (for example, when we were setting DateTime values on a JSON response to an AJAX call).  Then the extension methods got a little more complicated.  Eventually the time zone problem became so complicated, we needed some services to be pulled out of StructureMap and the extension method thing kinda fell flat on its face.

And remember, these are \*just\* the DateTime properties. We had a host of other issues such as our localized list values (where the value of a drop-down list is not displayable or localized, and we need to display a different, localized value to the user), currency and other floating point numbers, the link text when linking to an entity, etc.  We soon had a bunch of extension methods and one-off solutions for each type of problem we faced. Ultimately, though, all the problems were around taking a value/model/entity of some type and displaying it properly to the user (where “properly” is whatever is appropriate for that type of data and context).

This became a maintenance nightmare replete with duplication/DRY-violations, one-off static location from the container, and all sorts of other general nastiness. We needed a single solution through which to pump all our data-that-needs-to-be-displayed and have it rendered to the client in a consistent, easy to maintain way. Naturally, the first thing that came to our mind was: “Conventions!”

We ended up building Stringifier and IDisplayFormatter which allows us to have a central, conventional way of consistently displaying things.  It’s pluggable and allows us to customize it. You can [read about Stringifier/DisplayFormatter in my other post](http://lostechies.com/chadmyers/2011/06/10/cool-stuff-in-fubucore-no-9-stringification/).

## What conventions mean to us…

Early on in our development cycle (that would be in June of 2008), we kept hitting problems where we would find ourselves saying, out loud in meetings/stand-ups, etc, “That stupid [X] bug bit me again. Be advised, team, that any time you need to do [X], it should be done this way [Y].”  And we trained ourselves to recognize that phrase formula and immediately knee-jerk by adding something conventional into our architecture to lock it down. We found that these efforts always resulted in a huge boost in productivity so much so that I can’t imagine how we would’ve been able to do half of what we’ve accomplished the past 3 years at Dovetail without all our conventional stuff.

Naturally, you can imagine why I now think that building conventions into your infrastructure is critical to maintaining velocity over a long period of time and why I consider this mindset a critical factor in the success we’ve had over these past 3 years without a single re-write and not a ton of legacy code baggage.

We’ve all written a lot of conventional programming, convention over configuration, and the like. You should check out some of these posts, videos, and podcasts:

**Jeremy Miller**

  * [Convention Over Configuration](http://msdn.microsoft.com/en-us/magazine/dd419655.aspx) (MSDN Magazine article)
  * [Convention Over Configuration](http://www.hanselman.com/blog/HanselminutesPodcast167ConventionOverConfigurationWithJeremyMiller.aspx) (Hanselminutes Podcast)
  * [Convention Over Configuration](http://osherove.com/blog/2009/8/18/ndc-video-jeremy-d-miller-convention-over-configuration.html) (Video, NDC talk 2009)
  * [Building a simple FubuMVC Convention](http://codebetter.com/jeremymiller/2011/01/11/building-a-simple-fubumvc-convention/) (blog post)
  * [FubuMVC’s Configuration Strategy](http://codebetter.com/jeremymiller/2011/01/10/fubumvcs-configuration-strategy/) (blog post)

**Joshua Flanagan**

  * [FubuMVC &#8211; Define your actions your way](http://lostechies.com/joshuaflanagan/2010/01/18/fubumvc-define-your-actions-your-way/) (blog post)
  * [Coding with Conventions](http://lostechies.com/joshuaflanagan/2011/02/23/code-samples-from-my-adnug-talk-coding-with-conventions/) (blog post about a local NUG talk, with code)

**Chad Myers**

  * [Model-based Apps and Frameworks](http://lostechies.com/chadmyers/2010/05/29/model-based-apps-and-frameworks/) (blog post)
  * [Convention Scanners in StructureMap](http://lostechies.com/chadmyers/2008/08/02/stucturemap-advanced-level-usage-scenarios-part-1-type-convention-scanners/) (blog post)
  * [Houston Alt.NET ‘09 talk on FubuMVC with Jeremy Miller](http://houstonaltnet.pbworks.com/w/page/19525997/Fubu-MVC) (video)