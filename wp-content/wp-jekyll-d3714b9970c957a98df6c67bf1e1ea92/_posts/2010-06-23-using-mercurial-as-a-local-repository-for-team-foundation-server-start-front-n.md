---
id: 81
title: Using Mercurial as a local repository for Team Foundation Server / Start Front’N
date: 2010-06-23T03:01:22+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2010/06/22/using-mercurial-as-a-local-repository-for-team-foundation-server-start-front-n.aspx
permalink: /2010/06/23/using-mercurial-as-a-local-repository-for-team-foundation-server-start-front-n/
dsq_thread_id:
  - "262151500"
categories:
  - mercurial
  - source control
  - TFS
---
This post covers how to setup mercurial(HG) as are local source control repository to sit in front of a Team Foundation Server . I am not going to go into the details of why you would want to run this way in this post. You can look at the [StackOverflow question](http://stackoverflow.com/questions/2331636/real-word-use-of-mercurial-with-a-team-foundation-server) that may give you more insight. For those of you who want to use mercurial for your day to day source control but have to synchronize your source code into a TFS server, this will allow you to do this.

The tools used for this process were lifted from blog posts all over the web.

&#160;

## The Tools.

  1. TFS 2010&#160; Powertools 
  2. Tortoise HG 
  3. MakeWritable Mercurial Extension 
  4. Rebase Mercurial Extension 
  5. Two Powershell scripts to push and pull files to the TFS server (listed below) 

&#160;

## Setting up the environment

  1. Download and install, TFS 2010 Powertools, Tortoise HG, and the MakeWritable Mercurial extension 
  2. Enable the MakeWritable and Rebase extensions in mercurial. 
      1. Edit your profiles Mercurial.ini file.&#160; Add the following section to the file. 
        [extensions]   
        makewritable = _<font color="#ff0000">c:program files (x86)TortoiseHgmakewritable.py </font>_   
        rebase=

  3. Configure the TFS and HG repositories on your local file system. 
      1. Setup your project repository from tfs in a folder. C:codeProject-from-TFS . This is the gold repository that is only used for merging changes to and from the TFS repository. You will never make changes to code in this repository. 
      2. Make that folder a Mercurial Repository and add all the files from TFS into the mercurial repository and commit them to Mercurial. 
      3. Make a second folder. This is your working folder.&#160; In this folder using mercurial clone from the gold repository. 
      4. Place the push.ps1 and pull.ps1 files into the working folder and commit them to the local repository. 

## The Workflow

  1. Start developing your work.. If you want commit to branches and merge to the main when you want to push something to TFS. 
  2. Commit your local work. 
  3. Run the pull.ps1 command to pull down changes from tfs and merge them. 
  4. Keep working and committing to mercurial 
  5. When your ready to send your change to the TFS server commit your changes to mercurial and then run the push.ps1 command. 
      1. The push.ps1 command will pop up one window for adding new files to TFS (if you have created new files as part of your dev work) 
      2. The push.ps1 will pop up a commit dialog for TFS so that you can verifiy all the files going to TFS and enter a commit message. 

Rinse and Repeat.

&#160;

Show sample of pull.ps1

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_0CDD3F24.png" width="644" height="228" />](http://lostechies.com/erichexter/files/2011/03/image_5FC85255.png) 

Show sample of push.ps1

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_55477E35.png" width="1028" height="233" />](http://lostechies.com/erichexter/files/2011/03/image_729CD5FF.png) 

This shows the results of running a pull command.&#160; By using the Rebase command needless merge commits just go away. You see the +1 heads text below, that suggests a merge is needed, and it normally is.&#160; By scripting the rebase command I essentially eliminate the need for the merge, except for when a true merge conflict exists.

[<img style="border-right-width: 0px;border-top-width: 0px;border-bottom-width: 0px;border-left-width: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_3EC4B9E1.png" width="644" height="186" />](http://lostechies.com/erichexter/files/2011/03/image_60909272.png) 

&#160;

Is this useful?&#160; Is there a better way to do this?&#160; Please let me know.