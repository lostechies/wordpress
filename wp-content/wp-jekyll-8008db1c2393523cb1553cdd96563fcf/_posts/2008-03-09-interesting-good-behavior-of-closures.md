---
id: 27
title: Interesting (good) Behavior of Closures
date: 2008-03-09T03:42:00+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/03/08/interesting-good-behavior-of-closures.aspx
permalink: /2008/03/09/interesting-good-behavior-of-closures/
dsq_thread_id:
  - "262113699"
categories:
  - .NET
  - Misc
---
For some reason, I didn&#8217;t think this would work, but it does:

<pre><span>Customer</span> c = <span>null</span>;
            <span>Func</span>&lt;<span>string</span>&gt; func = ()=&gt;c.LookupName;
            c = <span>new</span> <span>Customer</span> {LookupName = <span>"First"</span>};
            System.Diagnostics.<span>Debug</span>.WriteLine(func());</pre>

[](http://11011.net/software/vspaste)

I would&#8217;ve expected an NRE in the WriteLine because the &#8216;c&#8217; reference (null) would&#8217;ve been packaged up by the closure.&nbsp; But apparently it packages up the reference to the reference also so that if the &#8216;c&#8217; variable value changes, so does the closure&#8217;s reference to it.&nbsp; 

The output is not an NRE, but rather &#8220;First&#8221;.

I was curious what it would do with valid references. Consider the following example:

<pre><span>Customer</span> c = <span>new</span> <span>Customer</span>{LookupName=<span>"First"</span>};
            <span>Func</span>&lt;<span>string</span>&gt; func = ()=&gt;c.LookupName;
            c = <span>new</span> <span>Customer</span> {LookupName = <span>"Second"</span>};
            System.Diagnostics.<span>Debug</span>.WriteLine(func());</pre>

The output is, as you would expect, &#8220;Second&#8221;.

One last stretch here, what about stack-based value types:

<pre><span>int</span> i = -1;
            <span>Func</span>&lt;<span>int</span>&gt; func = ()=&gt;i;
            i = 99;
            System.Diagnostics.<span>Debug</span>.WriteLine(func());</pre>[](http://11011.net/software/vspaste)</p> 

The output is 99. 

The way it works under the hood is that the compiler doesn&#8217;t actually create a new stack variable called &#8216;i&#8217; (like it would normally), it creates a new class called <>c__DisplayClass2d in my case. Well, that&#8217;s hard to type, so let&#8217;s just call it FancyClass:

<pre><span>public</span> <span>class</span> <span>FancyClass</span>{
                <span>public</span> <span>int</span> i;

                <span>public</span> <span>int</span> GetI(){
                    <span>return</span> i;
                }
            }</pre>

[](http://11011.net/software/vspaste)

Then, it re-writes &#8212; rather it compiles slightly different IL &#8212; the code above (the int i = -1 example) like this:

<pre><span>FancyClass</span> c = <span>new</span> <span>FancyClass</span>();
            c.i = -1;
            <span>Func</span>&lt;<span>int</span>&gt; func = ()=&gt;c.i;
            c.i = 99;
            System.Diagnostics.<span>Debug</span>.WriteLine(func());</pre>

[](http://11011.net/software/vspaste)

Seen like this, it seems a bit more obvious.

Many of you are probably saying &#8220;Duh!&#8221;, but this went against my understanding of how closures package up their context.&nbsp; 

[](http://11011.net/software/vspaste)