---
id: 19
title: Developing for Windows on Mac OS X
date: 2008-02-17T00:56:03+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/02/16/developing-for-windows-on-mac-os-x.aspx
permalink: /2008/02/17/developing-for-windows-on-mac-os-x/
dsq_thread_id:
  - "262089216"
categories:
  - .net
  - mac
  - osx
---
This past week I setup a new development environment on my [MacBook Pro](http://www.apple.com/macbookpro/). As I got into it, I realized that it might be a good idea to share the setup process with others who might be switching to a Mac. Unlike a lot of people that use Windows XP for development, I do all my .NET development on Windows Server 2003. I have always had a firm belief in developing on your target environment. 

For this discussion, I will be using [VMware Fusion](http://www.vmware.com/products/fusion/) to run Windows. I&#8217;ve always been a fan of VMware, and their Mac OS X version continues to impress. There are many slick features in VMware Fusion, including Unity mode and dual-processor support. I&#8217;m going to be installing on my MacBook Pro, which is a 2.4 GHz Core 2 Duo with 4 GB of RAM (using the Santa Rosa platform, for full 64-bit memory support). I&#8217;m going to install the 32-bit version of Windows Server 2003 since the tools are all 32-bit applications. 

I highly recommend getting your installation disks as ISO files (from MSDN, of course). VMware can mount the disk images directly, and they load a lot faster than using the physical media. For the purpose of this installation, you&#8217;ll need the following disk images:

  * Windows 2003 Server R2 with Service Pack 2 (disk 1, 2 is not needed)
  * Visual Studio 2005 Professional
  * Microsoft MSDN Library for Visual Studio 2005 (optional)
  * Microsoft SQL Server 2005 Developer Edition

You&#8217;ll also need the following downloads:

  * [Visual Studio 2005 Service Pack 1](http://www.microsoft.com/downloads/details.aspx?familyid=BB4A75AB-E2D4-4C96-B39D-37BAF6B5B1DC&displaylang=en)
  * [Windows 2003 Server Hot Fix for large installer files](http://support.microsoft.com/kb/925336)
  * [SQL Server 2005 Service Pack 2](http://www.microsoft.com/downloads/details.aspx?FamilyId=d07219b2-1e23-49c8-8f0c-63fa18f26d3a&displaylang=en)

**Creating the Virtual Machine** 

To create your virtual machine, start up VMware. On the Virtual Machine Library window, select New. On the New Virtual Machine Assistant, click Continue. For Operating System, choose Microsoft Windows, for version, choose Windows Server 2003 Standard Edition. When choosing a name for your VM, I find it helps to pick something that reflects what development will be done. I have two, one called W2K3x2K5 and one called W2K3x2K8. As you might guess, the first has Visual Studio 2005 and the latter has Visual Studio 2008. 

When choosing a disk size, be sure to give yourself enough room for your tools and applications, but don&#8217;t go overboard. Before I rebuilt my VMs, none of them were over 14GB in size so I chose a size that would give a little room to grow. Now, you could pick something like 40GB and configure the VM to grow the disk file as space is consumed but I prefer to allocate the entire disk in 2GB chunks at creation to get the best performance. I don&#8217;t usually use a lot of local space since all of my source code is kept in a remote Subversion repository. 

The next screen is the Windows Easy Install. This is an easy way to get the operating system setup without any user intervention. Just make sure your install disk ISO is ready, and enter your name, password, and Windows key. Check the &#8220;Make your home folder accessible to the virtual machine&#8221; so that you can easily transfer data from OS X to Windows. I make the folder read only, since I don&#8217;t trust Windows to write to my home folder. Once the Finish screen displays, **uncheck the Start and Install now option** since we want to make some tweaks before the OS install begins. You can go ahead and pick your ISO for the installation. 

Once the VM has been created, go back to the Virtual Machine Library, pick your virtual machine, and click Settings. We need to tweak a few things before we let Windows install.

  * Battery &#8211; I let the guest see the battery status
  * Display &#8211; Uncheck since we are not using XP
  * Memory &#8211; I give the VM 1492 MB, but you can adjust to taste.
  * Processors &#8211; Two (2) virtual processors should be set for installation.
  * Network &#8211; NAT or Bridged are the only real options here. NAT is good when you don&#8217;t need other machines to have access to the VM, but use Bridged if you want a direct link to the network. If you use NAT, you can get to your Mac from the VM using the _.host_ name.
  * Sound &#8211; I like sound, I enable it.
  * Shared Folders &#8211; This should be fine based on how the VM was created.
  * USB &#8211; I like to be able to use my flash drive in the VM, so I enable this option.

Once the settings are tweaked, go ahead and fire up the VM. Windows should install without any user intervention and after a short time (the install runs super fast from the ISO) you should have a working Windows Server 2003 installation. Once you have it up and you are logged in, it&#8217;s time to run Windows Update to get all the latest patches (there will be a ton of them). Go ahead and let them install, and be sure to get the optional .NET 2.0 and .NET 3.0 packages as well. 

Now that we have Windows setup, it&#8217;s time to take away all the things we don&#8217;t need.

  * Disable automatic updates &#8212; we can do that when we need to do it.
  * Disable remote access into the machine (no Remote Desktop or Remote Assistance).
  * My Computer, Properties, Advanced, select Adjust for Best Performance for Memory and CPU.
  * Set virtual memory to a fixed size of 1GB.
  * Advanced Startup and Recovery &#8211; Uncheck all reporting and set Debugging Information to none.
  * Disable error reporting and turn off critical error notification

_In the control panel, we need to tweak a few things as well:_

  * Set your time zone and turn off automatic time synchronization.
  * Turn off the screen saver, set the background to none, and make sure Windows Classic is selected for the theme.

_In the registry, this tweak really decreases disk access in your VM:_

  * HKLMSystemCurrentControlSetControlFileSystem  
    Add a new DWORD named NtfsDisableLastAccessUpdate and set it to 1.

_I also disable the following services:_

  * Automatic Updates
  * Error Reporting Service
  * Help and Support
  * Windows Time
  * Wireless Configuration

_Remove the following files:_

  * All the $whatever$ directories in C:Windows except for the $hf_mig$ directory.

_Add Operating System Components_

  * Use Add/Remove Programs, and select the Add/Remove Windows Components option.
  * Add IIS (including ASP.NET support)
  * Add Message Queueing (if you plan to use it)
  * Remove Enhanced Internet Explorer Security
  * Install any extra fonts you use for development, such a Consolas.

It&#8217;s probably a good idea to run Windows Update again after adding these features since they&#8217;ve likely been patched. 

**Back Up Your New VM** 

Now that we have a nice clean system, I recommend you shut down the VM and make a backup copy. Simple copy the Documents/Virtual Machines/YourVMName to an external drive so you can easily create new VMs without doing the Windows install again. If you do so, I recommend using [SysPrep](http://support.microsoft.com/kb/892778) to reseal the operating system so all new SIDs are created. **Do not make a backup for the purpose of closing after installing SQL Server 2005 since it goes crazy if you change the machine name after it is installed.** 

**Software Installation** 

I recommend installing Visual Studio 2005, followed by SQL Server 2005. For Visual Studio, if you aren&#8217;t going to do any Smart Device programming, I highly recommend you uncheck all those packages from the installer. I would also choose not to install Visual J# for obvious reasons. Once the install is complete, be sure to run it at least once. Then install SQL Server 2005 (running as Local System when asked). If you don&#8217;t care about SQL 2000 support, don&#8217;t bother with the compatibility sort orders and just pick Latin from the top. Once both are installed, go ahead and install VS2005 Service Pack 1 and SQL Server 2005 Service Pack 2. 

At this point, you have a pretty basic system with the needed applications. If you&#8217;re going to do any work on open source projects, you will need [Subversion](http://subversion.tigris.org/), [TortoiseSVN](http://tortoisesvn.tigris.org/), and [NAnt](http://nant.sourceforge.net/). Many recommend [VisualSVN](http://www.visualsvn.com/), but I have never used it so I can&#8217;t comment but I&#8217;ve heard good things. When downloading applications to install, I recommend pulling them down using Safari into your Downloads folder. Then in your VM, go to the &#8220;on my Mac&#8221; share and run the installers from your shared folder. I never download anything inside the VM unless I absolutely know it can be trusted (which is pretty much never). 

You will notice that I didn&#8217;t install any &#8220;fearware&#8221; such as virus or spyware tools. That&#8217;s my style, I don&#8217;t really care to slow down my system with things of that nature. I maintain a tight VM and rarely introduce anything from the outside so it&#8217;s my choice. Your mileage may vary. 

And before I write another word, you should install [Resharper](http://www.jetbrains.com/resharper/) and start on your path to becoming a [Resharper Jedi](http://blogs.jetbrains.com/dotnet/2007/05/the-resharper-jedi/). 

**Wrap Up** 

I hope this post has been helpful for those looking to setup a development VM. I&#8217;ve found that using Leopard OS X for everything but development to be a pleasure compared to the applications available for Windows.