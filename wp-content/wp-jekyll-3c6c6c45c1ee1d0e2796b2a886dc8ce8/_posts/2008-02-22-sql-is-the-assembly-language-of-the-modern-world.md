---
id: 22
title: SQL is the assembly language of the modern world
date: 2008-02-22T00:55:59+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/02/21/sql-is-the-assembly-language-of-the-modern-world.aspx
permalink: /2008/02/22/sql-is-the-assembly-language-of-the-modern-world/
dsq_thread_id:
  - "262113674"
categories:
  - Misc
  - SQL is evil
---
This isn&#8217;t a new idea, it&#8217;s [been mentioned before](http://www.codinghorror.com/blog/archives/000117.html), so I&#8217;m not taking credit for it, but it&#8217;s still worth pointing out&#8230; again&#8230; for the umpteenth time. So I&#8217;m gonna pick up the baton-of-flames and try the argument again:

I really would like to challenge the conventional wisdom that stored procedures are the best and/or that hand-crafted SQL is the only way to achieve good performance.

I once heard someone say that &#8220;SQL is the assembly language of the business application world&#8221; and I totally agree with this (I linked to Jett Attwood&#8217;s post above, but I heard it somewhere else first and my Google-fu is failing me tonight). 

If you read the discussions on USENET back in the day when C++ and later Java were coming into popularity, there were a bunch of die-hards who held the conventional wisdom that C++ and Java compilers couldn&#8217;t possibly ever generate machine code that would achieve the super high performance of lovingly hand-crafted assembly language.&nbsp; Add into that the bytecode interpreting of Java and the Garbage Collector and their heads nearly exploded. 

Now, the same kinds are arguments are being made about not using stored procedures and instead using generators or even the inconceivable: Object/Relational Mappers. 

While the arguments of the assembly-language advocates were mostly true: Compilers can&#8217;t create the mostly highly optimized code, it turns out that modern runtime environments, processors, and operating systems can account for this and actually do a better job of managing the complexities of runtime performance optimizations better than a human assembly language writer could ever hope to achieve.&nbsp; The system now tunes itself on the fly based on the current reality of the operating environment as it stands right now.&nbsp; 

SQL Server is now getting to the point where it&#8217;s able to better tune itself based on the kinds of queries coming in and the volume and type of data it&#8217;s returning. It&#8217;s getting to the point where hand-crafting SQL may actually be self-defeating. We&#8217;re not quite there yet, and there are still scenarios where hand-crafting SQL makes sense. Coincidentally, there are still situations where, in C#, it&#8217;s appropriate to use the unsafe() keyword, or even use unmanaged code or even assembly language! 

I don&#8217;t think we&#8217;ll ever be able to get away from hand-crafted SQL, but I think it should be our goal to standardized on a set and sytle of SQL generation and let the tools like Linq2SQL, NHibernate, etc work with tools like SQL Server and let them work together to optimize your intentions. 

Our goal should be to get out of the SQL crafting business and get back into the data access business.