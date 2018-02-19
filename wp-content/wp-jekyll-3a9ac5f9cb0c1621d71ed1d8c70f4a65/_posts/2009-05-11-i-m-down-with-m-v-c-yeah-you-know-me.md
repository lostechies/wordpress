---
id: 50
title: 'I&#8217;m Down With M.V.C., Yeah You Know Me!'
date: 2009-05-11T01:48:01+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/05/10/i-m-down-with-m-v-c-yeah-you-know-me.aspx
permalink: /2009/05/11/i-m-down-with-m-v-c-yeah-you-know-me/
dsq_thread_id:
  - "262089334"
categories:
  - .net
  - altdotnet
---
Over the past week, I&#8217;ve had some time to dig into the new [ASP.NET MVC framework](http://www.asp.net/mvc/). For starters, my background in web development is mostly classic ASP talking to COM objects built in C++. I&#8217;ve only used ASP.NET to provide web services for smart clients. Beyond that, my experience has been all PHP joined by a short experimentation period with Ruby on Rails. When Scott Gu presented the new ASP.NET MVC framework at the first ALT.NET Austin in 2007, I was excited to see Microsoft stepping into the space where at the time Monorail was the only viable choice.

First things first &#8212; the benefit of waiting until now to jump into ASP.NET MVC is being able to learn from the writing that has been produced. Jimmy Bogard has [written](http://www.lostechies.com/blogs/jimmy_bogard/archive/2009/04/24/how-we-do-mvc.aspx) a number of articles about how they are using the MVC framework, including strong opinions about how to adhere to the SOLID principles and ensure the long-term maintainability of the final application. Jeremy Miller and Chad Myers have certainly [voiced](http://codebetter.com/blogs/jeremy.miller/archive/2008/10/23/our-opinions-on-the-asp-net-mvc-introducing-the-thunderdome-principle.aspx) their [opinions](http://www.lostechies.com/blogs/chad_myers/archive/2009/04/27/to-mvc-or-to-webforms.aspx) about the framework, resulting in their own [FubuMVC](http://code.google.com/p/fubumvc/) framework.

From my initial dive into the framework, it seems as if an emphasis was put on the View and Controller while leaving the Model a bit behind. Views and controllers are certainly easier to demonstrate, but a good model is going to be very domain specific and hard to generalize in a demo. The framework does make it easy to keep the domain and application services separate from both the controllers and the views, so I think the underpinnings for success are certainly present.

At this point, I&#8217;ve only been working with ASP.NET MVC for about a week and I am enthusiastic about what is being provided by Microsoft. Considering Microsoft&#8217;s efforts to work with the development community during the development of the framework combined with developer interest, I think it is a sensible solution and certainly a better alternative to ASP.NET WebForms in a .NET development shop. Plus, I feel that web developers **should** know both HTML and JavaScript, they are the languages of the web after all.