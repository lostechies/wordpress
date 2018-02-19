---
id: 120
title: Asynchronous JavaScript Testing with QUnit
date: 2008-12-22T18:24:12+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/12/22/asynchronous-javascript-testing-with-qunit.aspx
permalink: /2008/12/22/asynchronous-javascript-testing-with-qunit/
dsq_thread_id:
  - "262239805"
categories:
  - QUnit
---
I’m implementing a feature that does some stuff when an IFRAME is finished loading.&#160; Due to the inherent asynchronous nature of this functionality, it was hard to test.&#160; I was trying to use QUnit, but having issues, until I found this post:

<http://markdotmeyer.blogspot.com/2008/07/javascript-unit-testing-with-qunit.html>

The summary?&#160; Check out the stop() and start() functions.

Now, I can write my test like this:

<div>
  <pre>test(<span class="str">"addWindow should remove the loadingStauts div after the iframe is loaded"</span>, <span class="kwrd">function</span>() {
    
    <span class="kwrd">var</span> loadingStatus = $(<span class="str">"&lt;div&gt;&lt;/div&gt;"</span>).attr(<span class="str">"id"</span>, <span class="str">"loadingDiv"</span>);
    
    <span class="kwrd">var</span> stack = $(<span class="str">"&lt;div&gt;&lt;/div&gt;"</span>)
                    .attr(<span class="str">"id"</span>, <span class="str">"stackDiv"</span>)
                    .appendTo(<span class="str">"#stack"</span>)
                    .windowStack()
                    .withLoadingStatus(loadingStatus);

    stack[0].addWindow(<span class="str">"Blank_for_iframe_testing.htm"</span>, <span class="str">""</span>);

    stop();

    setTimeout(<span class="kwrd">function</span>() {
        equals(loadingStatus[0].parentNode, <span class="kwrd">null</span>, <span class="str">"loadingStatus DIV should be removed after the iframe is loaded"</span>);
        start();
    }, 500);
});</pre>
</div>