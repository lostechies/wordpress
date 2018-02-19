---
id: 71
title: Update on using MSDeploy for remote deployments.
date: 2009-12-29T14:02:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/12/29/update-on-using-msdeploy-for-remote-deployments.aspx
permalink: /2009/12/29/update-on-using-msdeploy-for-remote-deployments/
dsq_thread_id:
  - "262208528"
categories:
  - .Net
  - agile
  - Deployment
  - MSDeploy
---
This is a follow up to the post [http://www.lostechies.com/blogs/hex/archive/2009/11/06/using-msdeploy-to-automate-your-enterprise-application-remote-deployments.aspx](http://www.lostechies.com/blogs/hex/archive/2009/11/06/using-msdeploy-to-automate-your-enterprise-application-remote-deployments.aspx "http://www.lostechies.com/blogs/hex/archive/2009/11/06/using-msdeploy-to-automate-your-enterprise-application-remote-deployments.aspx")

&#160;

The only trouble I have run into using this approach is that the runCommand does not bubble up error code or exit code from the command being executed on a remote machine.&#160; This is a complete fail in my book.&#160; You have to know that your process works and be notified when it does not.&#160; In the mean time, the work around for my process works like this.

We kick this job off from Nant, so I capature the text output from the remote command, put it into a variable and than run a Regular Expression against it to determine if the remote process finished successfully or not.

Here is what this looks like in Nant ( oh.. that is some ugly xml) 

&#160;

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_11B8B3F2.png" width="1028" height="397" />](http://lostechies.com/erichexter/files/2011/03/image_407E6C94.png) 

So what is happening here?

The output of the exec command is being sent to a text file using the **Output** attribute.

The text file is then loaded into a variable called _**deploystep2**_.

The reg ex parses out the Build Success or Build Failed text from the file.

If build Failed is found than the _**<fail>**_ tag fails the deployment and than the rest of our reporting process works as planned.

&#160;

Thoughts.