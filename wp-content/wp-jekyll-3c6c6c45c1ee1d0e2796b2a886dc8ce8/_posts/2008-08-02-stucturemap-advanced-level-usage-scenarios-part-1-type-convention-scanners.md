---
id: 74
title: 'StuctureMap: Advanced-level Usage Scenarios (Part 1: Type/Convention Scanners)'
date: 2008-08-02T00:51:58+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/01/stucturemap-advanced-level-usage-scenarios-part-1-type-convention-scanners.aspx
permalink: /2008/08/02/stucturemap-advanced-level-usage-scenarios-part-1-type-convention-scanners/
dsq_thread_id:
  - "262113960"
categories:
  - StructureMap
---
I’ll start with my strong hand on the advanced StructureMap-foo and go straight to the type scanners (a.k.a. convention scanners).&#160; Thankfully, there was [a thread](http://groups.google.com/group/structuremap-users/browse_thread/thread/5f3c5c6824d380ad) on the [StructureMap Users mailing list](http://groups.google.com/group/structuremap-users) with just the kind of problem these things solve. I’ll use that problem as the strawman for this post.

## The Problem

Let’s say you had an IRepository<T> interface implemented by an abstract base class (RepositoryBase<T>) which, in turn, is implemented by many classes – one for each entity.&#160; Let’s say your implementations looked something like this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">interface</span> IRepository&lt;T&gt;
{
    <span class="rem">// intersting stuff here    </span>
}

<span class="kwrd">public</span> <span class="kwrd">abstract</span> <span class="kwrd">class</span> RepositoryBase&lt;T&gt; : IRepository&lt;T&gt;
{
    <span class="rem">// interesting abstract base stuff here</span>
}

<span class="kwrd">public</span> <span class="kwrd">class</span> UserRepository : RepositoryBase&lt;User&gt;
{
        <span class="rem">// interesting abstract base stuff here</span>
}

// ... a bunch more of these CustomerRepository, SaleRepository, etc</pre>
</div>

And you you may add more in the future and you’d rather not have to register them all individually in StructureMap like this:

<div class="csharpcode-wrapper">
  <pre><span class="rem">// You don't have to do this!</span>
StructureMapConfiguration
    .ForRequestedType&lt;IRepositor&lt;User&gt;&gt;.TheDefaultIsConcreteType&lt;UserRepository&gt;()
    .ForRequestedType&lt;IRepositor&lt;Customer&gt;&gt;.TheDefaultIsConcreteType&lt;CustomerRepository&gt;()
    .ForRequestedType&lt;IRepositor&lt;Sale&gt;&gt;.TheDefaultIsConcreteType&lt;SaleRepository&gt;();</pre>
</div></p> </p> </p> </p> </p> </p> 

&#160;

What would be nice is if StructureMap could automatically figure my convention out. Well, unfortunately it won’t do that. BUT you can give it enough of a hint so that it CAN do it using your own ITypeScanner implementation. ITypeScanner has one method on it: Process(Type, Registry).&#160; StructureMap will call Process() for each Type it finds when scanning (using ScanAssemblies).&#160; Your scanner can, if it wants, add things to the container (through the ‘Registry’ parameter).&#160; This allows you to do all sorts of cool things like automatically find any types Foo which implement an interface named IFoo (or Bar/IBar, Something/ISomething, etc) and register them for you.&#160; In fact, this last example is done for you using [StructureMap.Graph.DefaultConventionScanner](http://structuremap.svn.sourceforge.net/viewvc/structuremap/trunk/Source/StructureMap/Graph/ITypeScanner.cs?view=markup). Here, let me show you:

<div class="csharpcode-wrapper">
  <pre>ScanAssemblies().IncludeTheCallingAssembly()
    .IncludeTheCallingAssembly()
    .With&lt;DefaultConventionScanner&gt;()</pre>
</div>

&#160;

## Implementing our Repository Convention ITypeScanner

First, create a class that implements ITypeScanner. Let’s call it RepositoryConvention.

The next thing we’ll need is a method that will, given a type, see if it’s the type of generic type we’re looking for (i.e. RepositoryBase<T>), and return what the T parameter is (i.e. <User>). With this, we can register an IRepository<User> in StructureMap for that class (UserRepository, for example). It might look something like this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">private</span> <span class="kwrd">static</span> Type GetGenericParamFor(Type typeToInspect, Type genericType)
{
    var baseType = typeToInspect.BaseType;
    <span class="kwrd">if</span> (baseType != <span class="kwrd">null</span>
        && baseType.IsGenericType
        && baseType.GetGenericTypeDefinition().Equals(genericType))
    {
        <span class="kwrd">return</span> baseType.GetGenericArguments()[0];
    }

    <span class="kwrd">return</span> <span class="kwrd">null</span>;
}</pre>
</div>

