---
id: 71
title: 'StructureMap: Basic Scenario Usage'
date: 2008-07-16T01:13:29+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/07/15/structuremap-basic-scenario-usage.aspx
permalink: /2008/07/16/structuremap-basic-scenario-usage/
dsq_thread_id:
  - "262113947"
categories:
  - StructureMap
---
First, I&#8217;m going to assume that you are somewhat already familiar with the concepts of Dependency Injection and what, in general, an Inversion of Control Container is for. If not, you may find these links helpful:

  * [http://www.martinfowler.com/articles/injection.html](http://www.martinfowler.com/articles/injection.html "http://www.martinfowler.com/articles/injection.html") 
      * [http://codebetter.com/blogs/jeremy.miller/archive/2005/10/06/132825.aspx](http://codebetter.com/blogs/jeremy.miller/archive/2005/10/06/132825.aspx "http://codebetter.com/blogs/jeremy.miller/archive/2005/10/06/132825.aspx")</ul> 
    &nbsp;
    
    I&#8217;m also going to assume that you know what I&#8217;m talking about when I say &#8220;StructureMap&#8221;.&nbsp; If not, then you should check out this link:
    
      * [http://structuremap.sourceforge.net](http://structuremap.sourceforge.net "http://structuremap.sourceforge.net")
    
    &nbsp;
    
    If I&#8217;ve lost you with any of these assumptions, please leave a comment and I&#8217;ll step back and go into these some more for you! 
    
    ## Most Common Usages
    
    I&#8217;m going to cover three of the more common usage scenarios and how you accomplish these with the upcoming StructureMap 2.5.
    
    ### Simple Factory
    
    _I have an interface IFoo with a concrete implementation Foo. When IFoo is requested, new up and return a Foo._
    
    First, somewhere in the startup code area of your application, register the two types with the container, like so:
    
    <div class="csharpcode-wrapper">
      <pre>StructureMapConfiguration
    .ForRequestedType&lt;IFoo&gt;()
    .TheDefaultIsConcreteType&lt;Foo&gt;();</pre>
    </div>
    
    Next, to retrieve the instance elsewhere in your code, use the ObjectFactory class in StructureMap:
    
    <div class="csharpcode-wrapper">
      <pre><span class="rem">// fooInstance is actually of type Foo</span>
IFoo fooInstance = ObjectFactory.GetInstance&lt;IFoo&gt;();</pre>
    </div>
    
    ### &nbsp;
    
    ### Object Lifetime Manager
    
    _I have a session-type object I need kept alive for the entire thread or ASP.NET request.&nbsp; When IFoo is requested, return me a Foo instance specific to this ASP.NET request or thread_
    
    StructureMap can create an instance of an object for you and manage it&#8217;s life time according to the life of the current Thread or, in an ASP.NET scenario, the life of the current HTTP request.&nbsp; This is useful for caching things like database connection sessions or user credentials, etc.
    
    First, when you define your object in your startup code, add the CacheBy() option:
    
    <div class="csharpcode-wrapper">
      <pre>StructureMapConfiguration
    .ForRequestedType&lt;IFoo&gt;()
    .TheDefaultIsConcreteType&lt;Foo&gt;()
    .CacheBy(InstanceScope.HttpContext);</pre>
    </div>
    
    You can also use InstanceScope.ThreadLocal for non-ASP.NET multithreaded scenarios, InstanceScope.Singleton which means the object will live for the entire life of your AppDomain, and InstanceScope.Hybrid which will choose HttpContext if available, otherwise it&#8217;ll revert to ThreadLocal. Hybrid is particularly handy in a unit testing scenario where your tests will automatically adapt to either a live ASP.NET scenario or a test threading scenario.
    
    Then, request your object just like normal:
    
    <div class="csharpcode-wrapper">
      <pre>IFoo fooInstance = ObjectFactory.GetInstance&lt;IFoo&gt;();</pre>
    </div>
    
    If you&#8217;ve called GetInstance<IFoo> more than once in that same ASP.NET request, you&#8217;ll get the same Foo instance.&nbsp; If there are two requests executing simultaneously on your web server, they&#8217;ll each get their own Foo instance.
    
    &nbsp;
    
    ### Object Assembler
    
    _I have an object that needs to have a value set from the application configuration on startup. When IFoo is requested, new up a Foo, <strike>set it&#8217;s NumberOfChickens property</strike> from the AppSettings/NumChickens setting in my app.config and return me the instance._
    
    > <span style="color: red"><b>UPDATE 7/26/2008</b></span>:&nbsp; My apologies &#8212; at the time of this post and updating, StructureMap does not currently set property values unless they have the [SetterProperty] attribute.&nbsp; The &#8216;WithProperty&#8217; and &#8216;SetProperty&#8217; methods are misleading as they apply normally to CONSTRUCTOR parameters by that name OR properties with the [SetterProperty] attribute placed upon them.&nbsp; There have been several requests for this in the past and there is likelihood the ability to set properties without requiring attributes will be added to the final StructureMap 2.5 release (currently version is 2.4.9).
    
    Like the previous examples, define your object in your startup code, but change it slightly to have StructureMap automatically take care of getting the property for you:
    
    <div class="csharpcode-wrapper">
      <pre>StructureMapConfiguration
    .ForRequestedType&lt;IFoo&gt;()
    .TheDefaultIs(
        <span class="kwrd">new</span> ConfiguredInstance()
            .UsingConcreteType&lt;Foo&gt;()
            .WithProperty(<span class="str">"NumberOfChickens"</span>)
            .EqualToAppSetting(<span class="str">"NumChickens"</span>)
    );</pre>
    </div>
    
    Just like the others, the business end is still the same:
    
    <div class="csharpcode-wrapper">
      <pre>IFoo fooInstance = ObjectFactory.GetInstance&lt;IFoo&gt;();</pre>
    </div>