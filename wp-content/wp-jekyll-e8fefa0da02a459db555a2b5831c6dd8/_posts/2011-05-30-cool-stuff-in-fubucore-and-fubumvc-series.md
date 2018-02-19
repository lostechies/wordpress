---
id: 240
title: Cool Stuff in FubuCore and FubuMVC Series
date: 2011-05-30T14:03:20+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=240
permalink: /2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/
dsq_thread_id:
  - "317853728"
categories:
  - .NET
  - cool-stuff-in-fubu
  - FubuMVC
---
## Introduction

I (and the Fubu team) get asked a lot: &#8220;What&#8217;s better about FubuMVC over ASP.NET MVC?&#8221; I really hate that question because a.) It&#8217;s not simple to answer because it&#8217;s a lot like the question &#8220;Which is better, Mac, Windows, or Linux?&#8221; b.) it puts me in the uncomfortable position of having to promote one framework over another and all the associated problems that causes (fanboi-ism, hurt feelings, framework allegiance, etc).

However, someone once asked me, &#8220;What&#8217;s so great about FubuMVC anyhow?&#8221;  Now _that_ is a much better question because I can answer it concretely without offending anyone or casting anyone else in a negative light.  So I started going through the source of the various projects under the &#8220;[DarthFubuMVC](https://github.com/darthfubumvc)&#8221; umbrella account on Github and making a bunch of draft posts in a series.  So far, I have two series:  FubuCore and FubuMVC.

## FubuCore

This series doesn&#8217;t have much to do with MVC or web frameworks in general. FubuCore ended up being a shared repository for cool utilities and core infrastructure stuff that we used in a number of other projects and products.

You can find the repository here: <https://github.com/DarthFubuMVC/fubucore>

Posts:

  1. [The Cache<TKey, TValue> Class](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-no-1-cache)
  2. [Extension Methods](http://lostechies.com/chadmyers/2011/05/31/cool-stuff-in-fubucore-no-2-extension-methods/)
  3. [Static Reflection](http://lostechies.com/chadmyers/2011/06/01/cool-stuff-in-fubucore-no-3-static-reflection/)
  4. [Dependency Analysis with Directed Graph](http://lostechies.com/chadmyers/2011/06/02/cool-stuff-in-fubucore-no-4-dependency-analysis-with-directed-graph/)
  5. [Easy Configuration](http://lostechies.com/chadmyers/2011/06/03/cool-stuff-in-fubucore-no-5-easy-configuration/)
  6. [Command-Line Binding and Usage Framework](http://lostechies.com/chadmyers/2011/06/06/cool-stuff-in-fubucore-no-6-command-line/)
  7. [Model Binding](http://lostechies.com/chadmyers/2011/06/08/cool-stuff-in-fubucore-no-7-model-binding/) (and [follow-up post](http://lostechies.com/chadmyers/2011/06/10/a-quick-follow-up-on-model-binding-in-fubucore/) with more clarification)
  8. [UrlContext](http://lostechies.com/chadmyers/2011/06/09/cool-stuff-in-fubucore-no-8-urlcontext/)
  9. [Stringification](http://lostechies.com/chadmyers/2011/06/10/cool-stuff-in-fubucore-no-9-stringification/) (you may also want to read the [preface post](http://lostechies.com/chadmyers/2011/06/10/convention-over-lots-of-code/) which explains the context of this post)

## FubuMVC

This series is all about the Front Controller MVC framework we built for our usage at [Dovetail](http://www.dovetailsoftware.com/). FubuMVC has taken on a more expanded role than _just_ an MVC framework. It now includes things like validation, packaging/bottles, advanced user/role/permission authorization, advanced configuration, and a number of other helpful infrastructure-y type things that may be useful in web and non-web projects.

Posts:

  1. [Behaviors](http://lostechies.com/chadmyers/2011/06/23/cool-stuff-in-fubumvc-no-1-behaviors/)
  2. [Action Conventions](http://lostechies.com/chadmyers/2011/10/07/cool-stuff-in-fubumvc-no-2-action-conventions/ "Action Conventions")

You can find the repository here:  <https://github.com/DarthFubuMVC/fubumvc>