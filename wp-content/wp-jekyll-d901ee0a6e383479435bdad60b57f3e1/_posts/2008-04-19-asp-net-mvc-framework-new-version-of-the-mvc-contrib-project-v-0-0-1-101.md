---
id: 13
title: 'ASP.Net MVC framework &#8211; New version of the MVC Contrib project! &#8211; v 0.0.1.101'
date: 2008-04-19T11:38:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/04/19/asp-net-mvc-framework-new-version-of-the-mvc-contrib-project-v-0-0-1-101.aspx
permalink: /2008/04/19/asp-net-mvc-framework-new-version-of-the-mvc-contrib-project-v-0-0-1-101/
dsq_thread_id:
  - "1069820462"
categories:
  - Asp.Net
  - mvc
  - mvccontrib
---
There was a new source code release of the [Asp.Net MVC framework](http://shrinkster.com/x4x) .&nbsp; We just got the MVC Contrib project upgraded to work against the new release.


  


You can find the [release here](https://www.codeplex.com/Release/ProjectReleases.aspx?ProjectName=MVCContrib&ReleaseId=12711).


  


&nbsp;


  


First I would like to thank [Jeremy Skinner](http://blog.jeremyskinner.me.uk/) for his hard work upgrading the release! 


  


&nbsp;


  


Here is what changed in the release:


  



  


  * Upgraded to the 0416 Source Code drop of ASP.NET MVC.
  
      * Moved most of ConventionController&#8217;s logic into ConventionControllerActionInvoker.
  
          * ControllerDescriptor now only treats methods that return an ActionResult as a valid action.
  
              * Moved the filters implementation more in line with the implementation in ControllerActionInvoker.
  
                  * Removed the ReturnBinders implementation. The same result can be achieved by using custom ActionResults.
  
                      * Introduced XmlResult to replace XmlReturnBinder.
  
                          * Added RenderText and RenderXML methods to ConventionController.
  
                              * TestControllerBuilder no longer proxies controllers or captures renderview/redirect calls</UL>
                            
  
                            &nbsp;
                            
                            
  
                            Keep up to date by subscribing to <http://feeds.feedburner.com/EricHexter>
                            
                            
  
                            &nbsp;
                            
                            
  
                            Do you twitter?&nbsp; You can follow the project on twitter here: <http://twitter.com/mvccontrib></p>