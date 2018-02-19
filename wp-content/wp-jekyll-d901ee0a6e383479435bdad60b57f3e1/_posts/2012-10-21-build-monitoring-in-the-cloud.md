---
id: 101
title: Build Monitoring in the cloud
date: 2012-10-21T08:22:12+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/2012/10/21/build-monitoring-in-the-cloud/
permalink: /2012/10/21/build-monitoring-in-the-cloud/
dsq_thread_id:
  - "893819192"
categories:
  - .Net
  - CC.Net
  - continous improvement
  - continous integration
  - Deployment
  - GIT
  - Uncategorized
---
I have been using a number of services in the cloud lately, [AppHarbor](http://www.appharbor.com), [Azure Websites](http://www.windowsazure.com/en-us/develop/net/common-tasks/publishing-with-git/), [MyGet](http://www.myget.org/), [Code Betters](http://devlicio.us/blogs/derik_whittaker/archive/2009/02/25/teamcity-codebetter-com-is-alive-and-kicking.aspx) Team City OSS Continuous Integration server. While these services are making deploying websites and nuget packages easier then ever.  I do not have to maintain my own build servers anymore I find, I have lost my single source of build status.  I know need to remember where to look for each of my projects.  It is a mental tax that is just [one more paper cut](http://en.wikipedia.org/wiki/Death_by_a_thousand_cuts) that is a pain to deal with.

Back to old school tools

I have been working to show a better way, and it is interesting to me because it actually revives an older open source project.  I have been using [CCTray](http://www.cruisecontrolnet.org/projects/ccnet/wiki/Visualizers), it is a system tray tool that shows toaster pop ups notifications for builds. It is part of the Cruise Control.net build server, which is a project I thought was all but dead.  It seems like my current dilemma of the could has helped me rediscover the system tray tool from this project.

Here is an example of what I was able to do with the CCtray tool.

![](https://pbs.twimg.com/media/A5gs6CTCUAAty6k.png:large)

Let me summarize what I have done here:

  1. Display builds from my companies internal TFS server.
  2. Display builds from my internal TeamCity Server (TeamCity added CCTray support in the box in their 7.0 version)
  3. Display builds from the external CodeBetter TeamCity OSS server.
  4. Display builds from my AppHarbor website builds.
  5. Display builds from my Azure website builds.

I think the possibilities are pretty endless. Had to write adaptors to make TFS, AppHarbor, and Azure work with this process.  My AppHarbor and Azure adaptor are a cloud website that translates each systems native build status to the xml that CCtray needs.

## What is still painful?

The approach with Azure websites only works with Git deployed azure websites, and the process for setting up azure websites is pretty cumbersome, I have found that the AppHarbor API is much easier to work with and built to enable this scenario much better then the Azure APIs.  The Azure team needs to stop what they are doing and really get some customer feedback. they clearly are not talking to customers about what would be useful.

## What&#8217;s next?

Are you interested in this?  If so, contact me and we can work towards a more open solution, then my current prototype.

&nbsp;

&nbsp;