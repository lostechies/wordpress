---
id: 85
title: Odoyule Rules Engine for .NET
date: 2012-04-11T11:16:16+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=85
permalink: /2012/04/11/odoyule-rules-engine-for-net/
dsq_thread_id:
  - "645220984"
categories:
  - .net
---
So I&#8217;ve been writing a rules engine for .NET for many years (on and off, but mostly off unfortunately). Lately, I picked it up again and yesterday published an early version on NuGet (OdoyuleRules). The implementation at this point is capable of pretty extensive matching, but testing is light at this point so there are probably some rough edges.

One of my favorite features is the visualization of the RETE graph once the engine has been loaded with rules. An example is shown below.

<img style="display: block; margin-left: auto; margin-right: auto;" src="http://blog.phatboyg.com/wp-content/uploads/2012/04/OdoyuleRulesVisualization.png" border="0" alt="OdoyuleRulesVisualization" width="640" height="305" />

 

You can download the Visualizer and install it in Visual Studio 2010 (unzip the contents to your My Document/Visual Studio 2010/Visualizers folder). Then, mouse over a reference to a rules engine while debugging and you should be able to select and display the RETE graph of the engine.

Download the visualizer assemblies here: [OdoyuleRulesVisualizer.zip](http://blog.phatboyg.com/wp-content/uploads/2012/04/OdoyuleRulesVisualizer.zip "OdoyuleRulesVisualizer.zip")

The project is hosted on GitHub, at <http://phatboyg.github.com/OdoyuleRules>

Enjoy!

 