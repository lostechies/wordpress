---
id: 78
title: Design and Testability
date: 2008-08-17T01:27:22+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/16/design-and-testability.aspx
permalink: /2008/08/17/design-and-testability/
dsq_thread_id:
  - "262114000"
categories:
  - Design
  - TDD
---
There was a rather healthy public discussion and debate going on via Twitter today between Roy Osherove, Ayende Rahien, Colin Jack, me, and several others. Michael Feathers even dropped in at one point which was cool.&#160; This all started when Roy twittered an interesting [link to a post](http://theruntime.com/blogs/jacob/archive/2008/08/15/testability-in-.net.aspx) by Jacob Proffitt.

Most of the “debate” seemed to be all of us saying the same thing different ways and violently agreeing, but there were some honest to goodness points of contention.&#160; Ayende has [covered this](http://ayende.com/Blog/archive/2008/08/16/Inversion-of-Control-is-NOT-about-testability.aspx) at length, so I’d like to try to cover it as succinctly as possible which may also help matters. One of the big sticking points was the concept of “Design for testability”. I wanted to point out that TDD != “Design for Testability”.&#160; So here goes my shot at trying to explain why TDD is not “Designing for Testability”, succinctly:

> You should design with the goals of loose coupling and high cohesion in mind.&#160; Using TDD is one really great and surefire (though not foolproof) way of getting you there. You can do it without TDD, but it’s much easier to get it wrong. When striving for a loosely coupled, highly cohesive design, using TDD as a method, you will likely need to perform interaction testing at some point. Mock objects and associated frameworks will assist in this effort and language-based mock objects and frameworks (i.e. those that are created using normal means for normal usage) are all you should need in this regard.

Most of those involved in the debate/discussion will hopefully understand my attempt above (even if they disagree). If I’ve failed in my succinctness, then allow me to elaborate. TDD is not always possible/effective/realistic in all situations. Roy pointed out SharePoint development, which is a great example of this. While you can go through a lot of rigormoral to achieve TDD in this situation, it’s probably going to involve a lot of frustration, inefficiency, and time that could be better spent bang-for-buck-wise.&#160; In these situations, something like TypeMock would be excellent and a worth-while investment. For those not familiar, TypeMock does not use “normal” means to achieve some of it’s functionality. It uses, among other things, the Profiler API in order to create situations not normally available to regular run-of-the-mill C#/VB.NET code.&#160; In this respect, TypeMock is an extremely powerful tool and enables TDD and interaction testing easily against otherwise insurmountable complexity.

So you see, SharePoint, in this example, is the big problem. It’s a poor design that doesn’t lend itself well to extensibility (and therefore testability) except the type of extensibility it prescribes (which is usually not enough and very frustrating for developers wishing to extend SharePoint). What I’m pushing for is to help developers (including MS developers – especially those on the SharePoint and ASP.NET design teams) understand these complexities and problems so that we won’t need to resort to extraordinary means to write good, tested good against these designs.

Simply put, I wish for an environment where TypeMock isn’t needed – or rather, where the extraordinary features of TypeMock aren’t needed. Now, don’t get me wrong, I don’t wish ill on Roy or his company. They’re smart people, they’ll come out with some other amazing tool and service that will blow us away and they’ll be doing quite well. Of this, I am quite sure!