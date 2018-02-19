---
id: 69
title: Using MSDeploy to automate your Enterprise Application remote deployments.
date: 2009-11-06T17:00:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/11/06/using-msdeploy-to-automate-your-enterprise-application-remote-deployments.aspx
permalink: /2009/11/06/using-msdeploy-to-automate-your-enterprise-application-remote-deployments/
dsq_thread_id:
  - "262117085"
categories:
  - Asp.Net
  - CC.Net
  - continous integration
  - Deployment
  - MSDeploy
  - Open Source Software
  - Tools
---
</p> 

MsDeploy is a newish technology that is a bit schizophrenic.&#160; What I mean is that it is a tool that is useful to both Developers and Administrators but it is not clear from the documentation how to best use the technology and how to approach it. I believe it stated as a Server Administrator tool and the team was able to work in an integration with Visual Studio which made it into a more robust framework, but at the same time left is command line interface with so many options that it is challenging to get a grasp on.&#160; To top that off the Web Platform Installer uses the MsDeploy packages as a way to distribute packages through that tool.&#160; After working through some various ways to use the technology I have settled into some commands that work well for our projects. 

&#160;

Let me set the context of how we are using the tool and what we already had in place so that you can better understand if my use of MsDeploy will work for you. At [Headspring](http://www.headspringsystems.com/) we use Continuous Integration on all of our projects and as a result, once our software is built by our build server the next logical step is to deploy our software to a server and than run User Interface tests against the application. Most of our projects are web applications running on ASP.Net MVC using Sql Server as the back end.&#160; We install our software using a lightweight zipfile that contains the web application files, database migration scripts and a deployment script which can poke config files and execute our database migration tool.&#160; We already have all the pieces in place to deploy our application on a local machine.

&#160;

Up until know we have used two methods to deploy instances to remote machines.&#160; The first methods was to install Cruise Control.Net on the server and have it monitor our source control repository for a new installation package being committed to the repository. Once it sees a new package CCNet will pull down the package, install it locally and go on its merry way.&#160; The second method, is to kick off the deployment from the build server and connect over the network to the target database to run upgrades and then xcopy the files to a unc share.&#160; Both of these methods require setting up some configuration on our target servers. My goal with our deployments is to reduce the amount of per server configuration we do on each server and use some conventions to make each server look similar to one from a different project.

&#160;

Using MSDeploy allows us to do the following.

> 1. Remove the need to install cruise control on the target server and update the configuration for cruise control on each target server.&#160; We do have to install MSDeploy on each server but we do not have to mess with any configuration after that.
> 
> 2. We do not have to mess with setting up unc shares and deal with the mess.&#160; It sounds like a silly thing but by getting away from the unc share we can also test our deployments from any machine and msdeploy is actually firewall friendly.&#160; xcopy to a unc share is not firewall friendly which means that we cannot use it for all of our clients which means variations between our projects.&#160; 
> 
> 3. We use msdeploy as a mechanism to distribute our deployment packages and then remotely execute the packages.&#160; This means I can have a single instance of our Continuous Integration server which reduces the number of places to maintain configuration.&#160; That is a big win.&#160; This also means the log files for all of the deployments can be tracked in a single place.
> 
> 4. Another benefit of using msdeploy to push our deployments means that I can easily setup new instances of a test configuration and push it to multiple servers without having to log into each machine.. This is good for efficiency.

Our use of MSDeploy now boils down to two steps.&#160; Distribute and Execute.&#160; We have some of our scripts in NAnt and we are in the process of migrating to PowerShell now that version 2.0 is available from the older operating systems.&#160; Below is a sample of executing msdeploy from a NAnt script.

Calling MsDeploy from Nant

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_19E0E10C.png" width="1028" height="249" />](http://lostechies.com/erichexter/files/2011/03/image_4912CCA3.png)

The **dirPath**&#160; command tells MSDeploy to synchronize a directory from the source computer a target computer. This is a pretty easy command to understand.

The second command is the **runCommand** this command was added between the RC and 1.0 release of MSDeploy and I am so happy they added it. The run command is told to execute a command on the remote machine.&#160; Since we are running installation scripts, they do not execute instantly and as a result the waitInterval and waitAttempts need to be specified so that the command does not timeout before it has completed running. other than that the output of the console application is piped back to the source computer.&#160; The one caveat about the run command is that when it starts it runs from the C:windowssystem32 directory.&#160; In order to work around this issue I have found that passing the directory of the command into the batch file that I run allows my batch files to first cd to that directory as its first step.&#160; This is a pretty harmless thing to do and works pretty well.

This is what a sample deployment batch files looks like.

> cd %1   
> rd ..codeToDeploy /s /q   
> applicationNamePackage.exe -o..CodeToDeploy -y   
> cd ..CodeToDeploy   
> cmd /c %systemroot%system32inetsrvappcmd stop site applicationName_dev   
> iisreset   
> call dev.bat   
> cmd /c %systemroot%system32inetsrvappcmd start site applicationName_dev

This is pretty basic and does some IIS commands as well.&#160; 

&#160;

I am sure I left some information out, but I wanted to get a brain dump of our use of MSDeploy.

&#160;

Long term I would like to see the use of PowerShell driving msdeploy and adding some configuration around each Server Role in an application and tie it to the servers needed for each environment.&#160; I have started a project to put this together called psTrami but I have not put any of the code together yet, just some small spikes to prove it out.

&#160;

More to come sometime soon…..