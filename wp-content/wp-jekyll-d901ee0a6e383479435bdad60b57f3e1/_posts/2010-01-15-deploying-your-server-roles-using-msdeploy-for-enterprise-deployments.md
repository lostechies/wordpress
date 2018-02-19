---
id: 73
title: 'Deploying your Server Roles: Using MSDeploy for Enterprise Deployments.'
date: 2010-01-15T15:46:23+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2010/01/15/deploying-your-server-roles-using-msdeploy-for-enterprise-deployments.aspx
permalink: /2010/01/15/deploying-your-server-roles-using-msdeploy-for-enterprise-deployments/
dsq_thread_id:
  - "262208896"
categories:
  - .Net
  - continous improvement
  - continous integration
  - Deployment
  - headspring
  - IIS
  - MSDeploy
---
&#160;

This is an update that builds upon the previous posts about how We do Deployments.

  * Part 1: [Using MSDeploy to automate your Enterprise Application remote deployments.](http://www.lostechies.com/blogs/hex/archive/2009/11/06/using-msdeploy-to-automate-your-enterprise-application-remote-deployments.aspx)

  * Part 2 [Update on using MSDeploy for remote deployments.](http://www.lostechies.com/blogs/hex/archive/2009/12/29/update-on-using-msdeploy-for-remote-deployments.aspx)

## &#160;

## The development environment is simple

The previous posts built upon our remote deployments.&#160; These examples were pretty trivial and not realistic, for the fact that in our development, testing, and staging environments we deploy an entire application to a single server.&#160; That includes a web application, database migrations, batch jobs, ect..&#160; 

&#160;

## A production environment needs Roles 

All production environments I have deployed to have at least two roles.&#160; Usually a Web Server and a Database Server.&#160; In many cases we would have a web farm which is a number of web servers with identical configurations that have a hardware device that sits in front of them (Load Balancer).&#160; This type of environment requires that your database migrations need to only run on the database server.&#160; It is possible to update the database from a webserver deploy but this means that you may need to pass through a sql connection string with sql authentication.&#160; I do not like that option because in production I prefer to have service accounts (windows accounts) act as the credentials to authenticate to the database server.&#160; By doing this it allows me to have a consistent deployment where security always works.&#160;&#160; But, using Windows authentication becomes troublesome if your production environment is all not part of a windows domain.&#160; I have found that more often than not, in hosting environments, the servers are usually built as standalone servers.&#160; This causes a problem with trying to deploy your database changes through your web server.&#160; MSDeploy does not propagate the clients windows credentials to other network connections when it runs.&#160; 

&#160;

My work around was to introduce a concept of deployment Roles.&#160; This helps clean up the deployment to make it simpler.&#160; A side benefit, is that the deployments to each role become more efficient.&#160; Lets explore the Roles:

I created to Roles:

  * Web – This includes the webserver / web application code. Configuration files are updated to point to the production database instance at deployment time.
  * Database – This includes running the database migrations and optionally supports additional data loads.&#160; The additional data loads are used to load code tables and other look up data that is not configurable in the application.

&#160;

So how does this change the previous examples?

First I have a call to my deploy script for each Role, here is an example of setting this up in CruiseControl.Net

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_58C210B8.png" width="1204" height="277" />](http://lostechies.com/erichexter/files/2011/03/image_071B9666.png) 

The first call updates the webserver but includes the database server address so that the deployment will update the appropriate connection strings in the config files. This call runs the Web role.

The second call updates the database server, and runs the database role.

&#160;

The role is actually passed to the script through the deploy.cmdargs parameter. Since this is a string the role is just being passed through in the calls to MsDeploy. Notice my script to call msdeploy does not change, or reference an additional parameter.

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_25F20A44.png" width="1204" height="291" />](http://lostechies.com/erichexter/files/2011/03/image_0A4D7E4E.png) 

Now my actual deployment script just needs to branch its install logic based on a parameter value of web or database.&#160; It is pretty simple.&#160; I will show a nant example, but I have already started to move these types of scripts to powershell.&#160; There are many reasons for that, but ultimately I think of powershell as being the default scripting language for the servers that we are using.&#160; Since the there are built in support for IIS and Sql Server in powershell it only makes sense to use this tool over other scripting tools.

Here is my new build file for deploying roles.

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="image" src="http://lostechies.com/erichexter/files/2011/03/image_thumb_4F19A282.png" width="1204" height="842" />](http://lostechies.com/erichexter/files/2011/03/image_36F63827.png) 

&#160;</p> 

I know I have breezed over how these scripts are wired together, but I hope that the concept still makes sense.&#160; I will update the [Code Camp Server](http://codecampserver.org) project with these files as well as the powershell versions of them soon.