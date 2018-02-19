---
id: 63
title: How did I get started in software development?
date: 2008-06-28T00:04:38+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/06/27/how-did-i-get-started-in-software-development.aspx
permalink: /2008/06/28/how-did-i-get-started-in-software-development/
dsq_thread_id:
  - "262113871"
categories:
  - Programming
  - TDD
---
[Jason Meridth](http://www.lostechies.com/blogs/jason_meridth/archive/2008/06/27/how-did-i-get-started-in-software-development.aspx) tagged me with this meme, so I&#8217;ll play along if anyone cares.

### How old were you when you started programming?

I remember being 6 or 7 years old helping my brother open the box for our new [Commodore Vic-20](http://en.wikipedia.org/wiki/Commodore_VIC-20) (yeah, that&#8217;s right baby, RESPECT).&nbsp; My Dad got us a book or two with BASIC source code in it for all sorts of things (recipe filers, video games, etc).&nbsp; I seem to recall him getting us a magazine or two (or was it a subscription?) that had articles featuring BASIC code in it.

Of course the trick was, we didn&#8217;t have the tape deck at first, so we&#8217;d spend 3 hours transcoding (i.e. I would read from the book &#8216;ONE TEN, FOR, I, EQUALS SIGN, ONE to ELEVEN NEXTLINE, ONE TWENTY&#8217; and so forth.&nbsp; At the end of this, we&#8217;d have a dozen or two typos and other errors which we&#8217;d fix and then play the game or enter some recipes for our Mom and then we&#8217;d leave it on. Eventually it would get shut off and we&#8217;d loose all the work (yeah, that&#8217;s right: No storage! hah!).&nbsp; Eventually we got a tape deck and were able to store our programs.

After that, I had a on and off again relationship with the computer. We eventually got an 80-88, then a 286, then a 386 Goldstar with MULTIMEDIA. I remember signing onto Prodigy and getting DOS debugging commands to hack values into the Sim City save game files to add more money, etc. Eventually I got a Hex editor and was able to poke values in all over the place. One summer I was able to map out most of the SimCity and Civilization save game formats and do all sorts of awesome things like make a 2&#215;2 airport in SimCity (no pollution!) and make a flying troop-carrying battleship in Civilization that totally owned all over my CPU enemies.

My first real entrance into actual programming was my 6th grade computer class writing simple BASIC applications on the Apple IIe&#8217;s and IIgs&#8217; (when I wasn&#8217;t sneaking a few games of Oregon Trail in, that is).

### What was the first real program you wrote?

I&#8217;ll assume this means one that I authored from scratch, with no copying from a book or little assignments in a class or something like that.&nbsp; I believe I wrote a VB3 or VB4 app to open a Civilization save game file and edit various characteristics (change your money, your form of government, size of cities, etc).&nbsp; I wrote a lot of little one-off things back then, just playing around so I can&#8217;t remember which was THE first one.

### If you knew then what you know now, would you have started programming?

If I had the KNOWLEDGE I had today or the wisdom?&nbsp; If I had the knowledge, yes, definitely. If I had the wisdom I had today back then, I probably would&#8217;ve done a lot of things differently. I would&#8217;ve been involved with computers and some programming of some sort for sure, but I wouldn&#8217;t have been a corporate developer like I am now.

### If there&#8217;s one thing you learned along the way that you would tell new developers, what would it be?

Oh, I&#8217;d have a lot of things to tell them. Probably the most important, in this order would be:

#### Personal

##### Humility

Do not give up your spirituality.&nbsp; I went totally engineering/science-minded when I was young and put away my faith and anything that I couldn&#8217;t create/control/manipulate and I lost many years in my blindness and self-centeredness.&nbsp; Yes, you can be faithful and science minded and I think you will find that they actually go together very well and that they compliment each other nicely producing a balance that further enhances your ability to do both.&nbsp; Being mindful of your place in the grand scheme of things naturally forces a form of humility on you that helps to keep your ego in check. It doesn&#8217;t always work, but if you&#8217;re committed to it, it can really help in all areas of your life.

##### Creativity

Programmers are naturally creative beasts. Explore your creativity in other areas of your life and don&#8217;t let your life be dominated by your career or your programming. You&#8217;ll have a tendency to want to solve every problem with technology. Stop and search deeper and use your creativity to find the right solution, not necessarily the most technologically advanced solution.&nbsp; There is unbelievable beauty and functionality in the simple things. Learn to appreciate that, and you will be much more productive and at peace in all areas of your life.

Suggestions? Take up gardening, Bonsai tree trimming, wood carving, or some other form of natural art. Working with life will help you appreciate subtleties and nuance and it will also teach you the very hard lesson that you&#8217;re not in control of everything and your value lies most in your ability to adapt to adversity. This was one of the hardest lessons <strike>I&#8217;ve learned</strike> I&#8217;m learning.

##### Work/Life Balance

Being able to just create working, functional software that solves people&#8217;s problems is a very intoxicating drug that can lead to obsessive behavior (i.e. just one more feature! one more screen! ten more lines of code! I have to get this feature working before I leave, darnit!). Don&#8217;t let your desire to produce dominate you.&nbsp; Learn to make more use out of the time you&#8217;re there. Learn to be efficient with the checking of your email/reading blogs/twitter, etc. Learn to reduce coding friction as much as possible. Learn to put in place checks on yourself so that you can code with more freedom and not have the heavy weight of manually testing things all the time (which can be tedious and frustrating).

#### Professional

##### Automate Out Time Waste

Automate everything.&nbsp; Do not repeat yourself or your actions more than twice. We are also creatures of repetition and habit and we waste TONS of time brute-forcing through code or repeating ourselves over and over again rather than just writing a little fluent-interface API to push down the repetition of things. For example, ever tried to use one of the bigger designer items from the Toolbox (i.e. GridView) or one of the 3rd party controls (like the big commercial uber-Grids)?&nbsp; You know how much clicking and dragging you have to do. If you have more than one grid, you&#8217;re probably repeating about 80% of your work. If you do it a 3rd time, you&#8217;ve now already wasted more time than if you just wrapped a little thin API around the Grid Setup to drive it. We did this when I worked with Jeremy at our previous employer and it saved us a TON of time and it was well worth it.

##### This Includes Most of Your Manual Testing

And when I say automate everything, I certainly include testing in here. If you&#8217;re writing code and then firing up the debugger more than once in a session as a routine thing (i.e. hacking/fire-fighting sessions excluded), you might as well be throwing your employer&#8217;s money out the window (not to mention your own personal patience) because you&#8217;re wasting tons of time.

##### Use Tests to Stay Focused and Driven Towards Important Goals

Write your tests first. It helps to constraint your natural creativity (see above) and focus on what&#8217;s important: Business value. You can save your creativity for off the computer or you can put some of it into your test code which may benefit from more creative solutions to testing the real code.&nbsp; Keep the real code boring and functional. Keep your tests lean, mean, easy to write, and as least brittle/resistant-to-change as you can make &#8216;em.

### What&#8217;s the most fun you&#8217;ve ever had &#8230; programming?

Pretty much everything since I found TDD and ReSharper. By adding enough discipline to my coding, it has opened up more freedom in the way I code because I don&#8217;t get the dread feelings as I&#8217;m coding that I&#8217;ll never be able to test all this and that I&#8217;m writing code for code&#8217;s sake, etc.