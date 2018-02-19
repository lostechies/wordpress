---
id: 17
title: Resharper 3.1 Solution Wide Analysis
date: 2008-01-06T14:26:39+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/01/06/resharper-3-1-solution-wide-analysis.aspx
permalink: /2008/01/06/resharper-3-1-solution-wide-analysis/
dsq_thread_id:
  - "262089178"
categories:
  - .net
  - agile
---
Since early last year, I have been using [Resharper](http://www.jetbrains.com/resharper/) to increase my .NET coding productivity. After seeing the product used at a Code Camp, I was intrigued by how it make test driven development so much easier. I started on version 3.0 and JetBrains dropped 3.1 on Christmas Eve so I checked it out over the holiday break.

One of the features that first interested me was the [Solution Wide Analysis](http://www.jetbrains.com/resharper/features/code_analysis.html). I turned it on, looked at the badly drawn green circle in the corner of the [Visual Studio 2005](http://msdn2.microsoft.com/en-us/vs2005/default.aspx) IDE, and went, OK. It took me a bit more time to recognize how this new feature was going to improve my skills yet again.

The first thing I learned was that the blinking light was not the real power behind solution wide analysis. The power was that Resharper was working hard eating up those idle CPU cycles to verify the integrity of my entire solution. It wasn&#8217;t until I double clicked and put the window as part of my IDE into practice that I saw the true power (of the force?).

<img src="http://blog.phatboyg.com/wp-content/uploads/2008/01/picture-2.png" alt="Picture 2.png" border="0" width="259" height="331" />

The above image shows the errors in solution window with a clean bill of health, no problems with compilation. The next image shows what it looks like when things get broken:

<img src="http://blog.phatboyg.com/wp-content/uploads/2008/01/picture-3.png" alt="Picture 3.png" border="0" width="274" height="322" />

I slipped the window right under my solution explorer, giving me a constant view of my code status. When refactoring, it makes it easy to see all the affected files at a glance. Very cool. But I do have a couple of nags on this feature:

  * I really don&#8217;t need a tall bar eating space at the top of the window for a repeat of the red/green indicator &#8212; get rid of it
  * I would like the option to expand all the nodes in the tree by default instead of only showing the file names

The new solution wide analysis feature is a great red/green indicator to see the impact of code changes. If you haven&#8217;t upgraded to 3.1 yet, what are you waiting for? And if you aren&#8217;t using Resharper yet, what is holding you back?