---
id: 176
title: 'Build Metrics with Distributed Teams &amp; Large Organizations'
date: 2012-11-21T23:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=176
permalink: /2012/11/21/build-metrics-with-distributed-teams-large-organizations/
dsq_thread_id:
  - "937497764"
categories:
  - agile
  - CodeProject
  - continous improvement
  - continous integration
  - offshore
  - Tools
  - Unittests
---
With some recent changes at work and I am looking at the quality of software development teams across a very large software organization. I am currently looking at getting the teams back to the basics in terms of software quality. The first and most important metric is having a Working build, in terms of continuous integration, that means: compiling software and passing unit tests. It is pretty simple but with distributed teams these becomes even more important. As I looked at the build tools we are using I found that most build tools look at successful builds as a count or percentage of good versus bad builds. 

There is an important element that is missing for distributed teams and that is the factor of time. When you have a team that is distributed across multiple time zones, the working hours of the team extends to the sum of the working hours for every team member. The idea of counting successful builds now does not really help drive the behavior of keeping your source control tree working. So, I am looking at measuring successful builds as a percentage of time per day. This makes more sense to me to keep a build green so that when you walk out at the end of your day, you leave your remote team members with working code rather than forcing them to fix what you broke. I have seen some references to the consulting company ThoughtWorks and their policy of no broken builds. The negative comments about it were around the team members having to stay late to fix what is broken when it may not really matter and there being mental weight with having to deal with this pressure. I can totally understand that point of view and how my proposed metrics could cause more pain then good. I think the most responsible and easiest solution to a broken build is to revert the check-ins that cause the problem in the first place. Let the developer who had the bad check-in spend some more time on their local machine to determine why they could not get the build working properly on the build servers at their own pace, without blocking team members from working. I see this as the same approach I use when troubleshooting production issues, the most important aspect is to get the system running, using your redundant servers and networking equipment to make sure the system is working and only after making things right, do you go in and perform analysis on a server or component in the system that is not working properly. Do the same thing with the build, fix it for the team first, then spend the time to add the new features or commits to the system.
  


#### Applying this to a large organization

This is a little more complicated, it is easy to determine the amount of time a build is successful vs broken for any given day. In an organization that has over 500 developers, how can one properly manage all of the builds and source trees in a way that makes sense? My approach to this is treat every build as being important, if it is not then, remove it. 

[<img style="background-image: none; border-bottom: 0px; border-left: 0px; padding-left: 0px; padding-right: 0px; display: inline; border-top: 0px; border-right: 0px; padding-top: 0px" title="image" border="0" alt="image" src="http://lostechies.com/erichexter/files/2012/10/image_thumb2.png" width="529" height="214" />](http://lostechies.com/erichexter/files/2012/10/image5.png) 

So, each team gets to have the metrics from all their builds averaged together, so the team is rewarded for keeping all of their builds working properly. The next roll up is go average all the builds and times to the top level leader, I do not see value in reporting at every level of management. Use this metric to see if each area of the organization is improving. To do this, I am looking at rolling up the build success to weekly and monthly reports where we can see how much time the builds succeeded and have we improved this week compared to the previous. The other interesting metric is the number of builds, so if a program spins up and forces teams to manage more branches, the number of builds will increase. I would expect that the effort to keep more builds working will come at a loss of productivity in terms of feature development or the % time of build success will decrease.