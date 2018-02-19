---
id: 66
title: MassTransit Update
date: 2010-05-04T20:56:07+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2010/05/04/masstransit-update.aspx
permalink: /2010/05/04/masstransit-update/
dsq_thread_id:
  - "262089430"
categories:
  - .net
  - masstransit
---
It&#8217;s been a while since I&#8217;ve posted about MassTransit, the .NET distributed application framework and service bus that Dru Sellers, myself, and several other contributors have been working on for the past 2.5 years. This is mostly due to a pretty heavy schedule in the first quarter (CodeMash, the MVP Summit, Pablo&#8217;s Fiesta, the North Dallas .NET User Group, and having an in-ground swimming pool built), along with a lot of exploratory coding on some new features for the framework. 

While traveling to community events, it&#8217;s amazing to run into folks that are using MassTransit in their applications &#8212; particularly ones that I&#8217;ve never heard from before. It&#8217;s a cool feeling to know that people are finding value in the effort we&#8217;ve put into it. Over the past few months, several organizations have been finalizing the testing of new applications built on top of MassTransit, taking advantage of the state-driven saga support (including the new distributor for load balancing saga instances across servers), in preparation for production launches. Several contributors have offered tremendous help with this new functionality, including development of and testing with the distributor support. 

It is great to see users of the framework taking an active role in shaping the feature set to meet a more generalized set of requirements. When Dru and I started creating MassTransit, we had a fairly narrow feature set that needed to be implemented. As the use of messaging in our applications expanded, we started to identify new features that would provide additional benefits. Being able to harvest application-specific code into the framework has provided a high level of reuse which helps everyone. 

### GitHub

The biggest move that we made in the past few months was leaving GoogleCode behind and migrating the project to [GitHub](http://github.com/phatboyg). If you have not yet discovered it yet, Git is an amazing distributed version control system that offers tremendous flexibility when working on highly distributed projects, such as open source projects. Combined with the amazing social collaboration that occurs on GitHub, we have merged significantly more features from contributors on GitHub in the past few months than we had previously received the entire time we were hosted at GoogleCode. Many have forked the [main project](http://github.com/phatboyg/MassTransit) (which is hosted on [my GitHub account](http://github.com/phatboyg), and is also used to drive [the official builds](http://teamcity.codebetter.com/project.html?projectId=project6&tab=projectOverview) on the CodeBetter TeamCity server) and made changes that I have merged into the main project. 

You can still download a compressed archive of the latest source from GitHub by clicking the [download source](http://github.com/phatboyg/MassTransit) link on the [project source](http://github.com/phatboyg/MassTransit) page. You can also [download the latest build](http://teamcity.codebetter.com/viewType.html?buildTypeId=bt8&tab=buildTypeStatusDiv) (or the [tagged v1.0 build](http://teamcity.codebetter.com/viewLog.html?buildId=10337&buildTypeId=bt8&tab=artifacts)) from the TeamCity artifacts link. The build runs automatically when code is push to GitHub, so the latest build is always from the latest bits in the master branch. 

### Major Milestone

On March 1st, we marked a v1.0 release candidate of [MassTransit](http://masstransit-project.com/) (and the related projects [Topshelf](http://topshelf-project.com/) and [Magnum](http://magnum-project.net/)). With open source projects there is always a syndrome of 0.x, where many projects never reach 1.0 yet are still used in production systems at multiple organizations. Considering the number of organizations using MassTransit (and even Topshelf by itself for hosting Windows services), we decided it was time to mark the release 1.0 and freeze the feature set for that line of the codebase. 

Since the 1.0 release candidate, there has been very little active development on the MassTransit codebase. The reason for this is simple, we wanted to allow the framework a little time to soak into the community. There are a lot of features that we want to put into the framework, and several of these are under heavy development outside of the master codebase, but the main feature set for 1.0 was released to allow organizations to go forward with implementations that were waiting on an official release. 

### Documentation

We have heard you, and we are going to start improving the documentation. We&#8217;ve set up a site specific to each project ([MassTransit](http://masstransit-project.com/), [Topshelf](http://topshelf-project.com/), [Magnum](http://magnum-project.net/)) and are going to be harvesting the [content from the wiki](http://masstransit.pbworks.com/) to create a reference set of documentation for using MassTransit. Hopefully we can take some of the questions from [the discussion list](http://groups.google.com/group/masstransit-discuss) and get them into a QA/FAQ section as well. 

_As an aside, I started this post based on a purse fight that was held on Twitter this morning in regards to OSS activity in the .NET community. It is certainly important as an open source project owner to keep the lines of communication flowing in regards to the project status, new features, and roadmap. I plan to work with Dru over the next few days to get these details laid out on the web site so that we can get feedback from the community._ 

In the next few weeks, I hope to start detailing out some of the 2.0 features that are planned for MassTransit. There are several exciting features in the _pipeline_, including an entirely new set of edge components for interfacing with clients connected via Ajax/JSON, WCF, or regular web services. As I get my act<span style="color:white">ors</span> together, I hope to post some details, as well as complete my series on building a service gateway using the new edge components.