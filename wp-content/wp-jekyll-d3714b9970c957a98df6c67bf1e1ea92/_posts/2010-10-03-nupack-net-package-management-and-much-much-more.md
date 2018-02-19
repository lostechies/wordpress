---
id: 87
title: NuPack– .Net Package Management… and much, much, more
date: 2010-10-03T20:43:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2010/10/03/nupack-net-package-management-and-much-much-more.aspx
permalink: /2010/10/03/nupack-net-package-management-and-much-much-more/
dsq_thread_id:
  - "262103358"
categories:
  - .Net
  - nupack
  - OSS
---
Yeah.. so all the Ruby and Java guys are saying.. Its about time .Net got a package management system. There were a few growing in the open source space, but none have really gained any traction.&nbsp; Nu seemed to be getting going, I saw it earlier on at Pablo&rsquo;s Fiesta here in Austin at the beginning of the year.&nbsp; I would pull the source down and it seemed to be going, but slowly.&nbsp; It has picked up some traction over the summer. But now that they guys have gotten together with Microsoft to make NuPack, I think we are going to see some interesting things happen in the .Net space.&nbsp; Why is that?

&nbsp;

## <img height="159" width="240" src="http://www.thedigeratilife.com/images/septic-tank-worker-2.jpg" align="right" border="0" style="border-bottom: 0px;border-left: 0px;margin: 0px 0px 10px 10px;padding-left: 0px;padding-right: 0px;float: right;border-top: 0px;border-right: 0px;padding-top: 0px" />Package management is a thankless job

First, let me say that writing a package management system is like being the guy who cleans out septic tanks&hellip;&nbsp; No one wants to do it. But for the greater good of the community it has to be done.&nbsp; Every Alt.Net conference I have been to has had a session about writing a package management system, and everytime we left saying we would do it, and it never got done or hardly past started. A few have stepped up to the plate, but I am so happy to see Microsoft putting a team of people out their to work on this full time on an open source solution.&nbsp; Most open source projects in the .Net space have sparse commit logs.&nbsp; I think you will see how much work has been invested into this solution when you look through the source code on the NuPack project website.

## More than package management. 

<img height="180" width="240" src="http://images2.fanpop.com/images/photos/5700000/Fantasia-Wallpaper-classic-disney-5776599-1024-768.jpg" align="left" style="margin: 0px 10px 0px 0px;float: left" />NuPack goes beyond package management and moving bits from a server to your workstation, it adds all the hooks needed to make hooking up new tooling and assemblies inside of Visual Studio a non event.&nbsp; The biggest sell here is that instead of dealing with copying in boilerplate code, or adding nodes to configuration files, the packages can now just do that work.&nbsp; I personally believe the reason Ruby and Rails has had such great velocity and acceleration is because of of the Ruby Gems system.&nbsp; It is the super highway of reusability.&nbsp; The .Net space has just dealt with horrible documentation and even worse XML configuration and it has been killing us.&nbsp; I really think NuPack is a key piece to help change that story. I have worked on two projects when I was at Headspring to try to make it easier to replicate solutions.&nbsp; They were Solution Factory and Flywheel.&nbsp; Both were great ideas conceptually but in the end I found that I did not want to be the guy cleaning out the septic tank. It really took a team of people to pull this off and make it work frictionless(ly) in Visual Studio.

&nbsp;

&nbsp;

## &nbsp;

## The future is bright

The future of NuPack is bright..This means that the sun has set for Solution Factory, while I am not going to shut the doors on the project, I have reworked the code of Solution Factory and its essence is now contained in a single class and packaged as a NuPack package.&nbsp; I think the dramatic changes I was able to make with Solution Factory are a testament to how much of the problem space of Solution and Library reuse automation the NuPack project has taken on. I can see the remaining pieces of the Solution Factory project being totally subsumed by the NuPack project over time. From my point of view, this is a good thing. I would much rather collaborate on a solution than just being a lone committer.

### Go Get NuPack [<img height="67" width="244" src="//lostechies.com/erichexter/files/2011/03/Nupack-logo_4450CDEC.png" align="left" alt="Nupack-logo" border="0" style="border-bottom: 0px;border-left: 0px;padding-left: 0px;padding-right: 0px;float: left;border-top: 0px;border-right: 0px;padding-top: 0px" />](http://nupack.codeplex.com/) from Codeplex.com 

&nbsp;

&nbsp;

&nbsp;

I will post about Solution Factory and what it can do for projects like FubuMVC and Sharp Architecture.&nbsp; I think when combine with NuPack the project can make it trivial to build your own Opinionated solution template.