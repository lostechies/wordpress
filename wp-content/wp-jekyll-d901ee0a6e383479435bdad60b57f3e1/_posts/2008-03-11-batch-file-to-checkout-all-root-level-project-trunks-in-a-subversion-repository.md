---
id: 9
title: Batch file to Checkout all root level project trunks in a Subversion repository
date: 2008-03-11T16:46:15+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/03/11/batch-file-to-checkout-all-root-level-project-trunks-in-a-subversion-repository.aspx
permalink: /2008/03/11/batch-file-to-checkout-all-root-level-project-trunks-in-a-subversion-repository/
dsq_thread_id:
  - "262304170"
categories:
  - Uncategorized
---
Our source control tree is setup with the projects at the root of our server and each has a separate trunk, tags, and branches.&nbsp; While this makes it very easy to have a location agnostic build and include all the dependencies in one place for a particular project, this aspect can be painful when you want to checkout the trunk of each project to a new developer machine.&nbsp; I wrote a little batch file to ease the pain.

**Sample Source Control Repository**

> Project1  
> &nbsp;&nbsp; trunk  
> &nbsp;&nbsp; tags  
> &nbsp;&nbsp; branches

> Project2  
> &nbsp;&nbsp; trunk  
> &nbsp;&nbsp; tags  
> &nbsp;&nbsp; branches
> 
> ect &#8230;

&nbsp;

Batch file to pull checkout all of the trunks.

<div style="border-right: gray 1px solid;padding-right: 4px;border-top: gray 1px solid;padding-left: 4px;font-size: 8pt;padding-bottom: 4px;margin: 20px 0px 10px;overflow: auto;border-left: gray 1px solid;width: 97.5%;cursor: text;line-height: 12pt;padding-top: 4px;border-bottom: gray 1px solid;font-family: consolas, 'Courier New', courier, monospace;background-color: #f4f4f4">
  <div style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none">
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   1:</span> set svnbin=<span style="color: #006080">"d:Program FilesCollabNet Subversion Serverbinsvn.exe"</span></pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none"><span style="color: #606060">   2:</span> set svnroot=http://sourceserver:8080/svn/cgi/</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: white;border-bottom-style: none"><span style="color: #606060">   3:</span> %svnbin% list %svnroot%&gt;projects.txt</pre>
    
    <pre style="padding-right: 0px;padding-left: 0px;font-size: 8pt;padding-bottom: 0px;margin: 0em;overflow: visible;width: 100%;color: black;border-top-style: none;line-height: 12pt;padding-top: 0px;font-family: consolas, 'Courier New', courier, monospace;border-right-style: none;border-left-style: none;background-color: #f4f4f4;border-bottom-style: none"><span style="color: #606060">   4:</span> FOR /F <span style="color: #006080">"tokens=1"</span> %%i IN (projects.txt) DO %svnbin% checkout %svnroot%%%itrunk %%i</pre>
  </div>
</div>

&nbsp;

**_Subscribe to this feed:_**&nbsp; [http://feeds.feedburner.com/EricHexter](http://feeds.feedburner.com/EricHexter "http://feeds.feedburner.com/EricHexter")

This is pretty easy to modify, simple replace your bin location for subversion executable and update the svnroot to the path to your subversion repository and you are good to go.&nbsp; The one important gotcha here is that subversion is case sensitive.&nbsp; I ran into a problem where our repository has some of the trunks starting with a lowercase t and other starting with a uppercase t.&nbsp; In that case, I just added an additional line 4 with the uppercase Trunk.&nbsp; That batch file roles on without stopping if there is a mismatch in the case of trunk.