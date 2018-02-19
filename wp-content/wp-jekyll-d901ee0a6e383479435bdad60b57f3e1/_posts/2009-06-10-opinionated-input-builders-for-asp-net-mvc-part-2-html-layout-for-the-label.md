---
id: 42
title: 'Opinionated Input Builders for ASP.Net MVC &#8211; Part 2 Html Layout for the Label'
date: 2009-06-10T01:26:02+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx
permalink: /2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label/
dsq_thread_id:
  - "262053478"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - CoC
---
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx" target="_blank">Part 1 – Overview</a> 
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx" target="_blank">Part 2 – the Labe</a>l 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx" target="_blank">Part 3 – the Source Code</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx" target="_blank">Part 4 – the Partial View</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx" target="_blank">Part 5 – the Required Field Indicator</a>&#160; 
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx" target="_blank">Part 6 – the Performance</a> 
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/14/opinionated-input-builders-part-7-more-on-performance-take-2.aspx" target="_blank">Part 7 – the Performance Take 2</a>
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/17/opinionated-input-builders-part-8-the-auto-form.aspx" target="_blank">Part 8 – the AutoForm</a>

In part two of this series I will cover the different components of the Input as it is rendered to HTML and explain how each of those are created by the Input Builder.

Given the following form layout I will explain each feature of the input builder framework.

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image_thumb2" src="http://lostechies.com/erichexter/files/2011/03/image_thumb2_7DCD6C39.png" width="644" height="346" />](http://lostechies.com/erichexter/files/2011/03/image5_5EF6F85B.png) 

## the Label

<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="inputbuilder-label" src="http://lostechies.com/erichexter/files/2011/03/inputbuilder-label_43DE294D.png" width="561" height="309" />

The text highlighted in red are labels that come from the Model type. The label is created from the PropertyInfo object that represents the respective properties of the mode.

  1. The label is Property Name. 
  2. The label is the Property Name that is split on the pascal case property name. 
  3. The label is specified by using the Label Attribute applied to the property. 

 <img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="inputbuilder-label-model" src="http://lostechies.com/erichexter/files/2011/03/inputbuilder-label-model_554E8A25.png" width="626" height="453" />

The html for the label is created in a Content control of the Field.Master Master Page. That control is highlighted in red.

<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="inputbuilder-label-masterpage" src="http://lostechies.com/erichexter/files/2011/03/inputbuilder-label-masterpage_46A3DE40.png" width="803" height="394" />

That explains how the labels are rendered to the html for the builder.&#160; There will be more posts in this series to explain the other conventions followed by the Input Builders.

&#160;

This is part 2 in the series.

  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx" target="_blank">Part 1 – Introduction to the Input Builder</a>