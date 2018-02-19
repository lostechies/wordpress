---
id: 23
title: My Current .Net Application and Tools Stack
date: 2009-01-29T18:38:49+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/01/29/my-current-net-application-and-tools-stack.aspx
permalink: /2009/01/29/my-current-net-application-and-tools-stack/
dsq_thread_id:
  - "264628807"
categories:
  - .Net
  - Asp.Net
  - continous integration
  - testing
  - Tools
---
For what it is worth I thought I would share what my current application stack for Enterprise Web Application / Line of Business Applications.&#160; When these tools are used together they allow me to develop in a frictionless way.&#160; I am able to build maintainable software using these tools.

&#160;

##### For the runtime environment I like the following:

  * SQL Server 2005 
  * Windows 2003 Server 
  * IIS 6 
  * .Net 3.5 
  * Asp.Net MVC web application framework 
  * JQuery for client side Javascript 
  * Structure Map for the Inversion of Control (IoC) container 
  * NHibernate for Object Relational Mapping 
  * Tarantino for some utility classes. 
  * MvcContrib – additions to the Asp.Net MVC library 
  * Castle Validators – Great validation engine which is part of the Castle framework. 
  * FluentNHibernate – I really like the AutoMapping by convention.&#160; I have this in a small side project and I think it could change the way I think about databases. 

##### Testing, Development, and Build Tools

  * Visual Studio – VS 2008 with C# and Web Developer installed.&#160; I don’t need any of those silly VBx languages installed. 
  * nUnit for Unit and Integration Testing 
  * Gallio/MBUnit for running and reporting of Web UI Automation Tests 
  * WatiN framework for automating Internet Explorer for UI Automation Tests 
  * Cruise Control for Continuous Integration Server 
  * NAnt for build scripting language( I use the term scripting very loosely). I also use this to automate application deployments, it works great.&#160; I only wish it could be deployed as a single executable. 
  * Resharper &#8211; Visual Studio Add-In usable for a solution with lots of files. 
      * TDD Productivity Plugin for Resharper 
  * TestDriven.Net Visual Studio Add-in for running tests fast. 
  * Tortoise Svn – A Windows Explorer integrated subversion client. Simple and Easy. 
  * Subversion – source control.&#160; I prefer to have a hosted subversion repository.&#160; If that is not an option I like Visual SVN for hosting a repository. 
  * Tarantino – to handle Database Change Management.&#160; without this DB change management is a total pain. 
  * SQL Compare and SQL Data Compare- great tools for creating database change scripts. The Pro versions can be automated via command line which is a win in my book. 
  * CCTray – the cruise control client to monitor builds from the system tray. 
  * Balsamiq Mockups – great tool to create a ui mockup. 
  * Vitual PC / VMWare – I have machines for both. I seem to think that either platform is ok enough for me.&#160; The real performance in vm’s is how I configure the client machines. 
  * WinDBG – great tool for getting into the down and dirty. 
  * QUnit – a unit testing tool for javascript.&#160; Once I started using this.. I started liking Javascript again. 
  * 7-Zip command line. 
  * Dos / batch files.&#160; Too many people skip the basics to solve simple automation problems with batch files.&#160; I automated a server setup using a batch file and took a manual multi-hour process to a 30 minute totally automated setup.&#160; I cannot stress the power of the pure command line. 
  * Fiddler, Developer Toolbar – IE plugins. 
  * Google Chrome – I like this browser a lot. 
  * Rhino Mocks 

&#160;

&#160;

##### Tools and Frameworks I want to tryout sometime soon.

  * NHibernate Profiler.&#160; I have high hopes for this tool, I installed .Net 3.5 sp1 just so I can start using it. 
  * WinSnap – Screen capture tool.&#160; Thanks Jason for the recommendation. 
  * JQuery UI – ui gadgets for jQuery. 

&#160;

##### What do you use?

&#160;

### _<font color="#004080">Updated: 1/29/2009 How could I forget about Rhino Mocks ?</font>_