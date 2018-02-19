---
id: 34
title: Hot fix available for Visual Studio 2008 SP1 crashing when opening up aspx files (views) on Vista SP1 x64
date: 2009-03-03T03:39:25+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/03/02/hot-fix-available-for-visual-studio-2008-sp1-crashing-when-opening-up-aspx-files-views-on-vista-sp1-x64.aspx
permalink: /2009/03/03/hot-fix-available-for-visual-studio-2008-sp1-crashing-when-opening-up-aspx-files-views-on-vista-sp1-x64/
dsq_thread_id:
  - "262047759"
categories:
  - Uncategorized
---
&#160;

I have been fighting some a crash with visual studio 2008.&#160; The IDE would crash without a single dialog box when opening any of the aspx files. This includes pages (aspx), user controls (ascx) and master pages (.master) files.

This problem occurred on my system with the following configuration:

  * Vista x64 SP1 
  * [Visual Studio 2008](http://www.ecostsoftware.com/microsoft/microsoft-visual-studio-2008-professional_p3503 "Microsoft Visual Studio 2008") SP1 
  * Asp.net MVC RC1 

I did not try a regular web forms (Asp.Net Classic) project as I am not working on any but if you are getting crashes after installing Visual Studio sp1 than give this a try.

**FIX**

> **** 
> 
> You can download the hot fix from here: 
> 
> <https://connect.microsoft.com/VisualStudio/Downloads/DownloadDetails.aspx?DownloadID=16827&wa=wsignin1.0>
> 
> I installed the following patch from the download set. **Windows6.0-KB963676-x64.msu**. It did require a reboot but it looks like this fixed my issue.
> 
> You can also reference another variation of this which is obviously related: <http://blogs.msdn.com/jnak/archive/2009/02/26/fix-available-asp-net-mvc-rc-crash-in-a-windows-azure-cloud-service-project.aspx></blockquote> 
> 
> &#160;
> 
> **Work Around**
> 
> > If you cannot apply this patch you can work around this problem by changing your default editor to use the Html Editor instead of the Web Forms Editor.&#160; You need to make this change to the User Controls and Master pages as well.
> > 
> > To do the workaround :
> > 
> >   1. Right click on a .Aspx file. Select the **Open With** command 
> >   2. Click on the Html Editor 
> >   3. Select the **Set as Default** button. 
> >   4. Click OK