</p> </p> </p> </p> </p> </p> </p> </p> </p> 

This will take a given type (i.e. UserRepository) and check it’s base type (i.e. RepositoryBase<User>) to see if it’s generic and if it’s the generic type we’re looking for. If so, it’ll return the “User” portion of RepositorBase<User>, for example.

Now, our process method looks something like:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">void</span> Process(Type type, Registry registry)
{
    Type entityType = GetGenericParamFor(type, <span class="kwrd">typeof</span>(RepositoryBase&lt;&gt;));

    <span class="kwrd">if</span> (entityType != <span class="kwrd">null</span>)
    {
        var genType = <span class="kwrd">typeof</span>(IRepository&lt;&gt;).MakeGenericType(entityType);
        registry.ForRequestedType(genType).AddInstance(<span class="kwrd">new</span> ConfiguredInstance(type));
    }
}</pre></p>
</div>

We try to get the entityType (i.e. User). If present, then we create a new specific type from the generic IRepository<T> and register it. In our UserRepository case, it’ll register IRepository<User> with the default concrete type of UserRepository. Our whole class now looks like this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> RepositoryConvention : ITypeScanner
{
    <span class="kwrd">public</span> <span class="kwrd">void</span> Process(Type type, Registry registry)
    {
        Type entityType = GetGenericParamFor(type, <span class="kwrd">typeof</span>(RepositoryBase&lt;&gt;));

        <span class="kwrd">if</span> (entityType != <span class="kwrd">null</span>)
        {
            var genType = <span class="kwrd">typeof</span>(IRepository&lt;&gt;).MakeGenericType(entityType);
            registry.ForRequestedType(genType).AddInstance(<span class="kwrd">new</span> ConfiguredInstance(type));
        }
    }

    <span class="kwrd">private</span> <span class="kwrd">static</span> Type GetGenericParamFor(Type typeToInspect, Type genericType)
    {
        var baseType = typeToInspect.BaseType;
        <span class="kwrd">if</span> (baseType != <span class="kwrd">null</span>
            && baseType.IsGenericType
            && baseType.GetGenericTypeDefinition().Equals(genericType))
        {
            <span class="kwrd">return</span> baseType.GetGenericArguments()[0];
        }

        <span class="kwrd">return</span> <span class="kwrd">null</span>;
    }
}</pre></p>
</div>

Now, we need to let StructureMap know about it…

## Configuring StructureMap with the new Scanner

Now, somewhere in your bootstrapping/startup routines for your app, add the With() call to your ScanAssemblies configuration. It should end up looking like this:

<div class="csharpcode-wrapper">
  <pre>StructureMapConfiguration
   .ScanAssemblies()
   .IncludeTheCallingAssembly()
    <span class="rem">// maybe other assemblies, too?</span>
   .With(<span class="kwrd">new</span> RepositoryConvention());  // add our convention <span class="kwrd">for</span> wiring up the repos</pre></p>
</div>

As StructureMap mines through all the types in your assemblies, it’ll pass them to your Process() method where you can evaluate whether they meet your Repository convention and register them accordingly.

## Using the Repository

Finally, to grab one of your newly configured repositories, you can simple make a normal ObjectFactory GetInstance call:

<div class="csharpcode-wrapper">
  <pre>var userRepo = ObjectFactory.GetInstance&lt;IRepository&lt;User&gt;&gt;();</pre></p>
</div></p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> 

Also, it’ll work with for normal constructor injection scenarios. For example:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> SomeService
{
    <span class="kwrd">private</span> <span class="kwrd">readonly</span> IRepository&lt;User&gt; _userRepo;

    <span class="kwrd">public</span> SomeService(IRepository&lt;User&gt; userRepo)
    {
        _userRepo = userRepo;
    }
}</pre>
</div>

## What else can you do?

I hope as you come up with clever uses for this convention technique you let us know about them!&#160; As a teaser, here’s something Jeremy and I are doing:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> ControllerConvention : TypeRules, ITypeScanner
{
    <span class="kwrd">public</span> <span class="kwrd">void</span> Process(Type type, Registry registry)
    {
        <span class="kwrd">if</span> (CanBeCast(<span class="kwrd">typeof</span> (IController), type))
        {
            <span class="kwrd">string</span> name = type.Name.Replace(<span class="str">"Controller"</span>, <span class="str">""</span>).ToLower();
            registry.AddInstanceOf(<span class="kwrd">typeof</span> (IController), <span class="kwrd">new</span> ConfiguredInstance(type).WithName(name));
        }
    }
}</pre>
</div></p> </p> </p> </p> 

See if you can guess what that’s for… ;)