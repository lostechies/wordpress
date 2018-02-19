---
id: 46
title: NAnt script for determining whether an assembly is registered in the GAC
date: 2008-05-08T18:53:29+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/05/08/nant-script-for-determining-whether-an-assembly-is-register-in-the-gac.aspx
permalink: /2008/05/08/nant-script-for-determining-whether-an-assembly-is-register-in-the-gac/
dsq_thread_id:
  - "262654434"
categories:
  - Uncategorized
---
A friend of mine, [Kevin Miller](http://blogs.dovetailsoftware.com/blogs/kmiller/), recently put out a public call for anyone who had some NAnt magic for detecting whether a given assembly is in the GAC or not. I had written something like this a year or so ago and I thought I&#8217;d share it with everyone in the hopes it might help you.

Standard disclaimer: I don&#8217;t guarantee that this works, I don&#8217;t guarantee that this won&#8217;t explode your computer if you run it. I make no warrantees of any kind.

First, you have to have the .NET SDK installed. If you have Visual Studio 2005 or later, you do. If you&#8217;re on a server, make sure you install the .NET Framework 2.0 SDK (free download from MS &#8212; [SDK x86](http://www.microsoft.com/downloads/details.aspx?FamilyID=fe6f2099-b7b4-4f47-a244-c96d69c35dec), [SDK x64](http://www.microsoft.com/downloads/details.aspx?FamilyId=1AEF6FCE-6E06-4B66-AFE4-9AAD3C835D3D), and [SDK IA64](http://www.microsoft.com/downloads/details.aspx?FamilyId=F4DD601B-1B88-47A3-BDC1-79AFA79F6FB0)) first.

At the top of your build script somewhere:

<pre><span>&lt;</span><span>property</span><span> </span><span>name</span><span>=</span>"<span>gacutil.exe</span>"<span> </span><span>value</span><span>=</span>"<span>${framework::get-sdk-directory('net-2.0')}gacutil.exe</span>"<span> /&gt;</span></pre>

[](http://11011.net/software/vspaste)

Next, add the GAC check in a task somewhere (NOTE: Replace the YOUR_ASSEMBLY&#8230; with the name of the assembly to find without the &#8220;.dll&#8221; portion on the end):

<pre><span>&lt;</span><span>exec</span><span> </span><span>program</span><span>=</span>"<span>cmd.exe</span>"<span> </span><span>failonerror</span><span>=</span>"<span>false</span>"<span> </span><span>resultproperty</span><span>=</span>"<span>foundInGac</span>"<span> </span><span>verbose</span><span>=</span>"<span>true</span>"
<span>    </span><span>commandline</span><span>=</span>"<span>/c gacutil.exe /l YOUR_ASSEMBLY_NAME_WITHOUT_THE_DOT_DLL | %windir%system32find </span><span>&quot;</span><span>Number of items = 1</span><span>&quot;</span>"<span>&gt;
    
    &lt;</span><span>environment</span><span>&gt;
        &lt;</span><span>variable</span><span> </span><span>name</span><span>=</span>"<span>PATH</span>"<span>&gt;
            &lt;</span><span>path</span><span>&gt;
                &lt;</span><span>pathelement</span><span> </span><span>path</span><span>=</span>"<span>%PATH%</span>"<span>/&gt;
                &lt;</span><span>pathelement</span><span> </span><span>dir</span><span>=</span>"<span>${framework::get-sdk-directory('net-2.0')}</span>"<span>/&gt;
            &lt;/</span><span>path</span><span>&gt;
        &lt;/</span><span>variable</span><span>&gt;
    &lt;/</span><span>environment</span><span>&gt;
&lt;/</span><span>exec</span><span>&gt;</span></pre>

[](http://11011.net/software/vspaste)

In my particular case, I added a <fail> task to fail the build if that assembly was in the GAC because it could hose the versioning of my build. Here&#8217;s how I did that:

<pre><span>&lt;</span><span>fail</span><span> </span><span>if</span><span>=</span>"<span>${int::parse(foundInGac) == 0}</span>"<span> </span><span>message</span><span>=</span>"<span>The Core assembly is registered in the GAC. Please un-GAC this assembly before attempting to build the project.</span>"<span>/&gt;</span></pre>

[](http://11011.net/software/vspaste)</p> 

&nbsp;

I hope this helps someone.