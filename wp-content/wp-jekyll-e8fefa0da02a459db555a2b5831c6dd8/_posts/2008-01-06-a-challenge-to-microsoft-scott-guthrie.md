---
id: 9
title: A Challenge to Microsoft, Scott Guthrie
date: 2008-01-06T14:35:29+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/01/06/a-challenge-to-microsoft-scott-guthrie.aspx
permalink: /2008/01/06/a-challenge-to-microsoft-scott-guthrie/
dsq_thread_id:
  - "262113563"
categories:
  - .NET
---
After reading [Ayende&#8217;s latest post](http://ayende.com/Blog/archive/2008/01/06/ASP.Net-Ajax-Error-Handling-and-WTF.aspx), and having run into few myself just this weekend (see System.Data.SqlClient.MetaType), I&#8217;d like to challenge Microsoft&#8217;s .NET efforts, and particularly Scott Guthrie&#8217;s group (since I have the most hope of them actually accomplishing this), to release a library/framework/module (something like ASP.NET AJAX, ASP.NET MVC Extensions, etc &#8212; on that scope) with the following statistics:

  * 0% &#8216;internal&#8217; keyword usage
  * 0% &#8216;sealed&#8217; keyword usage
  * 0% (or very few) &#8216;static&#8217; keyword usage
  * 0% (or very few) &#8216;private&#8217; methods (only private fields).

If this functionality is good enough for you, why isn&#8217;t it good enough for us!

Also, sometimes you guys make mistakes or do something not very good (we all do, I&#8217;m not pointing fingers), and having a most of those methods be &#8216;virtual&#8217; would really help so that we can fix things when occasional mistakes occur.

This would help us folks in the field more than you know!