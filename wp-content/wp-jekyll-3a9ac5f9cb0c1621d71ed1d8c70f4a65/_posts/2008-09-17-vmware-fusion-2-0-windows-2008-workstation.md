---
id: 32
title: VMware Fusion 2.0, Windows 2008 Workstation
date: 2008-09-17T16:46:00+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/09/17/vmware-fusion-2-0-windows-2008-workstation.aspx
permalink: /2008/09/17/vmware-fusion-2-0-windows-2008-workstation/
dsq_thread_id:
  - "262089259"
categories:
  - mac
  - osx
  - vmware
---
[VMware Fusion 2.0](http://www.vmware.com/products/fusion/) was released yesterday and I was anxious to upgrade. Rather than feel the full pain myself, I let [brewbie](http://twitter.com/brewbie) go first. He got it setup and installed and said all was good, so I figured I&#8217;d give it a shot. 

I was in a VM working on some new code that I had neither saved to disk nor commited to Subversion. I figured I&#8217;d live on the edge and just suspend the VM so I could upgrade Fusion. Once Fusion had exited, I downloaded the update and fired up the installer. Less than a minute later version 2.0 was installed and ready to go (no reboot required). I clicked the icon for my 2003 Server VM and it fired up just a few seconds, picking up right where I left off. Needless to say, I was very impressed. 

The release notes said that previous VMs should update the VMware Tools to take advantage of the new features available in 2.0 so I went ahead and restarted Windows 2003 (1st time). Once it was back up, the new tools package installed and prompted for another reboot (2nd time). The reboots were amazingly quick and I was back up and running in no time. 

Since it was all up and running, I started to configure the new features in Fusion 2.0. There is a new keyboard mapping feature so you can map certain key combinations to work within your VM. It works pretty slick, making it possible finally map a key for INSERT. There is also a new feature to make it so that clicking mailto links in the VM opens the Compose Mail window in Mac Mail. VERY COOL! I was less impressed with the browser linking since it changed my default browser to EverNote (WTF?). I changed it back to Safari and then disabled the feature. 

After the short interruption, I felt that it was time to create a new VM for Windows Server 2008. I was following the guide on the <a href="http://www.win2008workstation.com/wordpress/" target="_blank">Windows 2008 Workstation</a> site to build a workstation-grade installation of Server 2008. Since VMware 2.0 supports things like Shader Model 2.0 with 3D graphics, I wanted to see it work. It took a couple of hours to get everything setup and configured, but the end result was a clean install of 2008 server configured for a workstation environment. 

I then installed Steam, and downloaded a fresh copy of TeamFortress 2. I fired it up and it failed. It turns out that the tools by default only enable a certain level of hardware acceleration. I went to the advanced troubleshooting tab and cranked up the acceleration. I could now run everything, including Microsoft PhotoSynth and TeamFortress 2. The frame rate was pretty amazing considering it was running in a VM &#8212; seriously impressive actually. I experienced a lot of sound breakup when IO was being performed, so there is still some tweaking to do there I suppose. 

Once play time was over, I installed Visual Studio 2008, TortoiseSVN, VisualSVN, Resharper, and updated. I pulled down the latest trunk of MassTransit and built it. The build took 16 seconds, compared to 21 seconds on my 2003 VM. However, when I ran the load test I was surprised to see that MSMQ performance was about half of what it was with 2003 Server. I ran the test a couple of times with the same result. I&#8217;m not sure what is at work here, but it seems like MSMQ4 has some different performance numbers than MSMQ3. I&#8217;ll do some additional tests and post more on this later. Maybe MSMQ was slowed down to make WCF look better (joking, of course). 

In the end, the upgrade to 2.0 was painless &#8211; completely painless infact. I highly recommend it to take advantage of all the new features.