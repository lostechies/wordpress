---
id: 72
title: 'StructureMap: Medium-level Usage Scenarios'
date: 2008-07-17T16:50:25+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/07/17/structuremap-medium-level-usage-scenarios.aspx
permalink: /2008/07/17/structuremap-medium-level-usage-scenarios/
dsq_thread_id:
  - "262113935"
categories:
  - StructureMap
---
This is a follow-on to my previous post about [basic usage scenarios for StructureMap](http://www.lostechies.com/blogs/chad_myers/archive/2008/07/15/structuremap-basic-scenario-usage.aspx).&#160; This post will focus on slightly more advanced usage scenarios and how StructureMap handles them.&#160; For those playing the home game, I’m still working on the ‘Exploring ShadeTree’ series, but it’s hit a small roadblock because there are some design changes pending on the NHibernate stuff I was going to cover. Please bear with me.&#160; Anyhow, in the meantime, I hope you find these StructureMap guides helpful.

## Auto-wiring Factory

> _I have many objects I wish to manage who have dependencies upon each other. Managing the construction and assembly of these objects is complicated and tedious. When I request an IFoo, I want to get back an instance of Foo with all its dependencies satisfied._

Let&#8217;s assume you have the IFoo/Foo combination, in addition to IBar/Bar, and IBaz/Baz.&#160;&#160; Let&#8217;s also say that Foo has a dependency on both IBar and IBaz.&#160; The current recommended way of handling this situation is to define a constructor for Foo() that receives an instance of IBar and IBaz.

Consider this type structure:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">interface</span> IBar{}
<span class="kwrd">public</span> <span class="kwrd">class</span> Bar : IBar{}

<span class="kwrd">public</span> <span class="kwrd">interface</span> IBaz{}
<span class="kwrd">public</span> <span class="kwrd">class</span> Baz : IBaz{}

<span class="kwrd">public</span> <span class="kwrd">interface</span> IFoo{}

<span class="kwrd">public</span> <span class="kwrd">class</span> Foo : IFoo
{
    <span class="kwrd">public</span> Foo( IBar bar, IBaz baz )
    {
    }
}</pre>
</div>

The StructureMap configuration for this structure would look like this:

<div class="csharpcode-wrapper">
  <pre>StructureMapConfiguration
    .ForRequestedType&lt;IBar&gt;().TheDefaultIsConcreteType&lt;Bar&gt;();

StructureMapConfiguration
    .ForRequestedType&lt;IBaz&gt;().TheDefaultIsConcreteType&lt;Baz&gt;();

StructureMapConfiguration
    .ForRequestedType&lt;IFoo&gt;().TheDefaultIsConcreteType&lt;Foo&gt;();</pre>
</div>

&#160;

And then, to get a Foo instance with all its dependencies satisfied, simply use ObjectFactory.GetInstance like normal:

<div class="csharpcode-wrapper">
  <pre>IFoo fooInstance = ObjectFactory.GetInstance&lt;IFoo&gt;();</pre>
</div>

&#160;

Note that no where did you have to explain to StructureMap that Foo was dependent upon Bar or Baz. StructureMap figured it out automatically!&#160; This concept is known as "autowiring".&#160; By default, StructureMap will attempt to satisfy as many dependencies as it can.&#160; It will attempt to use the &#8216;greediest&#8217; constructor (the one with the most parameters).&#160; If your class has two constructors, one has just IBar and the other has IBar and IBaz, StructureMap will try to use the IBar and IBaz constructor.

## Isolated Configuration (Registration of Dependencies)

> _I have many objects in many assemblies (some of which may not be known at compile time). Or, I don&#8217;t like having every single object in my StructureMap configuration defined in my startup routine. Is there a way that each unit of deployment can specify it’s own object dependency registration?_

So in our project at work, we have a few assemblies that have varying concerns such as Web (our ASP.NET MVC project) and Core (pretty much everything else).&#160; Within Core, we have several areas of concern such as Domain model, Persistence, Web (everything related to Web applications in general – stuff we can reuse on other web projects).&#160; Each of these areas of concern has a class that derives from Registry. No, this has nothing to do with the Windows Registry, this is in the context of ‘object dependency registration.’&#160; You can create a class which derives from StructureMap.Configuration.DSL.Registry and override the configure() method.&#160; In this method, you should register the objects that are “local” to the Registry class. For example, your ‘WebRegistry’ class would register all the controllers, any HttpContext abstractions, and things like that.

Another, perhaps better, example case for this might be a composite UI/SmartClient type application (think CAB, Prism, etc) where entire portions of the application are loaded at runtime from external assemblies. It’s actually impossible for the central application startup code to know all the components that will be loaded into the system. In this case, Registries really shine.</p> </p> </p> </p> </p> </p> </p> </p> </p> </p> 

Consider this contrived example of what a PersistenceRegistry class might look like:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> PersistenceRegistry : Registry
{
    <span class="kwrd">protected</span> <span class="kwrd">override</span> <span class="kwrd">void</span> configure()
    {
        ForRequestedType&lt;IValidator&gt;().TheDefaultIsConcreteType&lt;Validator&gt;();
        ForRequestedType&lt;IRepository&gt;().TheDefaultIsConcreteType&lt;Repository&gt;();
        ForRequestedType&lt;ISecurityDataService&gt;().TheDefaultIsConcreteType&lt;SecurityDataService&gt;();
    }
}</pre>
</div>

Notice how it has only the stuff related to persistence and nothing about controllers or anything like that?&#160; 

In order for these Registries to take effect, you must let StructureMap know of their existence. One way is to tell it implicitly using the AddRegistry method, like so:

<div class="csharpcode-wrapper">
  <pre>StructureMapConfiguration.AddRegistry(<span class="kwrd">new</span> PersistenceRegistry());</pre>
</div></p> </p> 

## Auto-discovery of Configuration

> _I have several registries including ones that I don’t know about at compile time. It would be nice if these could be auto-discovered._

Another way in which to invoke StructureMap Registries, which also happens to be the the preferred method of doing so, is to tell StructureMap to scan through the assemblies you tell it to scan through (including the current one, if you tell it to do so). StructureMap will automatically recognize types deriving from Registry and invoke their configure() method.&#160; There are two primary use cases for this behavior: 1.) You know all the assemblies at compile time and 2.) You do not know all the assemblies at compile time.&#160; For the first case, consider the following example:

<div class="csharpcode-wrapper">
  <pre>StructureMapConfiguration
    .ScanAssemblies()
    .IncludeTheCallingAssembly()
    .IncludeAssemblyContainingType&lt;CoreRegistry&gt;()
    .IncludeAssemblyContainingType&lt;PersistenceRegistry&gt;()
    .IncludeAssemblyContainingType&lt;WebSharedRegistry&gt;()
    .IncludeAssemblyContainingType&lt;OurWebApplicationRegistry&gt;();</pre>
</div>

As you can see here, we’re explicitly telling StructureMap to load the current assembly, plus our contrived “Core”, “Persistence”, “WebShared”, and “OurWebApplication” assemblies which each have their own Registry implementations.&#160; Note that if it just so happened that TheCallingAssembly was also OurWebApplicationRegistry’s assembly, StructureMap would handle that gracefully and would not result in duplicate registrations.

As for the other case &#8212; the dynamically-loading-assemblies case – you’ll just need to call ScanAssemblies().IncludeTheCallingAssembly() from the initialization/startup/bootstrap method of your plugin.&#160; For example, assuming you’re using some sort of SmartClient/Composite UI application, when you load in a new module, you’re likely going to have some sort of entry point into the module (i.e. a well known IModule interface that some class implements that has an Initialize() method on it of some sort).&#160; Put your ScanAssemblies().IncludeTheCallingAssembly() call in there or have it called by your Initialize() method.&#160; Your module/plug-in’s Registry implementation will know all about the dependencies of your module and when you inform StructureMap of this, the module and all its dependencies will be loaded into the container and your module will be ready to go.</p> 

## Profiles, Alternate Configurations

> _Certain objects I’ve defined in my container are not appropriate in all circumstances. I would like to have one concrete instance returned when my application is running in Mode A and a different instance returned when my application is running Mode B._</p> 

A common scenario we use at work is “Live” and “Stubbed” where live usually means “connected to the database and external services” and “stubbed” means “it’s not connected to anything outside the application.”&#160; This is, of course, useful for integration testing and for quick smoke tests, etc where full connectivity might not be required. Another example might be the “Google Map API” or “Yahoo Map API” profiles where some different services with different underlying implementations may be warranted, etc.

First, declare your dependencies like normal. Then, create a new profile and declare the differences. New profiles will gain all the configuration of the default/unnamed profile, so you only need to define what is different.&#160; Remember our PersistenceRegistry up above?&#160; He’s an example of how it might change when the concept of profiles are introduced:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> PersistenceRegistry : Registry
{
    <span class="kwrd">protected</span> <span class="kwrd">override</span> <span class="kwrd">void</span> configure()
    {
        ForRequestedType&lt;IValidator&gt;().TheDefaultIsConcreteType&lt;Validator&gt;();
        ForRequestedType&lt;IRepository&gt;().TheDefaultIsConcreteType&lt;Repository&gt;();
        ForRequestedType&lt;ISecurityDataService&gt;().TheDefaultIsConcreteType&lt;SecurityDataService&gt;();

        CreateProfile(<span class="str">"Stubbed"</span>)
            .For&lt;IRepository&gt;().UseConcreteType&lt;InMemoryRepository&gt;()
            .For&lt;ISecurityDataService&gt;().UseConcreteType&lt;StubSecurityDataService&gt;();
    }
}</pre>
</div></p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> 

Note the ‘CreateProfile’ call.&#160; When StructureMap’s current profile changes to “Stubbed”, requests for IRepository will receive an InMemoryRepository instead of a normal Repository object.

In order to use this profile, you can do a number of things (this list is not comprehensive, I’m sure I’m missing something else): 1.) Call TheDefaultProfileIs(“YourProfileName”), 2.) Drop a StructureMap.Config file in your bin folder or web root.

#1 is easy, somewhere in your startup code, when you’ve determined (somehow) that you need to load a specific profile, you can simply call StructureMapConfiguration.TheDefaultProfileIs(“SomeOtherProfile”).

#2 is also pretty easy. When we want to run in ‘stubbed’ mode, we simply drop a mostly-empty StructureMap.config file into our web root (see example below). When we want to run ‘live’ again, we remove the file. Pretty easy, huh?&#160; Here’s what our stubbed file looks like:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">&lt;</span><span class="html">StructureMap</span> <span class="attr">MementoStyle</span><span class="kwrd">="Attribute"</span> <span class="attr">DefaultProfile</span><span class="kwrd">="Stubbed"</span><span class="kwrd">&gt;</span>
<span class="kwrd">&lt;/</span><span class="html">StructureMap</span><span class="kwrd">&gt;</span></pre>
</div>

## Conclusion

That’s a good chunk of stuff for right now, there may be a few other medium scenarios that aren’t coming to mind right now. Please feel free to suggest some and I’ll look into it.

In the next post, I’m going to go into some more advanced scenarios such as convention scanners, more manual/fine-grained object construction, construction-via-lambda, direct object container injection, and possibly a few others.