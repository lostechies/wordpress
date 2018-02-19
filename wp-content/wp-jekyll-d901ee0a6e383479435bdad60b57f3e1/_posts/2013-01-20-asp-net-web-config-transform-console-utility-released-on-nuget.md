---
id: 377
title: ASP.Net Web Config Transform Console Utility released on nuget
date: 2013-01-20T00:01:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=377
permalink: /2013/01/20/asp-net-web-config-transform-console-utility-released-on-nuget/
dsq_thread_id:
  - "1036021214"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - CodeProject
  - Deployment
  - MSDeploy
  - nuget
  - Open Source Software
  - OSS
  - Tools
---
## Overview

ASP.Net Web.config transformations are a great way to manage configuration differences between environments. You can easily change a database connection string or change the compilation model for asp.net.&nbsp; <a href="http://msdn.microsoft.com/en-us/library/dd465326.aspx" target="_blank">Here is a link to the syntax documentation on msdn</a>. The problem with web.config transformations, is that it has been historically really hard to run the transforms. The tooling to do this was buried into Visual Studio.&nbsp; The ASP.Net team just <a href="http://nuget.org/packages/Microsoft.Web.Xdt" target="_blank">released</a> a library to run the transformations as a <a href="http://nuget.org" target="_blank">nuget</a> library.&nbsp; 

&nbsp;

## Installation

Using that library I created a very simple command line tool to transform config files <a href="http://nuget.org/packages/WebConfigTransformRunner" target="_blank">WebConfigTransformRunner</a> is the package containing this utility.

&nbsp;

> install-package <a href="http://nuget.org/packages/WebConfigTransformRunner" target="_blank">WebConfigTransformRunner</a>

&nbsp;

## Usage

>     WebConfigTransformationRunner.exe WebConfigFilename TransformFilename OutputFilename

## Scenarios

I see this package being used in two ways. 

First, using this in an automated build as part of a packaging process to pre transform configuration files for different environments.&nbsp; This was the main reason I created this library. I am using it in a build in TeamCity to transform my web.config file for an asp.net mvc application as part of an automated CI build and deploy.

The second scenerio that seems very useful would be to access this package from the install script (install.ps1) from a nuget package. The current configuration transformations that nuget supports is very limited, It works best when you have static configuration nodes that will never change.&nbsp; If you have a node that has an attribute that a user / developer may change then using a configuration transformation would be a more reliable.&nbsp; Since this tool is delivered as a nuget package the command is available in the path of the nuget console, so a package that needs to run a transformation would just need to take a dependency on this package then it could run the exe command from the install script, on the files it wants to transform. I could see running the main web.config with a transformation that is located in the packages content folder, for example.&nbsp; 

&nbsp;

## Want to help?

The <a href="https://github.com/erichexter/WebConfigTransformRunner" target="_blank">project is open source and available on github</a>. Please submit issues, ideas or pull requests!