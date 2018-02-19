---
id: 151
title: The usual result of Poor Man’s Dependency Injection
date: 2009-07-14T18:41:28+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/07/14/the-usual-result-of-poor-man-s-dependency-injection.aspx
permalink: /2009/07/14/the-usual-result-of-poor-man-s-dependency-injection/
dsq_thread_id:
  - "262114426"
categories:
  - Advice
  - IoC
---
Alternate Title: An IoC Container is a Rich Man’s Factory Pattern Implementation

I ruffled some feathers with my last post on Poor Man’s Dependency Injection (PDMI), so please allow me to clarify further.

The natural progression of using PMDI is this:

  * You start out using PMDI, everything is fine. It goes really smooth and easy. “What’s the big deal?” you think.
  * Later, you need to add some functionality. DI makes it easy, but then you have all these “new()” calls lying around.&#160; Well, that “new FooRepository()” call that’s being made in 17 places in your code now suddenly changes to “new FooRepository(new ConfiguredSessionSource())”, for example.&#160; 17 changes. Not terrible, but not good either.
  * Later, ConfiguredSessionSource needs to take in some configuration. This is getting out of hand. Making all these changes gets difficult.&#160; I know! I’ll write a small factory that will manage the creation of all these objects.
  * Eventually even the factory gets too convoluted with all the different forms your dependency object graph can take. It’s out of hand now.
  * You now have to make a choice:&#160; Improve your factory implementation and eventually implement a half-baked IoC container, or just use an IoC Container.

Every time I’ve used PDMI (which was a significant number of attempts a few years ago), I ended up at this point.&#160; I wrote a few half-baked IoC containers that ended up being more complex than the application itself.&#160; The rest of the time, I ended up going the IoC route, even for small apps with less than, say, 10 classes.

It’s my recommendation that you save yourself some headache and go right for the IoC container. Yes, I know it’s new and a little scary, but trust me, once you get the hang of it, you’ll never look back and laugh at all the fuss that’s being made over this.&#160; It’s like wearing seat belts: Sure, it’s a hassle the first few times and the perceived benefit is little, but once you start doing it it’s not a big deal and the alternative is not pleasant to think about any more.

One more thing:&#160; How small is too small for IoC?

If you have less than “a few” classes and have no expectation this project will grow further.&#160; In my experience, every project usually grows and the ones that don’t are the very rare exception.

Once you have more than “a few” classes, the complexity of maintaining the coupling and dependency graph starts growing rapidly and you’ll wish you had an IoC container later.&#160; You’ll then spend more time retrofitting in a container than if you had just started out that way. So save yourself some effort and just do it.

Also, since the effort, once familiar with a container, is so low that even if you don’t end up reaping the benefits, the sunk cost of using a container unnecessarily is negligible.