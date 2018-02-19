---
id: 65
title: In the ORM Battle, Everyone Loses.
date: 2008-06-29T01:06:33+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/06/28/in-the-orm-battle-everyone-loses.aspx
permalink: /2008/06/29/in-the-orm-battle-everyone-loses/
dsq_thread_id:
  - "262113883"
categories:
  - Database
  - ORM
---
As Ted Neward aptly pointed out in his post: [ORM is the Vietnam of Computer Science](http://blogs.tedneward.com/2006/06/26/The+Vietnam+Of+Computer+Science.aspx)(credit to [Justin Etheredge](http://www.codethinked.com) for reminding me of this).&nbsp; You need to do it, but there&#8217;s no real good end solution here. RDBMS do what they do very well (that is, persist things to disk and load them back up quickly and reliably).

Yet another reason (and there are many) why I feel strongly that things like DDD and PI are extremely important, and why I feel that Model-Driven Architecture and the sort of behavior that the v1 of the Entity Framework will be targeting/enabling is not a good long term strategy, is that the problems that RDBMS&#8217; solve are not problems that we may have for much longer.

Consider this: What are the major problems that RDBMS&#8217; solve?&nbsp; I thought about this for awhile and came up with this list (which I&#8217;m not declaring exhaustive by any means):

  1. Transactional interaction
  2. Fast, reliable storage of data to a disk medium
  3. Fast, reliable retrieval of data to a disk medium
  4. Fast querying of data

Now, consider this: With RAM getting cheaper and cheaper (database servers with 12-16GB RAM are common place, 32-64GB are available, 128/256 are conceivable), and solid state drives already on the market and getting bigger and faster, won&#8217;t the need for items #2 and #3 become irrelevant?

Most large DB server setups I know of already have 16GB mirrored memory (32 / 2) and load up the entire DB into RAM and cache all the queries execution plans, etc, etc, etc.&nbsp; The database is essentially an IN MEMORY database.&nbsp; It&#8217;s conceivable that in is a few as 5 years, solid state drives will be the norm, or at least readily available such that the storage and retrieval from a disk medium is not required or will change significantly.

Given these facts (and I hope you agree these are facts), do we really need to keep architecting our systems with a heavy bias on a pre-OO (1969) relational model designed for efficient structure of data for storage and retrieval using an equally archaic query language (SQL) to access it?

Don&#8217;t get me wrong, I&#8217;m not advocating we throw out our databases today and stop writing SQL. Quite the contrary; ADO.NET will still have a long and fruitful life.&nbsp; No, what I propose is that we design our systems such that we do not limit our design to mere relational model persistence concerns. We design our software to take best advantage of what the application architecture/framework affords us (i.e. fundamental OO concepts) and then figure out a way, in the mean-time, to map our OO design to our relational model which is also carefully crafted and managed properly.

To keep with Ted&#8217;s motif:&nbsp; If ORM is Vietnam, then we must keep an eye on the real goal: The fall of the Soviet Union (RDBMS for managing slow disks).&nbsp; ORM is a short-lived, necessary, but bloody battle. Soon when slow-spinning disk storage is no longer a concern, issues #2 and #3 will be removed.&nbsp; DBAs will be free to worry about more high level concerns about the best way to arrange queries and how to ensure that transactions are getting used correctly, etc rather than having to worry about where clustered indexes go or how long that NVARCHAR field should be, etc.&nbsp; We&#8217;ll still need those DBA&#8217;s, but we&#8217;ll need their higher order functions, and not waste their time by having them do menial tasks like log file rollover schedules.

Please do not allow your application architecture to be dominated by RDBMS concerns. That isn&#8217;t to say that you shouldn&#8217;t be concerned with your RDBMS, I&#8217;m saying that your application code that determines whether a given user gets a 5% or 10% discount should have nothing to do with the database at all (and shouldn&#8217;t need things like a .Load() call to the DB or to execute a SQL stored procedure &#8212; or at least these things should be abstracted away from the core biz logic to the maximum extent possible).

My concern with the mindset to which tools like EF v1 are appealing is that you will not (easily) be able to accomplish this level of separation of concerns.&nbsp; Database/persistence concerns will naturally bleed into every part of your application.&nbsp; With the promised features of EF v2, you will be more able to accomplish the appropriate level of separation of concerns.&nbsp; Thus, you will be able to quickly adapt to any new breakthroughs that are (hopefully) just around the corner in the Database world when Solid State drives or in-memory databases become the norm.