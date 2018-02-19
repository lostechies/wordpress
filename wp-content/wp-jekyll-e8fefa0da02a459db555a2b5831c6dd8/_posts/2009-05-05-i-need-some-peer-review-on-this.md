---
id: 141
title: I need some peer review on this
date: 2009-05-05T04:21:00+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/05/05/i-need-some-peer-review-on-this.aspx
permalink: /2009/05/05/i-need-some-peer-review-on-this/
dsq_thread_id:
  - "262114390"
categories:
  - .NET
  - GenericFun
---
So I have a problem where I have an open type:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> ThunderdomeActionInvoker&lt;TController, TInput, TOutput&gt; 
    : IControllerActionInvoker
    <span class="kwrd">where</span> TController : <span class="kwrd">class</span>
    <span class="kwrd">where</span> TInput : <span class="kwrd">class</span>, <span class="kwrd">new</span>()
    <span class="kwrd">where</span> TOutput : <span class="kwrd">class</span>
{
    <span class="rem">/*...*/</span>
}</pre>
</div>

And I need to make a generic one of these bad-boys and then &ldquo;new&rdquo; it up.&nbsp; The only problem is, I don&rsquo;t know whether my candidate/proposed type for TInput meets the &ldquo;class&rdquo; and/or &ldquo;new()&rdquo; constraints.&nbsp; There doesn&rsquo;t appear to be a Type.TryMakeGenericType() method and calling MakeGenericType() blindly will toss you up a nice fat ArgumentException to catch.

I did some cursory searching, but my Google-fu has failed me this day.&nbsp; Is there nothing to do this?&nbsp; If not, then I scrapped something together and I wanted to see what you all thought of this just in case I&rsquo;m really the first person to have needed this.&nbsp; I haven&rsquo;t fully unit tested this (this was a spike, so I didn&rsquo;t test-drive this&hellip; I know&hellip; SHAME), so don&rsquo;t just COPY AND PASTE this or bad things will happen including 7 years bad luck and maybe some rain coming in through your windows.

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">static</span> <span class="kwrd">bool</span> MeetsSpecialGenericConstraints(Type genericArgType, Type proposedSpecificType)
{
    var gpa = genericArgType.GenericParameterAttributes;
    var constraints = gpa & GenericParameterAttributes.SpecialConstraintMask;

    <span class="rem">// No constraints, away we go!</span>
    <span class="kwrd">if</span> (constraints == GenericParameterAttributes.None)
        <span class="kwrd">return</span> <span class="kwrd">true</span>;

    <span class="rem">// "class" constraint and this is a value type</span>
    <span class="kwrd">if</span> ((constraints & GenericParameterAttributes.ReferenceTypeConstraint) != 0
        && proposedSpecificType.IsValueType )
    {
        <span class="kwrd">return</span> <span class="kwrd">false</span>;
    }
           
    <span class="rem">// "struct" constraint and this is a value type</span>
    <span class="kwrd">if</span> ((constraints & GenericParameterAttributes.NotNullableValueTypeConstraint) != 0
        && ! proposedSpecificType.IsValueType)
    {
        <span class="kwrd">return</span> <span class="kwrd">false</span>;
    }

    <span class="rem">// "new()" constraint and this type has no default constructor</span>
    <span class="kwrd">if</span> ((constraints & GenericParameterAttributes.DefaultConstructorConstraint) != 0
        && proposedSpecificType.GetConstructor(Type.EmptyTypes) == <span class="kwrd">null</span> )
    {
        <span class="kwrd">return</span> <span class="kwrd">false</span>;
    }

    <span class="kwrd">return</span> <span class="kwrd">true</span>;
}</pre>
</div>

Thoughts?&nbsp; Obvious bugs?