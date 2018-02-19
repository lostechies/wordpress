---
id: 62
title: Building a Service Gateway Using MassTransit, Part 2
date: 2009-10-29T22:34:21+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/10/29/building-a-service-gateway-using-masstransit-part-2.aspx
permalink: /2009/10/29/building-a-service-gateway-using-masstransit-part-2/
dsq_thread_id:
  - "262089401"
categories:
  - masstransit
---
_This post is the second in a series on building a highly available service gateway. The implementation will be built in C# using MassTransit, StructureMap, ASP.NET MVC, and NHibernate._ 

### Continued&#8230;

In part one, I discussed two exchange patterns that are often exposed as a web service. In this installment, I&#8217;m going to cover a more complex exchange pattern that including makes a request to an external system in response to a request on our web service. 

_
  


> One of the comments on the previous post raised the question of using messaging for queries. Udi, Ayende, and I agree that this so-called &#8220;Data-SOA&#8221; is a bad thing. The queries I am presenting in this article are made against an external service and not an internal database. In many cases, this service might have limited availability and limited throughput, making it important to isolate our service to increase availability.</p>
</em>

### Complex Request

In the simple request, order status is a small enough data point that caching it at the web service makes sense. The details of an order, however, are much more involved and it is not practical to keep the details cached in case they are requested (which in this case, is much less often that the order status). To support the order detail request, we will apply a pattern that separates the inbound request from the outbound request, ensures that requests are performed only once (minimizing the click, click, click refresh mentality of some users), and even retain requests if the outbound service is unavailable until the request expires or the outbound service becomes available. 

The first thing we want to build is the service that will be responsible for calling the external web service. To start, we&#8217;ll define two messages representing the happy path of calling the service. The first message contains the criteria of the request (such as the order id and perhaps the customer id) and the second message contains the details of the order that were returned by the web service. In addition to the messages on the happy path, we may also define additional messages used to publish exception information related to the request. 

Once the message contracts are defined to call the web service, we need to build a service that will handle the request messages. To do this, we&#8217;ll build a message consumer for the request message, host it inside Topshelf, and subscribe to a service bus bound to the input queue of the service.
  
The message handler will use the request message properties to prepare the request to the external web service and produce the response message once the request returns. In this example, the external web service only supports synchronous requests (in a later article I will try to cover calling remote services that support asynchronous requests). 

At this point, we have a service that responds to a command message (the request) and produces a result depending upon the outcome of the request. What we need now is a way to coordinate the requests to the service to ensure that requests are not lost due to an unavailable service, errors are retried once a failed service becomes available, and duplicate requests are ignored. 

To coordinate the service requests, a saga will be created to manage the state of each request. A new message will be created to initiate the saga containing the same data that is needed to produce the request message that is sent to our gateway service. And as with the service, messages will be created to return the results of the request to the consumer of the external service. The saga will use our state machine driven saga syntax, making the business logic understandable at a glance. The saga will also define the retry parameters that should be used to recover from service outages by specifying an exception policy. The messages that are used by the requester to interact with the saga will become the interface that is used by our system to make requests to the external service. This includes the web service we are in turn providing to our customers. The internal messages used to communicate between the saga and the gateway service are not intended for use outside of our gateway service component. 

_
  


> A nice side benefit of this architecture involves the actual call made by the gateway service. Since the interface is defined by the messages that are orchestrated by the saga, the backing implementation can be changed without impacting the consumers of the saga-based front end. This can be a huge benefit when it comes time to change service providers or bring an external service in-house either through acquisition or new product developments.</p>
</em>

With the saga in place (and for this example, we will go ahead and host it in the same process that we are hosting the gateway service), we are now ready to build the web service request handler. Rather than go straight into that now, I think I&#8217;m going to stop here and save that for part three. After part three is finished, I&#8217;ll start posting some of the code for the examples and include it in the samples folder to make it easy to pull down and experiment with on your own machine.