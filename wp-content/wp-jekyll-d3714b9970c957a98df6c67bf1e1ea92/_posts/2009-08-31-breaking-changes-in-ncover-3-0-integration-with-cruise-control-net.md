---
id: 57
title: Breaking changes in Ncover 3.0 integration with Cruise Control .Net
date: 2009-08-31T20:31:02+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/08/31/breaking-changes-in-ncover-3-0-integration-with-cruise-control-net.aspx
permalink: /2009/08/31/breaking-changes-in-ncover-3-0-integration-with-cruise-control-net/
dsq_thread_id:
  - "1077709873"
categories:
  - .Net
  - agile
  - CC.Net
  - OSS
  - testing
  - Tools
---
&#160;

There were some changes to the [nCover](http://ncover.com) xml reports for code coverage which will break your existing integration with [cruise control .net](http://confluence.public.thoughtworks.org/display/CCNET/Welcome+to+CruiseControl.NET). Specifically if you use the Statistics feature of Cruise Control which is one of the best features it provides IMHO, the xml nodes have changed and ncover no longer provides the total percent of coverage of the project as a single xml Node (or attribute).&#160; This means that you need to do a little more work..(not much) in order to have your code coverage collected as part of the ongoing statistics inside cruise control.

&#160;

You can view the statistics through this link on the project page inside the CCNet Web dashboard.

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_62C9CFA7.png" width="665" height="403" />](http://lostechies.com/erichexter/files/2011/03/image_2E95A661.png) 

&#160;

The coverage is not being collected with the new version of ncover…

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_08BF7FFE.png" width="535" height="556" />](http://lostechies.com/erichexter/files/2011/03/image_2946BFB0.png)

&#160;

Here is the ugly side of Cruise Control .Net.. The xml configuration.&#160; I know it is ugly and painful to deal with… The line underlined is the new xpath selection for code coverage.

<statistics >   
&#160;&#160;&#160; <statisticList>   
&#160;&#160;&#160;&#160;&#160;&#160;&#160; <<font color="#ff0000"><strong>statistic</strong></font> name="Coverage"&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;   
&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; xpath=" **<font color="#ff0000" size="4">(</font>**<a><font color="#ff0000" size="4"><strong>//trendcoveragedata/stats/@vsp</strong></font></a><font size="4"><font color="#ff0000"><strong> div ( //trendcoveragedata/stats/@vsp + //trendcoveragedata/stats/@usp ) ) * 100</strong> </font></font>"   
&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; generateGraph="true"/>   
&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; …   
&#160;&#160;&#160; </statisticList>   
</statistics> 

&#160;

The old xml node for selecting the coverage was a **firstMatch** element, that must now be a **statistic** element.&#160; The old xPath must be replaced with this horrible statement which calculates the percentage of code coverage for the project.&#160; It helps to know that **VSP** = **Visited Sequence Point** and **USP= Unvisited Sequence Point.**&#160; Once you know that the rest falls into place.

&#160;

Once the data is collected it falls into place and shows up in the trend chart….&#160; 

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_72F597A0.png" width="815" height="453" />](http://lostechies.com/erichexter/files/2011/03/image_5A65FA50.png)