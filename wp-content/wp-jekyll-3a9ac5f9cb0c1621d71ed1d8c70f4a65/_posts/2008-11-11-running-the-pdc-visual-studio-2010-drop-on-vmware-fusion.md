---
id: 40
title: Running the PDC Visual Studio 2010 Drop on VMware Fusion
date: 2008-11-11T01:52:40+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/11/10/running-the-pdc-visual-studio-2010-drop-on-vmware-fusion.aspx
permalink: /2008/11/11/running-the-pdc-visual-studio-2010-drop-on-vmware-fusion/
dsq_thread_id:
  - "262089266"
categories:
  - .net
  - mac
  - osx
---
At the Microsoft PDC in Los Angeles this year, attendees received a CTP of Visual Studio 2010 on an external HD along with all the conference materials. VSX came installed on Windows Server 2008 (along with TFS) giving attendees a chance to dig into the new features of .NET 4.0 and the IDE. 

Unless you&#8217;re on a Mac. The VM was released in Microsoft&#8217;s VPC format which can only be run on a Windows host. Or can it?

To run the CTP under VMware Fusion, you&#8217;ll need to convert it to the proper format. To do this, you&#8217;ll need to install the [VMware Converter](http://www.vmware.com/products/converter/) on a Windows system. Once installed, plug the PDC drive into a USB port and find the directory containing Visual Studio 2010. In VMware Converter, click the Import Machine button and follow the instructions. Be sure to pick the latest virtual machine version if you are using Fusion 2.x, as this will give you the best performance.

<div style="text-align:center">
  <img src="http://blog.phatboyg.com/wp-content/uploads/2008/11/8c0d37fc7dd5cbe6de9e680b6d6d42ea.png" alt="8c0d37fc7dd5cbe6de9e680b6d6d42ea.png" border="0" width="411" height="271" />
</div>

I chose to create the new image on the external drive so I could copy it to my Mac. The conversion took maybe 40 minutes to finish. Once converted, I connected the external drive to my Mac and copied the directory (VSXCTP in my case) to the Virtual Machines folder in my Documents folder. I then used the Library window to open the VM, which copied it into my library.

<div style="text-align:center">
  <img src="http://blog.phatboyg.com/wp-content/uploads/2008/11/fusionlibrary.jpg" alt="FusionLibrary.jpg" border="0" width="640" height="416" />
</div>

After starting up the CTP under Fusion, I had to install the latest version of the VMware Tools, after which Windows 2008 discovered a bunch of new hardware. Once the tools were installed, the machine runs nearly as fast as my [Windows 2008 Workstation hack](http://blog.phatboyg.com/2008/09/17/vmware-fusion-20-upgrade-windows-workstation-2008/) that I had previously installed.

I haven&#8217;t tried running the VMware Converter inside of a VM under Fusion, but I would imagine that it might work. Again, I didn&#8217;t attempt this, so if you do it and it works, reply and let me know about it!

Good luck and enjoy the CTP!