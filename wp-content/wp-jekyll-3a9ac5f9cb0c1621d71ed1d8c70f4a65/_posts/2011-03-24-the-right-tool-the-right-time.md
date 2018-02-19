---
id: 68
title: The Right Tool, The Right Time
date: 2011-03-24T19:44:28+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=68
permalink: /2011/03/24/the-right-tool-the-right-time/
dsq_thread_id:
  - "262401875"
categories:
  - Development
---
Over the past few months I have been reviewing many of the products I was involved in creating, both as a developer and an architect, and have assembled an inventory of the technology and architecture used. With a catalog of products spanning more than eighteen years, a diverse set of architectural styles are represented. On one end of the spectrum are client/server systems deployed on-premise and on the opposite end are software-as-a-service (SAAS) browser-based products. Most of these products are line-of-business systems and include both heavy user interaction and background data processing. In fact, two separate products offer a similar feature set targeted at the same market but sit on opposite ends of the architectural spectrum. The first product was built in the 90&#8242;s and is a client/server system, the latter was built more recently during the SAAS era targeting the web.

What follows are a few of the common design choices that I encountered, with my take on how appropriate that same choice would be today.

## Data Storage

As I looked into each product, I examined how various requirements were addressed given the tools available at the time. For example, I didn&#8217;t question the use of a flat file to store reference data in the early client/server products since flat files were perfectly acceptable at the time. However, this led me to question some design choices when looking at SAAS products &#8212; including some choices that you might not expect. For instance, why is a flat file not an acceptable design choice for a system developed today? The data is still the same reference data, yet current guidance would suggest this reference data be stored in a database, most likely a relational database.

Is this because developers have become too lazy to write the component to read the file? Surely not, since a component will have to be written to import the reference data into the database. While it can be done fairly easily using database tools, the process still has to be scripted out and repeatable in case the import needs to be repeated on a new database.

Let&#8217;s enhance the problem and add a time dimension to the reference data, making updates available every thirty days. Now, not only is an initial import needed, but the import component will also need to support updating the database with the new content. Again, this could be done using database tools &#8212; a simple truncate table and repeat the import process. But what if developers have created relationships between the reference data table and other tables in the system? What if those relationships were created using the row id instead of the appropriate business identifier? At that point, the table cannot be simply truncated and the update process must now perform a complete delta of the existing and updated data sets and merge the changes into the database. That certainly doesn&#8217;t sound lazy &#8212; if anything, it sounds downright painful.

Another question that came to mind when using a relational database to store reference data was &#8220;which database?&#8221; Now, if the first answer that popped into your head when you read that was &#8220;SQL Server,&#8221; or even worse &#8220;the database,&#8221; therein lies the real problem.

A product is not just an application, it is a system composed of one or more applications, multiple components, multiple services, **and multiple databases**. Consider the earlier example that used a flat file to store reference data. The flat file itself **is** a separate database. In a system of any complexity there are many different sets of reference data, all of which are stored in their own separate flat files. Therefore, the system has multiple databases, each using the appropriate technology based on how that database is used.

If the reference data had remained in a flat file, when the flat file was updated with the new reference data, the original file is simply replaced and the system continues. No special import or update process is required.

## Nested Object Graphs

Another common design I saw, particularly in products that manage a revolving set of accounts, was the use of a deeply nested object graph that is persisted in a relational database. As accounts were accessed, the entire object graph would be loaded from the database and presented to the user. Once the user made whatever changes were necessary at the time, the account was then saved to the database. In order to save the object graph, the nodes at each level in the graph are compared with the database, and deltas are generated to update the database tables.

In early examples of this design, a pessimistic locking system was implemented to track user activity and prevent multiple users from working on the same account at the same time. This was common in the client/server products, since even at that time record locking using ISAM files (or even network file locking) was fairly problematic.

As products moved to the web, a more optimistic locking strategy was used. I found two different conflict resolution methods, the first of which used a timestamp to track modifications to an account. If an update was received and the timestamp didn&#8217;t match, the later update was rejected. The second method was &#8220;last write wins,&#8221; updating the account to whatever was in the later update &#8212; possibly and quite commonly losing previous updates from other users. This got real interesting when two updates were performed at the same time.

