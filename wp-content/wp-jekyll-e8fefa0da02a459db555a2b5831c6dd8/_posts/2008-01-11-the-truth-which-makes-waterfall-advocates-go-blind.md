---
id: 12
title: The truth which makes waterfall advocates go blind
date: 2008-01-11T19:04:58+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/01/11/the-truth-which-makes-waterfall-advocates-go-blind.aspx
permalink: /2008/01/11/the-truth-which-makes-waterfall-advocates-go-blind/
dsq_thread_id:
  - "262113590"
categories:
  - Uncategorized
---
[Frans Bouma](http://weblogs.asp.net/fbouma) recently posted a [post to his blog](http://weblogs.asp.net/fbouma/archive/2008/01/11/the-waterfall-which-makes-agile-pundits-go-blind.aspx?CommentPosted=true#commentmessage) pointing out some of his frustration with the various ALT.NET communities (specifically mailing lists).&nbsp;&nbsp; As I understand it, his primary argument was that there wasn&#8217;t much academic thinking and citations behind some of the positions and postulations people have voiced on the list. While I certainly appreciate his (and am guilty of it) and agree that there&#8217;s a less citation and academic backup behind some of the ideas than there should be.&nbsp; Part of this is simply because the CS academic community is behind the commercial world in some areas, and the commercial software development world generally doesn&#8217;t produce a lot of academic-quality research papers sufficient for the level of citation Frans appears to be demanding.

But aside from that, I have a particular beef with Frans over his position on Waterfall. He has, on several occasions, asserted that there are specific situations where the waterfall methodology makes sense and/or is even preferred &#8212; even necessary. He used a specific contrived example of MRI (Magnetic Resonance Imaging) machines and the software that runs them.&nbsp; This is essentially an argument that mission-critical, life-critical machines MUST or SHOULD be developed using Waterfall.&nbsp; I&#8217;m not sure I agree with this and the two seem to be separate, if not mutually exclusive.So, in order to elevate the discussion using Frans&#8217; suggestion, I did some research to try to find how and what methodologies are used for mission- or life-critical systems such as medical machines, military combat command and control systems, etc.

## Case Example: QinetiQ

I stumbled upon [this press release](http://www.qinetiq.com/home/case_studies/health/qinetiq_mayo_mrisoftware_deal.html) from a company called [QinetiQ](http://www.qinetiq.com) announcing an MRI software deal with [Mayo Clinic](http://www.mayoclinic.org/) in Minnesota (a world-renowned top-notch medical facility).&nbsp; It turns out that QinetiQ also builds other life-critical systems including [Hyperbaric Oxygen Wound Healing](http://www.qinetiq.com/home/case_studies/health/hyperbaric_oxygen_and_wound_healing.html) chambers and, perhaps more interesting, battlefield tactical management and human integration systems. They have a product named (and I love this name): SMITE &#8211; Systems Management In Tactical Environments.

 <img height="321" src="http://www.qinetiq.com/home/case_studies/health/smite.MediaPar.0003.Image.gif" width="485" />

(screen shot from QinetiQ&#8217;s SMITE application)

## Software Methodologies in C2 Systems

Ok, so we&#8217;ve established that QinetiQ is doing some pretty heavy life-and-death critical stuff. So, if Frans is right, they are most likely using some form of Waterfall Methodology, because it&#8217;s the only one reliable enough to guarantee critical software reliability, right?

Imagine my surprise when I saw [this PDF whitepaper](http://handle.dtic.mil/100.2/ADA466925) that QinetiQ&#8217;s UK office prepared for the [8th ICCRTS Command and Control Research Technology Symposium](http://www.dodccrp.org/events/8th_ICCRTS/Pres/track_4.htm), and [indexed by](http://stinet.dtic.mil/oai/oai?&verb=getRecord&metadataPrefix=html&identifier=ADA466925) the U.S. Department of Defense&#8217;s [Scientific and Technical Information Network](http://stinet.dtic.mil/) (suggesting the world&#8217;s largest military apparatus is interested in this information). The PDF walks through various popular software methodologies including Waterfall, V-Model, SSADM, and a pragmatic, quasi-Agile &#8220;Rapid Application Development&#8221; methodology (they call it). They weigh the plusses and minuses of the various methodologies and essentially eliminate them one by one.&nbsp; Of particular interest, here is an excerpt where they argue that Waterfall will not work for critical &#8220;C2&#8243; (command & control) systems:

> The waterfall model was based on a number of assumptions:&nbsp;&nbsp; 
> 
>   * that all its stages could be completed in sequence 
>       * that the costs and benefits of an information system could be calculated in   
>         advance 
>           * that users knew what they wanted 
>               * that the work needed was known and could be measured 
>                   * that programs once written could be altered 
>                       * that the right answer could be produced first time </ul> 
>                     For the development of C2 systems, none of these have been shown to be true. C2   
>                     systems have proved difficult to manage because of at least two major problems   
>                     which cannot be dealt with by traditional management methods. These are (Grindley,   
>                     1993): 
>                     
>                       * the difficulty of stating what is required 
>                           * the difficulty of measuring pioneering work </ul> 
>                         The traditional life cycle approach effectively ignores these issues and developers   
>                         have been forced to consider other methods to overcome these problems. One solution   
>                         is to integrate prototyping into the user and system requirement processes.</blockquote> 
>                         
>                         ## It&#8217;s Scientific Frans, Waterfall Doesn&#8217;t Work; All Non-Agile Projects Eventually Devolve into Necessary Sub-Standard Agile
>                         
>                         Now, granted, this is only one white paper (which cites the book &#8220;[Managing IT at Board Level: The Hidden Agenda Exposed](http://www.amazon.com/Managing-Board-Level-Financial-Publishing/dp/0273613057)&#8220;), but I&#8217;m quite sure that given a few more days, I could come up with quite a few more examples.
>                         
>                         Frans, I respect you greatly and you&#8217;re a very smart guy, but I defy you to show me quantitative proof that Waterfall has led to the success of anything after the 1950&#8242;s, rather than projects succeeding in spite of the Waterfall process they started using.
>                         
>                         It has been my anecdotal experience that all projects that aren&#8217;t specifically attempting to do Agile will eventually end up there out of force of necessity, but they will do it too late and without proper methodology, thus jeopardizing the project itself, or the moral of the talent on the team.
>                         
>                         Agile, at its most basic, it concerned with managing the main, unavoidable (whatever your Waterfall books may say) constant in all projects: You (anyone) simply cannot know everything that will need to be done in order to call the project &#8216;Done&#8217;. Done is something that is eventually discovered, no matter how good the planning, experience, and knowledge of the problem is up front.