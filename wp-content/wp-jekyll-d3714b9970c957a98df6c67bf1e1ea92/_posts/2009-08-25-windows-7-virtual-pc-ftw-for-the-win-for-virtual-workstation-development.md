---
id: 56
title: Windows 7 Virtual PC FTW (For The Win) for virtual workstation development
date: 2009-08-25T12:00:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/08/25/windows-7-virtual-pc-ftw-for-the-win-for-virtual-workstation-development.aspx
permalink: /2009/08/25/windows-7-virtual-pc-ftw-for-the-win-for-virtual-workstation-development/
dsq_thread_id:
  - "262920212"
categories:
  - .Net
  - Tools
  - Virtual Machines
---
I have constantly fought both Virtual PC and VM Workstation when working on virtual machines for development purposes. While VMWare had the features I liked it also had a price tag and a rather smug attitude. I usually ended up having to use the free version of VMWare which was crippled or Virtual PC which was not much better. Both were missing features that I wanted.

Now that I am using Windows 7 on my developer laptop I figured I would put the Virtual PC through its paces and see if they finally solved my pain points. At this point is has been over a week and I am sold on **Win 7 and virtual pc**.

&#160;

## 1. Removed the annoying system tray application.

I know it is pretty nit picky but I just bothered me that I needed to run that little system tray application.&#160; That is gone now and when you go to your Virtual Machines it shows you all of them and the location that they are running from windows explorer.

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_6FEF0751.png" width="859" height="184" />](http://lostechies.com/erichexter/files/2011/03/image_1F20F2E9.png) 

&#160;

&#160;

## 2. Support for my USB devices

One of the uses for my Virtual PCs is to have a virtual machine that works with some of my devices like video camera or x10 that I want to work on a moments notice after I repave a machine.&#160; Virtual PC did not support this so I had to do this in VMWare before. See the USB menu and the Attach menu items below. 

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_7B381B8E.png" width="664" height="250" />](http://lostechies.com/erichexter/files/2011/03/image_4A18E0EE.png) 

&#160;[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_5F46E696.png" width="658" height="211" />](http://lostechies.com/erichexter/files/2011/03/image_596C42FD.png) 

&#160;

## 3. Connect to the Network over my Wireless Connection

This one was a real pain to deal with. VM Workstation could do this out of the box. Virtual PC would not. There was a work around where you could install a Loopback adaptor on your host machine and do some route commands to make the network work properly but it was a pain and not portable.&#160; No when I teach the Headspring Agile Bootcamp or other classes I can share the main setup for our Continuous Integration server over our wireless network. This makes it real easy to start the class and run this virtual machine from my machine or say copy it over to a machine on the network. Since we teach the class at different venues having this different options really help.

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_54C61276.png" width="665" height="417" />](http://lostechies.com/erichexter/files/2011/03/image_0946E4BF.png) 

&#160;

## 4. Access local drives

This seems like a pretty basic requirement but before Virtual PC had it but the free version of VM ware did not have it. The work around was to map a network drive but it was so slow.

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_1E284165.png" width="672" height="422" />](http://lostechies.com/erichexter/files/2011/03/image_002A3371.png) 

&#160;

_**What do you like or hate about Virtual PC?**_