---
id: 47
title: Opinionated Input Builders Part 6 – Performance of the builders
date: 2009-06-13T17:15:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx
permalink: /2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders/
dsq_thread_id:
  - "262527819"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - CoC
  - mvccontrib
---
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx" target="_blank">Part 1 – Overview</a> 
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx" target="_blank">Part 2 – the Labe</a>l 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx" target="_blank">Part 3 – the Source Code</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx" target="_blank">Part 4 – the Partial View</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx" target="_blank">Part 5 – the Required Field Indicator</a>&#160; 
  * Part 6 – the Performance 

**<font color="#ff0000">Update &#8211; 6/14/2009</font>** [Chad Myers blogged about the trade offs and the importance of productivity over premature optimizations](/blogs/chad_myers/archive/2009/06/14/on-the-performance-of-opinionated-builders.aspx).

<font color="#ff0000"><strong>Update 6 /14/2009</strong>&#160;</font>– <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/14/opinionated-input-builders-part-7-more-on-performance-take-2.aspx" target="_blank">Please see the second set of tests I ran for a large performance increase.</a>

&#160;

Multiple people asked about the performance implications of using this style of input builders.&#160; First let me say that as far as performance, using the partial views is probably the least efficient way to render html.&#160; But with every approach there are tradeoffs. In this case we are trading run time performance for developer productivity and codebase and user interface consistency. That being said I cannot answer what the best approach is for you. That depends on the size of your team , the size of your project, the skill set of your team and a number of other aspects which determine what the best approach is.&#160; For instance I would not use input builders or a MVC view if I was building a form to collect votes for American Idol.&#160; I would actually create the forms in static html pages.&#160; The scalability would require the best performing solution.

&#160;

&#160;

### The Control Test

With any good test you have to have a control case. In this case I ran a load test against an empty MVC view that was using the same Master Page as my form page.&#160; I ran a constant load against that page in IIS 7, on a x64 Vista OS for 10 minutes.&#160; The results is that I have a maximum Request / Second of **1,622** and an Average Requests / Second of **1,275**. You can see the chart below of the Requests/Second.

<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="//lostechies.com/erichexter/files/2011/03/image_20D7B973.png" width="1028" height="216" />

### The Load Test

Next I ran the same test against the page I have used for all of the samples in this series.&#160; With the same load , machine configuration, and duration as the control test.&#160; In this case my Maximum Requests/Second was **442** and the Average Requests/Second were **351**.&#160; What does that mean?&#160; I lost **75%** of my page request through put by using the Input Builders. Does this mean we should not use the input builders?&#160; The answer is … it depends.&#160; What through put do you need? From my experience I have found that most forms backed by a data store cannot scale to 400 Requets / Sec without some significant architectural principles in play.&#160; Such as asynchronous messaging and other methods to scale.&#160; 

 <img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="//lostechies.com/erichexter/files/2011/03/image_22A80F3A.png" width="1028" height="380" />

### &#160;

### What are the next steps for performance?

The next step for me is running the load test with a Profiler attached to the process.&#160; I used the JetBrains Dot Trace application.&#160; It is nice because after I run the profile session and analyze the data it has a quick and dirty Hot Spot report.&#160; This show the single biggest offender of my codebase.&#160; This means that if I optimize the code below that will have the biggest improvement for performance.&#160; It is a combination of the time it takes to execute this code combined with the number of times this code path is executed.&#160; That being said, lets dig into it.&#160; 

The 3rd call in this stack is part of the RenderPartial call I do not totally understand the internals of the MVC view engine and I will not pretend to. If I really wanted to see more it would make sense to pull down the MVC source code and build it with is symbol files, than the profiler could give me more information.&#160; So what I am surprised by is that my hunch when first thinking about performance would have taken me to the reflection and Lamda Expression code, but this test shows that the biggest bottle neck is in the control / partial rendering.&#160; So by using this tool I have saved myself a huge headache by preventing myself from optimizing the wrong code.&#160; At this point I am going to put this information together and get it in front of those in the .Net Community who are way smarter than I am and of course, get it to the brainiacs at Microsoft who wrote this stuff to suggest some approaches for better performance . They know their internal benchmarks as well as what they are planning for the future.&#160; 

The biggest lesson I can demonstrate here is do not pre optimize.&#160; I already wasted 20 minutes of my time and Jimmy Bogard’s time talking about different ways to optimize Lambda Expressions.&#160; It is clear that implementing those optimizations would not make a single difference in effecting the output of this performance test. 

<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="//lostechies.com/erichexter/files/2011/03/image_737623A2.png" width="1028" height="269" />

&#160;

### 

### Should you use the builders?

Well that decision is really up to you, but I hoped that I demonstrated a scientific approach to answering that question. For me the componentization of the HTML and the productivity increases of using the builders far outweigh the runtime performance issues.&#160; Again, I would take this on a case by case basis and when I need more throughput than what I can provide with this approach I would consider a different method of mark up generation.