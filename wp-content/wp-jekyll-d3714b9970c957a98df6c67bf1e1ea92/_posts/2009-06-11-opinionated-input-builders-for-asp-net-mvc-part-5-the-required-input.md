---
id: 45
title: Opinionated Input Builders for ASP.Net MVC – Part 5 the Required input
date: 2009-06-11T02:58:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx
permalink: /2009/06/11/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input/
dsq_thread_id:
  - "262043648"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - 'c#'
  - CoC
  - mvccontrib
---
  * <a target="_blank" href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx">Part 1 &ndash; Overview</a>
  * <a target="_blank" href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx">Part 2 &ndash; the Labe</a>l
  * <a target="_blank" href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx">Part 3 &ndash; the Source Code</a>
  * <a target="_blank" href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx">Part 4 &ndash; the Partial View</a>
  * Part 5 &ndash; the Required Field Indicator 

### The Required Field Indicator

The Required Field Indicator is a property which allows the UI to indicate that a field is required.&nbsp; The example below shows that an&nbsp;asterisk&nbsp;could be used to indicated the field is required. This could be used to apply a css class to the Label which could change the color or bold the label.&nbsp; The possibilities for how you turn this property into a compelling user interface is endless. The important point to know is that there are different approaches to decide how this could be set.

 <img height="343" width="644" src="//lostechies.com/erichexter/files/2011/03/image_596CFF37.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />

&nbsp;

### Model Approach

Here is an example of using a DataAnnotations Required attribute as a way to indicate the field is required.&nbsp; I like this approach since this attribute can be used with a <a target="_blank" href="http://www.asp.net/learn/mvc/tutorial-39-cs.aspx">Model Binder to perform Model Validation using model state</a>.&nbsp;&nbsp; This model binder will be provided in the ASP.Net MVC 2.0 release so I included this as a way to get synergy with existing features of the MVC framework.

 <img height="352" width="644" src="//lostechies.com/erichexter/files/2011/03/image_71906992.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />

I have received a lot of feed back that people feel marking your model with attributes pollutes the model.&nbsp; I disagree with this because the models that I use are View Models not my Domain entities which represent my business object which will be stored into my database.&nbsp; The Models that I would decorate with validation attributes would be used for one specific MVC View.&nbsp; The model would represent the fields needed to create the User Interface view.&nbsp; 

### Fluent Approach

An alternative approach to using attributes would&nbsp; be to use a Fluent method as shown below. I dislike this approach as it does not work with my preferred way of performing data type validation using the MVC Model Binder. in the framework. I would be more likely to use the fluent methods for the Label or PartialView selection, but I would not use it for the Required indicator because it would mean I am duplicating how I identify a required property on my Model.

 <img height="337" width="644" src="//lostechies.com/erichexter/files/2011/03/image_3081EA2E.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />

### The View markup

Here is an example of how the Required property is used in the Field.Master master page.&nbsp; As I wrote earlier, this could be used to add a css class to the html markup.

<img height="214" width="644" src="//lostechies.com/erichexter/files/2011/03/image_7A30C21E.png" alt="image" border="0" style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" />

### Your own convention

The framework uses a convention to determine if a Model property is required.&nbsp; By implementing your own **_PropertyIsRequiredConvention_** you could make all Properties with the name **Name & Description** required or&nbsp; whatever makes sense for the type of application that you are creating. It could be **Username or email** if you are creating a consumer facing website the possibilities are endless. But at the end of the day you can have your own convention.

 <img height="299" width="1028" src="//lostechies.com/erichexter/files/2011/03/image_6E2ED1EA.png" alt="image" border="0" style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" />

Here is the implementation of my Default Convention for Property Is Required, it is simple and to the point.&nbsp; I could see implementing some sort of Chain of Responsibility pattern here and in the other conventions to have some consistency to your User Interface. 

 <img height="122" width="644" src="//lostechies.com/erichexter/files/2011/03/image_66372F88.png" alt="image" border="0" style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" />

Thoughts&hellip; opinions..?