Neither of these solutions make sense today for SAAS applications. In an environment where multiple users may be interacting with an account at the same time, it&#8217;s more important to look at providing users with a task-based user interface that captures the intent of each action on an account. For example, loading an entire account just to change the billing address creates unnecessary data movement that can limit throughput (read: scalability concern). At the same time, preventing a user from adding a charge to an account because another user slipped in behind you to update the phone number creates an unnecessary user burden. If updating the billing address, updating the phone number, and adding a charge to an account were explicit actions (read: commands) that can be performed on an account, they could all be performed simultaneously without conflict.

_Note that the Command-Query Responsibility Segregation (CQRS) or even just Command-Query Separation (CQS) architectural styles specifically addresses this type of design._

## Stored Procedures

In the example above, a deeply nested object graph was loaded from the database. In a system designed today, a developer would most likely reach for an object-relational mapper (ORM) to deal with loading and saving the object graph to the database. There are many to choose from (Hibernate, NHibernate, and Entity Framework are a few) and they solve the problem of binding object graphs to relational database tables very well. In fact, most ORMs today can generate the DDL needed to create the database objects as well &#8212; eliminating the need to write table creation scripts by hand.

At this point, I can hear the blood pressure of many database administrators reading this rising through the roof. With SQL book in hand and years of experience writing stored procedures full of selects and cursors, the story of how a hand tuned stored procedure that returns a sequence of forward-only record sets in a single round trip to the database server is the only way the scalability requirements of the application can be met. I&#8217;m not saying that using a stored procedure in this situation is wrong, but making a stored procedure the first tool you pull out the toolbox is very wrong indeed.

Why is it wrong? Creating a stored procedure to read data as the first approach is wrong because it is an optimization. Optimizing components of a system before that particular component has been identified as a bottleneck will lead to increased complexity, and that complexity will breed quickly in the project. And as complexity increases across the project, long term maintainability suffers as the capabilities of the development team are challenged. Yep, you guessed it, the stored procedure first approach is a classic case of premature optimization.

How does using a stored procedure in this way breed complexity? First of all, it establishes a myth that reads are a problem. As functionality is added to the system, developers who have come to believe that any account related reads must be done with a stored procedure else they become responsible for performance inadequacy, create more read procedures. As features continue to be implemented, more data elements are added to the schema, requiring every stored procedure to be updated as the schema changes &#8212; creating more work for developers who must now touch features that were complete and tested to ensure they still operate as expected.

The opposite effect of the read myth is that retrieving the entire object graph for an account is so well optimized that it is better to load the entire object and use only the needed data elements rather than create a new read procedure. With an ORM, this is handled very well using projections and fetching strategies. Developers can use the ORM to read a partial object graph, returning on the required data elements and reducing the data movement between the database and application server.

All of this accidental complexity was created based on the superstition that only a stored procedure would be fast enough to support the scalability needs of the product. An optimization that was implemented before a bottleneck was identified.

Considering that most ORMs today are capable of writing very efficient SQL and have dialects specifically tuned for each database platform, the read performance of the ORM is less likely to be a system bottleneck. For example, with Microsoft SQL Server, NHibernate takes advantage of batch queries with ADO.NET to reduce the number of round trips between the database and application servers. The SQL generated is also parameterized, allowing the SQL engine to cache execution plans for better server performance. Given these optimizations have already been done by the ORM, tuning read performance in the database is not likely to create the biggest benefit in system scalability. For example, caching of already loaded objects will likely result in greater overall read performance.

_Did I forget to mention that this early decision tightly coupled the product to using a particular database platform? SQL dialects are hardly portable between platforms, so the product now has to decide if it will work with a single platform or create a separate release branch for each database platform supported. The better ORMs support multiple server dialects, including Microsoft SQL Server, Oracle, MySQL, PostgreSQL, and many others._

I said I wouldn&#8217;t argue the performance difference between using an ORM and a stored procedure. I will point out, however, that using a stored procedure to tune performance is an **optimization** for a particular environment and should not be an early choice in system design. Going straight for the stored procedure without considering less complex options is another case where a lot of times, the tool we used yesterday is not always appropriate for a system being designed today.

## To Be Continued&#8230;

Above I&#8217;ve covered a few of the design choices made early in the development of several major products and how that affected the evolution of the product over time as featured were added. I also applied a modern view of how many of the choices we made before all these &#8220;great tools&#8221; were available are not necessarily bad today. As I get more time, I hope to share a few more stories with you as I undercover them in what has basically become a &#8220;career retrospective&#8221; for me.

 