---
id: 18
title: Assert.That(this, Is.Easy);
date: 2008-01-21T15:10:00+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/01/21/assert-that-this-is-easy.aspx
permalink: /2008/01/21/assert-that-this-is-easy/
dsq_thread_id:
  - "262089206"
categories:
  - .net
  - agile
---
I came up with this a month or two ago, but finally decided to share it. While working on [Mass Transit](http://masstransit.googlecode.com/), I was joking with [Dru Sellers](http://geekswithblogs.net/dsellers/Default.aspx) about how nice it was to have really good test coverage when making design changes to some all-new development code. I&#8217;ve had very limited opportunity for a completely new projected started purely from unit tests, so I was just impressed at how easy it was to make code changes knowing that a passing set of tests meant all was well in the world.

You see, not all parking lots are paved with quality asphalt, generally flat, and void of any obstructions like islands and lights (see my other hobby). At work, our application is a lot of vintage C++ code, a ton of stored procedures packed to the hilt with domain logic, and nearly zero percent unit test coverage. Since adapting agile development, it is something that has been missing from our process. In our latest iteration, we&#8217;ve started using unit tests (with [NUnit](http://www.nunit.org/index.php)) to design our interfaces and classes. At the same time, we&#8217;re integrating Mass Transit to support the loosely coupled layer of application services (which include object translation, communication with high-latency remote systems, and lazy auditing of transactions). Aside from a few basic web services to support remote client application support tools, this is the first C#/.NET development that is being done as part of the main application.

So back to our story, my first project with really good test coverage exposed me to a lot of new things. From a TDD perspective, I&#8217;d read about it, used it to build some basic tests for various classes, and thought I had a pretty decent understanding of it. In this new project, I also learned how to use [Rhino.Mocks](http://www.ayende.com/projects/rhino-mocks.aspx) (which took the test run time from 40-50 seconds down to 1.83 seconds on average), a very powerful tool for making an interface behave as you would expect an implementation of that interface to behave. The use of mocks has really helped me focus on actually writing tests and building a single class at a time. Prior to using mocks I would jump around creating additional classes as I defined new interfaces just to be able to continue writing my unit tests on the original class. By using a mock, I&#8217;m able to simulate the behavior of the other class without losing focus.

As my appreciation for TDD grew, I jokingly dropped a slogan into a chat window (using [Skype](http://www.skype.com/welcomeback/), of course, aren&#8217;t you?):

[<img src="http://farm3.static.flickr.com/2107/2208925827_c424ecb144.jpg?v=0" alt="Assert-That-This" border="0" />](http://www.cafepress.com/phatboyg.210816995)

I got a few chuckles, and thought it would make a great t-shirt to wear to tech events like code camps. So I threw together a [quick online store](http://www.cafepress.com/phatboyg.210816995) so that I could [order one](http://www.cafepress.com/phatboyg.210816995) for myself. I showed it to a few others (like [Joe Ocampo](http://lostechies.com/blogs/joe_ocampo/default.aspx), who suggested the [slightly less offensive](http://www.cafepress.com/phatboyg.216752029), yet [subtly more suggestive variant](http://www.cafepress.com/phatboyg.216753686)) and decided to make it available to anyone that wanted one. So if you like it, [grab one for yourself](http://www.cafepress.com/phatboyg) and maybe I&#8217;ll see you wearing it at [ALT.NET Seattle](http://codebetter.com/blogs/david_laribee/archive/2008/01/16/alt-net-open-spaces-seattle.aspx)!