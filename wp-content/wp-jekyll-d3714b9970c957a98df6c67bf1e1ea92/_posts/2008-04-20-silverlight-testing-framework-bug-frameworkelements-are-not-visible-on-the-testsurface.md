---
id: 14
title: 'Silverlight Testing framework bug &#8211; FrameworkElements are not visible on the TestSurface'
date: 2008-04-20T04:24:36+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/04/20/silverlight-testing-framework-bug-frameworkelements-are-not-visible-on-the-testsurface.aspx
permalink: /2008/04/20/silverlight-testing-framework-bug-frameworkelements-are-not-visible-on-the-testsurface/
dsq_thread_id:
  - "1088629346"
categories:
  - silverlight
  - testing
---
<div class="wlWriterSmartContent" style="padding-right: 0px;padding-left: 0px;padding-bottom: 0px;margin: 0px;padding-top: 0px">
  Technorati Tags: <a href="http://technorati.com/tags/Silverlight" rel="tag">Silverlight</a>,<a href="http://technorati.com/tags/Unit%20Testing" rel="tag">Unit Testing</a>,<a href="http://technorati.com/tags/Test%20Framework" rel="tag">Test Framework</a>
</div>

Working with the Silverlight testing framework the last three weeks has been interesting.&nbsp; I ran into a crazy intermittent bug which drove me made for about 2 hours.&nbsp; The usercontrol that I was adding to the TestSurface would be visible about 50% of the time when running my tests. The test would still run and I could hear the audio portion of the videos that were playing as part of an integration test, but the Controls were not visible on the test surface. All I could see was the blank test surface and the testing framework status on the right side of the test runner. 

&nbsp;  
After resorting to reflector on the test framework I found that the TestSurface is a Grid control.&nbsp; That got me to think that since my controls parent control is also a Grid control that maybe the nested grids are just having some sort of issue.&nbsp; I ended up solving the problem by Adding my controls to a Canvas control and adding the Canvas instance to the TestSurface.&nbsp; Code as follows&#8230;&#8230;

_Subscribe to this feed:_ [_http://feeds.feedburner.com/erichexter_](http://feeds.feedburner.com/erichexter)_&nbsp;_ 

[<img alt="si-testing-testsurfacebug" src="http://static.flickr.com/2183/2426484873_04cd4296a5.jpg" border="0" />](http://www.flickr.com/photos/45074821@N00/2426484873/ "si-testing-testsurfacebug")

&nbsp;

This solved my problem&#8230; The issue is not with the test framework as much as the silverlight runtime.&nbsp; It is still beta so what do you expect?

More posts on the test framework, both unit testing and integration testing, to come soon.

&nbsp;

**Additional Info:**&nbsp;

For more information about the silverlight testing framework see: <http://www.jeff.wilcox.name/2008/03/31/silverlight2-unit-testing/>