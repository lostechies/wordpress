---
id: 154
title: Github for windows – I would send a pull request if I could
date: 2012-10-25T07:54:16+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=154
permalink: /2012/10/25/github-for-windows-i-would-send-a-pull-request-if-i-could/
dsq_thread_id:
  - "899783082"
categories:
  - GIT
  - software
  - source control
  - Uncategorized
---
I am a huge fan of [Github for Windows](http://windows.github.com/). I believe it is a major game changer for using GIT on windows machines.
  
It took a horrible installation experience and turned it into a pleasant surprise. I think that the creation and release of this product actually is the death of Mercurial on windows as well. I was a pretty vocal supporter of Mercurial on windows. But I typically will pick the tool with the least amount of friction and for version control, [Github](https://github.com/) for Windows is it. I use TFS and Git at work and at home, I am only using Git now. So Thanks for that.

Now, that I am done with the [Github](https://github.com/) fanboy act. I find that there is one area of friction for me when using GH4W. I am constantly using it to locate a repository. I usually don’t remember where the folders are on my disk drive as I switch between my many machines. Then I click on the Tools menu and then open in explorer, then I click on one of my batch files. I have one to open Visual Studio, one to force a deployment in my preferred cloud system, and a todo command that opens up [trello](https://trello.com/) in a browser. I don’t need bother with synchronizing bookmarks or urls because I keep the important information for each project in the repositories. Because I follow this convention, it seems like with a simple change to the GH4W client, I could reduce two mouse clicks and a bunch of wait time, Windows Explorer starting up, and then locating my batch files. I know I could just keep a console window open.. but why, I am already using GH4W, which is primarily a point and click app, so context switching to the command line at this points is kind of a pain. Once I am in visual studio I use the nuget package manager console to run powershell, I don’t need a separate window.

_[<img class="alignnone size-medium wp-image-159" title="image1" src="http://lostechies.com/erichexter/files/2012/10/image1-300x183.png" alt="" width="300" height="183" />](http://lostechies.com/erichexter/files/2012/10/image1.png)
  
Above are the batch files I typically have in the root of my source control. It would be simple to enumerate these and add them to the tools context window of the repository. Here is a little mock up of what it could look like._

[<img class="alignnone size-full wp-image-160" title="image2" src="http://lostechies.com/erichexter/files/2012/10/image2.png" alt="" width="556" height="225" />](http://lostechies.com/erichexter/files/2012/10/image2.png)
  
_The existing context menu._

[<img class="alignnone size-full wp-image-161" title="image3" src="http://lostechies.com/erichexter/files/2012/10/image3.png" alt="" width="804" height="293" />](http://lostechies.com/erichexter/files/2012/10/image3.png)

_The context menu with additional commands located in the root of my repository._

&nbsp;

If the project was open source, I would certainly send a pull request or keep my own fork for this feature alone. But since the project is not open source, this is my plea to the team to look into adding some extensibility to make our lives simpler.

&nbsp;

If you think this is a good idea too. Let Github know you think it is by telling them here <https://help.github.com/contact> or tweet them here: <http://twitter.com/github>, or just comment on this blog saying you agree! I think that the team would be willing to listen to their users!