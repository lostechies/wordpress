---
id: 16
title: 'Silverlight Testing &#8211; Part 2 &#8211; Making the test easier understand.'
date: 2008-04-21T17:59:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/04/21/silverlight-testing-part-2-making-the-test-easier-understand.aspx
permalink: /2008/04/21/silverlight-testing-part-2-making-the-test-easier-understand/
dsq_thread_id:
  - "1109736656"
categories:
  - silverlight
  - testing
---
Now that we have a working test that can make the proper assertions, the next step is to make the test easier to understand.&nbsp; First, here is the existing test.


  


<A title="FluentUiTest" href="http://erichexter.googlecode.com/svn/trunk/EndToEndSilverlightDemo/EndToEndSilverlightDemo/EndtoEndSilverlightDemo.Tests/Test.cs" target="_blank"><IMG height="194" alt="FluentUiTest" src="http://static.flickr.com/2363/2431211087_06ec8d318d.jpg" width="579" border="0" /></A>


  


The test is loaded with infrastructure code that helps execute the asynchronous calls with the testing framework. This does not help the readability of the tests.&nbsp; More than half of the code in this methods are helper methods and plumbing.&nbsp; This is far from ideal.&nbsp; Another approach to this would be to use a fluent interface that abstracts the plumbing code and leaves a test that is easier to comprehend.


  


&nbsp;


  


<A class="" title="FluentUiTest" href="http://erichexter.googlecode.com/svn/trunk/EndToEndSilverlightDemo/EndToEndSilverlightDemo/EndtoEndSilverlightDemo.Tests/IntegrationTestPartII.cs" target="_blank"><IMG height="285" alt="FluentUiTest" src="http://static.flickr.com/3269/2432024392_69f4b19130.jpg" width="553" border="0" /></A>


  


In this code you will see the UiTestHelper class which hides more of the magic EnqeueXXXX calls to the SilverlightTest base class. This class also hides the code needed to add/remove the control to the test surface as well as call the TestComplete method.&nbsp; This approach is less complicated and as a result allows for easier comprehension when you need to come back and change the code or the tests later in the project.&nbsp; The tests are doing the exact same work and making the same assertion.&nbsp; 


  


&nbsp;


  


**_Subscribe to this feed:_** <http://feeds.feedburner.com/erichexter> 


  


&nbsp;


  


The code for this project is located here : <http://erichexter.googlecode.com/svn/trunk/EndToEndSilverlightDemo>