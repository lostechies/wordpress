---
id: 184
title: 'Cool stuff in FubuCore No. 1: Cache'
date: 2011-05-30T14:03:34+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=184
permalink: /2011/05/30/cool-stuff-in-fubucore-no-1-cache/
dsq_thread_id:
  - "317853776"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the first post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

This post covers the [Cache<TKey, TValue>](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Util/Cache.cs) class (tests can be found in the [CacheTester](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore.Testing/Util/CacheTester.cs))

## Introduction

The name of this class may make you think it has something to do with ASP.NET output caching, but that would be incorrect.  A cache stores things, so in that loose sense, this class is a cache.

The purpose of this class is to be a very convenient wrapper around a [Dictionary<TKey, TValue>](http://msdn.microsoft.com/en-us/library/xfhwa508.aspx).  This wrapper makes the API of Dictionary much easier to use in-line in functional-like expressions, among other purposes.

In the FubuMVC framework, and at Dovetail, we use this class extensively for maintaining an in-memory, application-lifetime (non-expiring) cache of stuff loaded from the database, filesystem, or other expensive/time-consuming source.  FubuMVC uses this class, for example, to cache all the behavior chain configuration that is produced at start-up time in your app. This configuration is costly to generate and doesn&#8217;t change after start-up time, so it makes sense to cache it for the duration of the AppDomain.

You can see this by looking at the [BehaviorGraph](https://github.com/DarthFubuMVC/fubumvc/blob/master/src/FubuMVC.Core/Registration/BehaviorGraph.cs) class in FubuMVC. You can see we store the Behavior Chains several different ways (similar to indexes in a database) in order to make retrieval quick.

With that in mind, let&#8217;s get to some of the specifics about how useful a class Cache<TKey, TValue> can really be.

## Default Values, or &#8220;OnMissing&#8221;

One of the most useful features of Cache (and, if memory serves, the main reason Cache was created in the first place), is the Default Value/OnMissing functionality.

If you&#8217;ve ever used a Dictionary before in .NET, you&#8217;ve probably written this code a million times:

<pre class="brush:csharp">var dict = new Dictionary();
// later, elsewhere in the code...
if( !dict.TryGetValue("foo", out myVal))
{
    dict.Add("foo", myVal = "");
}
return myVal;
</pre>

If the key &#8220;foo&#8221; doesn&#8217;t already exist, Cache will execute the (s => &#8220;&#8221;) action and stuff that value into the dictionary under key &#8220;foo&#8221; and return the value for you.

## Fill and FillDefault

The _Fill_ method takes a key and value. If the key already exists in the dictionary, nothing happens. Otherwise, the key with the specified value is added.

The _FillDefault_ method takes a key. If the key already exists in the dictionary, nothing happens. Otherwise, the key is added with the default value specified in the OnMissing action passed in via constructor argument.

## OnAddition

We added this method because there were some Caches that we used that would occasionally have things added after start-up time.  If something was added, we needed to know about it to take action.

The Cache class exposes an OnAddition property. You can set this to an Action<TValue> and it will get called every time a new value is added to the dictionary. For example:

<pre class="brush:csharp">cache.OnAddition = value => someService.NewItemAdded(value); 
</pre>

## WithValue

This method is handy if you want to do something with the value of a particular key in the dictionary \*if and only if\* it is already present in the dictionary.  It’ll return _true_ if the key was found (and your action was executed), otherwise false (the key was not found and your action not executed).  For example:

<pre class="brush:csharp">if( ! cache.WithValue("errors", errorList => errorNotifyService.NotifyErrors(errorList) )
{
   errorNotifyService.NotifyNoErrorsFound();
}
</pre>

## Functional-y Methods

Cache has some nifty functional programming-type methods on it that make it easy to chain together and use when building up expression chains.

### First

The First property returns the first value that was added to the dictionary. Sometimes this is useful if your cache contains a list of potential candidates (i.e. a list of services that can process your request) and you don’t care which one, so it might as well be the first one.

### Each

This is the same as doing a “foreach” over the dictionary, but the syntax is tighter.  There are two variants: One that returns just the values, and one that returns the keys and values. For example:

<pre class="brush:csharp">cache.Each((key, val) => Console.WriteLine("{0}: {1}", key, val));  
</pre>

### Find

This method is useful if you’re searching for a specific value in the dictionary. You want the value returned or default(TValue) (i.e. null for objects, 0 for integers, etc). For example:

<pre class="brush:csharp">// Does the cache contain the entity with name"bar"?
cache.Find(v => v.Name == “bar”)
</pre>

Since it returns the value, you can chain this together with other methods which can be handy in other expressions.

### Exists

This is the same as the Find method, but returns a boolean value instead of the value in the dictionary.

## Summary

It’s not the most awesome class in the world, but Cache is pretty handy and useful. We’ve gotten a lot of mileage out of it in our code. Hopefully some of the ideas may be useful for you as well.