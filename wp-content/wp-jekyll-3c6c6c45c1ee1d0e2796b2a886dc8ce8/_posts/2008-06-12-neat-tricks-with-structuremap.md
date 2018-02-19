---
id: 60
title: Neat Tricks with StructureMap
date: 2008-06-12T01:04:04+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/06/11/neat-tricks-with-structuremap.aspx
permalink: /2008/06/12/neat-tricks-with-structuremap/
dsq_thread_id:
  - "262113866"
categories:
  - StructureMap
---
I&#8217;ve been getting a crash course in [StructureMap](http://structuremap.sourceforge.net/) the past 2 weeks. It&#8217;s been going pretty well especially when you consider that the author/maintainer sits next to me every day :)

We&#8217;ve been using the new 2.5-ish trunk code and there are some cool features I&#8217;d like to share with you and maybe get you pumped about the [upcoming 2.5 release](http://codebetter.com/blogs/jeremy.miller/archive/2008/06/11/structuremap-2-5-will-be-released-on-june-23rd.aspx).

## Auto-registration of obvious types

This one is particularly cool since most of the types registered in your container are ISomeService with an associated SomeService implementation.

Simply put:&nbsp; If you have a class Foo that implements interface IFoo, StructureMap, if asked to do so, will auto-register Foo as the default concrete type for plugin family IFoo. No config necessary!&nbsp; Phew&#8230; just saved the world some serious angle brackets tax there. Every bit counts, trust me &#8212; I came from a SpringFramework.NET background which is rich in its XML configuration.

## Convention-based Discovery/Registration

When calling StructureMapConfiguration.ScanAssemblies(), you can now provide your own type registration conventions in addition to the default one. For example:

<div style="border-right: gray 1px solid;padding-right: 4px;border-top: gray 1px solid;padding-left: 4px;font-size: 8pt;padding-bottom: 4px;margin: 20px 0px 10px;overflow: auto;border-left: gray 1px solid;width: 97.5%;cursor: text;line-height: 12pt;padding-top: 4px;border-bottom: gray 1px solid;font-family: consolas, 'Courier New', courier, monospace;background-color: #f4f4f4">
  <div style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none">
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   1:</span> StructureMapConfiguration.ScanAssemblies()</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none"><span style="color: #606060">   2:</span>     .With&lt;DefaultConventionScanner&gt;()</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   3:</span>     .With&lt;YourCustomConvention&gt;();</pre>
  </div>
</div>

&nbsp;

StructureMap will call a method on YourCustomConvention for each Type it finds, allowing you to do fancy things such as:

<div style="border-right: gray 1px solid;padding-right: 4px;border-top: gray 1px solid;padding-left: 4px;font-size: 8pt;padding-bottom: 4px;margin: 20px 0px 10px;overflow: auto;border-left: gray 1px solid;width: 97.5%;cursor: text;line-height: 12pt;padding-top: 4px;border-bottom: gray 1px solid;font-family: consolas, 'Courier New', courier, monospace;background-color: #f4f4f4">
  <div style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none">
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   1:</span> <span style="color: #0000ff">if</span> (CanBeCast(<span style="color: #0000ff">typeof</span> (IController), type))</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none"><span style="color: #606060">   2:</span> {</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   3:</span>     <span style="color: #0000ff">string</span> name = type.Name.Replace(<span style="color: #006080">"Controller"</span>, <span style="color: #006080">""</span>).ToLower();</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none"><span style="color: #606060">   4:</span>     registry.AddInstanceOf(<span style="color: #0000ff">typeof</span> (IController), <span style="color: #0000ff">new</span> ConfiguredInstance(type).WithName(name));</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   5:</span> }</pre>
  </div>
</div>

This allows us, in our MVC application to register all of our controllers using their short name (i.e. LoginController -> &#8220;login&#8221;) so that they can be loaded via our custom StructureMapControllerFactory.

## On-the-fly Dependency Satisfaction

This one comes in handy, but I feel a little dirty when I use it &#8212; as though I&#8217;m cheating IoC somehow. It&#8217;s cool nonetheless:

I have a service that takes the current HttpContext from ASP.NET in order to function. I then needed to pass this service into yet another service in order to construct it properly. There are a couple different ways of accomplishing this, but for this example, I&#8217;ll do it this way just to illustrate the point:

<div style="border-right: gray 1px solid;padding-right: 4px;border-top: gray 1px solid;padding-left: 4px;font-size: 8pt;padding-bottom: 4px;margin: 20px 0px 10px;overflow: auto;border-left: gray 1px solid;width: 97.5%;cursor: text;line-height: 12pt;padding-top: 4px;border-bottom: gray 1px solid;font-family: consolas, 'Courier New', courier, monospace;background-color: #f4f4f4">
  <div style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none">
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   1:</span> ObjectFactory</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none"><span style="color: #606060">   2:</span>     .With&lt;ISecurityContext&gt;(<span style="color: #0000ff">new</span> HttpSecurityContext(HttpContext.Current))</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   3:</span>     .GetInstance&lt;AuthenticationService&gt;();</pre>
  </div>
</div>

In order to get my AuthenticationService instance, I needed an ISecurityContext &#8212; particularly the HttpSecurityContext which takes the current HttpContext.

## More to Come

As I learn more I&#8217;ll post &#8216;em.&nbsp; Also, I think Jeremy has a few more tricks up his sleeve before the release so keep an eye on his blog and the StructureMap web site for more news.