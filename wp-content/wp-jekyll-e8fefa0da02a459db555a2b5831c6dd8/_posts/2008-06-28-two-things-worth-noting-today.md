---
id: 64
title: Two things worth noting today
date: 2008-06-28T17:23:40+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/06/28/two-things-worth-noting-today.aspx
permalink: /2008/06/28/two-things-worth-noting-today/
dsq_thread_id:
  - "262113917"
categories:
  - ASP.NET MVC
  - Misc
---
1.) [Serious] [Rob Conery](http://blog.wekeroad.com/) (of SubSonic fame, and oh yeah I think he works at Microsoft or something, too :)) has posted his [FIFTEENTH screencast](http://blog.wekeroad.com/mvc-storefront/mvcstore-part-15/) in his [series on building an e-ecommerce app using ASP.NET MVC](http://blog.wekeroad.com/mvc-storefront/) and exploring and learning lots of things along the way.&nbsp; I tell you, this series was outstanding before it hit Episode 10, and 15 is a topper for sure.&nbsp; In this episode he pairs with [Ayende Rahien](http://www.ayende.com/Blog/) (Rhino.Mocks, Castle Windsor, NHibernate, among other project) and [Steven Harman](http://stevenharman.net/) (SubText, among others).&nbsp; 

I know I&#8217;m asking a lot, but I would encourage all of you to watch every episode in the series. Each one has at least a dozen nuggets of useful information, but most are packed full of &#8216;em.&nbsp; Kudos again to Rob for putting in the ridiculous effort and time on this and making a good contribution to the community!

&nbsp;

2.) [Silly] Just when you thought .NET couldn&#8217;t get any better, someone has gone and created an [80386 ASM to IL assembler](http://www.viksoe.dk/code/asmil.htm) so you can use 80386 assembly instructions to write .NET code! I mean, c&#8217;mon, what&#8217;s not to love about writing ASP.NET pages like this:

<pre><span class="asp">&lt;%@ page language="Asm80386" %&gt;</span>
<span class="asp">&lt;%</span>
Str:  DB <span class="str">"Testing..."</span>, 0

  mov eax, -2
  cmp eax, 2
  jle Label1
  xor eax, eax
Label1:
  lea esi, Str
  push esi
  call <span class="str">"Response.Write(string)"</span>
  pop esi
<span class="asp">%&gt;</span>
<span class="kwrd">&lt;</span><span class="html">br</span><span class="kwrd">&gt;</span>EAX: <span class="asp">&lt;%</span>= eax <span class="asp">%&gt;</span></pre>

[via [John Bush](http://twitter.com/johnnyb) - twitter link, couldn't find his home page, let me know and I'll update link]