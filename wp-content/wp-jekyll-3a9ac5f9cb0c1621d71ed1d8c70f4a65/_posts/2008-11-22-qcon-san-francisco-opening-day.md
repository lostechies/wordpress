---
id: 42
title: QCon San Francisco, Opening Day
date: 2008-11-22T05:50:49+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/11/22/qcon-san-francisco-opening-day.aspx
permalink: /2008/11/22/qcon-san-francisco-opening-day/
dsq_thread_id:
  - "365364476"
categories:
  - Uncategorized
---
The main conference for QCon started Wednesday, opening with a keynote by Martin Fowler and Rebecca Parsons from Thoughtworks. The topic was Architects and Agilists &#8211; Allies not Adversaries. As you can surmise from the title, this talk focused on building a collaborative relationship between ivory tower architects and the teams responsible for delivering software. With a scene from the Matrix where Neo meets The Architect as the backdrop, a number of solutions were presented after highlighting the key disconnects between the two roles. I&#8217;ve always been a firm believer that architects who do not code (NCA&#8217;s) are not nearly as effective as those who understand the issues of those actually writing code.

### MERB

Since the presentation by Dan North was overflowing with humanity, we opted to attend the session on MERB. MERB is a high-performance, scalable MVC framework for Ruby. It is in the same space as Rails, but with a lot of optimizations to increase performance. It also supports slices, allowing features to be added as simple gems. This is one to keep an eye on as it grows.

### Google App Engine and the Google Data APIs

My next stop was to learn about Google&#8217;s AppEngine and how it handles scalability and performance. It&#8217;s currently free, and developers can build and deploy applications into the cloud using Python and Bigtable. It&#8217;s an interesting engine with a completely transparent scaling infrastructure. You worry about your application, the system takes care of the rest. Large applications have been built and Google has allowed them to scale beyond the standard quota for free accounts. While final pricing has yet to be discussed, it&#8217;s likely to be very competitive. There is also a planned introduction of new language support early next year, but the exact language runtime being added was kept secret.

### Responsive Design

The next stop was a talk by the legendary Kent Beck and his thoughts on what he calls responsive design. This talk was way up the clouds, and I&#8217;m talking the real ones. I think it&#8217;s great that we have people that think that far out, but I found little to take away from this session other than some looks of befuddlement. 

### Coupling, Messages, and Conversations

Since I started working on [MassTransit](http://code.google.com/p/masstransit/), I&#8217;ve used the [Enterprise Integration Patterns](http://www.integrationpatterns.com/) book by Gregor Hohpe as a reference manual for building distributed message-based systems. In this talk, Gregor laid down some fundamentals and set the stage for a sequel to the book that will be titled Conversation Patterns. But first, the challenges of message-based systems were presented. The levels of failure are quite involved, and include things like lost request, lost response, slow response and retry duplication. A lot of these are covered in texts online, so much of this material was review for me. A new acronym for ACID was also declared: Associative, Commutative, Idempotent, and Distributed. 

With large scale distributed systems where consistency is of a more eventual rather than immediate nature, it&#8217;s important to recognize that the future if flexible and redundant rather than predictable and accurate. Building distributed transactions that are durable and that support compensation is crucial to having a success, scalable application.

During the final session slot, a few of us sat down and had an in-depth discussion about what we had learned that day. Realizing that this was only the first and lightest day, we recognized quickly that we were in for a couple of dense days of exposure. We went over some things in MassTransit, and thought about how we could offer a more developer-friendly method of managing the state of distributed transactions (sagas in MT). We also delved into the hierarchical structure of conversations on top of sagas, a topic we hoped to dig into more as we saw multiple concurrent sagas running in parallel as part of an overall conversation.

### Attendee Party

That evening, there was an attendee party at a nearby pool hall. After some snacks and a quick game of pool, Dru and I sat down with Gregor to discuss some messaging concepts. After a quick exchange in Japanese, we earned a seat at the table and started to talk about various conversation patterns that we had identified in our own work. I was surprised that we were thinking along the same lines and that several of the message patterns we had used were going to be covered in the book. We also talked a little bit about [Google Protocol Buffers](http://code.google.com/apis/protocolbuffers/) (a platform and language independent format for serializing data in an efficient, binary stream). We started digging into GPB a few weeks ago as a way to build more system interoperability between Java and .NET when using MassTransit. Based on our process so far, this is likely to end up in a future release of MT.

With that, the evening was pretty much done with my head pounding. I retired for the night recognizing that the time zone change was probably going to result in me waking up at 4:00 AM again (which, of course, I did).