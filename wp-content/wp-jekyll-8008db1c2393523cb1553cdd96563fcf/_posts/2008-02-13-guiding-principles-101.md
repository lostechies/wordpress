---
id: 19
title: Guiding Principles 101
date: 2008-02-13T02:06:58+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/02/12/guiding-principles-101.aspx
permalink: /2008/02/13/guiding-principles-101/
dsq_thread_id:
  - "262113646"
categories:
  - Principles
---
As a answer-in-part to my own [Call To Blog More](http://www.lostechies.com/blogs/chad_myers/archive/2008/02/10/you-need-to-blog-now.aspx), I&#8217;d like to make an entry.&nbsp; I&#8217;d like to talk about some of the guiding principles of design we should all be thinking about and re-enforcing in each other.&nbsp; These principles require discipline and it&#8217;s VERY easy to not use them and still achieve decent results (at the cost of looming, expensive problems down the road).&nbsp; You owe it to yourself and your fellow co-worker developer to be familiar with these, at least, and to make an attempt to practice them on a daily basis.

Rather than me repeating documentation on various principles which is already abundantly available on the web, I&#8217;m going discuss two things:&nbsp; 1.) The ObjectMentor site which has a collection of well-written documents (in PDF, \*ugh\*) and 2.) Discuss a somewhat newer principle which I call &#8216;Framework Ignorance Principle&#8217; and which Ayende recently dubbed &#8216;[Infrastructure Ignorance [Principle]](http://www.ayende.com/Blog/archive/2008/02/12/Infrastructure-Ignorance.aspx).&#8217;

## Wealth of OO Design Principle Knowledge

[http://www.objectmentor.com/omSolutions/oops_what.html](http://www.objectmentor.com/omSolutions/oops_what.html "http://www.objectmentor.com/omSolutions/oops_what.html")

This has a breakdown of each and every principle (plus more) that I was planning on talking about here.&nbsp; That kinda stole my thunder, actually.&nbsp; It&#8217;s hard to top [&#8216;Uncle&#8217; Bob Martin](http://blog.objectmentor.com/articles/category/uncle-bobs-blatherings) when it comes to OO design principles, so I&#8217;m not going to attempt it. 

It is definitely worth your time to spend a few nights browsing through the PDF&#8217;s on that page. 

NOTE: If you ever plan on interviewing with me for anything more than a junior level developer position, you better be able to give a sentence or two on at least 5 or 6 of these principles and discuss, at length at least one of them.

I&#8217;d like to call out one principle, in particular that I think would probably benefit everyone the most. It&#8217;s one of the simplest concepts, though hardest in practice to maintain and requires a good team discipline to maintain:

### [Single Responsibility Principle](http://www.objectmentor.com/resources/articles/srp.pdf)

> &#8220;There should never be more than one reason for a class to change&#8221; 
> 
> - Robert &#8216;Uncle Bob&#8217; Martin

If you have a communications class that has methods like &#8216;Open()&#8217; and &#8216;Close()&#8217; as well as &#8216;Send()&#8217; and &#8216;Receive()&#8217;, you&#8217;re violating SRP.&nbsp; Connection management and data transfer are separate concerns and should be isolated.

## Framework Ignorance Principle

This one isn&#8217;t really a new concept and is instead really an amalgam of several other principles. It&#8217;s worth pointing out and promoting to the level of a &#8216;virtual&#8217; first-class principle, in my opinion.

When working with various frameworks, there is a propensity for that framework to become pervasive at all levels of the code.&nbsp; Without rigid discipline, the temptations and weakening arguments such as &#8216;Well, we&#8217;re joined at the hip to FrameworkX, might as well make my life easier and give up the pretense that I&#8217;m NOT going to use it&#8217; will gain in frequency and intensity until there is a collapse of discipline.&nbsp; Depending on what your framework does, this line of reasoning will trigger a set of events that will lead to a quick or gradual decline in your projects maintainability, testability, and overall agility. It&#8217;s a self fulfilling prophecy. If you give up the discipline of keeping the framework segregated by saying that you&#8217;re already in for a penny, you will quickly be in for a pound.&nbsp; While it&#8217;s probably true that you may not be migrating from NHibernate any time soon, you will most likely be migrating from NHibernate 1.0 to 1.2, or better yet, 1.2 to 2.0 which could be a much larger issue. At that point, you&#8217;re very close to adopting a new framework anyhow. Sure, the API is very similar, but the guts could be very different and there is tons of new functionality that may make you rethink certain design decisions &#8212; forcing rewrites of part of your app.&nbsp; Maintaining the ignorance to the last possible moment will greatly ease this refactoring or rewrite.&nbsp; If you made the mistake of allowing ICriteria or ISession references bleed up into your UI or Web layer, making the switch from 1.2 to 2.0 will likely be very painful.

Another case study here is log4net.&nbsp; Over the years, I had grown so accustomed and trusting of log4net and relied on it&#8217;s snail-like release schedule (or lack thereof), that I allowed log4net to bleed into all parts of my app. &#8220;It&#8217;s a logging framework, how much could it possibly change?&#8221; I found myself saying.&nbsp; Well, then log4net 1.2.9 came out. Sure, the API was exactly the same, but they changed the key signature for the DLL which broke assembly linkage all over the place and was irremediable due to the fact that you cannot do assembly versioning redirection in .NET when the key signature changes.&nbsp; Yet another time that a lack of framework ignorance discipline bit me hard in the rear.

I&#8217;m not advocating you go out and write abstraction layers for all your frameworks (\*ahem\* I&#8217;ve tried that, it&#8217;s not pretty). You may have to in certain circumstances, but avoid it as much as possible. You will create a potentially brittle change resistance layer that can slow down your refactoring in the future and also mask useful features in the underlying framework (the &#8216;least common denominator&#8217; problem).&nbsp; I would, however, advocate that you try to leverage the framework to it&#8217;s fullest, but do it in a way that works around and among your primary code and not in the middle of it.&nbsp; Attempt to make use of IoC containers for injecting or wrapping functionality. Look

A perfect example of this technique is how NHibernate mapping files are separate from the domain entity objects themselves. The mapping files explain to NHibernate how to persist and retrieve these objects from a relational data store. There are no mapper objects, no adapters, no attributes on the entities themselves, no code-generated partial classes, etc.&nbsp; To stop using NHibernate or to switch to a new version, you simply stop using it or start using the other version. There will be a few places in your code that will have a reference to NHibernate, but these will be minimal and self-contained, allowing for quick refactor.