---
id: 122
title: Oxite Review – Part 2
date: 2008-12-28T16:14:52+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/12/28/oxite-review-part-2.aspx
permalink: /2008/12/28/oxite-review-part-2/
dsq_thread_id:
  - "1081157221"
categories:
  - Uncategorized
---
In [Part 1](http://www.lostechies.com/blogs/chad_myers/archive/2008/12/20/oxite-review.aspx), we covered some overall, general aspects of Oxite (as a sample application, as an OSS project, etc) as well as the lack of tests and the problematic domain and persistence strategy.

In this part, dig a little deeper and get into some particular aspects of the application design of the application outside of the domain model.&#160; In this part, I plan on covering:

  * High Coupling, Low Cohesion
  * Lack of Dependency Injection and IoC causes cascading design problems
  * Incorrect layering and slicing of abstractions
  * The Provider Anti-Pattern

## High Coupling, Low Cohesion

The concepts of [Loosely Coupled](http://en.wikipedia.org/wiki/Coupling_(computer_science)), [Highly Cohesive](http://en.wikipedia.org/wiki/Cohesion_(computer_science)) code ([Jeremy](http://codebetter.com/blogs/jeremy.miller) has a [great article on MSDN](http://msdn.microsoft.com/en-us/magazine/cc947917.aspx) which you should stop now and go read), are not new even to the OO design world.&#160; Unfortunately we don’t hear much about it in the .NET space for some reason.&#160; I say unfortunately because they are two extremely important concepts&#160; around OO design. As the title of this section implies, the Oxite object design is, generally speaking, not loosely coupled or highly cohesive. There are some decent abstractions and quite a few classes are cohesive to various extents (some good, some OK, some not so good, etc).&#160; However, some classes are particularly egregious and I want to call them out as a big warning to anyone designing an application in the same manner as Oxite.&#160; The [BaseController class](http://www.codeplex.com/oxite/SourceControl/changeset/view/27048#371399) is extremely coupled to just about every part of the system.&#160; It is not cohesive at all as its functionality basically equals that of a “Utility” class. It has everything and the kitchen sink in it.&#160; As best I can tell, it does the following things:

  * Loads the current user object from the membership provider (coupled to MembershipRepository directly)
  * Maintains a list of feeds to be displayed on the view/page
  * Sets up the RSS/ATOM Feed list for a given view/action
  * Sets up the view/page title, checks for admin permissions, sets up the OpenSearch properties
  * Handles “Not Found” scenarios
  * Handles file/binary download scenarios
  * Handles XML result scenarios
  * Handles Feed (RSS/ATOM) result scenarios
  * Generates the ATOM/RSD link tags on the page
  * Handles RSD-xml requests
  * Handles Localization of strings
  * Handles localized Date/Time conversions

&#160;

## Lack of Dependency Injection, IoC

Lorem Ipsum

## Incorrect Layering of Abstraction

Lorem Ipsum

## The Provider Anti-Pattern

Lorem Ipsum