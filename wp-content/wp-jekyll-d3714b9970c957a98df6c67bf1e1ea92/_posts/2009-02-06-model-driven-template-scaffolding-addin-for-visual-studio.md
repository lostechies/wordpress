---
id: 26
title: Model Driven template/scaffolding addin for Visual Studio
date: 2009-02-06T04:33:37+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/02/05/model-driven-template-scaffolding-addin-for-visual-studio.aspx
permalink: /2009/02/06/model-driven-template-scaffolding-addin-for-visual-studio/
dsq_thread_id:
  - "268488260"
categories:
  - .Net
  - agile
  - Asp.Net
  - Asp.Net MVC
  - mvc
  - mvccontrib
  - Tools
---
&#160;

After playing around with the T4 templates in the Asp.Net MVC release, I wanted to test out what a more complete solution would look like.&#160; Here are some screen shots and mock ups to demonstrate what the tooling experience would feel like.&#160; The code is in progress and will be available publicly soon.&#160; The important thing to know is that a Model is a class file, it is code.

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="514" alt="Add-In" src="http://lostechies.com/erichexter/files/2011/03/Add-In_thumb_2539960A.png" width="763" border="0" />](http://lostechies.com/erichexter/files/2011/03/Add-In_25A5C8FF.png) 

First off turn the Add-in On.

&#160;

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="385" alt="CodeWindowContextMenu" src="http://lostechies.com/erichexter/files/2011/03/CodeWindowContextMenu_thumb_4337A3FE.png" width="760" border="0" />](http://lostechies.com/erichexter/files/2011/03/CodeWindowContextMenu_2F1E8775.png) </p> 

The Generate Scaffolding menu is available from inside of any class.&#160; This could easily be connected to a Hot-Key as well.

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="425" alt="SolutionExplorer" src="http://lostechies.com/erichexter/files/2011/03/SolutionExplorer_thumb_05C73F77.png" width="386" border="0" />](http://lostechies.com/erichexter/files/2011/03/SolutionExplorer_7B09E821.png) 

From the solution explorer, the Generate Scaffolding menu is available for any class file.

&#160;

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="391" alt="SelectTemplate" src="http://lostechies.com/erichexter/files/2011/03/SelectTemplate_thumb_1F8B4FD9.png" width="909" border="0" />](http://lostechies.com/erichexter/files/2011/03/SelectTemplate_20CFE8B8.png) </p> 

The goal of this template selection dialog box is to minimize the need to use the mouse.&#160; Ideally, the most used template set would be the default and all of the templates that are contained in that set are auto checked.&#160; The only action required would be pressing the <enter> key.

&#160;

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="346" alt="TemplateRunningDialog" src="http://lostechies.com/erichexter/files/2011/03/TemplateRunningDialog_thumb_4AEF70D3.png" width="917" border="0" />](http://lostechies.com/erichexter/files/2011/03/TemplateRunningDialog_24F9C07D.png) 

This dialog box would show the status of the template generation.&#160; It is a pretty short process to generate the files, but when editing the T4 templates when there is a compilation error, this dialog would show the results and make debugging the templates easier. 

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="417" alt="TemplatesCreated" src="http://lostechies.com/erichexter/files/2011/03/TemplatesCreated_thumb_5710EAFA.png" width="688" border="0" />](http://lostechies.com/erichexter/files/2011/03/TemplatesCreated_22708EBF.png) 

Obviously.. This is the current templates created dialog box… It has a long way to go before it looks like the previous mock up.

&#160;

What do you think?&#160; Is this a total waste of time or am I on to something?