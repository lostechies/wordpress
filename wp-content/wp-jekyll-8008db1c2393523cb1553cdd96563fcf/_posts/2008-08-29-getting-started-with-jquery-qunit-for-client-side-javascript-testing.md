---
id: 83
title: Getting Started With jQuery QUnit for Client-Side Javascript Testing
date: 2008-08-29T02:26:06+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/28/getting-started-with-jquery-qunit-for-client-side-javascript-testing.aspx
permalink: /2008/08/29/getting-started-with-jquery-qunit-for-client-side-javascript-testing/
dsq_thread_id:
  - "262114058"
categories:
  - jQuery
  - QUnit
---
# Setup

First of all, I’m assuming you’re already using [jQuery](http://www.jquery.com). If not, you should be :) QUnit may help you for non-jQuery testing, but it’ll work better with jQuery. 

Second, you should start by downloading and setting up QUnit ([from this link](http://docs.jquery.com/QUnit)).&#160; QUnit consists of a single JS file (testrunner.js) and a CSS file (testsuite.css).

Third, I recommend grabbing a patched testrunner.js from here ([Ticket 3215](http://dev.jquery.com/ticket/3215)).&#160; We, at Dovetail, submitted this patch to the jQuery team. Some of the changes were accepted, some weren’t (and then the ticket was surreptitiously closed! How rude!).&#160; One particular feature that was NOT accepted was the beforeEach/afterEach additions to achieve xUnit-style SetUp and TearDown (before each test/after each test) behavior.&#160; I don’t know about you, but I consider SetUp/TearDown a critical feature for any would-be xUnit framework, regardless of language/platform.

# Your First QUnit Test

To start testing, you’ll need to start by creating an HTML page (MyFooTests.htm, for example).&#160; This page will need to reference the jquery core JS file, testrunner.js, testsuite.css, as well as the JS file containing the code you’re going to be testing. Lastly, the page will need some special HTML at the bottom with well-known ID’s so that QUnit can display its output.&#160; When you’re done, you should have a rough skeleton like this:

<div class="csharpcode-wrapper">
  <pre>&lt;!DOCTYPE html PUBLIC <span class="str">"-//W3C//DTD XHTML 1.0 Transitional//EN"</span> <span class="str">"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"</span>&gt;
&lt;html xmlns=<span class="str">"http://www.w3.org/1999/xhtml"</span> &gt;
&lt;head&gt;
    &lt;title&gt;My Foo Tests&lt;/title&gt;    
    &lt;script language=<span class="str">"javascript"</span> src=<span class="str">"../jquery-latest.js"</span> type=<span class="str">"text/javascript"</span>&gt;&lt;/script&gt;
    &lt;script language=<span class="str">"javascript"</span> src=<span class="str">"testrunner.js"</span> type=<span class="str">"text/javascript"</span>&gt;&lt;/script&gt;
    &lt;!-- add a script reference to your library here --&gt;
    &lt;link media=<span class="str">"screen"</span> href=<span class="str">"testsuite.css"</span> type=<span class="str">"text/css"</span> rel=<span class="str">"stylesheet"</span>/&gt;    
&lt;/head&gt;
&lt;body&gt;

&lt;script language=<span class="str">"javascript"</span> type=<span class="str">"text/javascript"</span>&gt;

qUnitTesting(<span class="kwrd">function</span>(config){

    config.beforeEach = <span class="kwrd">function</span>(){
    }
    
    config.afterEach = <span class="kwrd">function</span>(){
    }
    
    <span class="rem">//TODO: Modules and tests go here</span>
});

&lt;/script&gt;

        &lt;h1&gt;My Foo Tests&lt;/h1&gt;
        &lt;h2 id=<span class="str">"banner"</span>&gt;&lt;/h2&gt;
        &lt;ol id=<span class="str">"tests"</span>&gt;&lt;/ol&gt;
        &lt;div id=<span class="str">"results"</span>&gt;&lt;/div&gt;
        &lt;div id=<span class="str">"main"</span>&gt;&lt;/div&gt;        
        
        &lt;!-- Any HTML you may require <span class="kwrd">for</span> your tests to work properly --&gt;
        
&lt;/body&gt;
&lt;/html&gt;</pre>
</div>

If you save that HTML and open it in a browser, you should see something to the effect of:

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="214" alt="image" src="http://lostechies.com/chadmyers/files/2011/03GettingStartedWithjQueryQUnitforClientSi_12D1D/image_thumb.png" width="244" border="0" />](http://lostechies.com/chadmyers/files/2011/03GettingStartedWithjQueryQUnitforClientSi_12D1D/image_2.png) 

## Modules and Tests

QUnit has the concept of “modules” and “tests.”&#160; Tests are, like you would expect, the individual test cases. Modules are merely grouping mechanisms to organize the display of tests on the results screen.

Let’s create our first module and first test case.&#160; To keep things simple and illustrative for this blog post, I’m merely going to test that the show() and hide() methods in jQuery work properly.&#160; Normally you would want to avoid testing framework stuff (assume it’s already well-tested unless proven otherwise).

First, near the bottom of the HTML, before the closing </body> tag, add a div with an id “testDiv”:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">&lt;</span><span class="html">div</span> <span class="attr">id</span><span class="kwrd">="testDiv"</span><span class="kwrd">&gt;&lt;/</span><span class="html">div</span><span class="kwrd">&gt;</span></pre>
</div>

Then, up higher, where the “TODO” is in our JavaScript, add a new test, like so:

<div class="csharpcode-wrapper">
  <pre>module(<span class="str">"Show and Hide"</span>);

test(<span class="str">"should hide the element when hide is called"</span>, <span class="kwrd">function</span>(){

    $(<span class="str">"#testDiv"</span>).hide();

    <span class="rem">// actual, expected</span>
    equals($(<span class="str">"#testDiv"</span>).css(<span class="str">"display"</span>), <span class="str">"none"</span>, <span class="str">"The element should be hidden"</span>);
});

test(<span class="str">"should show the element when show is called"</span>, <span class="kwrd">function</span>(){

    <span class="rem">// Arrange</span>
    $(<span class="str">"#testDiv"</span>).css(<span class="str">"display"</span>, <span class="str">"none"</span>);
    
    <span class="rem">// Act</span>
    $(<span class="str">"#testDiv"</span>).show();

    <span class="rem">// Assert</span>
    <span class="rem">// actual, expected</span>
    equals($(<span class="str">"#testDiv"</span>).css(<span class="str">"display"</span>), <span class="str">"block"</span>, <span class="str">"The element should be visible"</span>);
}); </pre>
</div>

Which should yield two successes:

[<img style="border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: 0px" height="382" alt="image" src="http://lostechies.com/chadmyers/files/2011/03GettingStartedWithjQueryQUnitforClientSi_12D1D/image_thumb_1.png" width="508" border="0" />](http://lostechies.com/chadmyers/files/2011/03GettingStartedWithjQueryQUnitforClientSi_12D1D/image_4.png) </p> </p> </p> </p> </p> </p> 

# Where to go from here?

For me, QUnit opened up the possibility for serious TDD with client-side JavaScript. Previously, quality with my JavaScript code was always an issue and it never seemed that manual testing was enough.&#160; With QUnit, I can breathe a little easier now.

If I can catch some time in the next few weeks, I’ll do a post or two on how mocking works in JavaScript (or rather, why it’s so dirt simple it’s almost not worth talking about), and then even show how to integrate your QUnit tests into your CI build (which isn’t as hard as you might think).