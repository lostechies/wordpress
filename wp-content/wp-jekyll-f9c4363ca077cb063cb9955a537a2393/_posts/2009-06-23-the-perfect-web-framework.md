---
id: 148
title: The Perfect Web Framework
date: 2009-06-23T05:32:26+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/06/23/the-perfect-web-framework.aspx
permalink: /2009/06/23/the-perfect-web-framework/
dsq_thread_id:
  - "262114423"
categories:
  - Humor
  - MVC
---
I’ve been paid professionally to work with or have messed around with many web frameworks. To name most of them:

  * Perl/CGI
  * RoR
  * a tiny bit of Django
  * ASP.NET WebForms
  * ASP.NET MVC
  * FubuMVC
  * MonoRail
  * a tiny bit of [OpenRasta](http://trac.caffeine-it.com/openrasta) (sorry Sebastian, I keep failing to find time to dig into this more. I really mean to, I promise!)
  * Apache Struts
  * Java JSP
  * Java Servlets
  * Java Server Faces
  * A bunch of other of the myriad of Java web frameworks
  * PHP
  * ASP
  * A bunch more that I can’t remember or aren’t worth mentioning

Each of them offers a little, but at the huge expense of getting in your way a lot of time.

The more and more I use more of them, the more I come to the conclusion that the perfect web framework looks like this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">string</span> Get(IDictionary&lt;<span class="kwrd">string</span>, <span class="kwrd">string</span>&gt; request)
{
  <span class="rem">//TODO: Stuff here</span>
}</pre>
</div>