---
id: 145
title: On the performance of “Opinionated Builders”
date: 2009-06-14T05:35:36+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/06/14/on-the-performance-of-opinionated-builders.aspx
permalink: /2009/06/14/on-the-performance-of-opinionated-builders/
dsq_thread_id:
  - "262114402"
categories:
  - Premature optimization
---
I was reading [Eric Hexter’s](http://hex.lostechies.com) post titled “[Opinionated Input Builders Part 6: Performance of the Builders](http://www.lostechies.com/blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx)” and I was going to leave a lengthy comment, but decided it would be better as its own blog post:

> I’m going to assume that the data is all correct (or representative of reality). As another reader pointed out, this [poor performance] could simply be because debug=true is set in the web.config or some other non-obvious, but simple explanation. For this exercise, let’s assume that this performance is the correct reality.
> 
> Since [Eric’s] approach is very opinionated and conventional, I would expect it to result in very consistent and expected results (code written in the same way, files in the same place, etc).
> 
> This consistency is key because you could write some sort of pre-compiler that could inline the partials or something before pushing to production.If there isn&#8217;t already a tool to do this, I would imagine it wouldn&#8217;t be that hard to write.
> 
> "But now I have to write a tool to do what [ASP.NET](http://ASP.NET) could do for me already!&#160; This input builder stuff just ain&#8217;t worth it!" a skeptic might say.
> 
> But consider this:&#160; Doing it WITHOUT input builders may slow you down 20% vs. doing it WITH them (I’m just making numbers up here, but you get the point).&#160; Over an 8 week project with 4 people (1280 man-hours), that&#8217;s a savings of 256 man-hours.&#160; I&#8217;m pretty sure that you could easily write some sort of in-liner or pre-compiler in 256 man-hours (6.4 man-weeks) and you&#8217;d end up with either a net-zero or a net-gain on the project.
> 
> I&#8217;m of the firm belief that you do what&#8217;s expedient for the project (YAGNI unless you&#8217;re absolutely certain you WILL NEED it), and deal with performance issues later in a systematic way.&#160; Performance problems are always easier to deal with later and with more data from which to make a better decision and especially so if you&#8217;re consistent and conventional in your development (which Opinionated Input Builders certainly are).

So for those who might immediately turn their noses up at Eric’s posts due to suspected performance issues, I suggest you at least give it a second look or give it a little time as an optimizer might show up later, negating most if not all performance issues.