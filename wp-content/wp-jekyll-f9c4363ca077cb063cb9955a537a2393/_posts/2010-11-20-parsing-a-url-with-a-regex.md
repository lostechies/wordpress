---
id: 171
title: Parsing a URL with a Regex
date: 2010-11-20T00:29:58+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2010/11/19/parsing-a-url-with-a-regex.aspx
permalink: /2010/11/20/parsing-a-url-with-a-regex/
dsq_thread_id:
  - "262114566"
categories:
  - parsing
  - regex
---
If that title didn’t strike you dead with fear, then you’ve never attempted this impossible task before. I consider it right up there with finding [Shangri-la](http://en.wikipedia.org/wiki/Shangri-La),&#160; [Atlantis](http://en.wikipedia.org/wiki/Atlantis),&#160; [Z](http://en.wikipedia.org/wiki/Lost_City_of_Z), or [El Dorado](http://en.wikipedia.org/wiki/El_Dorado).

Lots of <strike>ink has been spilt</strike> [bytes have been wasted](http://codinghorror.com/blog/2008/10/the-problem-with-urls.html) seeking this mythical creature but no silver bullet has been found.&#160; Thanks to a [Mike Strobel](http://codedreams.blogspot.com/), a friend on twitter, he pointed me to John Gruber’s [attempt at the problem](http://daringfireball.net/2010/07/improved_regex_for_matching_urls).&#160; You may know John for his co-authoring of “[markdown](http://en.wikipedia.org/wiki/Markdown).” Needless to say, he knows a thing or two about parsing text.

John’s regex is nearly perfect and captures most of the nastiest test cases he or I could throw at it.&#160; He released this pattern as public domain. But it doesn’t appear to be actively maintained anywhere that I could see.&#160; Otherwise, my Goggling skills are failing me.&#160; If you know of such a project that is actively maintaining his pattern, please let me know in the combox below.

I wanted to get this thing on Github ASAP so that the world might begin maintaining this thing in the hopes of, together, developing the One, True, Perfect URL Regex Pattern (OTPURP – ok, so I need better marketing).

If you have interest in something like, or if you have developed the OTPURP and wish to share/contribute it to the world, please check out my attempt to centralize it:

<https://github.com/chadmyers/UrlRegex>

It if takes off, I’m happy to move the repo home to a neutral account and turn control over to someone or someones else.

I’ve set up a test suite for it based on John’s test cases and some of my own. If you clone the source and open start.html, you should see something like this:

[<img style="border-bottom: 0px;border-left: 0px;padding-left: 0px;padding-right: 0px;border-top: 0px;border-right: 0px;padding-top: 0px" border="0" alt="urlregex" src="http://lostechies.com/chadmyers/files/2011/03/urlregex_thumb_600BADC1.png" width="675" height="657" />](http://lostechies.com/chadmyers/files/2011/03/urlregex_1A6723A3.png)