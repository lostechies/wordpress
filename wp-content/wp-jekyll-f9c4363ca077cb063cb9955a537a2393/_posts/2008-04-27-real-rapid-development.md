---
id: 42
title: Real Rapid Development
date: 2008-04-27T00:45:22+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/04/26/real-rapid-development.aspx
permalink: /2008/04/27/real-rapid-development/
dsq_thread_id:
  - "1073111247"
categories:
  - Uncategorized
---
&nbsp;&nbsp;&nbsp;&nbsp; From my experience, which is admittedly tainted with many bad RAD experiences, the term &#8216;RAD&#8217; or &#8216;Rapid Application Development&#8217; has come to mean &#8216;Bang on the keyboard and mouse as absolutely fast as possible to get through all the features you can and then have a major death march hero bugfixing party near the end of the project and then ship it and hope for the best.

&nbsp;&nbsp;&nbsp;&nbsp; When the stakeholders come back after a week and say, &#8220;That was great how you guys got that out so fast!&nbsp; Now we need a bunch more things (2x the features) and we need it faster (75% of the time of the last project)!&#8221;&nbsp; and then most of the team quits or finds ways of bailing out of the project and leave it the new guys or the junior developers who didn&#8217;t have enough experience to see it coming. The majority of my experience is similar to this, as a matter of fact. This is probably a major reason why I favor and strive for sustainable, maintainable development practices and principles and more Agile (which, to me, means &#8216;realistic&#8217; and &#8216;communicative&#8217;) management and process techniques.

# Fear of Functionality

&nbsp;&nbsp;&nbsp;&nbsp; I would contend that this style of development &#8212; focused solely on the next deadline &#8212; leads to tremendous amount of waste.&nbsp; In most of these projects I&#8217;ve been involved with, the idea was that you put a bunch of planning and effort in up front to manage where the project would head and then deal with the crisis that come up throughout the project. While not totally worthless (some planning is required no matter what methodology you use, obviously), much of the plans and designs drawn up were quickly out dated and not relevant to the current state of the project.&nbsp; Much of that time was ultimately wasted &#8212; time that could&#8217;ve been spent producing software.&nbsp; 

&nbsp;&nbsp;&nbsp;&nbsp; Many people would stop me here and argue that much of the software written during those phases would&#8217;ve been thrown away also. This is absolutely the case every time I&#8217;ve tried it. But the point is that by writing software and refactoring it, I actually learn about the business problems as well as the software design and architecture problems much faster. The stakeholders can usually see things faster and raise any red flags or major misunderstandings earlier on in the project.&nbsp; The throwing away of code is what some people bristle at. I believe the reason for this is that they&#8217;re not writing and designing their code to be easily thrown away or repurposed. Their code is inherently coupled and scattered throughout the project. They are, essentially, frightened of major changes because their code doesn&#8217;t allow easily for changes.&nbsp; In order to change feature XYZ, you have to touch 27 files in a major way and rip out huge swaths of business logic in 3 parts of the system.&nbsp; I believe that this is the core, fundamental problem and leads to much consternation when I argue on behalf of rapid, but sustainable, code development with a heavy emphasis on refactoring.

&nbsp;&nbsp;&nbsp;&nbsp; The short of it is, if you find yourself uncomfortable when your stakeholders come and propose major functionality changes to the app and you find yourself arguing why XYZ feature is prohibitively difficult due to how the code is organized, you made a big mistake somewhere early on.&nbsp; Don&#8217;t panic, though, there are some real, tangible things you can do right now in any code base to start making a difference!

# Virtues of truly rapid, but sustainable development

&nbsp;&nbsp;&nbsp;&nbsp; So you might be thinking, &#8220;OK, Mr. Smarty Pants, what do you folks do to your code that makes it so magically superior to allow you to turn on dimes like this?&#8221; The answer is not the code, but the way the code is built and the various chemical trails and signal flares we leave behind to make sure that we can easily change major functionality with high confidence of preserving functionality.&nbsp; So