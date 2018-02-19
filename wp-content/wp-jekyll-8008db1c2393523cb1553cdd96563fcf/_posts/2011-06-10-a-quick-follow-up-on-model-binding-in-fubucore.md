---
id: 290
title: A Quick Follow-up on Model Binding in FubuCore
date: 2011-06-10T10:41:00+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/2011/06/10/a-quick-follow-up-on-model-binding-in-fubucore/
permalink: /2011/06/10/a-quick-follow-up-on-model-binding-in-fubucore/
dsq_thread_id:
  - "327805099"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
I wanted to make some quick follow-up points to my “[Cool stuff in FubuCore No. 7: Model Binding](http://lostechies.com/chadmyers/2011/06/08/cool-stuff-in-fubucore-no-7-model-binding)” post:

[Joshua Flanagan](http://joshuaflanagan.lostechies.com/) pointed out that I had an error in my description of how the ExpandEnvironmentVariablesAttribute works.&nbsp; I updated the post to correct the error, so you may want to check that out.

Also, when I wrote the post I wasn’t quite clear on the distinction among ValueConverter, IPropertyBinder, and IModelBinder.&nbsp; There appeared to be some overlap.&nbsp; After speaking with Jeremy Miller some more, he set me straight.

**ValueConverter**: For coercing values from one type to another. These should be somewhat lightweight (i.e. turn “True” into the Boolean True value). The raw values will come from the IRequestData bag.

**IPropertyBinder**: These are meant for binding properties on your models to something not in the IRequestData bag. That is, something that wasn’t posted to the server or found in your ASP.NET Request or the AppSettings, etc.&nbsp; Two examples of the type of data you would might want to bind to your models that aren’t in the IRequestData bag:&nbsp; 1.) the current logged-on user’s email address and 2.) the current time zone of the server.

**IModelBinder**: This is if you need something beyond binding model objects and properties to name/value pair data.&nbsp; You can apply IModelBinders to specific situations (like the EntityModelBinder I mentioned in the original post), or complete replacement of Fubu’s default, built-in StandardModelBinder.&nbsp; I think this is one area where Fubu’s model binding shines because it does NOT require a full replacement/override of huge swaths of the model binding framework to handle a one-off situation.&nbsp; You can do it piece by piece. However, it does have the flexibility to be completely replaced/swapped-out if you need to do something completely different than name/value pair binding.