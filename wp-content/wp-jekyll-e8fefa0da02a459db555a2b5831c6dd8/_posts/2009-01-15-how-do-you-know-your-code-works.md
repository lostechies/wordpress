---
id: 127
title: How do you know your code works?
date: 2009-01-15T03:44:05+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/01/14/how-do-you-know-your-code-works.aspx
permalink: /2009/01/15/how-do-you-know-your-code-works/
dsq_thread_id:
  - "262114281"
categories:
  - Code Examples
  - Code Specifications
  - Enforcement
  - Proof
---
[Warning: shameless Austin plug and a bunch of&#160; namedropping] 

Shortly after New Years, I was sitting outside (in a t-shirt, by the way) at an Irish Pub (or as close as we can get here in Ausitn), sipping Guinness with [Scott Bellware](http://blog.scottbellware.com/) and [Rod Paddock](http://codebetter.com/blogs/rodpaddock) discussing all sorts of things when the conversation drifted towards professionalism, job titles, and eventually into testing, TDD/BDD, etc.&#160; Rob was working on a blog post at the time which you can now read here:

> <http://codebetter.com/blogs/rodpaddock/archive/2009/01/04/what-s-in-a-job-title.aspx>

One of the things that came out of this meeting, for me, was an interesting idea about how I write code, design software, make sure it adheres to specifications, and such.

I realized that when I write code, I also write corresponding/complimentary code that usually fits into one or more of 4 roles or purposes.

## Proofs

This kind of code is usually very straightforward. For example, Adder(2, 2).ShouldEqual(4).&#160; Very straightforward, matter of fact.&#160;&#160; This type of code is intended to verify that something performs as expected and doesn’t throw errors, return unexpected results, etc.

Consider this example:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">void</span> AddDefaultBehavior_should_add_the_behavior_to_the_list()
{
    _fubuConfig
        .AddDefaultBehavior&lt;TestBehavior&gt;();

    _fubuConfig
        .GetDefaultBehaviors()
        .ShouldHaveTheSameElementsAs(<span class="kwrd">typeof</span>(TestBehavior));
}</pre>
</div>

There is a very clear cause and effect declared here.&#160; If the underlying code changes and breaks this proof, I’m made aware of it the next time I run the above code.

## Contract/Assumption Enforcement

This type of code ensures that very important assumptions, conventions, and/or contracts that were in mind when me (the developer) original wrote the primary code.&#160; Should another maintenance programmer (including myself in the future) come along and make a change which violates one or more of these assumptions, that programmer will be made aware of the issue.&#160; Consider this simple example of this type of code:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">void</span> DefaultPathForController_should_default_to_controller_canonical_name()
{
    <span class="kwrd">new</span> FubuConventions()
        .DefaultUrlForController(<span class="kwrd">typeof</span>(TestController))
        .ShouldEqual(<span class="str">"test"</span>);
}</pre>
</div>

You may notice that this type of code isn’t that much different than a “Proof”. You’d be correct. They’re not that different. The difference is in how these types of code break when changes are made. WHY they break is what differentiates them. Paying attention to WHAT you’re ensuring in your side-code will help you to write this code so that it will fail/break for the correct reason.

## Examples of Usage

This type of code is useful for keeping things customer/user focused where, in this case, your user is another programmer using your API. This other programmer may be you in the future, another programmer on your team, or an actual customer.

I find it useful to write this type of code BEFORE I write the actual API it’s exemplifying. It’s actually very helpful for me to think like a customer/consumer.&#160; This is helpful because, before I used this approach, I would design my API according to just the immediate needs. What I found is that this was almost always naive and would cause me lots of pain and wasted time later on. By designing the API according to the way my consumer will use it, it helps me to catch all sorts of issues up front. It helps me to see where my API might have closed off some useful functionality or denied my customer the opportunity to override some behavior that wasn’t applicable to their situation.&#160; Another way of looking at this approach is “outside-in” API design. Starting with the goals of the customer and filling in the implementation as you go.

By doing that, it actually starts paying for itself quickly. This approach will end up yielding an API that is already pre-open for extension and customization and can easily be used in ways that I wouldn’t have originally imagined when designing the API from the inside-out.&#160; 

I had a hard time finding examples of this type of code because the point of this type of code is the process, not the end result. The process is the goal, essentially. It’s really hard to show that in a blog post.&#160; I encourage you to try this approach on your own or try to find someone who has some experience with this approach. Experienced people usually call this approach “TDD".

## Specification / Acceptance

This type of code is usually a little more high level and uses language that more closely mirrors how non-programmers describe the system. Where programmers might use terminology like “Domain Service” or “Data Repository”, non-programmers might talk about “Accounting Module” or “Deposit Account".&#160; This of code will be dealing at a higher level of the system.&#160; It should try to use the same language and concepts that non-programmers/users of the system use to describe features and functionality.&#160; The goal is not for non-programmers to read and understand this code, but it should be to keep the programmers and designers honest and focused on business value instead of technical minutiae.&#160; However, it is possible that tools could be used to produce non-programmer friendly descriptions of what this code is specifying about the system.

This type of code doesn’t necessarily have to deal at the higher level, but, in my experience, its benefit is more fully realized at this higher level as the language is less awkward to try to bend into the code.

A (silly, probably non-compiling) example of this type of code, courtesy of [Scott Reynolds](http://www.lostechies.com/blogs/scottcreynolds/default.aspx) and [Steven Harman](http://stevenharman.net/blog/archive/2009/01/14/saving-the-world-via-tdd.aspx), would be:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> when_initializing_core_module
{
    ISkynetMasterController _skynet;

    <span class="kwrd">public</span> <span class="kwrd">void</span> establish_context()
    {
        _skynet = <span class="kwrd">new</span> MockRepository.GenerateStub&lt;ISkynetMasterController&gt;();
        _skynet.Initialize();
    }

    <span class="kwrd">public</span> <span class="kwrd">void</span> it_should_not_become_self_aware()
    {
        _skynet.AssertWasNotCalled(x =&gt; x.InitializeAutonomousExecutionMode());
    }

    <span class="kwrd">public</span> <span class="kwrd">void</span> it_should_default_to_human_friendly_mode()
    {
        _skynet.AssessHumans().ShouldEqual(RelationshipTypes.Friendly);
    }
}</pre>
</div>

## Conclusion

This isn’t supposed to be any sort of specification or official recommendation. Just some observations about how I have seen my code evolving and behaving throughout the years. There are probably more types that I’m not thinking of right now, but this list seems pretty comprehensive to me.

You may have noticed that these code examples sound awfully like what we currently call “tests” today. You’d be right. Part of this exercise/post is to try to get people away from talking about “tests” because it can sometimes cloud and confuse someone new to these concepts.&#160; Simply because I happen to use a tool called “NUnit” and put “TestFixture” or “Test” on my classes and methods, doesn’t necessarily mean that I have to use that terminology outside of those attributes. Other frameworks use different terminology anyhow (i.e. XUnit uses [Fact] instead of [Test]).

If you have been averse to trying out TDD, BDD, unit testing in general, or anything related to extra code, I encourage you to re-think this decision and re-approach these problems from a different perspective.&#160; I hope you will find the same benefit that I have found from these patterns.