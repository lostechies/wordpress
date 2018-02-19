---
id: 366
title: Using sql compact for integration tests with entity framework.
date: 2013-01-06T12:23:12+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=366
permalink: /2013/01/06/using-sql-compact-for-integration-tests-with-entity-framework/
dsq_thread_id:
  - "1011394647"
categories:
  - .Net
  - Asp.Net MVC
  - CodeProject
  - EntityFramework
  - Tools
  - Unittests
---
In my practices using continuous integration, I try to achieve 100% code coverage using integration tests. This is a separate metric from my unit tests, think of these tests as verifying all of my infrastructure code works properly when wired up to data access or other out of process assets like databases or services.&nbsp; While it is easy to setup sql server on a build server, I have run into instance where organizations using shared build servers do not allow access to create and drop databases as part of the CI process.&nbsp; A simple way to work around this is to use sql compact in process in the integration test suite. This also gives you an advantage on developer workstations to isolate your integration test data access from your development instance if you are running an End to End application on your workstation, which you should be.

I have run into a number of issues getting the SQL CE working in a unit test project(class library). Here are my notes of how to get it working.

  1. install the following <a href="http://nuget.org" target="_blank">nuget</a> packages: 
      1. EntityFramework.SqlServerCompact 
          * Microsoft.SqlServer.Compact 
              * SqlServerCompact.IntegrationTestConfiguration – this is a package I created to quickly add the provider configuration into an app.config file.</ol> 
              * Add the native dlls to the integration test project, set the **Copy to Output Directory** to **Always**. See how to do this in VS2012 in the screenshot below.  
                [<img style="background-image: none; border-bottom: 0px; border-left: 0px; padding-left: 0px; padding-right: 0px; display: inline; border-top: 0px; border-right: 0px; padding-top: 0px" title="image" border="0" alt="image" src="http://lostechies.com/erichexter/files/2013/01/image_thumb.png" width="360" height="550" />](http://lostechies.com/erichexter/files/2013/01/image.png) 
                  * The item is to use a test setup method to remove the data in the database.&nbsp; There are two ways to accomplish this. Both of these methods help ensure your tests will be isolated from each other in terms of data setup and will not try to reuse test data from one test to the next.   
                    First you can delete the entire sql compact database file. The downside to doing this is that the tests will run slower since it will recreate the database for each test.&nbsp; The advantage to this approach, is that as you add new entities to your model, you do not have to update this method in order to keep your test suite clean.
                WithDbContext(x =>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; if (x.Database.Exists())  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x.Database.Delete();  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x.Database.CreateIfNotExists();  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });
                
                The second approach is to run a set of delete statements for each table in the test setup. This is faster because the Entity Framework does not need to recreate the entire file. The downside of this is maintance for your tests. Every time you add a new entity to the ORM you need to add a new line to this setup function.
                
                WithDbContext(x =>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x.Database.ExecuteSqlCommand(&#8220;delete from Users&#8221;);  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x.Database.ExecuteSqlCommand(&#8220;delete from ShoppingCarts&#8221;);  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; x.Database.ExecuteSqlCommand(&#8220;delete from Products&#8221;);  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });</ol>