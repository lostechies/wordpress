---
id: 82
title: Good Design is not Subjective
date: 2008-08-19T03:02:19+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/18/good-design-is-not-subjective.aspx
permalink: /2008/08/19/good-design-is-not-subjective/
dsq_thread_id:
  - "262113998"
categories:
  - Design
---
In case you haven’t guessed by my recent flurry of posts, I’ve been engaged in some debates in the past few days about design philosophies and why some designs are “good” and some are “bad.”&#160; I’ve been met with some relativistic arguments that no design is either good or bad, it just succeeds or fails differently, etc (ok, they didn’t really say that, but that was the gist of the argument).&#160; Of course arguments of relativism are always wrong in my book (it’s usually just that we haven’t reached a level of understanding and specificity in the subject matter to determine EXACTLY why something is A or B).

Well, at least in the subject of design, we actually DO have material and research that points to what constitutes a GOOD design and a BAD design. In fact, it was written over 10 years ago (1996/1997).&#160; Interestingly enough, it rings as true today as it ever did.

## What is Bad Design?

First, what is a BAD design?&#160; Courtesy of Robert C. Martin from his paper on the “[Dependency Inversion Principal](http://www.objectmentor.com/resources/articles/dip.pdf)” (PDF link, sorry – emphasis mine):

> But there is one set of criteria that I think all engineers will agree with. A piece of software that **_fulfills its requirements_** and yet exhibits any or all of the following three   
> traits has a bad design. 
> 
>   1. It is hard to change because every change affects too many other parts of the system. (Rigidity) 
>   2. When you make a change, unexpected parts of the system break. (Fragility) 
>   3. It is hard to reuse in another application because it cannot be disentangled from   
>     the current application. (Immobility)
> 
> Moreover, it would be difficult to demonstrate that a piece of software that exhibits   
> none of those traits, i.e. it is flexible, robust, and reusable, and that also fulfills all its   
> requirements, has a bad design. Thus, we can use these three traits as a way to unambiguously decide if a design is ‘good’ or ‘bad’.

Rigidity, Fragility, and Immobility are qualities of a bad design.&#160; These are problems that will rear their head later during future enhancement or maintenance of the software. Each of these qualities has a corresponding negative real-world impact on the ability to enhance or maintain the software going forward. 

Fortunately, there are contradictory and counter-acting practices that result in good traits and qualities of GOOD design.&#160; These include all the good ‘ilities’ like “reversibility&#8217;”, “reusability”, “maintainability”, “extensibility”, “portability”, etc.

## But it Works!</p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> 

I hear this argument a lot. It goes something like, “who are you to judge my design because it WORKS!”&#160; “Works” ends up being the relative word and the point of debate. We have different definitions of “works” apparently.&#160; For me, “works” is more than just “fulfills its requirements” (see emphasis in the Martin quote above).&#160; A design can fulfill its CURRENT requirements, but fail miserably in its ability to accommodate FUTURE requirements.&#160; How many of you out there write systems that are NEVER touched again once they are deployed to production?&#160; No hands? I thought so.&#160; Maintainability is IMPORTANT and justifies forethought and strong consideration in any design. If not, you’ll end up with a Rigid, Fragile, and Immobile design and you have just stiffed your employer for a lot of money in future maintenance.&#160; We can do better, and we should!

## </p> </p> </p> </p> </p> 

## Conclusion

Good design is not subjective. It is objective. It exhibits properties of high cohesion and loose coupling. Through these fundamental properties, all the other good “ilities” flow and the bad “ilities” are kept at bay.

P.S. – those who know me know that I’m not a big fan of the <u>**abuse****</u> of TypeMock’s exotic features (ability to mock anything by twiddling bits under the skirt of the CLR).&#160; The reason I’m not a big fan is because people abuse it in order to get around having to learn and use core fundamental design principles and they can easily end up with a design that has one or all three of the bad “ilities”. Particularly they could end up with a bad case of the “Immobility” trait since they likely didn’t follow the Dependency Inversion Principle (since TypeMock allows them to get away without needing it in many cases).

&#160;

** Note I said ABUSE. I still maintain that TypeMock is a handy tool in general (it’s a good mocking framework) and extra-handy when you’re in an otherwise unmaintainable situation (i.e. SharePoint development). But it’s special powers can be used to get away with things that are supposed to be difficult in .NET (basic OO design stuff).