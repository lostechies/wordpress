---
id: 104
title: Composing Statements with Expression Trees in .NET 3.0
date: 2008-10-28T02:59:50+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/10/27/composing-statements-with-expression-trees-in-net-3-0.aspx
permalink: /2008/10/28/composing-statements-with-expression-trees-in-net-3-0/
dsq_thread_id:
  - "262295062"
categories:
  - .NET
  - Expression Trees
---
I was preparing some examples for my upcoming [ALT.NET Workshop](http://www.lostechies.com/blogs/chad_myers/archive/2008/10/26/alt-net-workshops-internal-dsl-draft-outline-notes.aspx) and thought that this might be of some interest to a few people.

Expression Trees’ primary raison d&#8217;être was to facilitate LINQ-y type stuff in the IQueryable implementations to support delayed execution and some other fun stuff.&#160;&#160; Expression Trees, however, go much father than that. They are essentially a window in to the middle of the compilation process in .NET.&#160; Imagine if you could hit PAUSE on the C# or VB compiler in mid-compile and take a snapshot of its internal state/model of the code before it does the final step of writing out the MSIL.&#160; What if you could not only capture it, but you could manipulate and add to it before finishing the compilation and executing it? That’s exactly what Expression Trees are for (well, it doesn’t work EXACTLY like that, but it’s pretty close, close enough for this blog post anyhow). 

We use Expression Trees a lot at Dovetail, in StructureMap, Fluent NHibernate, and various other projects primarily as a trick for fast reflection (static reflection).&#160; But you can also compose whole new functionality with them to do some pretty crazy things. I don’t believe you could craft whole, complex programs via Expression Tree manipulation, but I would be delighted to be proven wrong in this statement.

## Composing Simple Programs with Expression Trees

In this heavily contrived, overly simplistic example, I have these requirements:

  * Grab the value of a property P off an object A 
  * Pass that value of A.P as an argument to a method B 
  * Call method B 

Assume that you don’t know, at compile time, that I don’t know what A, P, or B are.&#160; 

Let A be an instance of a class object.

Let B be a void method that takes one argument, of type System.Object ( i.e. void B(object));

> NOTE: There are probably easier ways of doing this particular example, so don’t go off and start getting crazy with Expression Trees. It’s my hope that someone may find this useful in a much more complex example for which there is no easier alternative.

Ok, ok, enough disclaimer, so me the code!&#160; First, a simple test which shows what we want to happen:&#160; Take the OrderID from the order and print it to the console. 

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> [Test]</pre>
    
    <pre><span class="lnum">   2:</span> <span class="kwrd">public</span> <span class="kwrd">void</span> hide_the_expression_tree_guts_in_another_method_below()</pre>
    
    <pre><span class="lnum">   3:</span> {</pre>
    
    <pre><span class="lnum">   4:</span>     var order = <span class="kwrd">new</span> Order {OrderID = <span class="str">"FUN!"</span>};</pre>
    
    <pre><span class="lnum">   5:</span>&#160; </pre>
    
    <pre><span class="lnum">   6:</span>     Get_prop_value_and_execute_method(</pre>
    
    <pre><span class="lnum">   7:</span>         order,</pre>
    
    <pre><span class="lnum">   8:</span>         o =&gt; o.OrderID,</pre>
    
    <pre><span class="lnum">   9:</span>         x =&gt; Console.WriteLine(x)</pre>
    
    <pre><span class="lnum">  10:</span>     );</pre>
    
    <pre><span class="lnum">  11:</span> }</pre></p>
  </div>
</div>

&#160;

Now, for the guts of Get\_prop\_value\_and\_execute_method:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span>&#160; </pre>
    
    <pre><span class="lnum">   2:</span> <span class="kwrd">public</span> <span class="kwrd">void</span> Get_prop_value_and_execute_method&lt;A&gt;(</pre>
    
    <pre><span class="lnum">   3:</span>     A target,</pre>
    
    <pre><span class="lnum">   4:</span>     Expression&lt;Func&lt;A, <span class="kwrd">object</span>&gt;&gt; propertyExpression,</pre>
    
    <pre><span class="lnum">   5:</span>     Expression&lt;Action&lt;<span class="kwrd">object</span>&gt;&gt; methodExpression)</pre>
    
    <pre><span class="lnum">   6:</span> {</pre>
    
    <pre><span class="lnum">   7:</span>&#160; </pre>
    
    <pre><span class="lnum">   8:</span>     <span class="rem">// Define the parameters for the various lambda expression</span></pre>
    
    <pre><span class="lnum">   9:</span>     <span class="rem">// i.e. the 'x' in (x =&gt; x.Foo)</span></pre>
    
    <pre><span class="lnum">  10:</span>     var parameters = propertyExpression.Parameters;</pre>
    
    <pre><span class="lnum">  11:</span>&#160; </pre>
    
    <pre><span class="lnum">  12:</span>     <span class="rem">// Create an 'Invoke' expression to actually execute the property P getter</span></pre>
    
    <pre><span class="lnum">  13:</span>     var getPropValueExpression = Expression.Invoke(</pre>
    
    <pre><span class="lnum">  14:</span>                                         propertyExpression,</pre>
    
    <pre><span class="lnum">  15:</span>                                         parameters.Cast&lt;Expression&gt;());</pre>
    
    <pre><span class="lnum">  16:</span>&#160; </pre>
    
    <pre><span class="lnum">  17:</span>     <span class="rem">// Create a 'Call' expression to call the function with the value of property P</span></pre>
    
    <pre><span class="lnum">  18:</span>     var methodBody = methodExpression.Body <span class="kwrd">as</span> MethodCallExpression;</pre>
    
    <pre><span class="lnum">  19:</span>     var methodCall = Expression.Call(methodBody.Method, getPropValueExpression);</pre>
    
    <pre><span class="lnum">  20:</span>&#160; </pre>
    
    <pre><span class="lnum">  21:</span>     <span class="rem">// Wrap it in a lambda so we can actually call it at runtime</span></pre>
    
    <pre><span class="lnum">  22:</span>     var finalCall = Expression.Lambda&lt;Action&lt;A&gt;&gt;(methodCall, parameters);</pre>
    
    <pre><span class="lnum">  23:</span>&#160; </pre>
    
    <pre><span class="lnum">  24:</span>     <span class="rem">// Compile the lambda to get an actual Action&lt;A&gt;</span></pre>
    
    <pre><span class="lnum">  25:</span>     var action = finalCall.Compile();</pre>
    
    <pre><span class="lnum">  26:</span>&#160; </pre>
    
    <pre><span class="lnum">  27:</span>     <span class="rem">// Execute it!</span></pre>
    
    <pre><span class="lnum">  28:</span>     action(target);</pre>
    
    <pre><span class="lnum">  29:</span> }</pre></p>
  </div>
</div>