---
id: 52
title: Opinionated Input Builders – Part 9 override the default Date Time picker
date: 2009-06-30T13:07:23+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/30/opinionated-input-builders-part-9-override-the-default-date-time-picker.aspx
permalink: /2009/06/30/opinionated-input-builders-part-9-override-the-default-date-time-picker/
dsq_thread_id:
  - "262687386"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - CoC
  - mvc
  - mvccontrib
  - Open Source Software
  - OSS
---
&#160;

  * [Part 1 – Overview](http://www.lostechies.com/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx)
  * [Part 2 – the Labe](http://www.lostechies.com/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx)l 
  * [Part 3 – the Source Code](http://www.lostechies.com/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx)
  * [Part 4 – the Partial View](http://www.lostechies.com/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx)
  * [Part 5 – the Required Field Indicator](http://www.lostechies.com/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx)
  * [Part 6 – the Performance](http://www.lostechies.com/blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx)
  * [Part 7 – the Performance Take 2](http://www.lostechies.com/blogs/hex/archive/2009/06/14/opinionated-input-builders-part-7-more-on-performance-take-2.aspx)
  * [Part 8 – the AutoForm](http://www.lostechies.com/blogs/hex/archive/2009/06/17/opinionated-input-builders-part-8-the-auto-form.aspx)
  * Part 9 – override the default Date Time Picker

I received a comment from Scott Hanselman about how would a better date time picker look using the opinionated input builders.&#160; I knew that this would be a complex problem just for the fact that there are currently very few good solutions to this problem now.&#160; While JQuery provides a great Date picker I am not very happy with the time picker.&#160; So&#160; here is a version of what this could look like.&#160; What I like about this approach is that it takes all the complexity including the multiple form elements and javascript and pushes it to a small partial that can be easily reused as well as it could be easily tested using QUnit.

&#160;

The user interface I came up with is a combination of the Jquery UI datepicker and a set of dropdowns to select the time.&#160; I trimmed down the minute select box so that it only contains fifteen minute increments for this example.

<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_393D72DF.png" width="616" height="174" />

&#160;

In order to implement this I added a call to the Partial( ) method and passed in the name of my opinion for how a datetime should be rendered.

 <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_69844795.png" width="1145" height="167" />

The next step was to add a partial control with the same name to my Shared view folder.&#160; This could have been placed in the Home folder if I only wanted to have this input available for that controller.

&#160; <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_1D4C3DE7.png" width="245" height="357" />

The code for the Partial view looks like the following. The view page is strongly typed to a DateTime model property. Than comes some jquery to pull it all together. 

I rendered a hidden field, this field will be used to databind when being posted back to my Save Action.&#160; The other elements I appended some fixed names so that I can wire up an event that updates the hidden field when any of the values of the dropdowns or the date pickker text box changes.&#160; I also write a dynamice method named after the input field in order to reduce the client side code.

 <img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_75398EC7.png" width="1028" height="429" /></p> </p> </p> 

This is one approach to solve this problem,&#160; if you did not want to include this javascript and do the client side wire up of updating the hidden field this same work could be done in a Custom Model Binder that is wired up for DateTime objects that could look for fields with these names and than it could do the formatting.&#160; So there you go a few ways to tackle this problem.