---
id: 89
title: Using Powershell to make your NuPack Packages – more Awesome
date: 2010-10-28T14:17:06+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2010/10/28/using-powershell-to-make-your-nupack-packages-more-awesome.aspx
permalink: /2010/10/28/using-powershell-to-make-your-nupack-packages-more-awesome/
dsq_thread_id:
  - "262063620"
categories:
  - .Net
  - nupack
  - Solution Factory
  - VS2010
---
Yeah.. Its a cheesy title but what can I say. You can file this under “why nupack is not just for open source”.&#160; We are using Nupack to distributed dependencies libraries and for the UI Framework where I work (Dell).&#160; My team is responsible for the UI Framework which builds on top of MVC2 and while we try to be unobtrusive, there are a few spots where the easiest form of integration caused us some pain as far as walking teams through setting up our framework.&#160; That aside, I think this technique is useful outside of my usecase.

&#160;

There are some Special Files available for NuPack Packages. By placing these files in the tools folder of your package they automatically run.&#160; The files are

  * ToolsInstall.ps1 = Runs after your package is installed. 
  * ToolsUninstall.ps1 = Runs after your package is uninstalled 
  * ToolsInit.ps1 = runs each time the project is loaded in visual studio. This is used to add additional commands to the nupack console. 

&#160;

The problem I had to sovle was that our framework requires a consuming project to Inherit the applications HttpApplication from our BaseClass and then move all of the code that was in Application\_Start to our UIFramework\_Application_Start method. While this is simple to document, it was the last step that prevented a developer from installing our framework and running the application with everything hooked up.&#160; So, I went into the install.ps1 and wrote some automation code using the old school Visual Studio Com automation library. EnvDTE.&#160; First let me show you the before and after states of the Code.

&#160;

### Before

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="before" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_1E5C2837.png" width="638" height="484" />](http://lostechies.com/erichexter/files/2011/03/image_7F85B458.png) 

### After

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="Untitled1" src="http://lostechies.com/erichexter/files/2011/03/Untitled1_thumb_074DA6FB.png" width="644" height="475" />](http://lostechies.com/erichexter/files/2011/03/Untitled1_6157F6A4.png) </p> 

So, the differences are subtle but make the difference between everything working and nothing working.

To make these changes programmatically, I used the DTE object model.&#160; Here’s the code.

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_3A3D3762.png" width="644" height="460" />](http://lostechies.com/erichexter/files/2011/03/image_0D284A94.png) 

The COM object model is a little scary but there is descent documentation on the MSDN website for navigating it.&#160; The single biggest win NuPack brings to the table for developing this kind of code is the Package Console. You can interactively type commands and inspect the object model.&#160; So to develop this code, I simply typed it into the console one line at a time and verified what I wanted to see happen. Once that works, I moved it into the install.ps1 script. Doing the development interactively is much easier than making code changes, rebuilding your package, then trying the install out.&#160; That is just too much friction to deal with. So, go experiment with the Package Management console. A good powershell command to start with is get-variable, this will let you inspect the objects that NuPack puts into the console and see what type of information you can access using the DTE object model.