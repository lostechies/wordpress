---
id: 78
title: 'Actor Model Programming in C#'
date: 2011-11-15T10:22:46+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=78
permalink: /2011/11/15/actor-model-programming-in-c/
dsq_thread_id:
  - "472803377"
categories:
  - .net
  - 'c#'
tags:
  - .NET
  - concurrency
---
Last week, I had the pleasure of attending [Øredev](http://oredev.org/2011) in Malmö, Sweden. While at the conference, I presented two sessions &#8212; including a new talk on [Actor Model Programming in C#](http://oredev.org/2011/sessions/actor-model-programming-in-c-). This was the first official presentation I&#8217;ve given on the subject, having done an ad-hoc version of the session at [Pablo&#8217;s Fiesta](http://pablosfiesta.pbworks.com/w/page/46324025/Actor%20Style%20Programming) this year (which went fairly well, likely due to the awesome [Chicken and Waffles](http://24diner.com/wp-content/uploads/2011/02/waffle_staff.jpg) at [24 Diner](http://24diner.com/) the night before). Early feedback from the Øredev session was positive, which is encouraging since I will be giving an updated version of the talk at CodeMash 2.0.1.2 in January.

First, I wanted to share a few links to the content discussed in the session, including the [GitHub Project](http://github.com/phatboyg/Stact), the [NuGet package](http://nuget.org/List/Packages/Stact), and the [TeamCity build](http://teamcity.codebetter.com/viewType.html?buildTypeId=bt258&tab=buildTypeStatusDiv). I will update the post with the video link once the presentation video is available, along with the slide deck.

Second, I plan to post a series of blog posts explaining how actor model programming is a great model for building concurrent applications, despite the difficulties that the actor model has had in becoming more mainstream (some of those difficulties are explaining in [this article by Paul Mackay](http://www.doc.ic.ac.uk/~nd/surprise_97/journal/vol2/pjm2/)).

In the meantime, I&#8217;m going to take a hard look at how different languages have implemented the actor model (many of which have influenced the current syntax used in Stact). I&#8217;m also taking a step back and identifying other ways the model can be implemented the minimize many of the difficulties and bring some modern programming style to the model. Concurrency is certainly difficult, but I&#8217;m convinced that many aspects can be made more approachable by applying some existing idioms to the problem.

If you do take a look at Stact, please offer any feedback you have via Twitter (I&#8217;m [@PhatBoyG](https://twitter.com/#!/phatboyg)) or GitHub (using issues, whatever). If the traffic grows, we&#8217;ll setup a Google group to keep things manageable.

Until next time&#8230;

 