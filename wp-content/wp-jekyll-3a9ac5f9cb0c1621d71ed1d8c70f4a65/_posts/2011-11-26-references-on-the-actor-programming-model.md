---
id: 83
title: References on the Actor Programming Model
date: 2011-11-26T14:22:56+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=83
permalink: /2011/11/26/references-on-the-actor-programming-model/
dsq_thread_id:
  - "484745709"
categories:
  - Uncategorized
---
The actor programming model is a software development method that encourages the decomposition of applications into autonomous components which are self-contained and operate asynchronously and independently from one another. This model is well aligned with the nondeterministic nature of distributed systems, including mobile systems, interactive systems, and the internet.

As I mentioned previously, I didn&#8217;t invent it. I&#8217;m merely leveraging the information obtained from a number of sources and applying it in a way that I think makes it easier to build certain types of applications. Applications that can benefit from a highly concurrent actor-based programming model include reactive systems &#8212; ones that respond to nondeterministic external events. Since many applications can be described as &#8220;a program that responds to external events&#8221; it only makes sense that the actor programming model can be applied to many domains.

Here are some papers that I&#8217;ve read on the actor model, some of which have influenced me in how I think about concurrent programming and others that have merely provided background information or depicted ways in which concurrent programming should not be approached.

[Actors](http://www.google.com/url?sa=t&rct=j&q=actors%20rajesh%20karmani&source=web&cd=5&ved=0CD8QFjAE&url=http%3A%2F%2Fwww.cs.ucla.edu%2F~palsberg%2Fcourse%2Fcs239%2Fpapers%2Fkarmani-agha.pdf&ei=1EjRToveNYTo2QW8jL2fDw&usg=AFQjCNFGRhp1lee0PTWR-P-zoZh53PlPPg), Rajesh K. Karmani, Gul Agha

[Actors: A Model of Concurrent Computation In Distributed Systems](http://hdl.handle.net/1721.1/1692), Gul A. Agha (out of print)

[Actor Languages for Specification of Parallel Computations](http://www.google.com/url?sa=t&rct=j&q=actor%20languages%20for%20specification%20of%20parallel%20computations&source=web&cd=2&sqi=2&ved=0CCcQFjAB&url=http%3A%2F%2Fciteseerx.ist.psu.edu%2Fviewdoc%2Fdownload%3Fdoi%3D10.1.1.54.8636%26rep%3Drep1%26type%3Dpdf&ei=yUTRTsagJ-Gi2gWq--ySDw&usg=AFQjCNG9xXGsndDiaOg4e1IXmidFT6_QyA), Gul Agha, Wooyoung Kim, Rajendra Panwar

[An Actor-Based Framework for Heterogeneous Computing Systems](http://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=0CCwQFjAA&url=http%3A%2F%2Fosl.cs.illinois.edu%2Fdocs%2Fhp92%2Fhp.pdf&ei=OEbRTvPvKILS2gXg3cy6Dw&usg=AFQjCNHnqFN88E0QqQhuMq8hIWvJXMlJbQ), Gul Agha, Rajendra Panwar

[Actors that Unify Threads and Events](http://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=0CB0QFjAA&url=http%3A%2F%2Flamp.epfl.ch%2F~phaller%2Fdoc%2Fhaller07actorsunify.pdf&ei=dkbRTsjhEKrs2AXi96nMDw&usg=AFQjCNEGCiUihzxt1xrjfocx_qanRATegw), Philipp Haller, Martin Odersky

[Lightweight Language Support for Type-Based, Concurrent Event Processing](http://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=0CCAQFjAA&url=http%3A%2F%2Flamp.epfl.ch%2F~phaller%2Fdoc%2Fhaller10-Translucent_functions.pdf&ei=qkbRToTHIsWC2wXUsrmaDw&usg=AFQjCNHfk44fbCGvf3ZDzI0BLkfNxITyDA), Philipp Haller

[Compilation of a Highly Parallel Actor-Based Language](http://www.google.com/url?sa=t&rct=j&q=compilation%20of%20a%20highly%20parallel%20actor-based%20language&source=web&cd=3&sqi=2&ved=0CDUQFjAC&url=http%3A%2F%2Fosl.cs.illinois.edu%2Fdocs%2Fhal-compilation92%2Fhal-compilation.pdf&ei=TEnRTrbUK6Hq2QXarNm1Dw&usg=AFQjCNFRI9bn7Cl-b8AkWmcIceFl5kQ8tQ), WooYoung Kim, Gul Agha

These are some of the more involved works from which I&#8217;ve found many useful bits of information. I&#8217;ve got them permanently stored in [GoodReader](http://www.goodiware.com/goodreader.html) so I can keep looking back to them (and my associated annotations as well). Hopefully anyone looking to build systems using the actor model (and hopefully, using Stact if you&#8217;re on the .NET platform) can get a better understanding of the model by reviewing these papers.

 