---
id: 7
title: 'New MvcContrib build released on CodePlex &#8211; Build 0.0.1.75 Beta'
date: 2008-02-29T10:57:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/02/29/new-mvccontrib-build-released-on-codeplex-build-0-0-1-75-beta.aspx
permalink: /2008/02/29/new-mvccontrib-build-released-on-codeplex-build-0-0-1-75-beta/
dsq_thread_id:
  - "1112751959"
categories:
  - Asp.Net
  - mvc
  - mvccontrib
---
I just released the latest build in binary and source code format on CodePlex.


  



  


  * _To Subscribe to this RSS feed use this url:_ [_http://feeds.feedburner.com/EricHexter_](http://feeds.feedburner.com/EricHexter)  
    


  


The following items are changes from the previous release:


  



  


  * Added support for InputImage in FormHelper (new methods FormHelper.ImageButton())
  
      * Added Password Tag
  
          * Added support for Password tag in FormHelper (new methods FormHelper.PasswordField())
  
              * Updated test to maintain 100% on form helper and UI
  
                  * Changed TextArea to use a full Close tag when value is empty instead of a XML tag close (&#8220;/>&#8221;).
  
                      * Fixed UI.Html/FormHelperTester.cs tests to anticipate new results.
  
                          * Patch #882 &#8211; tehlike ReturnBinder implementation ported from MonoRail. / Modified tests slightly to reach 100% coverage.
  
                              * Patch #864 &#8211; Woil This patch cleans up some of the namespaces from the older MvcTestFramework to the new MvcContrib.TestHelper namespace.
  
                                  * Added comments to all of the TestHelper classes which should make them easier to use. Applied with minor modification &#8211;
  
                                      * Sample test project referenced the Debug directory of MvcContrib.TestHelper, which caused CommitterBuild to fail. Changed to use $(Configuration) instead.
  
                                          * Made methods on FormHelper virtual. Fixed the namespace for the ObjectFactoryDependencyResolver, SpringDependencyResolver and StructureMapDependencyResolver &#8211; they were under the UnitTests namespace. </UL>
                                        
  
                                        You can download the release here:  
                                        <https://www.codeplex.com/Release/ProjectReleases.aspx?ProjectName=MVCContrib&ReleaseId=11177>
                                        
                                        
  
                                          
                                        The documentation for the features in the MvcContrib project are located here:  
                                        <http://www.codeplex.com/MVCContrib/Wiki/View.aspx?title=Documentation&referringTitle=Home>
                                        
                                        
  
                                          
                                        If you have some cool feature that adds to the MVC framework then contribute and share with the community! Here are details on how to contribute.  
                                        <http://www.codeplex.com/MVCContrib/Wiki/View.aspx?title=Contribute&referringTitle=Home></p>