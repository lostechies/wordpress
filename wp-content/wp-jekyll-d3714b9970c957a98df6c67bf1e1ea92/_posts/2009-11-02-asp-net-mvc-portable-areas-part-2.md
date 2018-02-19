---
id: 65
title: ASP.Net MVC Portable Areas – Part 2
date: 2009-11-02T17:00:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/11/02/asp-net-mvc-portable-areas-part-2.aspx
permalink: /2009/11/02/asp-net-mvc-portable-areas-part-2/
dsq_thread_id:
  - "262051356"
categories:
  - .Net
  - Asp.Net
  - Asp.Net MVC
  - mvc
  - mvccontrib
  - Portable Area
---
# Sample Portable Area

This is the second part in a series about creating a Portable Area (PA) using MvcContrib

  *   * [Part 1 – Introduction](http://lostechies.com/erichexter/2009/11/01/asp-net-mvc-portable-areas-via-mvccontrib/)
      * [Part 2 – Sample Portable Area](/blogs/hex/archive/2009/11/02/asp-net-mvc-portable-areas-part-2.aspx)
      * [Part 3 – Usage of a Portable Area](/blogs/hex/archive/2009/11/03/asp-net-mvc-portable-areas-part-3.aspx)
      * [Part 4 &#8211; IoC framework support](/blogs/hex/archive/2009/11/04/asp-net-mvc-portable-area-part-4-ioc-framework-support.aspx)
      * [Part 5 &#8211; Update for 2012 / 3 Years Later](http://lostechies.com/erichexter/2012/11/26/portable-areas-3-years-later/)

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">To create a Portable Area, the first step is to create a separate class library project for the Portable Area.  The output assembly is the single file needed to add this functionality to applications which wish to consumer it.</span>
</p>

<span style="line-height: 115%; font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The minimal references required for the Portable Area are shown below: </span>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_7C43078B.png" alt="image" width="644" height="393" border="0" />](//lostechies.com/erichexter/files/2011/03/image_39B36C13.png)

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">While DataAnnotations is not required to build a PA, using DataAnnotations for Model validation makes distribution of the PA very easy, since the MVC2 DefaultModelBinder supports the DataAnnotations validation out of the box. <span> </span>If you choose a different validation framework than you would need to distribute those assemblies or possible IL Merge them into your PA.</span>
</p>

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;"> </span><span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The sample PA in the MvcContrib project is a Login Portable Area, this is a pretty simple example, but demonstrates how a PA and application can integrate.<span>  </span>This is also a piece of functionality that most applications need.</span>
</p>

<span style="line-height: 115%; font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;"><span> </span>Below is the code listing and structure for the project.  It looks identical to a mulit-project ASP.Net MVC Area.</span>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_0000AC5C.png" alt="image" width="318" height="385" border="0" />](//lostechies.com/erichexter/files/2011/03/image_27A72886.png)

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The first difference between creating a Portable Area and a standard area from the files perspective is how the Views are registered with the project. The views Build Action should be changed from content to an <a href="http://msdn.microsoft.com/en-us/library/0c6xyb66.aspx"><span style="color: #669966;">Embedded Resource</span></a>. This allows the views to be embedded into the output assembly so that they view folders and files to not have to be manually copied into each application that uses it.<span>  </span>Instead a special view engine will pull these views out of the assembly at run time and render them the same way that a physical view would be rendered.</span>
</p>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_7E4FE087.png" alt="image" width="644" height="365" border="0" />](//lostechies.com/erichexter/files/2011/03/image_585A3031.png)

&nbsp;

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The second item that is needed to create a Portable Area is a specialized registration class for the that inherits from PortableAreaRegistration. This class provides an extended RegisterArea method that sends in the MVC AreaRegistrationContext and a IApplicationBus object to the method.  The IApplicationBus <span> </span>is the mechanism<span>  </span>that a Portable Area uses to send messages to the hosting application during. <span> </span>The use of the bus during registration is not required, but it is available in case and specific start up logic is needed to correctly configure the Portable Area.  </span>
</p>

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The last line of the method show how the Portable Area registers the embedded views with the view engine, using the call to the RegisterTheViewsInTheEmmeddedViewEngine method.</span>
</p>

<span style="line-height: 115%; font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">An important caveat around the setup of the Registration class is to make sure that the Registration class is sitting in the same Namespace as the controllers and views.<span>  </span>If the Namespaces do not match the views will not be able to be located. <span> </span>Since the namespace for the Embedded Resource views cannot be specified declaratively they are created using the Assemblies Default Namespace and the folder structure that they are stored in.  So keeping all of these properties consistent will make everything work.  If you change the default namespace of the project, you will need to update the namespace of your registration and controller classes.</span>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_68394F28.png" alt="image" width="1028" height="398" border="0" />](//lostechies.com/erichexter/files/2011/03/image_0998F4C5.png)

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The first call in this registration method sends a message to the hosting application.  This is a contrived example but it demonstrates sending a tracing message that can be used by an observer message handler to log the registration activity.  This tracing can be useful since the Portable Areas use the built in MVC registration mechanism for auto discovery and there is not a lot of visibility into the built in registration process. This example shows how a message can be sent between the PA and the hosting application.</span>
</p>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_2C2D0D73.png" alt="image" width="644" height="335" border="0" />](//lostechies.com/erichexter/files/2011/03/image_10F4B472.png)

<span style="line-height: 115%; font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The LoginController demonstrates the functionality needed to handle displaying the login form and then handling the form post. There are two Actions in the controller, one to render a Login View and a second Action to process the form post and redirect the user on success or , in the case of a login failure, display the login error messages to the user.</span>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_2937A8C0.png" alt="image" width="1028" height="428" border="0" />](//lostechies.com/erichexter/files/2011/03/image_35A5CBE9.png)

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The message bus is the main mechanism for communicating between a portable area and the hosting application. <span>  </span>This is a very simplistic mechanism that allows the Portable Areas to communicate with the hosting application in a synchronous manner. <span> </span></span>
</p>

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">For some scenarios, like when the area should not implement its own database, the host application can own how the domain model is persisted in data storage and the Portable Area can worry about handling the multi-page user interface and other user interface concerns like validating simple data types.</span>
</p>

<span style="line-height: 115%; font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The messages that are passed to the Bus are shown below.</span>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_29E05EEA.png" alt="image" width="644" height="172" border="0" />](//lostechies.com/erichexter/files/2011/03/image_38F73DC4.png)

<span style="line-height: 115%; font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The LoginInput represents the data that is collected from the Login screen. It is using the built in <span> </span>DataAnnotations attributes to handle the simple validation rules.</span>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_484A9FD3.png" alt="image" width="644" height="220" border="0" />](//lostechies.com/erichexter/files/2011/03/image_7DC361F8.png)

<span style="line-height: 115%; font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The result object is used to determine if the credentials were valid for the host application and are then used to either display the error message or redirect to a protected page. Since the LoginInputMessage is passed to the bus with a reference, the handlers in the host application can change the Result object&#8217;s state and the portable area can than access the Result and determine the correct logic to perform given that result.  The implementation for the handlers will be in the next post in this series.<br /> </span>[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_22747970.png" alt="image" width="644" height="253" border="0" />](//lostechies.com/erichexter/files/2011/03/image_7C129624.png)

<p class="MsoNormal">
  <span style="font-family: 'Trebuchet MS','sans-serif'; font-size: 10.5pt;">The Index view for the login uses the MvcContrib Input Builders to render a standard form to the page.  The use of the Input Builder allows an host application to override any of the html mark up using the Input Builder partials.  This means that the Portable Area and Input Builders play very nicely with each other.</span>
</p>

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_51E2E83C.png" alt="image" width="1028" height="203" border="0" />](//lostechies.com/erichexter/files/2011/03/image_4C0844A3.png)

This is what the view looks like in a browser.

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_072BFAA2.png" alt="image" width="899" height="772" border="0" />](//lostechies.com/erichexter/files/2011/03/image_4912DFF0.png)

This is the validation errors that are handled by the Portable Area, using the MVC 2 default model binder.

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_1D51F027.png" alt="image" width="899" height="772" border="0" />](//lostechies.com/erichexter/files/2011/03/image_0A7D6C7D.png)

This shows an error message that is passed back from the resulting application. Other rules could be applied as well.

[<img style="border: 0px;" src="//lostechies.com/erichexter/files/2011/03/image_thumb_57310D46.png" alt="image" width="899" height="772" border="0" />](//lostechies.com/erichexter/files/2011/03/image_2B60B957.png)

&nbsp;

This is the approach for creating a Portable Area (PA) using the MvcContrib Portable Area feature.  Let me know what you think about this approach, we tried to stay with the simplest approach that could possible work, and focused on making it easy to both develop and consume the Portable Areas.

&nbsp;

Please leave your comments on what you think of the approach.