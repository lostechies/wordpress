---
id: 43
title: Opinionated Input Builders for ASP.Net MVC – Part 3 the source code.
date: 2009-06-10T13:36:50+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx
permalink: /2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code/
dsq_thread_id:
  - "262054128"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - CoC
---
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx" target="_blank">Part 1 – Overview</a>
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx" target="_blank">Part 2 – the Labe</a>l
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx" target="_blank">Part 3 – the Source Code</a>
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx" target="_blank">Part 4 – the Partial View</a>
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx" target="_blank">Part 5 – the Required Field Indicator</a>&#160;

There have been a number of requests for me to provide the source for the input builders.&#160; I consider this code to be a prototype because, I expect to change the API as this post series helps me work out what should be supported.&#160; I have full intention to add this code to the MvcContrib project once I get the appropriate feedback and documentation as a result of fleshing out this post series.

With that being said the source code is located here: There is only V1 up there now but I expect to have some iterations pretty quickly.

<http://code.google.com/p/erichexter/downloads/list?q=label:Inputbuilder>

**Requirements:**

  * ASP.Net MVC 1.0 
  * Visual Studio 2008 

**Solution Structure:**

> The solution is structured into two projects.&#160; The InputBuilder project is what I would see providing as a dll in the future.&#160; The web project is a MVC web application that shows how to use the InputBuilders as well as override markup for the builders. 

<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_11ABA974.png" width="240" height="474" />