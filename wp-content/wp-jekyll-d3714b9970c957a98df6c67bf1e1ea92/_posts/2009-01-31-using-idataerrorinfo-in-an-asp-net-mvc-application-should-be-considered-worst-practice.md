---
id: 24
title: 'Warning: Using the IDataErrorInfo feature in an Asp.net MVC application should be considered a Worst Practice.'
date: 2009-01-31T19:52:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/01/31/using-idataerrorinfo-in-an-asp-net-mvc-application-should-be-considered-worst-practice.aspx
permalink: /2009/01/31/using-idataerrorinfo-in-an-asp-net-mvc-application-should-be-considered-worst-practice/
dsq_thread_id:
  - "262616922"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - mvc
---
I wanted to comment on the use of IDataErrorInfo in the Asp.Net Mvc Release Candidate.&nbsp;&nbsp; Take a look at a sample that <a target="_blank" href="http://codebetter.com/blogs/david.hayden/archive/2009/01/31/asp-net-mvc-and-validation-using-idataerrorinfo-and-validation-application-block.aspx">David Hayden</a> put together to demonstrate&nbsp;how to &nbsp;use this feature.

<textarea name="code">[AcceptVerbs(HttpVerbs.Post)]<br /> public ActionResult Create(FormCollection form)<br /> {<br /> var customer = new Customer();</p> 

<p>
  try<br /> {<br /> UpdateModel<icreatecustomerform></icreatecustomerform>(customer);<br /> // Do Something
</p>

<p>
  return RedirectToAction(&#8220;Index&#8221;);<br /> }<br /> catch (InvalidOperationException ex)<br /> {<br /> return View(customer);<br /> }
</p>

<p>
  // &#8230;<br /> }<br /> </textarea>
</p>

<p>
  &nbsp;
</p>

<p>
  The updateModel function&nbsp; will throw an InvalidOperationException if a member of the IDataErrorInfo returns a value indicating there was a validation error.&nbsp; I call this Exception Based Programming and I believe this is a horrible practice.&nbsp; Exceptions should be for exceptional cases, not a validation error which is a common ocurance in a line of business appliaction.&nbsp; I would propose that a better way to do this would be as follows:
</p>

<p>
  <textarea name="code">[ValidateModel(typeof (CustomerForm))]<br /> public ActionResult Save(CustomerForm form)<br /> {<br /> if (!ModelState.IsValid)<br /> {<br /> return View(&#8220;Edit&#8221;, form);<br /> }<br /> Customer model = _mapper.Map(form);<br /> _repository.Save(model);<br /> return RedirectTo<CustomerController>(c=>c.List());<br /> }</textarea>
</p>

<p>
  I think this is a better way to handle this sort of code because it is very obvious about the call to IsValid .&nbsp; This does not deal with any exception handling non-sense thorugh the introduction of a <a target="_blank" href="http://code.google.com/p/codecampserver/source/browse/trunk/src/UI/Helpers/Filters/ValidateModelAttribute.cs">ValidateModel</a> filter.&nbsp; The validation step can be run and ModelState is populated before the real business starts.
</p>

<p>
  The ValidateModel filter is part of the Code Camp Server sample application which you can find at <a href="http://www.CodeCampServer.org">www.CodeCampServer.org</a> , it is a open source sample application build on top of the Asp.Net MVC framework.
</p>

<h4>
  Closing Words:
</h4>

<p>
  Do not write code that explicitly throws exceptions as part of the normal opperations of an application.&nbsp; This is bad for so many reasons but the worst reason is that the code is not obvious in what and why it is acting that way.
</p>

<p>
  Comments ?
</p>