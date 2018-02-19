---
id: 85
title: Opinionated ASP.NET MVC by Joshua Flanagan
date: 2008-09-03T04:44:16+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/09/03/opinionated-asp-net-mvc-by-joshua-flanagan.aspx
permalink: /2008/09/03/opinionated-asp-net-mvc-by-joshua-flanagan/
dsq_thread_id:
  - "262114057"
  - "262114057"
categories:
  - ASP.NET
  - MVC
---
[Joshua Flanagan](http://flimflan.com/blog), who’s been tearing it up for the team I work on at Dovetail, has recently posted two great posts on how we’re doing ASP.NET MVC. I suggest you check ‘em out:

  * [Testing with Opinionated ASP.NET MVC](http://flimflan.com/blog/TestingWithOpinionatedASPNETMVC.aspx) (or how going with conventions made our controller testing considerably easier)
  * [Sample Opinionated Controller](http://flimflan.com/blog/SampleOpinionatedController.aspx)</p> </p> </p> </p> </p> 

He’s done a good job of trying to wrap everything up in a nice package. Unfortunately some of the guts of how the controllers are found and how the actions are invoked are not that easy to wrap up into a blog post, but he’s done a good job of covering the gist of it all.

Some of our major design goals were/are:

  * Simplify the intake of parameters to actions: One model object with all the properties you need (and maybe more optional ones).&#160; Use a fancy converter that’s smarter than the baseline parameter converter in ASP.NET MVC Preview 3. (NOTE: In Preview 5 there’s the IModelBinder stuff which looks like it may do everything we were doing in Preview 3, we may switch to this but we haven’t looked at it enough yet to determine)
  * In the controllers, separate the preparation of the view from the actual execution of the view (one model in, one model out). Use the action invoker to determine the appropriate thing to do with the results of the controller action invocation*.
  * Use a convention for form element names so that they can easily be picked up on the way back up to the server in a form-post scenario. This is also useful for a modal popup scheme we have which allowed us to develop a “select an existing or create a new” child feature in a fraction of the time it would’ve taken otherwise. 
  * The naming thing also helps us with our UI testing as the test harnesses know how to find elements intuitively
  * No magic strings (for reflection-type stuff, anyhow). Anywhere. This means you!&#160; Use static reflection lambda expression (i.e. model => model.SomePropertyName) wherever possible. We declare our textboxes like this:   
    <%= this.TextBoxFor( m => m.Contact.FirstName ).Width(200).WithLabel(“FIRST_NAME”) %>&#160;&#160;&#160;   
    Yes, I know FIRST_NAME is a string, but it’s a key to a localization thingee that spits out the correct string based on your language/culture settings.
  * Route all URL generation through an “Invocation Registry” that knows about all the controllers, actions, and their input and output model objects and can determine the correct URL for them and the best way to invoke the actions. No URL’s in the views (well, except maybe for static content).
  * There’s a bunch more that I’m not remembering right now

* By doing this, we can invoke an action via HTTP GET, JSON, in a modal pop-up window, or a number of other ways and the action invoker does the responsible thing with the result model and can return it back to the client using the appropriate mechanism (JSON in, JSON out, etc). The controller never has to know the difference.

Our controller tests are pretty easy to write now, as Josh pointed out. They could be better, but we’re getting there.&#160; We’re still struggling with View testing and are probably going to end up just going with full UI-only testing (key events, button clicks, that sort of thing).&#160; ASP.NET affords a lot of great functionality for the views, but kills a lot of our testing capabilities. It’s tempting to switch to NVelocity or something, but we’d be giving up too much on the functionality side, I’m afraid.