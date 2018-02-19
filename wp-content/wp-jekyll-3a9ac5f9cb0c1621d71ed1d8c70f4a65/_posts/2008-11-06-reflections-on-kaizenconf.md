---
id: 39
title: Reflections on KaizenConf
date: 2008-11-06T03:23:24+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/11/05/reflections-on-kaizenconf.aspx
permalink: /2008/11/06/reflections-on-kaizenconf/
dsq_thread_id:
  - "276369973"
categories:
  - altdotnet
---
Last weekend, Dru Sellers and I (along with 100 or so others) attended the [Continuous Improvement in Software Development](http://www.kaizenconf.com/) (referred to as KaizenConf, likely [due to the URL](http://www.kaizenconf.com/)) conference in Austin, TX. We left Tulsa late Friday night after taking my girls trick-or-treating for Halloween and drove all night arriving in Austin around 5:30 AM. After a quick nap and a shower, we went to the first day of the conference.

The night before at the opening, those who were there put up a series of topics that they wanted to discuss. One of those talks was on Enterprise Service Bus (ESB) patterns and implementations using MassTransit. I think it was pretty obvious where Dru and I were going to spend our time right after lunch. There were a number of people that we have had conversations with that also attended and they were excited to learn more about distributed application designs and how to implement them using open-source tools like MassTransit.

<div style="text-align:center">
  <img src="http://blog.phatboyg.com/wp-content/uploads/2008/11/img-0093.jpg" alt="IMG_0093.jpg" border="0" width="640" height="480" />
</div>

### The First Session: Alternative Architectures

After the morning announcements, Dru and I joined [Ben Scheirman](http://flux88.com/) and [Ayende Rahien](http://ayende.com/) in a conversations about alternatives to the RDBMS. The conversation started a bit rough, but quickly opened up into other ways to store data in our applications. Ayende brought up CouchDB and the things he learned about it. There was also some in depth discussions about proper use of databases and separating transactional data from reporting to avoid transaction blocks. Some concepts on how to achieve the appropriate separation, including asynchronous ETL (extract-transform-load) were discussed. The Map/Reduce algorithm was also covered and some examples were given in the discussion of how to map data into dimensions for reporting. The proceedings from this talk can be [found on the wiki](http://kaizenconf.pbwiki.com/Beyond+Traditional+Architecture).

<div style="text-align:center">
  <img src="http://blog.phatboyg.com/wp-content/uploads/2008/11/img-0094.jpg" alt="IMG_0094.jpg" border="0" width="640" height="480" />
</div>

### The Second Session: Lean Architecture

My second session of the day was on Lean Architecture. This discussion was forward looking and related to how development teams could branch out and work on features with the intent of releasing individual features as they are complete (instead of waiting for a big release with many unrelated features). There was a lot of talk about how the teams work, how version control and build processes would need to adapt to handle the complexity of dealing with multiple development versions of a single code base. I think one of my biggest take aways from this session was the need for an integration branch that is created from the trunk before each merge. It is then possible to integrate a branch into the trunk without immediately impacting the trunk. Once the simulation branch merge is complete and tested, the simulation is merged into the trunk (which should be easy, since it was created from the trunk originally). This alone would help to ensure a solid trunk that can be delivered on demand. The proceedings from this talk are [also on the wiki](http://kaizenconf.pbwiki.com/Lean%20Architecture).

Over lunch we enjoyed some amazing Austin weather while talking about projects and recent events. We then went to setup for the discussion on ESB/MassTransit. Upon arrival, we were surprised at the number of people in attendance. There was a crowd of at least 20 people and the video crew was setup with remote microphones and the works. Once we had gotten the projector setup and demos loaded, we started into the discussion.

### The Third Session: ESB Patterns and MassTransit

The conversation started with a general discussion about messaging patterns. A reading list was presented, along with the major patterns that are used in a publish/subscribe system like an ESB. Applications for this type of system including everything from a command/query interactive system to migrating a batch processing application to a more real-time asynchronous process. We touched on where MassTransit was in the development lifecycle and some of the things we learned over the last year of development. We showed some of the sample applications, including the new [web service bridge sample](http://blog.phatboyg.com/2008/10/22/new-masstransit-screencast-and-sample/) for connecting external customer web services to an internal domain.

Needless to say, we were amazed at the response we got related to MT and ESB patterns in general. It was great to have Ayende and [Jeremy Miller](http://codebetter.com/blogs/jeremy.miller/default.aspx) bouncing ideas around regarding the project and integration with other existing systems. The notes from the discussion are located on the [KaizenConf Wiki](http://kaizenconf.pbwiki.com/ESB-Patterns).

### The Last Session: A Mixed Bag

My last session of the day was split between two completely different sessions. One was on [Advanced IOC](http://kaizenconf.pbwiki.com/Advanced%20IOC%20Beyond%20Constructor%20Injection) usage, and the other was on moving from [Project to Product](http://kaizenconf.pbwiki.com/From%20%22Project%22%20to%20%22Product%22). I bounced between these two sessions, picking up some interesting bits from each one. Both were late in the day, so I was fading pretty fast considering I only had 90 minutes of sleep the previous night. Good concepts were captured in the notes, so be sure to check those out (I&#8217;ll have to just to remember them).

After the sessions for the day, we went to the Hyatt with Ben (B#) and provided input as he started writing a new sample for MassTransit. The context for this new sample was the Gregor Hohpe article about how [Starbucks Does Not Use Two-Phase Commit](http://www.eaipatterns.com/ramblings/18_starbucks.html). This was mostly a learning exercise for Ben, however, we gained some insight watching him build it out. I think Dru refactored the host quite a bit to remove some extraneous ceremony that was just unnecessary. Once we had the first bits working, it was time to find some dinner and the rest of the gang. We had some great Tex-Mex at Trudy&#8217;s and then went back to the hotel bar to watch Texas Tech put the smack down on U-Texas Longhorns. 

The next morning we met up at Starbucks (go figure) to complete the new sample Ben was building (yes, the irony of working on a sample about Starbucks @ Starbucks didn&#8217;t get past us). We ended up converting from using regular message consumers to a saga-based approach given the requirements and it took another 30 minutes to get it all working. Oren had some great ideas on how we could tweak little things here and there to eliminate some friction as well. Once we were done, we headed on over to the conference to see what was in store for the morning sessions.

This year, the focus of the conference was on continuous improvement. Therefore, instead of just having additional sessions on Sunday morning the attendees voted on sessions that they wanted to help improve. At least, that&#8217;s how I understood it, we were working on the Starbucks sample, remember? Anyway, when we arrived we found that the ESB Patterns session was one of the topics. The room was full with something like 22 votes on the page. I was surprised to see the response of the people, truly surprised.

### Continuous Improvement: ESB Patterns and MassTransit

The actions [are summarized on the wiki](http://kaizenconf.pbwiki.com/Actions+from+Sunday), and included things like documentation, more sample applications, and help on how to add messaging to an existing application. We also dug into the things needed to help people build and understanding messaging components in their applications. Things like diagnostics, conventions to avoid common missteps, hands-on labs to walk through building a message-based component, and a few other getting started items were brought up. From a technical side, we talked about additional patterns such as an overall conversation id to correlate multiple sagas (like a saga of sagas), as well as built-in support for compensation.

A large part of the discussion was on how functional programming features could be used to enhance the system. An example in Erlang of a message exchange was drawn up, along with how it might be written in C#. [Matthew Podwysocki](http://podwysocki.codebetter.com/) was consulted on how this example might be written in F#, and there was discussion about how the threading model of F# doesn&#8217;t really support the style used by Erlang. Some work is still needed there I suppose but we&#8217;ll continue to be open about the possibilities offered by functional languages. Glenn Block also talked about getting in touch with the connected systems group to see what they could offer.

<div style="text-align:center">
  <img src="http://blog.phatboyg.com/wp-content/uploads/2008/11/img-0095.jpg" alt="IMG_0095.jpg" border="0" width="640" height="480" /><br />County Line BBQ
</div>

With that, the conference was closed. Once again, the open space technology used for the event was awesome. The rules of open space dictate that what happened is the only thing that could have happened, and I agree with that completely. It was great to be a part of yet another excellent event and I look forward to future installments in other locations. Be sure to keep up with [the wiki](http://kaizenconf.pbwiki.com/), as videos from most of the sessions will be made available online soon. One of our improvements was to better document our proceedings, and I think we&#8217;ve managed to succeed on that one for sure.