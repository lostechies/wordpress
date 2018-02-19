---
id: 164
title: Unstated Requirements
date: 2010-07-23T17:41:33+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2010/07/23/unstated-requirements.aspx
permalink: /2010/07/23/unstated-requirements/
dsq_thread_id:
  - "267259753"
categories:
  - professionalism
---
I was formulating some thoughts for a whitepaper today and I was talking about two different ways to accomplish a particular task. Both ways accomplished the task, but one of them was clearly better.&#160; I pondered why, exactly, I thought it was better.

I’ve talked about “good” or “better” software design being an <a href="http://www.lostechies.com/blogs/chad_myers/archive/2008/08/18/good-design-is-not-subjective.aspx" target="_blank">objective reality and not merely a subjective one</a>, before.&#160; I guess this blog post is merely an addendum to that post because there was one specific point that popped in my mind and which I wanted to share with you, dear reader:&#160; “Good” or “better” solutions solve not just the stated requirements (anyone can do that), they also solve the “unstated requirements.”

## But you should have known that!

In every stated requirement (no matter how detailed that “Requirements Specification Document” is), there is at least one if not many _unstated requirements_.&#160; Some of these are self-evident, but some are not.&#160; Some, if not conceived of by the developer, product manager, or anyone else beforehand, will come back to haunt or thwart the product team going forward.&#160; One example of an unstated requirement that is not always self-evident is “and this requirement should continue working even in future versions of the software.”&#160; You might think that this is self-evident, but it is not. I say it’s not, because many software development teams do not take precautions to ensure that a given requirement remains in tact as the rest of the system continues changing.&#160; Some call these problems “Regression issues” and take steps to mitigate them, but they may not be doing enough.

## “Professional”

Where am I going with all this?&#160; Looking back at the history of most of my philosophical blog posts (the ones that aren’t about solving a particular coding or architecture problem), they all seems to come from the same presupposition:&#160; That if you’re a “professional”, you’ll want to do these things.&#160; It’s a backhanded insult to those developers who _don’t_ do those things because it implies that they are not “professional.”&#160; That was probably my intention in most of those posts, I’m afraid to admit, but I did so because I really believed (and still do) that those things are extremely important for good software.&#160; Each post was an attempt to illustrate a particular facet of what I consider responsible, “professional” software engineering.&#160; But I was never able, in any of those posts, to elucidate how they all fit together in a consistent philosophy. I could argue why practice X or principle Y was important and which benefits it offered, but I couldn’t really tie them all together into a coherent stream.

I think I’ve finally figured it out…

## The Primary Unstated Requirement: It works and keeps working

It seems simple. It seems stupid to have to say it, really. But it is surprisingly (and frighteningly so) simple to forget this simple unstated requirement.&#160; Don’t believe me? Some software teams don’t have testers at all. Some developers don’t consider automated testing one of their top priorities (as important as implementation itself – for what good is implementing something if you can’t verify it actually works?).&#160; They bang out features, giving them a quick once-over, and then mark it “done.”&#160; In the past, I might have characterized this behavior as “sloppy” or “unprofessional” or at the least “hasty” and “cowboy coding.”&#160; To be sure, I’m as guilty of this behavior as anyone. I’m not claiming moral high ground here.&#160; A drunk can say that getting drunk is wrong and still be speaking the truth. But now instead of calling people names (i.e. “sloppy”) I can clearly explain why this behavior is contrary to good practice: Because it fails to meet the unstated requirements of “it works” and “it keeps working.”

## Prove It

Without proper testing (both by a QA person and by automated tests at multiple levels [unit, integration, acceptance]) you cannot honestly say that the “it works” requirement is fulfilled.&#160;&#160; You must _prove it_.

Without a proper bevy of automated tests and (or at least) a clear manual test plan (that actually gets executed by a trained QA professional – that point is important!), you cannot honestly say that the “it keeps working” requirement is fulfilled. You must _prove it_.

What’s more, you must KEEP _proving it_.&#160; Just because it worked yesterday, or even before the last commit to source control, doesn’t mean it works NOW. _Prove it_.

A common objection I hear to the imploring that people do to encourage <a href="http://c2.com/cgi/wiki?TestDrivenDevelopment" target="_blank">Test-Driven Development</a> or use <a href="http://www.lostechies.com/blogs/chad_myers/archive/2008/03/07/pablo-s-topic-of-the-month-march-solid-principles.aspx" target="_blank">SOLID design principles</a>, etc is that these are wastes of time and that delivery of functionality is the most important aspect of coding. That is, the argument goes, that meeting requirements is the only real deliverable that matters and that TDD or efforts on making SOLID designs are out of scope and therefore wastes of time.&#160; To this I can now make a good argument back and say: Oh yeah, so you _say_ you’ve accomplished the requirement at hand, _prove it_!&#160; And then, in 6 months, I’ll come back again and say, remember that requirement that you _said_ works? Does it _still_ work? _Prove it_!