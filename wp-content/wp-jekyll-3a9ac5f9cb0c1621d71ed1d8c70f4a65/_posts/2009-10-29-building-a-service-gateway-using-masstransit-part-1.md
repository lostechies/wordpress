---
id: 61
title: Building A Service Gateway Using MassTransit, Part 1
date: 2009-10-29T03:18:58+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/10/28/building-a-service-gateway-using-masstransit-part-1.aspx
permalink: /2009/10/29/building-a-service-gateway-using-masstransit-part-1/
dsq_thread_id:
  - "262089386"
categories:
  - masstransit
---
_This post is the first in a series on building a highly available service gateway. The implementation will be built in C# using MassTransit, StructureMap, ASP.NET MVC, and NHibernate._

### Introduction

A common way of applying a messaging solution to an existing system is to find a tightly coupled service reference in the system and insulate the system from that dependency. For example, the system may utilize a web service via a call from the user interface, blocking the user interface until the web service request completes. Another situation might involve a web service provided by the system which in turn calls another web service to complete the request. While these two examples are common in systems today, it is important consider how the system is using a dependent service when determining how best to insulate the system from that service. 

To help make that decision, allow me to share some common exchange patterns implemented using a web service. While most web services are modeled after the request/response pattern, there are actually several types of exchanges that can occur within a web service method. 

### Drop Box

If the web service is called by the client to provide information to the application, availability is likely the most important concern. Clients may have limited connectivity (such as a wireless client), limited resources (such as an embedded system that is unable to store data for future delivery), or a combination of these and other factors. To deal with these limitations, the web service should be designed for maximum availability to avoid failed requests due to an outage behind the web service boundary. 

To support this high availability, the web service should count on the only thing that is available at the time web service method is invoked &#8212; the local machine. If the web service attempts to write the information to a database located on a server across the network that is not available, the information in the request may be lost. In this case, it would be a better choice to write a message that contains the request information to a local queue. By doing this, the request information is retained and can be processed separately from the web service request. This allows allows the web service method to return to the caller, keeping resources available for other clients to report. 

Once the data from the request is safely stored in the queue, a separate service is built that consumes the messages from the queue and sends the information to the internal system, which in this case might be a database server. If the database server is unavailable, the message is left in the queue until the database is available. This new service can also be stopped and even updated without disrupting the web service from receiving requests. 

### Simple Request

If we look at another scenario, one where the request contains search criteria and the response includes the data specified matching the request. In order to break this down in different way, we will look at two different types of requests. First, we will define a request to retrieve the status of an order. Second, we will define a request to retrieve the details of an order. 

When only the status of the order is requested, we are dealing with a relatively small amount of data per order &#8212; in this case, the order id and the status of the order. If this consisted of maybe 50 bytes of data per order, we could easily store the status of 100,000 orders in only 5 megabytes of RAM. Since users might check the status of an order often, at least once an hour, this could generate thousands of requests an hour. Since the status of an order may only change once or twice a day, the need to query the database each time the order status is checked can put an unnecessary strain on the database server. In addition, the order status request service is now tightly coupled to the database, making the availability of the service dependent upon the availability of the database. This dependency chain can get even longer as more complex systems are designed, so limiting the dependencies of a service is a key parameter in increasing availability. 

To reduce database load, eliminate the dependency on the database, and increase the availability of our order status web service, we can design our service to subscribe to order status updates. When the status of an order is updated, the update will publish a message containing the new status. As the status of orders are updated, our service would update an in-memory cache containing the status of every order in the system (well, every is not necessarily every &#8212; it could just be the orders placed over the last week that have not yet been received by the customer). On startup, the web service would query the database for the status of all orders placed and use the results of that query to seed the cache. Once the cache is seeded, as new orders are added and order status updates occur, the cache would update dynamically in response to the update messages. Since the cache is local to the web service, requests need only check the status by querying the cache and immediately returning the status of the order to the caller. In the case of an status request for an order that does not exist in the cache, the service could queue a request to get the order status from the database which would then publish that orders status so that it could be returned. If the order is not found, the service could return an unknown order response to the caller with instructions to perhaps try their request again later. 

### Up Next

The two exchanges described above are relatively easy to implement using messaging (and likewise, using MassTransit). The next exchange pattern I&#8217;m going to cover is the more complex request where the dependent service must be called to complete the request. Due to that complexity, I&#8217;m going to wait until the next installment to describe that in greater detail. After that, I&#8217;ll start to share some code as we build a solution to these exchanges.