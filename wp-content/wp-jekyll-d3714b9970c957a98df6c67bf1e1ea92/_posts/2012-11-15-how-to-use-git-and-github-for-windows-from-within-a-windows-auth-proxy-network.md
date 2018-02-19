---
id: 284
title: How to use Git and Github for Windows from within a Windows auth proxy network.
date: 2012-11-15T05:00:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=284
permalink: /2012/11/15/how-to-use-git-and-github-for-windows-from-within-a-windows-auth-proxy-network/
dsq_thread_id:
  - "929178639"
categories:
  - CodeProject
  - GIT
  - Tools
---
If you work at a company where you need to type in your user id to access sites on the internet and when you want to use git to push to a repository on the internet and it just hangs. This post may help you out.

While git is a nice distributed version control system (dvcs), it was not written for windows.&nbsp; A side effect of this fact is that it does support using proxy servers. But it really only supports using the kinds of proxy servers one would find in environments with non windows machines.&nbsp; So, this is a case, were a little ingenuity goes a long way.&nbsp; I credit [Matt Hinze](http://lostechies.com/matthinze/) for figuring all of this out. Now it is standard practice when we need to connect to remote git repositories.

In order to make git access repositories on the internet through a windows auth proxy server we need to add a local proxy and configure git to use the local proxy.&nbsp; This local proxy takes care of all the authentication so that git just works with the proxy and the proxy relays the data through the tightly controlled corporate proxy server.&nbsp; Lets look at a diagram of how this works.

[<img style="background-image: none; border-bottom: 0px; border-left: 0px; padding-left: 0px; padding-right: 0px; display: inline; border-top: 0px; border-right: 0px; padding-top: 0px" title="image" border="0" alt="image" src="http://lostechies.com/erichexter/files/2012/11/image_thumb14.png" width="658" height="301" />](http://lostechies.com/erichexter/files/2012/11/image14.png)

The light blue box represents your machine/workstation; the red box is the corporate network; the green box represents the internet. Since git cannot send ntlm credentials to the proxy, the network traffic just dies at the proxy.&nbsp; With the local ntlmmapps proxy, git can communicate to it without having to send the username and password, and the ntlmmapps proxy adds that information so the corporate ntml proxy gets it’s credentials and passes the network traffic through to github.com. 

To configure this its pretty simple.

  1. Download and unzip the [ntmlmaps](http://sourceforge.net/projects/ntlmaps/files/ntlmaps/ntlmaps-0.9.9.0.1/ntlmaps-0.9.9.0.1.zip/download) script & install [python](http://www.python.org/ftp/python/2.7.3/python-2.7.3.amd64.msi) for windows (15 MB download).
  2. Open up the server.cfg in notepad and enter the values for your proxy and network.
  1. **PARENT_PROXY**:
  2. **PARENT\_PROXY\_PORT**:
  3. **NT_DOMAIN**:
  4. **USER:**
  5. **PASSWORD**:&nbsp; (leave this blank, you can enter it when the proxy starts up)
  6. **LISTEN_PORT**:5865 ( remember this number you need it to configure git)

  3. Open the runserver.bat file in notepad and change the following line from   
    **before:** &#8220;c:\program files\python\python.exe&#8221; main.py  
    **after:** C:\Python27python.exe main.py
  4. run the runserver.bat ( probably need to run it as administrator)
  5. type in your password
  6. configure git in a command line.
  1. git config &#8211;global http.proxy <http://localhost:58665>

Your done, this should now push all the git commands through your local proxy which will authenticate the network calls and pass through the git commands.

Follow me on RSS and Twitter
  
<a href="https://twitter.com/ehexter" style="float:left;valign:top" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @ehexter</a><a style="float:left" href="http://feeds.feedburner.com/EricHexter" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png" alt="" style="border:0;padding-right:10px" /></a>