---
id: 91
title: Catching Arguments with Rhino Mocks
date: 2008-09-26T01:29:28+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/09/25/catching-arguments-with-rhino-mocks.aspx
permalink: /2008/09/26/catching-arguments-with-rhino-mocks/
dsq_thread_id:
  - "262114103"
categories:
  - Extension Methods
  - Mocks
---
I’ve noticed that in quite a few of my tests, I was using a mock simply to test one argument on one of the methods called.&#160; Maybe I was making sure it passed a correctly formatted string, the right date/time, or whatever.&#160; There was a lot of setup and overhead (even using the new AAA syntax in Rhino Mocks) just to catch one argument.&#160; While pairing with [Josh Flanagan](http://joshuaflanagan.lostechies.com), he said, “Wouldn’t it be cool if you could just catch the argument rather than having to go through all the mock setup stuff? I think Jeffrey Palermo did something like this.”&#160; Sure enough, he was right.&#160; We found [this post which was almost exactly what we wanted](http://codebetter.com/blogs/jeffrey.palermo/archive/2007/10/02/generic-constraint-for-rhino-mocks-make-unit-tests-more-readable.aspx). It was a little behind the times, however, since it didn’t account for some .NET 3.5 features (namely lambda expressions and expression trees) nor the new AAA syntax.&#160; We decided to take a few minutes and update it and this is what we came up with!

## CapturingConstraint

First, we decided to use the same approach Jeffrey did by using the Constraint functionality in Rhino Mocks and came up with this:

&#160;

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> <span class="kwrd">public</span> <span class="kwrd">class</span> CapturingConstraint : AbstractConstraint{</pre>
    
    <pre><span class="lnum">   2:</span>     <span class="kwrd">private</span> <span class="kwrd">readonly</span> ArrayList argList = <span class="kwrd">new</span> ArrayList();</pre>
    
    <pre><span class="lnum">   3:</span>&#160; </pre>
    
    <pre><span class="lnum">   4:</span>     <span class="kwrd">public</span> <span class="kwrd">override</span> <span class="kwrd">bool</span> Eval(<span class="kwrd">object</span> obj)</pre>
    
    <pre><span class="lnum">   5:</span>     {</pre>
    
    <pre><span class="lnum">   6:</span>         argList.Add(obj);</pre>
    
    <pre><span class="lnum">   7:</span>         <span class="kwrd">return</span> <span class="kwrd">true</span>;</pre>
    
    <pre><span class="lnum">   8:</span>     }</pre>
    
    <pre><span class="lnum">   9:</span>&#160; </pre>
    
    <pre><span class="lnum">  10:</span>     <span class="kwrd">public</span> T First&lt;T&gt;(){</pre>
    
    <pre><span class="lnum">  11:</span>         <span class="kwrd">return</span> ArgumentAt&lt;T&gt;(0);</pre>
    
    <pre><span class="lnum">  12:</span>     }</pre>
    
    <pre><span class="lnum">  13:</span>&#160; </pre>
    
    <pre><span class="lnum">  14:</span>     <span class="kwrd">public</span> T ArgumentAt&lt;T&gt;(<span class="kwrd">int</span> pos){</pre>
    
    <pre><span class="lnum">  15:</span>         <span class="kwrd">return</span> (T) argList[pos];</pre>
    
    <pre><span class="lnum">  16:</span>     }</pre>
    
    <pre><span class="lnum">  17:</span>&#160; </pre>
    
    <pre><span class="lnum">  18:</span>     <span class="kwrd">public</span> <span class="kwrd">override</span> <span class="kwrd">string</span> Message{</pre>
    
    <pre><span class="lnum">  19:</span>         get { <span class="kwrd">return</span> <span class="str">""</span>; }</pre>
    
    <pre><span class="lnum">  20:</span>     }</pre>
    
    <pre><span class="lnum">  21:</span>&#160; </pre>
    
    <pre><span class="lnum">  22:</span>     <span class="kwrd">public</span> T Second&lt;T&gt;(){</pre>
    
    <pre><span class="lnum">  23:</span>         <span class="kwrd">return</span> ArgumentAt&lt;T&gt;(1);</pre>
    
    <pre><span class="lnum">  24:</span>     }</pre>
    
    <pre><span class="lnum">  25:</span> }</pre></p>
  </div>
