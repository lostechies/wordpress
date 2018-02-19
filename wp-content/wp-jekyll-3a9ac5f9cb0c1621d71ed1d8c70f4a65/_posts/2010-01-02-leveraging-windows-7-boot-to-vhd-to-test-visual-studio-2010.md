---
id: 65
title: Leveraging Windows 7 Boot to VHD to Test Visual Studio 2010
date: 2010-01-02T00:11:01+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2010/01/01/leveraging-windows-7-boot-to-vhd-to-test-visual-studio-2010.aspx
permalink: /2010/01/02/leveraging-windows-7-boot-to-vhd-to-test-visual-studio-2010/
dsq_thread_id:
  - "262089419"
categories:
  - Uncategorized
---
The goal of this article is simple: a clean installation of Windows 7 that can be used to test new versions of Visual Studio 2010 until we reach RTM. Since a new beta drops every couple of months (and maybe even an interim release or two in between for those lucky enough to get access to it), I don&#8217;t want to have to repave the machine for each new release. Since Windows 7 has the ability to boot into a VHD, I thought this would be the perfect opportunity to try this functionality myself. 

### Getting Started

The first thing I did was slide the Windows 7 DVD into the drive and rebooted the machine. Once the setup window appeared, I pressed Shift+F1 to open a command prompt and created a new VHD by typing the commands shown below. 

<tt><br /><br /> diskpart<br /><br /> create vdisk file="d:vhdsw7base.vhd" type=expandable maximum=80000<br /><br /> select vdisk file="d:vhdsw7base.vhd"<br /><br /> attach vdisk<br /><br /> </tt> 

