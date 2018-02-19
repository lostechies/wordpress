---
id: 30
title: Changes/Refactorings to the Mvc Contrib project!
date: 2009-02-20T19:15:59+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/02/20/changes-refactorings-to-the-mvc-contrib-project.aspx
permalink: /2009/02/20/changes-refactorings-to-the-mvc-contrib-project/
dsq_thread_id:
  - "1080047442"
categories:
  - mvccontrib
---
&#160;

This <a href="http://groups.google.com/group/mvccontrib-discuss/browse_thread/thread/f0f43b4436908411?hl=en" target="_blank">message</a> was sent to the Mvc Contrib mailing lists.&#160; We are looking for feedback if you are a use of the MvcContrib project.


<span class="Apple-style-span"> 

<div>
  <p style="margin-left: 0.5in">
    As we get close to the release of the Asp.Net mvc framework it is time to take a look at what the contrib project has grown into organically and match that up with what we want to get out of the project to make sure everything is aligning.
  </p>
  
  <p style="margin-left: 0.5in">
    The goals of the project:
  </p>
  
  <p style="margin-left: 0.5in">
    <b>Ease of use/adoption:</b><span class="Apple-converted-space">&#160;</span>We want to position the MvcContrib project so that it is easy for someone new to the ASP.Net MVC framework to include and use the MvcContrib functionality.<span>&#160;&#160; <span class="Apple-converted-space">&#160;</span></span>The goal here is for frictionless and painless adoption.
  </p>
  
  <p style="margin-left: 0.5in">
    <b>Drive to conventions:</b><span class="Apple-converted-space">&#160;</span>We want to provide some opinions on how we think the framework should be used.<span class="Apple-converted-space">&#160;</span><span>&#160;</span><span>&#160;</span>This means making the conventions easy to discover and use.
  </p>
  
  <p style="margin-left: 0.5in">
    <b>Provide nice to have functionality:<span class="Apple-converted-space">&#160;</span></b>We are also willing to allow for some features that are infrequently used to still be easy to access, but this must be balanced with the first two goals.<span>&#160; </span>
  </p>
  
  <p style="margin-left: 0.5in">
    So, that leads us to the question of why are we bringing this up and what does that mean?
  </p>
  
  <p style="margin-left: 0.5in">
    We do see the MvcContrib project site being a central place to look for alternative implementations.<span>&#160;<span class="Apple-converted-space">&#160;</span></span>We may not host all of these in our project, but we could at least list all of them, view engines and IoC, than have links to their project homepages.<span>&#160;<span class="Apple-converted-space">&#160;</span></span>I see a lot of value in maintaining a complete list of known extensions.
  </p>
  
  <p style="margin-left: 0.5in">
    Here is a list of actions we want to take on the code base to support the goal.
  </p>
  
  <p style="margin-left: 1in;text-indent: -0.25in">
    <span><span>1.<span>&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Consolidate the existing mvc projects/assemblies down to four (4) projects.
  </p>
  
  <p style="margin-left: 1.25in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>MvcContrib
  </p>
  
  <p style="margin-left: 1.25in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>MvcContrib.Extras
  </p>
  
  <p style="margin-left: 1.25in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>MvcContrib.TestHelpers
  </p>
  
  <p style="margin-left: 1.25in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>MvcContrib.UnitTests
  </p>
  
  <p style="margin-left: 1in;text-indent: -0.25in">
    <span><span>2.<span>&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Add a dependency on the CommonServiceLocator to replace all of the IoC containers in the MvcContrib project.
  </p>
  
  <p style="margin-left: 1in;text-indent: -0.25in">
    <span><span>3.<span>&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Remove old dependencies that are available in their home projects:
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Ninject
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>StructureMap – provide links to the CSL implementation
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Unity – provide links to the CSL implementation
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Castle / Windsor – the Controller register could be pulled into documentation on the contrib project website.
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Spark – It is being maintained as a separate project, we should be pushing developers to it home page to get the most recent version of the project.
  </p>
  
  <p style="margin-left: 1in;text-indent: -0.25in">
    <span><span>4.<span>&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Deprecate and remove the following projects:
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Xslt View Engine
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Nvelocity
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Brail
  </p>
  
  <p style="margin-left: 1.5in;text-indent: -0.25in">
    <span style="font-family: symbol"><span>·<span>&#160;&#160;&#160;&#160;&#160;&#160;&#160; <span class="Apple-converted-space">&#160;</span></span></span></span>Spring
  </p>
  
  <p>
    <span style="font-weight: bold">At this point I would like to open up the discussion. Please make it know if you are relying on any of the functionality that is planned for removal.</span>
  </p></p>
</div>

<p>
  Thanks,
</p>

<div>
  Eric Hexter -&#160; MvcContrib Co-founder
</div>

<div>
  Jeffrey Palermo &#8211; MvcContrib Co-founder
</div>

<p>
  </span>
</p>