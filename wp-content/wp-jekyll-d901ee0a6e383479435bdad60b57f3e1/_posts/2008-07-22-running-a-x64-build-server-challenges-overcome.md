---
id: 21
title: Running a x64 build server. Challenges overcome.
date: 2008-07-22T13:02:10+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/07/22/running-a-x64-build-server-challenges-overcome.aspx
permalink: /2008/07/22/running-a-x64-build-server-challenges-overcome/
dsq_thread_id:
  - "274865873"
categories:
  - Asp.Net
  - CC.Net
  - continous integration
  - IIS
  - x64
---
We just setup a new build server on my current project and with it came some of those little hiccups which made the setup take longer than planned.

**<strike>Cruise Control</strike> Team Foundation Client&#160; issues**

**1. Although our continuous integration server (Cruise Control.Net) fully supports running on 64 bit not all of its dependencies do.&#160; Team Foundation Client 2008 does not support 64 bit operating systems.&#160; The fix was to force the .Net framework to run the cruise control service in 32 bit mode, by setting the 32 bit flag on the ccservice.exe. This was done using the [corFlags.exe](http://msdn.microsoft.com/en-us/library/ms164699(VS.80).aspx) from the .Net SDK.&#160; The actual command that was run is:**

<div class="CodeSnippetTitleBar">
  <div class="CodeDisplayLanguage">
  </div></p>
</div>

<div class="">
  <blockquote>
    <pre>CorFlags.exe ccservice.exe /32BIT+</pre>
    
    <pre>&#160;</pre>
  </blockquote>
</div>

2. **Running Asp.Net on wow32.**

Although our application code could run 64 bit.. not all of our dependencies can.&#160; Our web application kept failing on startup claiming that one dll could not run on x64.&#160; Rather than tracking down a new version for that dll only to deal with the next one I first wanted to see the application work on the server running wow32 (that&#8217;s Windows On Windows 32 bit) there are the operations that need to be done in order to make this happen. The first two are enabling 32 bit in IIS and registering the 32 bit .Net framework.

> cscript %SYSTEMDRIVE%inetpubadminscriptsadsutil.vbs SET W3SVC/AppPools/Enable32bitAppOnWin64 1
      
>   
> %SYSTEMROOT%Microsoft.NETFrameworkv2.0.50727aspnet_regiis.exe -i&#160; 

The third step is enabling the Asp.net (32) in the Web Extensions in IIS Manager. This option show us after you run the aspnet_regiis command.

Once I can test my application in 32 bit mode and I know it all works, now it is time to get back to 64 bit mode and track down the culprit that prevented this in the first place.&#160;