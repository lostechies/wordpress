---
id: 68
title: 'Exploring ShadeTree Features, Part 2: Cache&lt;KEY, VALUE&gt;'
date: 2008-07-08T02:48:33+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/07/07/exploring-shadetree-features-part-2-cache-lt-key-value-gt.aspx
permalink: /2008/07/08/exploring-shadetree-features-part-2-cache-lt-key-value-gt/
dsq_thread_id:
  - "264388950"
categories:
  - .NET
  - ShadeTree
---
Or, as I like to call it: "That stupid dictionary thing we&#8217;ve all written a thousand times but were too lazy to component-ize for reuse"

How many times have you written code like this in your C# 2.0-and-later life?

<div class="csharpcode-wrapper">
  <pre>Foo foo = null;

if( ! fooCache.TryGetValue(key, out foo))
{
    foo = new Foo();
    fooCache.Add(foo.Key, foo);
}

return foo</pre>
</div>

Well, no more!&#160; Enter [ShadeTree.Core.Cache](http://storyteller.tigris.org/source/browse/storyteller/trunk/src/ShadeTree.Core/Cache.cs?rev=177&view=markup)!

Nifty features:

  1. Automatic cache miss value creation: When you attempt to get an item from the cache that&#8217;s not there, if configured to do so, it&#8217;ll new one up for you, add it, and return it. 
  2. Quiet Add: Call the Store method to add an item if it&#8217;s not already added (otherwise, it&#8217;ll do nothing) 
  3. Quiet Remove: Remove won&#8217;t throw an error if the item isn&#8217;t in the Cache 
  4. Each(): Handy lambda-friendly version of &#8216;for each&#8217; 
  5. Exists(): Handy lambda-friendly version of TryGetValue

## Cache Miss Handling Example

This one I particularly like, especially when you need something like this: Dictionary<string, IList<Foo>>.

Consider this example: We want to have a Cache<string, IList<Foo>>.&#160; We want to add a new key "Blah" and add a new Foo to it&#8217;s list.

With Dictionary<T,U>, you have to do something like:

<div class="csharpcode-wrapper">
  <pre>Dictionary<span class="kwrd">&lt;</span><span class="html">string</span>, <span class="attr">IList&lt;</span><span class="attr">Foo</span><span class="kwrd">&gt;&gt;</span> dict = new Dictionary<span class="kwrd">&lt;</span><span class="html">string</span>, <span class="attr">IList</span>&lt;<span class="attr">Foo</span><span class="kwrd">&gt;&gt;</span>();

IList<span class="kwrd">&lt;</span><span class="html">Foo</span><span class="kwrd">&gt;</span> fooList = null;

if( ! dict.ContainsKey("Blah") )
{
    fooList = new List<span class="kwrd">&lt;</span><span class="html">Foo</span><span class="kwrd">&gt;</span>();
    dict.Add("Blah", fooList);
}

fooList.Add(new Foo());</pre>
</div>

But with Cache, it&#8217;s much simpler:

<div class="csharpcode-wrapper">
  <pre>Cache<span class="kwrd">&lt;</span><span class="html">string</span>, <span class="attr">IList</span>&lt;<span class="attr">Foo</span><span class="kwrd">&gt;&gt;</span> cache = new Cache<span class="kwrd">&lt;</span><span class="html">string</span>, <span class="attr">IList</span>&lt;<span class="attr">Foo</span><span class="kwrd">&gt;&gt;</span>(k =<span class="kwrd">&gt; </span>new List<span class="kwrd">&lt;</span><span class="html">Foo</span><span class="kwrd">&gt;</span>());
cache.Get("Blah").Add(new Foo());</pre>
</div>

The trick is that little lambda expression (k => new List<Foo>()).&#160; When the call to Get("Blah") fails to find anything in the underlying dictionary, it&#8217;ll add a new entry to the dictionary with key "Blah" and the result of that lambda expression (i.e. a new List<Foo>).