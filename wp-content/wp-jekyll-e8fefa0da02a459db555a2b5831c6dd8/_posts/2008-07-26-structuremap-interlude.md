---
id: 73
title: 'StructureMap: Interlude'
date: 2008-07-26T16:54:53+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/07/26/structuremap-interlude.aspx
permalink: /2008/07/26/structuremap-interlude/
dsq_thread_id:
  - "1085355853"
categories:
  - StructureMap
---
I&#8217;m trying to wrap up the &#8220;StructureMap: Advanced Scenarios Usage&#8221; post. In the meantime, I wanted to make you aware of a few things:

  * I just updated my [StructureMap: Basic Scenario Usage](http://chadmyers.lostechies.com/archive/2008/07/15/structuremap-basic-scenario-usage.aspx) post with a correction. I was mistaken about being able to set properties on configured objects. Currently, you cannot configure properties on configured objects unless the property has the [SetterProperty] attribute defined.&nbsp; This was on purpose since there is a good argument that property injection is &#8216;bad&#8217; (i.e. leads to problems later, can complicate configuration and testing, etc).&nbsp; There are, however, scenarios where property injection is acceptable so being able to configure properties without using the attribute is being seriously considered for the StructureMap 2.5 release. 
  * Derik Whitaker posted [about how to use StructureMap in an MSTest situation](http://devlicio.us/blogs/derik_whittaker/archive/2008/07/24/using-your-app-config-web-config-to-store-your-structuremap-settings.aspx) to work around some of MSTest&#8217;s quirks. He used StructureMap&#8217;s ability to configure itself through XML in your web.config/app.config file rather than having a separate XML file. Or you could, of course, save half your time and tons of complexity and just use NUnit/MBUnit/XUnit and not deal with the hassle. But it&#8217;s good for those people required to use MSTest to still be able to take advantage of StructureMap.
  * You should know that [Joshua Flanagan](http://flimflan.com/blog/) was the one who contributed that feature (the app.config configuration stuff) to StructureMap which is useful for a variety of reasons &#8212; not just the MSTest reason.&nbsp; The reason you should know of him is because&#8230;
  * The same Joshua just posted a great post on [how to get started from the most basic level with StructureMap](http://flimflan.com/blog/HelloStructureMap.aspx). It&#8217;s a &#8220;Hello World&#8221; type app, but shows off some of the ways StructureMap works. Of course it&#8217;s overdone as a Hello World app, but that wasn&#8217;t the point.&nbsp; The point is to show how to get started with StructureMap and I think it does a really good job at that.