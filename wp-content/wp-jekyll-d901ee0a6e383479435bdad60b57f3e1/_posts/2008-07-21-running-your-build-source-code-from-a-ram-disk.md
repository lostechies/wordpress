---
id: 20
title: Running your build/source code from a ram disk.
date: 2008-07-21T17:18:21+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/07/21/running-your-build-source-code-from-a-ram-disk.aspx
permalink: /2008/07/21/running-your-build-source-code-from-a-ram-disk/
dsq_thread_id:
  - "262305249"
categories:
  - .Net
  - 'c#'
  - testing
---
&#160;

As a test I wanted to run a build from a drive in ram rather than on a physical disk drive using the old Dos style Ram disk. For a trivial build that includes compilation, Asp.net compilation, database updates, unit test, and integration tests. I saw the build time decrease by 41%. That is pretty good. 

[<img style="border-top-width: 0px;border-left-width: 0px;border-bottom-width: 0px;border-right-width: 0px" height="420" alt="buildFromRamDisk" src="http://lostechies.com/erichexter/files/2011/03Runningyoursourcecodefromaramdisk_ACBC/buildFromRamDisk_thumb.jpg" width="687" border="0" />](http://lostechies.com/erichexter/files/2011/03Runningyoursourcecodefromaramdisk_ACBC/buildFromRamDisk_2.jpg) 

Running MvcContrib build using this same method return the following results, a decrease in build time from 37 to 28.7 seconds.

[<img style="border-top-width: 0px;border-left-width: 0px;border-bottom-width: 0px;border-right-width: 0px" height="461" alt="RamDiskCompileMvcContrib" src="http://lostechies.com/erichexter/files/2011/03Runningyoursourcecodefromaramdisk_ACBC/RamDiskCompileMvcContrib_thumb.jpg" width="690" border="0" />](http://lostechies.com/erichexter/files/2011/03Runningyoursourcecodefromaramdisk_ACBC/RamDiskCompileMvcContrib_2.jpg) 

I am running this from an XP virtual machine with the ram disk that is available for free from here:&#160; <http://www.mydigitallife.info/2007/05/27/free-ramdisk-for-windows-vista-xp-2000-and-2003-server/>

This is just a prototype and I am just playing with this idea right now.&#160; Next I am going to do some tests with loading database files to the ram disk and look at some options for ensuing all my data is not lost…. The important thing to know about the RAM Disk is that when the machine shuts down it dumps the contents of the disk.&#160; There are some options where the drive can be mapped to an image file so that the drive can start up with some basic configuration.&#160; More to come….