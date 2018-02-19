---
id: 50
title: 'Making a Unit Test Framework agnostic Assertion in C#'
date: 2009-06-18T17:49:48+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/18/making-a-unit-test-framework-agnostic-assertion-in-c.aspx
permalink: /2009/06/18/making-a-unit-test-framework-agnostic-assertion-in-c/
dsq_thread_id:
  - "262809323"
categories:
  - .Net
  - altnetseattle
  - 'c#'
  - mvccontrib
  - testing
  - Tools
  - Unittests
---
&#160;

At the beginning of the year I got some feedback that the assertions in the MvcContrib.TestHelper library were great and very useful but the problem with them is that we relyed on the NUnit assertions.&#160; This was a problem for some users as they did not use nunit and did not want to include that dll in their codebase.&#160; I also have been frustrated because NUnit is strongly named and since I am using other framework that add a little extra on top of nunit I have found that I know need to add all sorts of Assembly Redirect configuration in my app.config files in order to trick all&#160; of the assemblies I am using to think they have the right version of NUnit.&#160;&#160; It is quite a big mess when you really think about it.

So at the Alt.Net conference in Seattle I proposed a session to talk about Unit Test Framework agnostic assertions and helpers. I was quite lucky to have some very smart people in the room and on the kyte.tv feeds.&#160; The end result that came out of the was this.&#160; Just throw a custom exception and the test frameworks will pick it up.&#160; I was told that this is how Rhino Mocks handles it’s assertions and that the test frameworks would eventually add my namespace to there code base so that the Call stack reported to the developer running his tests would not see the frames that were used internally by my assertions. Let me give you a visual so that it is a little easier to understand exactly what the problem is….

The first line in this example shows a line that is from my special assertion code.&#160; I do not want that to show up when a user runs a unit test with my assertion.

&#160; <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_78309898.png" width="1134" height="95" />

Here is my little assertion helper example.&#160; Since I just created a standard exception I got the default behavior.</p> 

 <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_1E927BE4.png" width="1028" height="226" />

&#160;

The way to fix this is to throw a special exception which knows how to remove specific frames out of the call stack.&#160; This code was adapted from the xUnit source code and is working quite well in the MvcContrib Test Helper Library

 <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_3D68EFC2.png" width="1028" height="571" />

With some simple string manipulation of removing lines that contain the namespace of my exception it is really easy to reuse this exception in an Unit Test framework Agnostic helper library.

&#160;

Here is the result of an assertion that failed using this assertion.&#160; As you can see the test runner does not show lines that my assertion framework contain the call stack stops at the last line in my unit test code.&#160; Which is exactly what we want.&#160; That way there is no question as to where the developer using this needs to look to get information about the test failure.

 <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_4192C787.png" width="1207" height="232" /></p> 

This code is located in the MvcContrib TestHelper library located at <http://MvcContrib.org> in case you want to dig deeper into the code.&#160; I hope this helps others as it really took some time to get to this approach.. It seemed totally obvious to the developers of the unit test frameworks but for us mere mortals it took a little extra digging to really understand how the Unit Test runners work.&#160; 

&#160;

Comments .. Questions ???