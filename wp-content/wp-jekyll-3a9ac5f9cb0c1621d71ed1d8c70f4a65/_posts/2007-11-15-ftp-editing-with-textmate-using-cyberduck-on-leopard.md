---
id: 7
title: FTP Editing with TextMate using Cyberduck on Leopard
date: 2007-11-15T00:42:00+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2007/11/14/ftp-editing-with-textmate-using-cyberduck-on-leopard.aspx
permalink: /2007/11/15/ftp-editing-with-textmate-using-cyberduck-on-leopard/
dsq_thread_id:
  - "262089137"
categories:
  - mac
  - osx
---
While I spend most of mine developing applications with .NET in Visual Studio 2005, there are times when I want to tweak a site built in PHP/MySQL. Since all my sites are hosted on GoDaddy, I don&#8217;t have SSH access into the server. This leaves FTP as the sole choice for editing remote content. While a solid practice would be to have a local development environment to text changes, it&#8217;s a blog, and it&#8217;s just not that important to me if I make a quick mistake. Plus, sometimes you&#8217;re dealing with Authorize.NET or PayPal, or FedEx, or another cart-based solution that requires cURL through a proxy. 

For editing remote files, I use Cyberduck and TextMate on OSX. Cyberduck handles the FTP interface nicely with a finder-like interface. A quick click and you&#8217;re editing the remote file in TextMate. Make your change and save and Cyberduck automatically updates the file on the server. **Or at least it did with Tiger.** 

It seems that some things broke with Leopard in how file update notifications are handled with Cyberduck. If you try to update using the built-in software update, you won&#8217;t get anything newer than 2.8 &#8212; which doesn&#8217;t have the fix. So if you&#8217;re using Leopard, you can get this functionality back by installing a [nightly build](http://update.cyberduck.ch/nightly/) of Cyberduck. It&#8217;s a quick install (simply copy to the Applications folder) and you&#8217;re back up and running. Do yourself a favor at the same time and turn off the Growl notifications for connection/disconnection to avoid some on-screen spam when saving the file.