---
id: 22
title: 'Announcing the  Test Driven Development Productivity Plugin for Resharper'
date: 2008-10-08T01:28:31+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/10/07/announcing-the-test-driven-development-productivity-plugin-for-resharper.aspx
permalink: /2008/10/08/announcing-the-test-driven-development-productivity-plugin-for-resharper/
dsq_thread_id:
  - "263492713"
categories:
  - Uncategorized
---
_****_

_**Why does visual studio make doing the right thing, so hard to do?**_

[<img style="border-right: 0px;border-top: 0px;margin-left: 0px;border-left: 0px;margin-right: 0px;border-bottom: 0px" height="403" alt="easy_button" src="http://www.lostechies.com/blogs/hex/easy_button_thumb_0010E86F.jpg" width="536" border="0" />](http://www.lostechies.com/blogs/hex/easy_button_47D27156.jpg)

**_The background_** 

This last weekend during the Pablo&#8217;s Day of Test Driven Development workshop held in Austin, Tx I decided to solve a problem in visual studio that has bothered me for the last two years.&#160; In the process of following TDD using resharper I would normally create a test class.&#160; Than write a line that instantiates a class that has not been created yet.&#160; This would leave me with code that looks like this.

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="188" alt="TestFirst" src="http://www.lostechies.com/blogs/hex/TestFirst_thumb_57FE394F.jpg" width="807" border="0" />](http://www.lostechies.com/blogs/hex/TestFirst_54601E72.jpg) 

All of the classes and interfaces in red do not exist.&#160; Resharper is nice enough to highlight the non-existent definitions in red.&#160; The next step is to get this code to compile, which requires the classes to be created.&#160; Using the resharper quick fix menu, it is easy enough to generate the code for each of these types.&#160; This is where the problem starts.&#160; The resharper stubbed code is dropped into the end of the current file.&#160; Since I separate my UnitTest code from my production code using separate Visual Studio projects, I am now forced to move the type definitions into a separate project.&#160; The problem I have with moving the inline code into a new file in a different project is that this process takes a handful of steps, which although are very trivial, to complete.&#160; The process of cutting and pasting code into a new file gets in the way of what I want to do which is:&#160; 

> Design functionality by writing test code, Implement functionality by making my tests pass, & Make the implementation code easier to read by refactoring.&#160; 

The last thing that I want to worry about is organizing my files and namespaces.&#160; I want visual studio to just do the right thing.&#160; To use the Microsoft mantra make me _**fall into the pit of success**_, rather than the **_dark hole of cluttered files and project folders_**.&#160; I understand that I am asking for a lot from visual studio…. I mean its name starts with Visual which means lots of mouse clicks and Drag & Drop development. The important point to remeber is that when practicing TDD it is much more important to be able to concentrate on good design rather than having some code auto generated with a few mouse movements.&#160; 

**_My Solution_**

I decided to take advantage of the tools I have at my disposal to solve this problem.&#160; I first looked into somehow making a smart tag that would show up in visual studio.&#160; Although there is a SmartTag interface and a class in the visual studio sdk.&#160; The documentation on creating a smart tag is non-existent.&#160; I suppose I could email some people at Microsoft, but why?&#160; That would probably take forever to hear back from them and even get to someone who could actually point me in the right direction.

The next choice was to utilize resharper, it has a plugin model.&#160; Some partially usable samples and a little documentation.&#160; The documentation provided by Jetbrains although terribly lacking.. is much better than the non-existent samples for visual studio.&#160; The springboard that made this really work for me was being able to look through an existing open source resharper plugin.&#160; By looking through an existing (non trivial) plugin I was able to piece together what I want to do.&#160; 

**What does it do?**

The plugin adds some additional menu items to the Context Action menu for classes that are located in a file with additional classes.&#160; The menus add an option to copy the class into a new file with a name of the type and than move it into a project that is referenced by the unit test project. While this solution realistically can only save 30-60 seconds of actual work, what it really does is eliminate the mental stress of doing the right thing and moving the class under test into the correct place in the solution so that you can keep focus on the test and design of the class under test. 

<img height="612" src="http://resharper-tdd-productivity-plugin.googlecode.com/svn/content/MoveToProjectScreenShot.JPG" width="979" />

**_Where can I get it?_**

The Resharper TDD Productivity plugin for resharper is located here: <http://code.google.com/p/resharper-tdd-productivity-plugin/wiki/Features>&#160; It is an open source project and I welcome comments on how to make this plugin better. To download the latest version (works with resharper 4.1) download and run the installer from here: <http://resharper-tdd-productivity-plugin.googlecode.com/svn/trunk/LatestVersion/TddProductivity.Setup.msi>

What are the little inefficiencies that bother you?&#160; Shoot me an email, send me a patch,&#160; or just comment on this post.&#160;