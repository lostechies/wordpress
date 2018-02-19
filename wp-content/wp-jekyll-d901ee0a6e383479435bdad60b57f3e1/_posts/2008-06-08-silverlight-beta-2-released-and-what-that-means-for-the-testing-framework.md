---
id: 17
title: Silverlight Beta 2 Released and what that means for the Testing Framework.
date: 2008-06-08T20:49:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/06/08/silverlight-beta-2-released-and-what-that-means-for-the-testing-framework.aspx
permalink: /2008/06/08/silverlight-beta-2-released-and-what-that-means-for-the-testing-framework/
dsq_thread_id:
  - "266993969"
categories:
  - 'c#'
  - silverlight
  - testing
---
ok..&nbsp; So Silverlight Beta 2 was released on and it has some great new features. But what is the story about testing&#8230;?


  


  
1 [Jeff Willcox](http://www.jeff.wilcox.name/2008/06/06/unit-testing-templates-for-microsoft-silverlight-2-beta-2/) blogged about a small change you will need to make in order to use the existing testing framework. It is   
essentially adding a cast to the initial startup code for the testing framework.&nbsp; He also posted new C# and VB.net project  
and item templates. He also hinted that there will be a new release of the test framework and some samples of integration  
with a Continuous Integration server.&nbsp; I am excited about that.&nbsp; I have some prototypes that were half baked to do this,  
I just have not had any time to make it usable.


  


&nbsp;


  


2. The one feature that I am happy to see is the UI Automation (UIA) support. The UIA will make test driving the UI and   
producing a true end-to-end test possible with a well documented and supported API.&nbsp; [Accessibility](http://msdn.microsoft.com/en-us/library/ms753388.aspx "Accessibility") is supported in WPF  
so there are some controls that implement these features in this latest release of silverlight. UI Automation has all the hooks to allow   
testing tools to drive an application through the U.&nbsp; Reference [http://en.wikipedia.org/wiki/Microsoft\_UI\_Automation](http://en.wikipedia.org/wiki/Microsoft_UI_Automation)&nbsp;


  


The best part about silverlight supporting UIA is that a number of people have already paved the way by testing WPF using  
this&nbsp; API&#8230; <http://blogs.msdn.com/llobo/archive/2007/09/06/testing-using-wpf-ui-automation.aspx>&nbsp; 


  


Once again I think ThoughtWorks leads the way with their open source project <http://www.codeplex.com/white>.&nbsp; Looking at  
the getting started page, I am excited to see how easier their helper &#8220;core&#8221; library integrates with nunit&#8230;. What more could I ask for?


  


&nbsp;


  


As I upgrade my previous samples to the Beta 2 Framework and experiment with the White project I will have some posting coming soon.


  


&nbsp;


  


Happily Testing


  


Eric Hexter


  


&nbsp;


  


&nbsp;


  


&nbsp;


  


&nbsp;


  


&nbsp;


  


&nbsp;