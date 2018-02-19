---
id: 25
title: 'Ping-pong Pairing, it&#8217;s not just for breakfast anymore'
date: 2008-03-03T22:00:58+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/03/03/ping-pong-pairing-it-s-not-just-for-breakfast-anymore.aspx
permalink: /2008/03/03/ping-pong-pairing-it-s-not-just-for-breakfast-anymore/
dsq_thread_id:
  - "262113673"
categories:
  - Misc
  - Programming
---
Yesterday was my first day working at my new employer, [Bayern Software](http://www.bayernsoftware.com/), with (name drop alert!) [Jeremy Miller](http://codebetter.com/blogs/jeremy.miller/default.aspx).&nbsp; We started right off with an easy story doing ping-pong pairing. I really dig this method of doing development (not to mention pairing, not to mention TDD).

We started off with a quick whiteboard discussion. Fortunately this story was so easy, there wasn&#8217;t much room for debate or design decisions, so we went right to the keyboard.&nbsp; We were going to implement the [Command Executor Pattern](http://codebetter.com/blogs/jeremy.miller/archive/2008/02/15/build-your-own-cab-18-the-command-executor.aspx) and start off with a synchronous implementation to make testing easier (and worry about the asynchronous stuff later).

Our setup this:&nbsp; Jeremy at his laptop with a keyboard and mouse&nbsp; and me at a monitor connected to his laptop with my own keyboard and mouse (also connected to the laptop).

## How it worked

Jeremy started off and added an interface (ICommandExecutor) with some methods we know we&#8217;d need.&nbsp; At this point I noticed he was using r-click, add new item in Visual Studio to add the new interface and I was able to suggest a ReSharper shortcut (hit ALT+INS and choose &#8216;Interface&#8217;) to have it generate a new interface file for you using a more refined template than the default one built into VS.&nbsp; Score one for Pair Programming!&nbsp; Sidebar for those playing the home game: that would be Chad 1, Jeremy 0 &#8212; the game would eventually end with Chad 1, Jeremy 5,984. He then added a new class called SynchronousCommandExecutor, had it implement ICommandExecutor, use R# to stub out all the methods (each throwing a &#8216;NotImplementedException&#8217;) to satisfy the ICommandExecutor requirements, and then he added it to the project&#8217;s StructureMap configuration code. 

He then wrote a test for the first method we added to the ICommandExecutor interface.&nbsp; It was very simple and straight to the point. He ran the test, which failed of course because all the method does now is throw a NotImplementedException. He then turned the control over to me and I started banging on the keyboard.&nbsp; I went to the SynchronousCommandExecutor class and removed the &#8216;throw new NotImplementedException&#8217;, and then implemented the code of the method properly.&nbsp; I then re-ran the test (using the Re-Run Last Test keyboard shortcut for R# which he happened to have bound to CTRL+3) and it passed!&nbsp; Throughout this process, Jeremy kept correcting all my inefficiencies by showing me how R# can do that, or do this with a simple keyboard shortcut.&nbsp; I thought I knew R# pretty well, but I didn&#8217;t. Shame!&nbsp; 

_Note to self: We (.NET community in general) need more R# screencasts that show R#-fu in action._

Next, I wrote the test for the next method in SynchronousCommandExecutor.&nbsp; I ran it, and it failed.&nbsp; I then turned control of the system over to Jeremy who then implemented the method using a flurry of R# shortcuts.&nbsp; He then ran the test again and now it passed.&nbsp;&nbsp; 

We proceeded in this manner until we had tested the SynchronousCommandExecutor thoroughly and were both satisfied that it was well tested. We then moved onto a different story that was more complicated and involved touching more parts of the system.

## Why I like it

First, I got to tour the system in a non-threatening way.&nbsp; I was able to discover the parts of the system I needed and work out from there. It wasn&#8217;t a heavy top-down or bottom-up scan through the code, it was focused on where I was concerned and branched out from there.&nbsp; Second, Jeremy and I were able to swap (well, Jeremy was for the most part) tips and tricks to speed each other up.&nbsp; There was a bit of friendly competition of sorts to see who could be most efficient.&nbsp; It was mildly intense in a good way and broke the ice with a new codebase.&nbsp; Third, perhaps most importantly, with in the first few hours on my first day, we had already completed a few stories. I learned more in those 2-3 hours than I would&#8217;ve learned after weeks of studying the code from the outside or pouring over reams of already-outdated &#8220;Systems Documentation&#8221; or specifications or requirements that are common at most non-Agile shops.&nbsp; Fourth, by keeping each other honest and focused, we were less inclined to be distracted with other things or be tempted to floor the gas pedal and stream out a bunch of code that wasn&#8217;t tested properly.

## Try it!

In most shops I&#8217;ve worked in (which were almost all non-Agile shops), pair programming happened. It may not have been institutionalized, but it was not uncommon to see two developers at one workstation hammering out an issue. It&#8217;s just natural, it works, so people instinctively gravitate toward that style of cooperation. Sure, you don&#8217;t do it every hour of the day (nor should you!). There is a time and place for pair programming.&nbsp; I suggest that WHEN you find yourself in a pair situation, make the most of it and become super-productive by using the ping-pong technique (even if you&#8217;re not doing TDD, and you&#8217;re just banging out code you can still benefit from this!).