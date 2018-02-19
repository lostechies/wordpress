---
id: 68
title: Automapper Auto Profile Registration.
date: 2009-11-05T03:24:15+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/11/04/automapper-auto-profile-registration.aspx
permalink: /2009/11/05/automapper-auto-profile-registration/
dsq_thread_id:
  - "262053425"
categories:
  - .Net
  - AutoMapper
  - 'c#'
  - Open Source Software
---
</p> 

&#160;

On some of our projects we have been experimenting with smaller AutoMapper profiles.&#160; The idea is that it is easier to digest a smaller profile. We have gone so far as creating a profile for each Domain object and handle all of the mappings to and from the domain object.&#160; We are also trying out a Profile per scenario.&#160; While these smaller profiles are easier to dig in and understand, the registration of them are a little painful.&#160; So I put together a quick way to auto register all the profiles for automapper.&#160; Below is the code to discover all the profiles in an assembly than register them with AutoMapper.&#160; There is nothing fancy here and I could certainly spend more time making it better performing, but realistically this is startup code that runs once at application start up.&#160; That being said I would rather focus performance optimization efforts on places that actually make a difference to the End User Experience. 

&#160;

Here is the sample.

&#160;

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_344BD758.png" width="1028" height="337" />](http://lostechies.com/erichexter/files/2011/03/image_1C949FF2.png) 

It is important to know that we have full code coverage over our application including integration tests, so that if something were to break as a result of loading this in a non deterministic order, we would know before we commit our changes to source control. 

&#160;

&#160;

Here is the code for the ForEach extension method, since I breezed over it.

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_3875AF1D.png" width="1028" height="169" />](http://lostechies.com/erichexter/files/2011/03/image_322ED88F.png) 

This is a smaller post than I normally put together.. is this small of a post useful?