</div>

&#160;

This class captures everything Rhino Mocks throws at it. You can access the parameters, in order, by using the ArgumentAt method. It’ll also do the casing for you using a Generic type.&#160; We also added convenience methods for the first and second arguments since 99% of the time that’s all we cared about.

## CaptureArgumentsFor Extension Method

The next thing we did is to add an extension method to System.Object to allow you to specify which method’s arguments you wish to capture.&#160; Unfortunately we had to add an extension method to System.Object which is usually not a good thing to do, but our mocks could be of any type, so we couldn’t get more specific than that.&#160; Also, this extension method is only available in our unit testing code, so this crime again Extension Methods is fairly localized.

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> <span class="kwrd">public</span> <span class="kwrd">static</span> CapturingConstraint CaptureArgumentsFor&lt;MOCK&gt;(<span class="kwrd">this</span> MOCK mock, Expression&lt;Action&lt;MOCK&gt;&gt; methodExpression)</pre>
    
    <pre><span class="lnum">   2:</span> {</pre>
    
    <pre><span class="lnum">   3:</span>     var method = ReflectionHelper.GetMethod(methodExpression);</pre>
    
    <pre><span class="lnum">   4:</span>&#160; </pre>
    
    <pre><span class="lnum">   5:</span>     var constraint = <span class="kwrd">new</span> CapturingConstraint();</pre>
    
    <pre><span class="lnum">   6:</span>     var constraints = <span class="kwrd">new</span> List&lt;AbstractConstraint&gt;();</pre>
    
    <pre><span class="lnum">   7:</span>&#160; </pre>
    
    <pre><span class="lnum">   8:</span>     <span class="kwrd">foreach</span>( var arg <span class="kwrd">in</span> method.GetParameters())</pre>
    
    <pre><span class="lnum">   9:</span>     {</pre>
    
    <pre><span class="lnum">  10:</span>         constraints.Add(constraint);</pre>
    
    <pre><span class="lnum">  11:</span>     }</pre>
    
    <pre><span class="lnum">  12:</span>&#160; </pre>
    
    <pre><span class="lnum">  13:</span>     mock.Expect(methodExpression.Compile()).Constraints(constraints.ToArray());</pre>
    
    <pre><span class="lnum">  14:</span>&#160; </pre>
    
    <pre><span class="lnum">  15:</span>     <span class="kwrd">return</span> constraint;</pre>
    
    <pre><span class="lnum">  16:</span> }</pre></p>
  </div>
</div>

## Usage Example

Finally, our test ends up a bit more simple and looks something like this:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> [Test]</pre>
    
    <pre><span class="lnum">   2:</span> <span class="kwrd">public</span> <span class="kwrd">void</span> should_correctly_assemble_the_notification_batch_with_the_context_and_template_group()</pre>
    
    <pre><span class="lnum">   3:</span> {</pre>
    
    <pre><span class="lnum">   4:</span>     Services.PartialMockTheClassUnderTest();</pre>
    
    <pre><span class="lnum">   5:</span>     </pre>
    
    <pre><span class="lnum">   6:</span>     var argCatcher = ClassUnderTest.CaptureArgumentsFor(a =&gt; a.ExecuteBatch(<span class="kwrd">null</span>, <span class="kwrd">null</span>));</pre>
    
    <pre><span class="lnum">   7:</span>&#160; </pre>
    
    <pre><span class="lnum">   8:</span>     ClassUnderTest.Execute(_context);</pre>
    
    <pre><span class="lnum">   9:</span>&#160; </pre>
    
    <pre><span class="lnum">  10:</span>     var batch = argCatcher.Second&lt;UserMessageBatch&gt;();</pre>
    
    <pre><span class="lnum">  11:</span>     </pre>
    
    <pre><span class="lnum">  12:</span>     batch.Resolver.ShouldBeTheSameAs(_context);</pre>
    
    <pre><span class="lnum">  13:</span>     batch.Group.ShouldBeTheSameAs(ClassUnderTest.TemplateGroup);</pre>
    
    <pre><span class="lnum">  14:</span> }</pre></p>
  </div>
</div>