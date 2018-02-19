---
id: 53
title: Updated TDD Productivity Plug-in for Resharper
date: 2009-07-01T03:41:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/30/updated-tdd-productivity-plug-in-for-resharper.aspx
permalink: /2009/07/01/updated-tdd-productivity-plug-in-for-resharper/
dsq_thread_id:
  - "263155980"
categories:
  - agile
  - 'c#'
  - Open Source Software
  - Resharper
  - TDD
  - testing
  - Tools
  - Unittests
---
</p> 

&nbsp;

I first want to thank JetBrains for being pretty awesome.&nbsp; I have complained a lot about how they are constantly chaining their APIs to Resharper and as a result it makes keeping plugins very hard to maintain but they went way out of their way to help.&nbsp; I received and email from one of their developers offering to help on my plugin.&nbsp; Their was a change made in the latest version of resharp which made my plugin incompatible&nbsp; and their telemetry showed them a pattern with this problem.&nbsp; Just this week they made a commit to the source code and updated the project.&nbsp; I did not have the time to get into the internals of this change and I was really motivated by their help.

As a result, if you were using the plugin I recommend you download the latest version and install it!

#### <a target="_blank" href="http://code.google.com/p/resharper-tdd-productivity-plugin/">Download it Here</a>

For those of you who do not use it yet I will run down the features that are available.

### 1. Code forward, create a class in a referenced project.

When prompted with Quick Fixes for a non-existent class You get the following menu.&nbsp; This adds menu items to create the class in all referenced projects.( If this menu does not show up&hellip; you may need to add the project references to you unit test project).

&nbsp;

 <img height="404" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_1CA2EF1F.png" alt="image" border="0" style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" />

After selecting a menu item.&nbsp; The class is created in the project you selected but the IDE stays in your test class.&nbsp; And you are prompted with the quick fix for adding the using for your classes namespace.

 <img height="627" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_4C7D90E0.png" alt="image" border="0" style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" />

&nbsp;

The class file is created in the corresponding project under the correct folder and namespace.&nbsp; It is that easy!

<img height="465" width="644" src="//lostechies.com/erichexter/files/2011/03/image_03776F1A.png" alt="image" border="0" style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" />

&nbsp;

&nbsp;

### 2. Move Class/Interface to referenced project

If you prefer working with your Class or Interface under test in the same file as your test class and move the class to your referenced project after you get your tests passing this feature will reduce the number of steps it takes to move the class to the referenced project. This eliminates the need to fumble around in the Solution Explorer window.

<img height="272" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_2F47C309.png" alt="image" border="0" style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" />