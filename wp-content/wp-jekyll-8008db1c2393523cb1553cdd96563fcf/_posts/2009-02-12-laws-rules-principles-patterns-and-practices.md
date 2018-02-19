---
id: 131
title: Laws, Rules, Principles, Patterns, and Practices
date: 2009-02-12T04:42:25+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/02/11/laws-rules-principles-patterns-and-practices.aspx
permalink: /2009/02/12/laws-rules-principles-patterns-and-practices/
dsq_thread_id:
  - "262114289"
categories:
  - Principles
---
I speak and write a lot about principles, patterns, and practices.&#160; There has been a lot of hullabaloo lately about blind, rigid adherence to principles and how, apparently, this will result in some sort of catastrophe. Frankly, if we, as a profession, ever got the point where we were too rigidly following things like the [SOLID principles](http://www.lostechies.com/blogs/chad_myers/archive/2008/03/07/pablo-s-topic-of-the-month-march-solid-principles.aspx), I think we’d be doing pretty good and that it would generally be a good problem to have (like having too much money or one extra piece of cake – a problem no doubt, but a good problem and one easily solved).

Amidst all the chest pounding and spitting, there appears to be some sort of confusion among the various words and definition. In a laughably futile attempt to try to inject some sort of rationalism and logic into the debate, I’d like to take a stab at defining what the following words mean, in the context of the practice of software design:&#160; Laws, Rules, Principles, Patterns, and Practices.

## Law

Think more of the scientific definition of “law” than the governmental/legal definition.&#160; For example, the Merriam-Webster dictionary [defines it](http://www.merriam-webster.com/dictionary/law) as: 

> 6a: a statement of an order or relation of phenomena that so far as is known is invariable under the given conditions.

That’s a pretty good definition. To me, that means: Given X, if you do Y, the outcome will always be Z.&#160; That’s a bold statement, thus the gravity of the use of the word “Law” in the context of design (something that has a lot of subjectivity). It’s [not entirely subjective](http://www.lostechies.com/blogs/chad_myers/archive/2008/08/18/good-design-is-not-subjective.aspx), however, and so laws CAN apply.

These are pretty rare in software design due the fact that it is still quite young and there is very little science involved (in order to prove anything).&#160; Thus we must fall back to what little experience, observation, and empiricism we have available to us.&#160; So far only one of these comes to mind (sorry, I’m drawing a big blank): [Law of Demeter](http://en.wikipedia.org/wiki/Law_of_Demeter).

## Rule

I think I’ll referencing good ol’ M-W on [this one](http://www.merriam-webster.com/dictionary/Rule) again:

> 1 **a:** a prescribed guide for conduct or action, … **c:** an accepted procedure, custom, or habit

So we’re talking about something quite different from a law. A law is an observation of behavior of some phenomena whereas a rule is something we, as professionals, impose upon ourselves.&#160; You can break a law and you will feel the pain and consequences for it. Breaking a rule is quite different. There may not be any consequences unless your colleagues hold you to it.&#160; Rules, in my experience, are best prescribed by the individual team members for themselves and their own conduct. They should hold themselves accountable to each other and share the consequences in their violation (if any).

Rules are a way of enforcing consistency within a team, project, or set of projects. They do not enforce quality (unless your rules are designed to do that), they enforce consistency.&#160; You can have a set of rules that produce consistently poor quality software just as easily as high quality software.

Some good examples of rules I might suggest you, together with your team members, place upon yourself are things like:

  * Personal hygiene: Learn it, live it, love it.
  * Follow CI and all the other [minimal practices and requirements for good software](http://www.lostechies.com/blogs/chad_myers/archive/2008/03/16/time-to-login-screen-and-the-absolute-basic-requirements-for-good-software.aspx)
  * Don’t commit into a broken build
  * Don’t commit spike code into the trunk 
  * Don’t use the words “stored procedure” around Jeremy

## Principle

M-W defines this one as so:

> **1 a:** a comprehensive and fundamental law, doctrine, or assumption

I have to admit, I was a little thrown back by that one. To me, “Principle” was never quite that strong. M-W suggests that it’s actually stronger than a law.&#160; For now, I’ll defer to what the apparent popular usage of this word is within the development community versus what the dictionary actually says.

Principles are very important to me when I design software. People say things like “rigid adherence to principles” as though it’s a bad thing. In my practice, it seems to usually be a good thing and I can’t recall it ever being a bad thing. The key here is, though, that you must know and understand the principle well to ensure you’re actually following it and not some misguided misinterpretation.

To me, principle means something closer, but more loose, to Law rather than a Rule.&#160; Principle means this to me: Given X, if you do Y, the outcome will _likely_ be Z. Note the addition of the word ‘likely’.&#160;&#160; Conversely, given X, if you do _not_ do Y, the outcome will likely be A (or at least not Z).

Principles help guide me in the right direction and serve as a canary-in-the-mineshaft to tell me when I’m going in the wrong direction.&#160; I say “guide” not “steer” because sometimes I knowingly violate those principles to serve some end. I do so with understanding of the consequences and that’s OK.

There are many principles – too numerous to list here unfortunately. The SOLID principles linked above are a good place to start, though.

## Pattern

Pattern is merely an implementation detail: A standard, known-good way of solving a particular problem. I use patterns within the context of design laws, principles, and our self-imposed rules. Patterns help me work within a given design to implement it. Patterns themselves are not ends, only the means to a greater end.&#160; Unfortunately, patterns are severely abused and consequently end up getting a bad rap because they are the most visible elements of a failed design.

A good set of examples of patterns come from the&#160; book “[Design Patterns: Elements of Reusable Object-Oriented Software](http://en.wikipedia.org/wiki/Design_Patterns_(book)).” NOTE: If you have this book already, or are planning on getting it, PLEASE read the first chapters – _especially_ the parts about “composition versus inheritance” as these are crucially important.&#160; Many people (myself included) skipped right over these chapters and dove right into the meat of the patterns – to our great folly.

## Practice

A practice is more like a rule than a law of principle.&#160; A good way to look at a practice is a means by which a rule, principle, or law is adhered to.&#160; Adopt practices to help follow the rules, principles, and laws you find important.&#160; Establishing practices and good habits will increase your success rate of appropriate adherence to the rules, principles, and laws your team has chosen to follow.

Practices also serve as a means by which you can detect when you’ve fallen away from your adherence. This may be deliberate and conscious, or it may be accidental. Either way, you’re aware of it and can take appropriate action (continue down this path, knowingly, or correct it).

Examples of practices include: Continuous Integration, Check-in Dance, Test-Driven Development, and daily stand-up meeting.