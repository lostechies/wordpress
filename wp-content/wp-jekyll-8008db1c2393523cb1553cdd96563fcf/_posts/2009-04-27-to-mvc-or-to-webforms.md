---
id: 140
title: To MVC or to WebForms?
date: 2009-04-27T22:23:26+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/04/27/to-mvc-or-to-webforms.aspx
permalink: /2009/04/27/to-mvc-or-to-webforms/
dsq_thread_id:
  - "262114314"
categories:
  - ASP.NET
  - ASP.NET MVC
  - FubuMVC
---
In case you haven’t been following it, there’s a sort of blog storm happening around whether or not you should learn ASP.NET MVC (or indeed MVC in general) or stick with Web Forms.

You can follow the storm here:

  * [Rob Connery’s Post](http://blog.wekeroad.com/blog/i-spose-ill-just-say-it-you-should-learn-mvc/) (which also has links to some of the progenitor posts)
  * [Joe Brinkman’s Post](http://blog.theaccidentalgeek.com/post/2009/04/23/I-Spose-Irsquo3bll-Just-Say-It-Still-Waiting-For-a-GOOD-Reason-to-Learn-MVC.aspx) (which is sort of a response to Rob, plus some extra commentary)

Ok, so now that you’re caught up, I’d like to try to sum up this whole argument with this piece of advice:

**Productive Bliss**: If you’re happy with WebForms, and feel that it’s delivering you good value and you’re not sure what this “pain” or “friction” is that everyone keeps talking about, then you definitely should stay on Web Forms. 

**Disappointed Disillusionment**: If you generally like WebForms, but you keep bumping into problems (long postbacks, viewstate continually causing issues for you, hard to test, etc, etc), then you should start looking into the MVC pattern in general, and maybe start dipping your toe in some of the content over at [www.asp.net/mvc](http://www.asp.net/mvc).

**Disenfranchised Frustration**: Let’s say you came to ASP.NET from PHP, Java, ColdFusion, or some other framework and you like ASP.NET, but you can’t believe how ridiculously hard some tasks are compared to PHP, CF, or some other framework you used.&#160; You like .NET and don’t want to go back, but insist there must be a better way, definitely go check out [ASP.NET MVC](www.asp.net/mvc) right now.

**Diabolical Disgust**:&#160; If you’re appalled at how tightly coupled, SOLID-violating, and horribly mis-abstracted ASP.NET WebForms is, not to mention how completely impossible it is to write testable code, then you might think about skipping both ASP.NET Web Forms and ASP.NET MVC, going straight to something further like [OpenRASTA](http://trac.caffeine-it.com/openrasta) or even [FubuMVC](http://fubumvc.pbwiki.com/) (if you dare).