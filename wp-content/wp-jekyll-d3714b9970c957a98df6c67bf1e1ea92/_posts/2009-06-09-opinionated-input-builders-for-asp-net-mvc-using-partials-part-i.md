---
id: 41
title: Opinionated Input Builders for ASP.Net MVC using partials – Part 1
date: 2009-06-09T16:21:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx
permalink: /2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i/
dsq_thread_id:
  - "262052379"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - CoC
  - mvccontrib
---
</p> 

  * <a target="_blank" href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx">Part 1 &ndash; Overview</a> 
  * <a target="_blank" href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx">Part 2 &ndash; the Labe</a>l 
  * <a target="_blank" href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx">Part 3 &ndash; the Source Code</a> 
  * <a target="_blank" href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx">Part 4 &ndash; the Partial View</a> 
  * <a target="_blank" href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx">Part 5 &ndash; the Required Field Indicator</a>&nbsp; 
  * <a target="_blank" href="/blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx">Part 6 &ndash; the Performance</a> 
  * <a target="_blank" href="/blogs/hex/archive/2009/06/14/opinionated-input-builders-part-7-more-on-performance-take-2.aspx">Part 7 &ndash; the Performance Take 2</a>
  * <a target="_blank" href="/blogs/hex/archive/2009/06/17/opinionated-input-builders-part-8-the-auto-form.aspx">Part 8 &ndash; the AutoForm</a>

It has taken a while to really understand how different pieces and ideas can fit together to give a concise and productive form input helpers for the asp.net mvc framework. I have pulled together this idea from the following sources:

  * &ldquo;opinionated input builders&rdquo; that <a target="_blank" href="http://codebetter.com/blogs/jeremy.miller/">Jeremy Miller</a> and <a target="_blank" href="/blogs/chad_myers/">Chad Myers</a> presented at the <a target="_blank" href="http://www.kaizenconf.com/">Kaizen Conference</a> in Austin last year, 
  * The work that <a target="_blank" href="http://www.headspringsystems.com">Headspring Systems</a> (<a target="_blank" href="/blogs/jimmy_bogard/default.aspx">Jimmy Bogard</a> and <a target="_blank" href="http://mhinze.com/">Matt Hinze</a>) has done with that concept on some of our big projects. 
  * <a target="_blank" href="http://bradwilson.typepad.com/">Brad Wilson&rsquo;s</a> sample of how <a target="_blank" href="http://aspnet.codeplex.com/Release/ProjectReleases.aspx?ReleaseId=18803">Dynamic Data Could work on Asp.Net MVC</a> 
  * Convention Over Configuration &ndash; Ruby on Rails and Jeremy Miller 
  * Creating partial views as aspx pages with their own nested master pages via <a target="_blank" href="http://www.jeffreypalermo.com">Jeffrey Palermo</a> 
  * The strongly typed helpers from <a target="_blank" href="http://www.mvccontrib.org">MVC Contrib</a> and the <a target="_blank" href="http://aspnet.codeplex.com/Release/ProjectReleases.aspx?ReleaseId=24471">MVC Futures</a> work that the MVC Team has put together. 

Now that I have given credit to everyone who has helped me get to the point of understanding how to pull of these pieces together.&nbsp;&nbsp; 

## The Model comes first.

The goal of these control helpers is to reward you for developing MVC with the Model first.&nbsp; Yeah there is a reason that **Model View Controller** starts with the **Model**. Using the strongly typed views in the aspx view engine we can carry the type down to the control helpers with intellisense and then build html input control based on conventions for rendering specific CLR types to specific HTML output.&nbsp; Now my biggest problem with the ways that this has been attempted to date is that once helpers started to take on more mark up beyond the < input > tag it was hard to modify as that markup ended up being written in code rather than in a view file.&nbsp; This is where I abstracted the mark up and the logic to decide which markup to render so that there is a solution that is easy to maintain the markup and it is easy to add new conventions or change the conventions for how a particular type or model property is rendered to a control.

First here is an example of a model rendered in a strongly typed view and the markup used to create this.&nbsp; There are attributes applied to the model to add some specific control over how the UI is rendered. It is important to call out that in this case I have built a (view) Model specifically to represent a single view.&nbsp; I do not intend to reuse this model in another views.&nbsp; I think trying to get reuse out of models is a mistake in most circumstances, it is better to keep your model clean so that it represents exactly what you want for the View.&nbsp; Each of these attributes are used by my conventions to decide which Partial View to render.

[<img height="484" width="585" src="//lostechies.com/erichexter/files/2011/03/image9_thumb_48FDEDE2.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image9_23E0A376.png) 

&nbsp;

This is the example of the view page which is rendering the view and the markup used to create this.&nbsp; The Html.Input uses the LamdaExpression syntax to declare which property needs and input.&nbsp; 

[<img height="772" width="886" src="//lostechies.com/erichexter/files/2011/03/image_thumb_24A8E393.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_0D5DDF22.png) 

It is important to call out that the Guid property is rendered as a Hidden input tag and that is why it does not show up in the UI. This is a model element that is used to carry state in the form between posts.

## Walkthrough of the Html.Input( ) method

The syntax for calling into the input method uses a lamda expression like so&hellip;..&nbsp; This has full intelisense support. 

[<img height="41" width="566" src="//lostechies.com/erichexter/files/2011/03/image_thumb_2C70D635.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_53AB1F6A.png) 

&nbsp;

The helper determines that since the Name is a string data type it decides by convention to render this property using the String.aspx partial view. 

[<img height="484" width="566" src="//lostechies.com/erichexter/files/2011/03/image_thumb_473CFC41.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_00C00C39.png) 

Here is the markup of the String.aspx partial view.&nbsp; As you can see it uses a Master Page to control how its label and input is rendered.

[<img height="286" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_thumb_470D4C81.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_5D4367D3.png) 

Here is the Field.Master Master Page this controls the layout of the input, label, example text, and validation message. 

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

[<img height="427" width="1036" src="//lostechies.com/erichexter/files/2011/03/image_thumb_712CD49C.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />](//lostechies.com/erichexter/files/2011/03/image_2BF47D73.png)

Follow me on RSS and Twitter
  
<a href="https://twitter.com/ehexter" style="float:left;valign:top" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float:left" href="http://feeds.feedburner.com/EricHexter" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" style="border:0;padding-right:10px" /></a>