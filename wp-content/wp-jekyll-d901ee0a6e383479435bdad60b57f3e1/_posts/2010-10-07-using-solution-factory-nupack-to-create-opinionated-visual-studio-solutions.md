---
id: 88
title: Using Solution Factory + NuPack to create Opinionated Visual Studio Solutions.
date: 2010-10-07T17:17:36+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2010/10/07/using-solution-factory-nupack-to-create-opinionated-visual-studio-solutions.aspx
permalink: /2010/10/07/using-solution-factory-nupack-to-create-opinionated-visual-studio-solutions/
dsq_thread_id:
  - "262297902"
categories:
  - nupack
  - OSS
  - Solution Factory
  - Tools
  - VS2010
---
Using Solution Factory inside of NuPack opens up a great new world of creating Solution Level templates. Previously, I wrote a lot of code in Solution Factory that just kept running into edge cases working against the Visual Studio automation API ,DTE. Most of what I wanted to achieve was setting some defaults and installing dependencies.&#160; This is where using solution factory with Nupack really shines.

&#160;

The following code is a prototype of what you could use to make a MetaPackage for NuPack . (A meta package is a package that would not contain any assemblies or content to add to a project but would rather chain together a set of packages). In this scenario, using Visual Studio I can create a MVC project and using this script I automate setting up a test project with the latest versions of the testing tools that I like to work in.

[<img style="border-bottom: 0px;border-left: 0px;padding-left: 0px;padding-right: 0px;border-top: 0px;border-right: 0px;padding-top: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_323AC6DA.png" width="644" height="343" />](http://lostechies.com/erichexter/files/2011/03/image_59E14304.png)

&#160;

The commands that Solution Factory adds to the Package Management Console are:

  * Add-Project
  * Add-ProjectReference
  * Remove-LibraryReference
  * Set-DefaultNamespace

&#160;

After running this code, you will see the following output in the console

[<img style="border-bottom: 0px;border-left: 0px;padding-left: 0px;padding-right: 0px;border-top: 0px;border-right: 0px;padding-top: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_296ABE8E.png" width="644" height="266" />](http://lostechies.com/erichexter/files/2011/03/image_3C1FB845.png)

You can see the console pretty much echoes the commands of my little PowerShell script.&#160; Lets look at the solution explorer to see what was added.

[<img style="border-bottom: 0px;border-left: 0px;margin: 0px 10px 0px 0px;padding-left: 0px;padding-right: 0px;float: left;border-top: 0px;border-right: 0px;padding-top: 0px" border="0" alt="image" align="left" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_0EBE2275.png" width="244" height="484" />](http://lostechies.com/erichexter/files/2011/03/image_1A53DFB4.png) The Test project was added and it follows the convention/ naming pattern that I like.&#160; You can see that the assembly references are pretty clean.&#160; This is pretty much the way I like it but with previous solutions like solution factory, I get the benefit of having the latest version of each of the libraries, thanks to NuPack.

&#160;

While this is a little proof of concept, this can be turned into something much larger. At Headspring, I put together a standard File –> New –> Headspring project and it followed a more complex project structure that had some pretty specific ways of controlling dependencies so that Core logic did not depend on 3rd party assemblies.&#160; You can read more about this approach on [Jeffrey’s Blog](http://jeffreypalermo.com/blog/the-onion-architecture-part-1/). The part that broke down for us, is that it took a lot of effort to automate the process of setting up our structure with the latest and greatest bits. I think building on what I demonstrated here will really go far, for projects like Sharp Architecture, FUBU MVC, and any other project that wants to setup an opinionated way of working.&#160; 

&#160;

I can see bundling up known solutions together in a way that just was not easy to create and share with the community, I really think that will change now. And I am very excited about what will come as NuPack and Solution Factory evolve over the next few months.

&#160;

Solution Factory is in the current NuPack feed so you can start using this now.&#160; The code for Solution Factory is located on codeplex, but exists in one of my Forks, I will spend some time over the next few weeks moving this into the main trunk and I removing all of the existing Solution Factory Add-in and Command Line applications. The code is just not needed anymore.. And deleting code that has no value, makes me happy!

&#160;

Comments?&#160; Let me know. If this is something you have a passion for, let me know and we can work together on building out more of solution factory!