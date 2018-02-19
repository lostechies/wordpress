---
id: 20
title: The first 2 hours of TDD are the most painful
date: 2008-02-13T03:08:11+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/02/12/the-first-2-hours-of-tdd-are-the-most-painful.aspx
permalink: /2008/02/13/the-first-2-hours-of-tdd-are-the-most-painful/
dsq_thread_id:
  - "262113675"
categories:
  - CodingDojo
  - Programming
  - TDD
---
## Quick Background

I admit, I&#8217;ve had a lot of failures with TDD. Mostly they were solo projects and I didn&#8217;t have the discipline and self control enough to stick with it. I ALWAYS regretted not sticking with it. However poorly I was doing it, it always gave SOME value and saved me from several bugs (earning its keep and paying back with dividends all the time I spent on it).&nbsp; And the successes with TDD I have had have been rocky, at best.&nbsp; I usually felt ashamed and embarrassed by this, seeing how there&#8217;s all these noted luminaries and successful practitioners on my Blog Roll talking about optimizing, tweaking and even redefining the style of TDD as BDD.

In my selfish desire to find out their secret, I worked with [Ray Houston](http://www.rayhouston.com/blog) to try to trick a bunch of really good software developers (many of whom already had lots of TDD experience) to see if I could get them to teach me their secret ways so that I might become more proficient and successful at TDD. I didn&#8217;t expect it to work very well. BOY WAS I WRONG.

I was kind of down on the CodingDojo in my last post on the subject. I was bummed because some people came from great distances and left with less than I had hoped they would. I was bummed that I didn&#8217;t serve them better.&nbsp; But, there were some really great things that came out of it. It did spurn a bunch of people to get more serious about what they were doing and take a second look at how they were doing it. But more importantly, it re-instilled confidence in people (including me) who had been wavering and unsure of where to go or how to do TDD more effectively.

It was truly great to see people whom I thought had TDD down cold, experience some of the same problems I have been having and not have a quick answer for it.&nbsp; This reminded me the most important thing about TDD&#8230;

## TDD is not a solved problem, yet.

You cannot minor in TDD at college. Heck, you cannot take a graduate level course on TDD at college.&nbsp; TDD is not a fully solved problem. It&#8217;s a practice which has been proven, through experience of many, to be a useful, worthwhile, and valuable tactic for achieving higher quality, more agility (through change confidence), and measured, disciplined design.

Armed with this reassurance that I wasn&#8217;t totally a heel, I really started to get into the discussions, the debates, and, above all, the code at the Dojo.&nbsp; I started jotting down some of the questions that were being raised and not answered all that great in the hopes that I could spend some time thinking about them.

I plan on writing more about these things as the weeks/months go on (especially when I start on with Jeremy and get to practice them more thoroughly and have more substance to write about).&nbsp; But in the mean time, I thought I&#8217;d do a thought dump and see if anyone had any good rules of thumb, concrete advice, or even &#8216;laws&#8217; to go by. I&#8217;ll be updating this post with any interesting comments that appear so that you don&#8217;t have to go hunting through them to find any gems (of course, all the comments are gems &#8212; except for Anonymous Blog Coward ones &#8212; but some are worth bringing to the top).

(P.S.- I&#8217;m trying to keep the BDD style questions out of here, that will probably be another post)

## TDD Practice Questions

  * How much up-front design do you tolerate? How do you know when to stop (i.e. &#8216;when algorithms start getting discussed, it&#8217;s testing time&#8217;)?
  * What about certain &#8220;I just know we&#8217;ll need this&#8221; type stuff (i.e. putting a try/catch{Console.WriteLine(ex);} in your console main() method?)
  * When writing a test, in order to even get it to compile, you have to build an interface or two, a concrete class with some NotImplementedExceptions in it, etc. How far do you allow that to go?
  * If, during the middle of testing on a story, you realize that your up-front design wasn&#8217;t correct, do you stop and discuss with your pair right then, do what you need to do and proceed, or do you pull back and go back to full pre-test design mode on that story?
  * When proceeding to a new story, you discover that a test you wrote for a previous story no longer reflects the requirements. Do you refactor that test immediately, mark it as ignored until you finish the current story and cycle back to the ignored one? Something else?
  * If the new story&#8217;s requirements involve a slight tweaking to an existing test, do you tweak it, or make a new one and discard the old one (i.e. &#8216;No changing existing tests!&#8217; or &#8216;Only change if it&#8217;s a minor compiler issue, but otherwise don&#8217;t change it&#8217;)?
  * If you&#8217;re, say, building up your model and it passes tests, but you&#8217;re seeing that it&#8217;s infantile and that the next few upcoming stories will produce significant changes to produce a new emergent model, is it appropriate to step back and consider a larger refactoring, or do you keep plugging and make the changes into the existing model even if it could benefit from some housekeeping that is otherwise out of scope?

## TDD Style Questions

  * Assert.That(x, Is.EqualTo(y)) or Assert.AreEqual(y,x)?
  * How many asserts/test? Any caveats?
  * How do you know what to put in the SetUp method?

## TDD Mechanics Questions

  * Is a refactoring tool absolutely necessary?
  * If so, what is the bare minimum features that the tool would need to facilitate decent TDD?
  * Integrated IDE test runner or a background source-watching auto-runner?

That&#8217;s most of what I wrote down with a few extra thrown in for good.&nbsp; I&#8217;d love to hear some of your thoughts on these questions.