---
id: 322
title: Sweet, sweet vindication
date: 2011-12-30T16:31:06+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?page_id=322
permalink: /2011/12/30/sweet-sweet-vindication/
dsq_thread_id:
  - "521519771"
---
It&#8217;s been awhile since I have written an eye-poker post. I&#8217;ve been trying be more reserved, professional, and politically correct. But that basically had a cooling effect on my writing. So it&#8217;s time we turn up the heat and let the rage flow.

## The State of Web Frameworks Sucks

The state of big web frameworks sucks. Not the least sucky among these is Rails. There, I said it. &#8220;Bah, he&#8217;s just a bitter .NET developer stuck in the stone ages&#8221;. I&#8217;m tired of getting made fun of and beat up by former PHP scripters telling me how lame and &#8220;enterprisey&#8221; .NET is and how wonderful and magical Rails is and how it solves every problem.  Tell it all to this guy:

[ActiveRecord (and Rails) Considered Harmful](http://blog.steveklabnik.com/posts/2011-12-30-active-record-considered-harmful "ActiveRecord (and Rails) Considered Harmful")

Especially with this wonderful quote:

> It is practically impossible to teach OO design to students that have had a prior exposure to Rails: as potential programmers they are mentally mutilated beyond hope of regeneration.
> 
>   * Edsger W. Dijkstra (paraphrased)

My thoughts exactly, on all counts.  The whole &#8220;Controller&#8221; mindset in most MVC frameworks is &#8220;pants-on-head retarded&#8221;. Worse yet, most frameworks use inheritance.  I can&#8217;t say this loud enough, so I&#8217;m going to BOLDFACE it, ALLCAPS, BLOCKQUOTE it so maybe you&#8217;ll see it:

> **INHERITANCE IS FAIL FOR MOST DESIGNS, BUT NEVER MORE SO THAN IN WEB/MVC FRAMEWORKS!**

Rails is one of the biggest violators of this. I don&#8217;t care about your stupid dynamic typing and all your excuses about how it &#8220;just doesn&#8217;t matter&#8221; &#8212; it matters. The laws of good design don&#8217;t just fly out the window when you&#8217;re using Ruby or any other language.

## More Pants On Head: ActiveRecord

To call ActiveRecord an ORM is to insult the already sullied and notorious name of ORM. I won&#8217;t even say that AR is the Linq2SQL of Rails dev because it&#8217;s worse than that. AR is the equivalent of dragging and dropping your database to your design surface in Northwind/Designer-driven developing in Visual Studio.

I don&#8217;t care what you&#8217;re doing with your data store, the model should be the core. This principle is so fundamental that not even silly dynamic typing can overcome it. The model flows out into everything, not your database driving your model. AR represents everything that&#8217;s wrong with data-driven development as much as designer-driven EF does in .NET.  It&#8217;s just wrong, always has been wrong, and always will be wrong. The model is the key, not the persistence mechanisms.  AR flagrantly and flamboyantly violates this principle and anyone with a clue who has used AR seriously on any project of length will tell you how it grows into a big mess.

And then you have the whole &#8220;Unit test against your database&#8221; phenomenon. I&#8217;ve had Rails guys chide me for this unmentionable and detestable practice and say that I&#8217;m too stuck in my .NET ways, but I&#8217;m sorry. You&#8217;re an idiot. _Unit_ testing against the database is always, and in every case, wrong. Attempts to explain otherwise sound awfully like arguments I once heard from someone explaining why cannibalism isn&#8217;t as bad as people make it out to be. It&#8217;s just wrong (unit testing against your database and eating people).  Just because you wear thick rimmed glasses and drink lattes with your scarf flipped casually around your neck doesn&#8217;t mean you get to throw fundamental principles out of the window. So stop it. Just because it may be quick or easy (which I don&#8217;t believe) doesn&#8217;t make it right.

Just when I thought I couldn&#8217;t say anything worse about AR, I&#8217;ve got one more &#8212; the _coup de grace_ &#8211;it uses inheritance! ARGH! Add &#8220;maliciously&#8221; to the adverb list (&#8220;flagrantly, flamboyantly&#8221;).

## ActionController &#8211; Crack Den of Inheritance

It seems almost every web framework has this wrong: Rails, ASP.NET MVC, Struts, Django, Spring, and MonoRail from my limited research.

Let me put it another way in case I haven&#8217;t been clear enough: Inheritance is _antithetical_ to web app design.

One class &#8212; that derives from some gawdawful ginormous base class &#8212; that has many &#8220;action&#8221; methods on it is a pile of fail. Why? Because each of those methods has, by definition, a different responsibility and you&#8217;re breaking the Single Responsibility Principle.  [Principles matter](http://lostechies.com/chadmyers/2009/02/12/laws-rules-principles-patterns-and-practices/)! No matter what language (dynamic, static, etc), principles matter!  Just because you&#8217;re a Rails hipster doesn&#8217;t mean you don&#8217;t have to obey the laws of physics. With sufficient thrust, pigs can fly for a short while. Likewise, with sufficient ignoring of principles, a rails dev can be successful for awhile but the legacy maintenance cluestick will eventually come crashing down on him/her.

## The Perfect Web Framework

Rails is the whipping boy of this post, but most of the other frameworks deserve all the same vitriol because they have all the same fatal flaws (primarily inheritance).  So what would the perfect web framework look like? Let me show you:

  * **Total adherence to principles**: The framework should itself abide by the fundamental principles of good software design _and_ it should require you to do so as well. It should make it as difficult as possible to flout them and, preferably, punish you for doing so by making everything harder.
  * **Completely compositional**: It should itself be based entirely off of composition and either not use inheritance at all, or only in very minor circumstances and certainly should not require you to derive from any framework base classes if you don&#8217;t want to. Convenience base classes are fine, but should not be imposed upon the framework consumer.  The framework should encourage and reward compositional design and frustrate and punish inheritance mis-design.
  * **Model based**: It should encourage and reward you for having a centrally defined model (or models) and be based around one itself. The framework should itself use one or more models to represent its own internal structures (configuration, routing, etc) and expose these for manipulation by the consumer. It should facilitate you using your own models in your actions and views.
  * **Not have any notion of controllers**: The framework itself has one controller that processes the routes and this satisfies the &#8220;C&#8221; in MVC. The words &#8220;controller&#8221; should not appear anywhere else in the framework or outside. It should completely break you of the notion that you need a class called &#8220;controller&#8221; because this is just wrong and leads you to do all sorts of bad, nasty, and dumb things.
  * **Statically typed**: In line with the &#8220;Model based&#8221; requirement, it should facilitate inspection, reflection, and convention-based development where everything (and I mean everything) flows OUT from the model (not into the model, like ActiveRecord foolishly does).  All your validation rules, authorization rules, binding rules, display rules, input rules, etc. should all flow from decorations and conventions attached to your model. Which leads to the next requirement&#8230;.
  * **Conventional top-to-bottom**: The framework itself should expose all of its own conventions and allow them to be replaced. It should encourage and reward conventional development and frustrate and punish you for doing one-off stuff except as a last resort.  And I don&#8217;t mean Rails&#8217; conventions where it&#8217;s my-(lame)-way-or-the-highway, I mean real conventions &#8211; YOUR conventions where you can define them and reuse them. This is only possible with static typing because you can&#8217;t get the level of introspection and reflection necessary to pull this off with dynamic typing and string-only reflection.
  * **Based on IoC**: No more IoC as an afterthought. I&#8217;m not going to have this debate. If you disagree with this you are wrong. If you disagree then you simply haven&#8217;t seen the power of IoC done right in a framework and in an app. Try playing with FubuMVC for a few weeks and look at some of our samples or come hang out at Dovetail for a day or two and I guarantee you will no longer disagree with me.  The power this provides is so overwhelming and fundamental that is perhaps the requirement of requirements.
  * **Mostly model-based conventional routing**: Your routes should flow out, conventionally, from the model as much as possible allowing proper REST scenarios. This is extremely important in a CRUD app. Specific actions (for service actions like &#8220;send email&#8221; that aren&#8217;t based on your main domain model) should be easily created, defined, and conventionally routed.
  * **Action-based**: In line with the whole &#8220;no controllers&#8221; and &#8220;completely compositional&#8221; requirements, it should encourage each action to be tiny (a few lines at most). All things like model binding, validation, object/persistence retrieval, should be moved into composable &#8220;[behaviors](http://lostechies.com/chadmyers/2011/06/23/cool-stuff-in-fubumvc-no-1-behaviors/)&#8221; that are outside of the action since they are not the [concern](http://lostechies.com/seanchambers/2008/03/15/ptom-single-responsibility-principle/ "Single Responsibility Principle") of the action. Each action should be a single class with a single public method that does that one thing. No more multiple-50-plus-line methods in your dripping-with-inheritance &#8220;Controller&#8221; class. NO!
  * **Minimized code-in-view**: This one fits with the &#8220;conventional&#8221; and &#8220;compositional&#8221; requirements. The framework should provide ways of micro-HTML generation that flows from the model and through conventions. I&#8217;m not talking about lame loosely-typed &#8220;HTML helpers&#8221;, I mean real meaty, conventional, [model-based micro-HTML generators](https://github.com/chadmyers/fubumvc-package-demo/blob/master/source/SuperHtml5Package/Html5PlaceholderFieldLayout.cs).  The framework should also make using partials a natural, normal, and preferred way of compositing screens.  It should support the ability to render simple HTML no-code partials, or to execute a partial action through the framework to render a chunk of HTML, JSON, etc.
  * **One Model In, One Model Out**: Every action method should take in one model (not primitives) in and return one model out (no ActionResult nonsense or framework-dependent inheritance silly classes).  The action should not tell the framework which view to render or where to go next unless the action&#8217;s purpose is specifically for that (such as a post-successful-login routing action).  The framework shall conventionally determine how to bind the models going in and render views from the outgoing model
  * **Zero touch**: My actions should have ZERO knowledge of the web framework. I shouldn&#8217;t have to &#8220;import&#8221; or &#8220;using&#8221; or &#8220;require&#8221; any of your framework stuff. My actions should be simple PO*O&#8217;s [like this](https://github.com/DarthFubuMVC/fubumvc-examples/blob/master/src/Actions/HandlerStyle/SimpleWebsite/Handlers/Movies/ListHandler.cs) (note no &#8220;using FubuMVC*&#8221;)
  * **Independent of other frameworks**: I shouldn&#8217;t have to use your stupid &#8220;ORM&#8221; or your favorite JavaScript framework which is 2 weeks old and already outdated.  This is made easier, if not entirely possible, by the &#8220;IoC&#8221; requirement, by the way.
  * **Testing as a first class citizen**: I debated whether or not I should even put this in here because, for me, this is like putting &#8220;Step 1: Breathe&#8221; at the top of any list of instructions.  Generally, if you care about any of the other requirements, this one is essentially a &#8220;Step 0&#8243; requirement kinda like &#8220;Use a computer&#8221; or &#8220;Run on x86 processors&#8221;.

It should come as no surprise that we, at Dovetail, came to these conclusions (many of them solely by [Jeremy Miller](codebetter.com/jeremymiller)) after evaluating all the other major frameworks, suffering much ridicule and derision for noting the inherent and fundamental flaws in them and then building our own that follows all the principles: [FubuMVC](http://mvc.fubu-project.org).

In many ways, FubuMVC is better than Rails and I&#8217;ll put my framework up against yours any day of the week. In some ways, it has a long distance to go yet. These are, namely, approach-ability for newbies and community. Currently you have to be disgusted with your current web framework and have tried to replace large portions of it before you can truly appreciate FubuMVC. As far as community, it&#8217;s still pretty small at this point, and community contributions are growing, but still not anywhere near Rails level, for sure.