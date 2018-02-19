---
id: 150
title: 'Just say no to &#8216;Poor Man’s Dependency Injection’.'
date: 2009-07-14T14:53:48+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/07/14/just-say-no-to-poor-man-s-dependency-injection.aspx
permalink: /2009/07/14/just-say-no-to-poor-man-s-dependency-injection/
dsq_thread_id:
  - "262114468"
categories:
  - IoC
  - StructureMap
---
For background, Jimmy Bogard [originally posted](http://www.lostechies.com/blogs/jimmy_bogard/archive/2009/07/03/how-not-to-do-dependency-injection-in-nerddinner.aspx) about the ‘poor man’s dependency injection’ style used in NerdDinner. Not to single out NerdDinner, because there are lots of apps out there doing this. NerdDinner just happened to be the most recent and visible so it serves as a good whipping boy.

Tim Barcz respectfully countered with his post "[Why There’s Nothing Wrong With Dependency Injection in NerdDinner](http://devlicio.us/blogs/tim_barcz/archive/2009/07/12/why-there-s-nothing-wrong-with-dependency-injection-in-nerddinner.aspx).”

I promised Tim a respectful rebuttal to explain why there \*IS\* indeed something wrong with ‘poor man’s DI.’&#160; That will be forthcoming.&#160; For now, though, it reminded me of [a post I did](http://tech.groups.yahoo.com/group/altdotnet/message/10434) on the altdotnet yahoo mailing list awhile back.

Here’s an excerpt from it for your convenience:

> Been thinking a lot lately about how to teach about IoC and how to use containers such as StructureMap to someone who either is coming in cold to DI/IoC or has a vague awareness of what it is.   
> Personally, the stages I went through (and have seen few other people go through similarly) are:
> 
>   1. Replace all (most?) new()&#8217;s with ObjectFactory.GetInstance<T>.&#160; You get some immediate benefit out of this and it opens up some new opportunities for your code, but doesn&#8217;t even scratch the surface 
>   2. Move to ctor injection with very explicitly defined instances/pluginfamilies/etc and not using auto-wiring.&#160; Maybe you still even have an old-fashioned C&#8217;tor that still satisfies its own dependencies for those times when &#8216;you might not be using an IoC container&#8217; 
>   3. Embrace auto-wiring, remove non-IoC/DI c&#8217;tors and trust fully the container 
>   4. Start using more advanced techniques like lifecycle management, profiles, convention-based dependency satisfaction, etc 
>   5. Auto-registration, full trust of the IoC. Thoughts start to pop up like, &#8216;I wonder if I could get the Container to write my app for me??&#8217; 

Since I wrote that post, I can now add the following point:

&#160;

6.&#160; Conventional and custom registration. Rather than explicitly registering everything, and more than automatic registration of some things, you develop more complex and conventional ways of registering your objects/services/controllers/etc into the container.&#160; You know you’re in this stage when you’re building your own DSL/FI on top of your container’s configuration model to fit your application’s needs better.

Do you have a 7 or 8 you can add?