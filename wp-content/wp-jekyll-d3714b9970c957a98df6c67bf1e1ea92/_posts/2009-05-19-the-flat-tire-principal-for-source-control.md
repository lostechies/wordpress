---
id: 40
title: The Flat Tire Principle for Source Control
date: 2009-05-19T03:24:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/05/18/the-flat-tire-principal-for-source-control.aspx
permalink: /2009/05/19/the-flat-tire-principal-for-source-control/
dsq_thread_id:
  - "265166879"
categories:
  - .Net
  - agile
  - Asp.Net
  - 'c#'
  - Open Source Software
  - Tools
---
There is a strange correlation between automobiles and line of business software applications when it comes to performing some standard repairs.

&nbsp;

[<img border="0" align="right" width="244" src="//lostechies.com/erichexter/files/2011/03/flattire1_thumb_3947DCB0.jpg" alt="flat-tire1" height="190" style="border-right: 0px;border-top: 0px;margin: 0px 0px 0px 25px;border-left: 0px;border-bottom: 0px" />](//lostechies.com/erichexter/files/2011/03/flattire1_579293A6.jpg)Consider the following scenario, you are happily working away at your job or out dining with your friends or family and when you come out to your vehicle, it has a flat tire.&nbsp; While this does not happen that often, it is a pretty common&nbsp; occurrence.&nbsp; 

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

[<img border="0" align="left" width="362" src="//lostechies.com/erichexter/files/2011/03/ysod_thumb_7FC75D69.jpg" alt="ysod" height="283" style="border-right: 0px;border-top: 0px;margin: 0px 20px 0px 0px;border-left: 0px;border-bottom: 0px" />](//lostechies.com/erichexter/files/2011/03/ysod_305ADB22.jpg)

This common occurrence can look like this in an ASP.Net application&hellip;. 

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

[<img border="0" align="left" width="244" src="//lostechies.com/erichexter/files/2011/03/FlatTire_thumb_2A361F38.jpg" alt="FlatTire" height="184" style="border-right: 0px;border-top: 0px;margin: 5px 20px 10px 0px;border-left: 0px;border-bottom: 0px" />](//lostechies.com/erichexter/files/2011/03/FlatTire_3AAE9033.jpg) In fact it is so likely to happen that most (if not all) automobile manufactures include the necessary equipment to keep you moving along when this happens.&nbsp; So where in your trunk or hidden under your seats are usually a spare tire. a jack, a wrench, and in some cases a special adaptor to loosen on special lock lug nut.&nbsp; The lock lug nut is a lug nut that is specific to each manufacturer and is meant to deter criminals from stealing your tires.&nbsp;&nbsp;&nbsp; 

&nbsp;

&nbsp;

&nbsp;

[<img border="0" align="right" width="184" src="//lostechies.com/erichexter/files/2011/03/forester_wheel_lock_thumb_15472D76.jpg" alt="forester_wheel_lock" height="244" style="border-right: 0px;border-top: 0px;margin: 0px 0px 0px 25px;border-left: 0px;border-bottom: 0px" />](//lostechies.com/erichexter/files/2011/03/forester_wheel_lock_3A44EDEF.jpg)After a little work you can get your tire replaced or if you do not feel handy enough you can call for some help to get your spare tire put on and your flat tire put into your trunk so that you can get to a repair station.&nbsp; Once you get to a repair station they will ask for your lock nut.&nbsp; The repair stations do not want spend the time working with the wrong tools to get your new tire on.&nbsp; 

This is where I can relate this analogy back to software.&nbsp; I consider all of those **3rd part controls**, **open source libraries** and tools the **lock nuts** of software.&nbsp; We call these lock nuts **system dependencies**.&nbsp; You must handle all of your dependencies with extreme care.&nbsp; All of these tools can prevent your ability to maintain a software system in the future.&nbsp; 

&nbsp;

&nbsp;

&nbsp;

&nbsp;

[<img border="0" align="left" width="244" src="//lostechies.com/erichexter/files/2011/03/flattire_thumb_3902E5C1.jpg" alt="flat-tire" height="172" style="border-right: 0px;border-top: 0px;margin: 0px 25px 0px 0px;border-left: 0px;border-bottom: 0px" />](//lostechies.com/erichexter/files/2011/03/flattire_1783B632.jpg) Why?&nbsp; If you do not keep your dependencies in your source control tree than when it comes time to build your software after you rebuild your machine or when it comes time to fix a bug brought on by environmental changes this simple thing can turn an easy fix into an impossible task.

&nbsp;

&nbsp;

&nbsp;

&nbsp;

&nbsp;

[<img border="0" align="right" width="404" src="//lostechies.com/erichexter/files/2011/03/codecamptrunk_thumb_39057672.jpg" alt="codecamptrunk" height="381" style="border-right: 0px;border-top: 0px;margin-left: 0px;border-left: 0px;margin-right: 0px;border-bottom: 0px" />](//lostechies.com/erichexter/files/2011/03/codecamptrunk_3015E433.jpg) The fix to this problem is pretty simple.. Grab all of those evil 3rd party assemblies and specific versions of libraries and include them in your source control tree.&nbsp; Here is the /lib folder of the CodeCampServer project.&nbsp; This seems like such a simple little thing yet so many developers make the mistake of ignoring their dependencies and instead&nbsp; keep relying on remembering where they put the installer for the specific version of a control their project needs which is sitting on the company file server.&nbsp; I cringe thinking about all the developers who will stumble on this code years down the road.