Once this was finished, I switched back to the setup window and clicked Install Now. I chose the advanced install option, after which I selected my newly created partition as the installation target and formatted it so the installation could continue. While waiting for the setup process to complete (which included at least two reboots, both of which properly loaded into the VHD without any issues, so that&#8217;s cool), I started working on this blog post. 

After the install completed, I wanted to make sure I didn&#8217;t get confused by the boot manager now having two &#8220;Windows 7&#8243; options at started. So I quickly opened a command prompt (as Administrator), and typed: 

<tt><br /><br /> bcdedit /set description "Windows 7 Baseline"<br /><br /> </tt> 

This will change the name of the boot manager entry for the current machine to &#8220;Windows 7 Baseline,&#8221; distinguishing it from the normal Windows 7 install. Once I&#8217;ve completed all the setup tasks, I&#8217;ll set the regular Windows 7 option to be the default when I&#8217;m not working with the beta software installations. 

Next I ran Windows Update, along with installing the [Microsoft Security Essentials](http://www.microsoft.com/Security_Essentials) to have a basic level of virus/malware protection. 

I almost always need a database server to do any sort of distributed application testing, so I wanted to have a SQL Server 2008 available. However, I didn&#8217;t want to have it setup on each virtual disk. So I installed it to the base installation, along with a few other tools that I use often (and are not really updated regularly). I also decided that since Visual Studio 2010 and Visual Studio 2008 run nicely side-by-side that I would go ahead and install Visual Studio 2008 on the base image since I&#8217;ll most likely be working primarily with 2008 through the next year. 

When you boot from a VHD, your regular Windows system drive is available as drive D. This is really useful since you can keep a single checkout of all your projects and work on them from different systems! On my regular Windows 7 install, I created a &#8220;Shared&#8221; folder off the root (OMG not a Library?). Within that folder I have a Home folder which I use for SVN checkouts, and I also configured SQL Server to use a directory under Shared for all the data storage. This will be handy for ensuring that data in the database is updated regardless of which system is using SQL &#8211; very cool. 

### Making a Difference

With the above steps behind us, we now have a machine with two Windows 7 installations on it. The first, a regular disk-based install, is our primary installation that we use for whatever. The second, a VHD-based install, is our clean Windows 7 with our minimum set of software installed on it. It&#8217;s this clean version that we want to keep &#8220;pristine&#8221; to avoid having to redo all the steps above with each new release of Visual Studio 2010. 

_A quick note, the size of the VHD after all the software is installed is about 20 gigabytes, which is pretty substantial considering that we now don&#8217;t need to copy this space for each branch of the baseline we create &#8212; a nice savings!_ 

To create the differential image, I restarted the machine and selected my regular disk-based Windows 7 install. Once it was loaded, I opened up a command prompt and created a new VHD based off the existing one I just finished creating. 

<tt><br /><br /> diskpart<br /><br /> create vdisk file="D:vhdsw7-2008.vhd" parent="D:vhdsw7base.vhd"<br /><br /> create vdisk file="D:vhdsw7-2010.vhd" parent="D:vhdsw7base.vhd"<br /><br /> </tt> 

Once the partition is created, create a boot entry for it using: 

<tt><br /><br /> bcdedit /v <em>(this displays the GUID we'll use next for our copy)</em><br /><br /> bcdedit /copy {3F2504E<strong>0</strong>-4F89-11D3-9A0C-0305E82C3301} /d "Windows 7 - 2008"<br /><br /> bcdedit /v <em>(to get the GUID of our copy, which is also displayed after the copy command as well)</em><br /><br /> bcdedit /set {3F2504E<strong>1</strong>-4F89-11D3-9A0C-0305E82C3301} device vhd="[C:]vhdsw7-2008.vhd"<br /><br /> bcdedit /set {3F2504E<strong>1</strong>-4F89-11D3-9A0C-0305E82C3301} osdevice vhd="[C:]vhdsw7-2008.vhd"<br /><br /> bcdedit /v <em>(to verify our work)</em><br /><br /> bcdedit /set {3F2504E<strong>2</strong>-4F89-11D3-9A0C-0305E82C3301} device vhd="[C:]vhdsw7-2010.vhd"<br /><br /> bcdedit /set {3F2504E<strong>2</strong>-4F89-11D3-9A0C-0305E82C3301} osdevice vhd="[C:]vhdsw7-2010.vhd"<br /><br /> bcdedit /v <em>(again, to verify our work)</em><br /><br /> bcdedit /displayorder {current} {3F2504E<strong>1</strong>-4F89-11D3-9A0C-0305E82C3301} {3F2504E<strong>2</strong>-4F89-11D3-9A0C-0305E82C3301}<br /><br /> </tt>
  
In this case, {3F2504E****-4F89-11D3-9A0C-0305E82C3301} is my original VHD-based install, {3F2504E**1**-4F89-11D3-9A0C-0305E82C3301} is my copy for Visual Studio 2008, and {3F2504E**2**-4F89-11D3-9A0C-0305E82C3301} is my copy for Visual Studio 2010. 

I now have three boot options when the system starts, my disk-based Windows 7 install, and my two newly created &#8220;differential&#8221; installs &#8212; one for Visual Studio 2008 and one for Visual Studio 2010. Since both of these are based off the VHD we created above, we want to make sure we don&#8217;t accidentally boot into the w7base VHD and change it &#8212; that would be like crossing the streams in Ghostbusters (read: bad). The /displayorder command takes care of this by having a side effect of removing the Windows 7 Baseline option from the list of boot configurations. 

One thing to keep in mind, and another benefit of having the physical disk drive available as drive D, is that I do all of my work on the D drive (in the Shared folder). Since this drive is persistent I can be sure that I don&#8217;t lose my files as I boot between different installations of Windows 7. It also makes it so I don&#8217;t have to checkout projects on each VHD, which would waste valuable space. 

### Cleaning Up

So now that we have a nice baseline and a couple of working boot options (both of which don&#8217;t impact each other as changes are made), we can install our latest BETA/CTP/whatever on our 2010 install. When an update is released (in the form of a subsequent CTP, beta, etc.), we can take a few simple steps to revert our 2010 to a clean install. 

First, we need to boot into our disk-based installation of Windows 7. Once there, there are a couple of options available. We could create an entirely new configuration by repeating the steps above. This would be helpful if we were in the middle of something on a current version of 2010 and wanted to try it in the update to check for breaking changes. The more likely option, however, is to just replace the installation with a clean baseline to install fresh. 

To install fresh, we can just delete the existing w7-2010.vhd and create it again using: 

<tt><br /><br /> diskpart<br /><br /> create vdisk file="D:vhdsv7-2010.vhd" parent="D:vhdsw7base.vhd"<br /><br /> </tt>
  
The boot configuration is still pointing to that file, so it will find it after a restart and you can install the latest update without fear of some bad configuration/files from a previous beta/CTP getting in the way. 

### Conclusion

The new boot to VHD features of Windows 7 (which also work just fine for Windows 2008 Server R2 by the way) are a really slick addition to the Windows platform. Being able to take advantage of the VHD features, differential disks in particular, really makes it a great host for the various incarnations of Visual Studio. I hope this guide has helped ease some of the CTP/BETA pain that comes with running on the bleeding edge.