---
id: 61
title: Hosting an entire ASP.NET MVC request for testing purposes
date: 2008-06-25T02:11:37+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/06/24/hosting-an-entire-asp-net-mvc-request-for-testing-purposes.aspx
permalink: /2008/06/25/hosting-an-entire-asp-net-mvc-request-for-testing-purposes/
dsq_thread_id:
  - "262113854"
categories:
  - ASP.NET MVC
  - TDD
---
We&#8217;ve been playing around a lot with the ASP.NET MVC Preview 3 at Dovetail and trying to find various ways to test at various levels.  One of the levels we were toying with was doing an end-to-end test including URL routing, controller action, and view result rendering.  Unfortunately it&#8217;s still pretty complicated due to a lot of coupling in the bowels of the routing, controller invocation, and view rendering pieces but we were able to get an in-process host for fast-feedback testing without the need to fire up a browser or consult IIS.

The code and a few other things related this post can be found here: [http://www.lostechies.com/blogs/chad_myers/MVCRequestTesting.zip](http://lostechies.com/chadmyers/files/2011/03/Hostinga.NETMVCrequestfortestingpurposes_11DB3/MVCRequestTesting.zip "http://www.lostechies.com/blogs/chad_myers/MVCRequestTesting.zip")

## Hosting the ASP.NET Runtime

In order to process the first request, I found I had to do a number of things to prime the ASP.NET pump as well as ASP.NET MVC in order to process the first request. These steps include:

  1. Creating an application host in a separate AppDomain using ApplicationHost.CreateApplicationHost()
  2. Prime the ASP.NET engine with a bogus first request
  3. Execute the URL to a StringWriter and then return the result

Here&#8217;s a cheesy visualization that will hopefully illustrate things a little better:

![](http://lostechies.com/chadmyers/files/2011/03/Hostinga.NETMVCrequestfortestingpurposes_11DB3/mvc_request_test_2.png)

## Creating An Application Host and Initializing ASP.NET

First, you&#8217;ll need a class that will be created in the other app domain. In order to talk across app domain boundaries, the class will have to derive from System.MarshalByRefObject (heretofore known as MBRO).  For those not already familiar with MBRO&#8217;s, MBRO&#8217;s allow a class to be called from a remote application domain (including those in separate processes or even separate machines) and have the calls marshaled back to the object&#8217;s real physical location, executed, and then the results marshaled back to the caller.  The magic happens in the object&#8217;s home AppDomain, but things appear to be happening at the call site.  Nifty when you need such behavior, but it&#8217;s not without it&#8217;s own pitfalls (which are out of the scope of this article, unfortunately).

The humble TestASPAppHost object starts out looking like this (basic MBRO starter implementation):

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> <span class="kwrd">using</span> System;</pre>
    
    <pre><span class="lnum">   2:</span></pre>
    
    <pre><span class="lnum">   3:</span> <span class="kwrd">namespace</span> MVCRequestTesting.Web</pre>
    
    <pre><span class="lnum">   4:</span> {</pre>
    
    <pre><span class="lnum">   5:</span>     <span class="kwrd">public</span> <span class="kwrd">class</span> TestASPAppHost : MarshalByRefObject</pre>
    
    <pre><span class="lnum">   6:</span>     {</pre>
    
    <pre><span class="lnum">   7:</span>         <span class="kwrd">public</span> <span class="kwrd">override</span> <span class="kwrd">object</span> InitializeLifetimeService()</pre>
    
    <pre><span class="lnum">   8:</span>         {</pre>
    
    <pre><span class="lnum">   9:</span>             <span class="rem">// This tells the CLR not to surreptitiously </span></pre>
    
    <pre><span class="lnum">  10:</span>             <span class="rem">// destroy this object -- it's a singleton</span></pre>
    
    <pre><span class="lnum">  11:</span>             <span class="rem">// and will live for the life of the appdomain</span></pre>
    
    <pre><span class="lnum">  12:</span>             <span class="kwrd">return</span> <span class="kwrd">null</span>;</pre>
    
    <pre><span class="lnum">  13:</span>         }</pre>
    
    <pre><span class="lnum">  14:</span>     }</pre>
    
    <pre><span class="lnum">  15:</span> }</pre>
  </div>
</div>

In order to start the ASP.NET stuff, you need to look at the System.Web.Hosting.ApplicationHost object and it&#8217;s CreateApplicationHost method.  All this does is create an instance of your object in a new app domain and return a wrapped object reference to you.  I like to encapsulate this stuff as a static &#8216;factory&#8217;-type method on the object itself to keep things neat and tidy for the caller, so I added a method called GetHost which takes the physical path to where the web root will be. In my example, I have two projects in a solution: The MVC web app project (MVCRequestTesting.Web) and the integration test project (MVCRequestTesting.IntegrationTesting).  So my physical path will the MVCRequestTesting.Web root folder.  I&#8217;ll need to access this path relatively from where the NUnit tests are actually being run which can get a bit tricky. More on that later. For right now, here&#8217;s what my GetHost method looks like:

&nbsp;

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> <span class="kwrd">public</span> <span class="kwrd">static</span> TestASPAppHost GetHost(<span class="kwrd">string</span> webRootPath)</pre>
    
    <pre><span class="lnum">   2:</span> {</pre>
    
    <pre><span class="lnum">   3:</span>     var host = (TestASPAppHost)ApplicationHost.CreateApplicationHost(</pre>
    
    <pre><span class="lnum">   4:</span>                                    <span class="kwrd">typeof</span>(TestASPAppHost),</pre>
    
    <pre><span class="lnum">   5:</span>                                    <span class="str">"/test"</span>,</pre>
    
    <pre><span class="lnum">   6:</span>                                    webRootPath);</pre>
    
    <pre><span class="lnum">   7:</span></pre>
    
    <pre><span class="lnum">   8:</span>     <span class="rem">// Run a bogus request through the pipeline to wake up ASP.NET and initialize everything</span></pre>
    
    <pre><span class="lnum">   9:</span>     host.InitASPNET();</pre>
    
    <pre><span class="lnum">  10:</span></pre>
    
    <pre><span class="lnum">  11:</span>     <span class="kwrd">return</span> host;</pre>
    
    <pre><span class="lnum">  12:</span> }</pre>
    
    <pre><span class="lnum">  13:</span></pre>
    
    <pre><span class="lnum">  14:</span> <span class="kwrd">public</span> <span class="kwrd">void</span> InitASPNET()</pre>
    
    <pre><span class="lnum">  15:</span> {</pre>
    
    <pre><span class="lnum">  16:</span>     HttpRuntime.ProcessRequest(<span class="kwrd">new</span> SimpleWorkerRequest(<span class="str">"/default.aspx"</span>, <span class="str">""</span>, <span class="kwrd">new</span> StringWriter()));</pre>
    
    <pre><span class="lnum">  17:</span> }</pre>
  </div>
</div>

The &#8216;host&#8217; variable actually lives in the other app domain. What we know as &#8216;host&#8217; is actually a wrapped object reference. All calls to host.Foo will be marshaled to the other app domain, executed there, and the results marshaled back.

There&#8217;s one last thing we need to worry about: The Web path.  It must be relative from where the testing assembly is, but this can be tricky. When running in the debugger in Visual Studio, it&#8217;s going to be in the binDebug dir of the IntegrationTesting project. When run from the NUnit runner (console or GUI), it&#8217;s going to assembly shadow copying, so it&#8217;ll be in some funky path like c:userschadAppDataLocalDatablahblahblah.

It turns out that we don&#8217;t want to just use the Assembly.Location. We can use the Assembly.CodeBase. Unfortunately, CodeBase is in the URI format, so it doesn&#8217;t work with the System.IO.Path convenience methods. Yadda yadda. Anyhow, I wrote a convenience method that lets you specify the relative path from the testing assembly code base (i.e. binDebug) regardless of where it&#8217;s being run from:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> <span class="kwrd">public</span> <span class="kwrd">static</span> TestASPAppHost GetHostRelativeToAssemblyPath(<span class="kwrd">string</span> relativePath)</pre>
    
    <pre><span class="lnum">   2:</span> {</pre>
    
    <pre><span class="lnum">   3:</span>     <span class="kwrd">string</span> asmFilePath = <span class="kwrd">new</span> Uri(<span class="kwrd">typeof</span>(TestASPAppHost).Assembly.CodeBase).LocalPath;</pre>
    
    <pre><span class="lnum">   4:</span>     <span class="kwrd">string</span> asmPath = Path.GetDirectoryName(asmFilePath);</pre>
    
    <pre><span class="lnum">   5:</span>     <span class="kwrd">string</span> fullPath = Path.Combine(asmPath, relativePath);</pre>
    
    <pre><span class="lnum">   6:</span>     fullPath = Path.GetFullPath(fullPath);</pre>
    
    <pre><span class="lnum">   7:</span></pre>
    
    <pre><span class="lnum">   8:</span>     <span class="kwrd">return</span> GetHost(fullPath);</pre>
    
    <pre><span class="lnum">   9:</span> }</pre>
  </div>
</div>

So now it&#8217;s easy to get an app host set up and pointed to your web project folder regardless of the context in which the tests are being run. For example:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> var host = TestASPAppHost.GetHostRelativeToAssemblyPath(<span class="str">@"......MVCRequestTesting.Web"</span>);</pre>
  </div>
</div>

## Executing an MVC Request and Getting a Response

Now comes the fun part.  Here&#8217;s what I want my test to look something like this:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> var host = TestASPAppHost.GetHostRelativeToAssemblyPath(<span class="str">@"......MVCRequestTesting.Web"</span>);</pre>
    
    <pre><span class="lnum">   2:</span> var htmlResult = host.ExecuteMvcUrl(<span class="str">"Home/Index"</span>, <span class="str">""</span>);</pre>
    
    <pre><span class="lnum">   3:</span> Assert.That(htmlResult, Text.Contains(<span class="str">"&lt;h2&gt;Welcome to ASP.NET MVC!&lt;/h2&gt;"</span>));</pre>
  </div>
</div>

The last trick is to actually execute a request through the ASP.NET and MVC pipelines, get the resultant HTML and then be able to execute tests on it. So here&#8217;s the coup de grâce that enables all of this: Behold the ExecuteMvcUrl method:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> <span class="kwrd">public</span> <span class="kwrd">string</span> ExecuteMvcUrl(<span class="kwrd">string</span> url, <span class="kwrd">string</span> query)</pre>
    
    <pre><span class="lnum">   2:</span> {</pre>
    
    <pre><span class="lnum">   3:</span>     var writer = <span class="kwrd">new</span> StringWriter();</pre>
    
    <pre><span class="lnum">   4:</span>     var request = <span class="kwrd">new</span> SimpleWorkerRequest(url, query, writer);</pre>
    
    <pre><span class="lnum">   5:</span>     var context = HttpContext.Current = <span class="kwrd">new</span> HttpContext(request);</pre>
    
    <pre><span class="lnum">   6:</span>     var contextBase = <span class="kwrd">new</span> HttpContextWrapper2(context);</pre>
    
    <pre><span class="lnum">   7:</span>     var routeData = RouteTable.Routes.GetRouteData(contextBase);</pre>
    
    <pre><span class="lnum">   8:</span>     var routeHandler = routeData.RouteHandler;</pre>
    
    <pre><span class="lnum">   9:</span>     var requestContext = <span class="kwrd">new</span> RequestContext(contextBase, routeData);</pre>
    
    <pre><span class="lnum">  10:</span>     var httpHandler = routeHandler.GetHttpHandler(requestContext);</pre>
    
    <pre><span class="lnum">  11:</span>     httpHandler.ProcessRequest(context);</pre>
    
    <pre><span class="lnum">  12:</span>     context.Response.End();</pre>
    
    <pre><span class="lnum">  13:</span>     writer.Flush();</pre>
    
    <pre><span class="lnum">  14:</span>     <span class="kwrd">return</span> writer.GetStringBuilder().ToString();</pre>
    
    <pre><span class="lnum">  15:</span> }</pre>
  </div>
</div>

Awesome isn&#8217;t it?  No? Not really? Yeah, it made me feel a little dirty, too. Unfortunately there&#8217;s a lot of tight coupling going on all over the place, so it&#8217;s difficult to be able to go from request to HTML without setting up a bunch of things first.  The biggest culprit, unfortunately, is the routing/URL handling stuff. But, being tucked away in the corner of our testing host, it&#8217;s not too bad because it enables simple testing as demonstrated above.

## Running the Test

Finally, I used TestDriven.NET to run the test (or you can use R#&#8217;s UnitRunner or the NUnit Gui/Console runner) and got:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> ------ Test started: Assembly: MVCRequestTesting.IntegrationTesting.dll ------</pre>
    
    <pre><span class="lnum">   2:</span></pre>
    
    <pre><span class="lnum">   3:</span></pre>
    
    <pre><span class="lnum">   4:</span> 1 passed, 0 failed, 0 skipped, took 7.61 seconds.</pre>
  </div>
</div>

<div class="csharpcode">
  <p>
    <span style="font-family: 'Trebuchet MS';">The code and a few other things related this post can be found here: </span><a title="http://www.lostechies.com/blogs/chad_myers/MVCRequestTesting.zip" href="http://www.lostechies.com/blogs/chad_myers/MVCRequestTesting.zip"><span style="font-family: 'Trebuchet MS';">http://www.lostechies.com/blogs/chad_myers/MVCRequestTesting.zip</span></a>
  </p>
</div>