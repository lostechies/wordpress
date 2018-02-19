---
id: 114
title: Do not test private methods
date: 2008-11-21T21:49:01+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/11/21/do-not-test-private-methods.aspx
permalink: /2008/11/21/do-not-test-private-methods/
dsq_thread_id:
  - "262114175"
categories:
  - TDD
  - Tips
---
You should only be testing public methods. Private methods are an implementation detail of the object and are subject to heavy change, etc.&#160; Any class, including test fixtures, that care about private methods on another object exhibit the “Inappropriate intimacy” code <strike>smell </strike>stench. 

If you find the need to test a private method, then you’re doing something else wrong. There is an “upstream” problem, so to speak. You have arrived at this problem due to some other mistake previous in this process.&#160; Try to isolate what that is, exactly, and remove that rather than bending your tests to go down a painful road of brittleness in testing.

Better yet, consider why you even need those private methods in the first place.&#160; Why do you feel you need to test them? Is there some major functionality there worth testing? Maybe it shouldn’t be private?&#160; Maybe you have a “responsibility violation” (a violation of the [Single Responsibility Principle](http://www.lostechies.com/blogs/sean_chambers/archive/2008/03/15/ptom-single-responsibility-principle.aspx))?&#160; Maybe you should break this functionality into another class?&#160; There is no one right answer, it depends on your situation so judge accordingly.

In general, don’t let yourself fall into the “It’s legacy code, I can’t do anything” mental trap. There is usually something you can do. For example,&#160; extract class and inject it, make the method public, etc.&#160; If all else fails (and please try not to just give up here, give it a college try), then you can fall back to extraordinary means.