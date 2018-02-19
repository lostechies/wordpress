---
id: 49
title: Opinionated Input Builders – Part 8 the Auto Form
date: 2009-06-17T17:38:20+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/06/17/opinionated-input-builders-part-8-the-auto-form.aspx
permalink: /2009/06/17/opinionated-input-builders-part-8-the-auto-form/
dsq_thread_id:
  - "262105677"
categories:
  - Uncategorized
---
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-using-partials-part-i.aspx" target="_blank">Part 1 – Overview</a> 
  * <a href="/blogs/hex/archive/2009/06/09/opinionated-input-builders-for-asp-net-mvc-part-2-html-layout-for-the-label.aspx" target="_blank">Part 2 – the Labe</a>l 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-source-code.aspx" target="_blank">Part 3 – the Source Code</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-3-the-partial-view-inputs.aspx" target="_blank">Part 4 – the Partial View</a> 
  * <a href="/blogs/hex/archive/2009/06/10/opinionated-input-builders-for-asp-net-mvc-part-5-the-required-input.aspx" target="_blank">Part 5 – the Required Field Indicator</a>&#160; 
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/13/opinionated-input-builders-part-6-performance-of-the-builders.aspx" target="_blank">Part 6 – the Performance</a> 
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/14/opinionated-input-builders-part-7-more-on-performance-take-2.aspx" target="_blank">Part 7 – the Performance Take 2</a>
  * <a href="http://www.lostechies.com/blogs/hex/archive/2009/06/17/opinionated-input-builders-part-8-the-auto-form.aspx" target="_blank">Part 8 – the AutoForm</a>

Once I defined what my the opinions for rendering each data type of my model as a form element it was a pretty trivial exercise to take this to the next level and render a default form for the model.&#160; Just a single like in the view that walks over each property of the model and decides how it should render each property. Although this was not my goal of the builders it was a logical step to go from a pattern for each property to just enumerating all the properties.&#160; I think this really shows the power of having the strongly typed view models. 

While I like this approach I would not stick to this as the only way to develop forms.&#160; I would use an approach like this to take care of my initial CRUD type screens and allow this to quickly get my views hooked up to my controllers.&#160; The next step is to have a clear and simple path for dealing with the case where the AutoForm does not work for a scenario.&#160; Using some of the View Templates it is pretty trivial to generate a view or a partial that displays the view code to define each input individually so that they can be re ordered or have properties overridden.&#160; 

&#160;

Here is the form that is generated as well as the single line of view code that is used to create it.

 <img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_11C72ED6.png" width="1028" height="664" />

&#160;

Just to show how trivial it was to implement this functionality here is the section of code that is called to loop over each property of the model.&#160; It would be pretty easy to modify this for your conventions to say add a Validation Summary to the top of the form.&#160; This code simply loops of the properties of the Model Type and then renders the partial needed for each of the properties type.&#160; Than a Submit Button is added and the form tag is closed.&#160; Pretty simple.

<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_0B03FF86.png" width="1028" height="381" />