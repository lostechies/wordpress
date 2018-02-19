---
id: 58
title: Under the Covers with MassTransit Endpoints
date: 2009-09-12T19:57:40+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/09/12/under-the-covers-with-masstransit-endpoints.aspx
permalink: /2009/09/12/under-the-covers-with-masstransit-endpoints/
dsq_thread_id:
  - "262089371"
categories:
  - .net
  - activemq
  - 'c#'
  - masstransit
  - msmq
---
_This post details some of the internal changes to how [MassTransit](http://code.google.com/p/masstransit/), an open-source lightweight service bus, communicates with transports such as MSMQ, ActiveMQ, and TIBCO. These changes are not likely to impact anyone using MassTransit, they are all well below the abstraction layer provided by the bus. At the same time, I felt it was important to share the change, along with the reasons it was made, with those that are using MassTransit._ 

When [MassTransit](http://code.google.com/p/masstransit/) was first started, MSMQ was the only transport we intended to support. In due time, however, it was determined that support for transports such as ActiveMQ and TIBCO was important. The ability to run on Linux and OS X under Mono (which does not support the System.Messaging namespace) as well as interoperability with Java systems using JMS (a specification for messaging, implemented by messaging systems like ActiveMQ and TIBCO) were the primary drivers of this decision. At the same time, insulating developers from the particulars of each transport was equally important. 

To communicate with an endpoint, MassTransit uses the _IEndpoint_ interface. The service bus would receive messages from an endpoint using this method: 

<pre>IEnumerable SelectiveReceive(TimeSpan timeout);
</pre>

This involved making a call that returned an enumeration of message selectors, allowing the caller to step through the messages until an interesting message (in the case of the bus, a message with a subscribed consumer). The concerns of receiving a message were seemingly spread at random across three or four different classes (and yes, I wrote this crap). The reason for the complexity was solid though &#8211; I need the ability to selectively receive a message from a queue and skip over ones in which I have no interest. 

The complexity of dealing with the yield return/break syntax of enumerators and managing scope is difficult. The programming semantics behind it are difficult to understand. I wanted something better. With all the time I&#8217;ve been spending since this was written dealing with nested closures, lambda functions, and continuations I realized there was a better way to reduce the complexity while at the same time improving extensibility. 

The new signature for the receive method on an endpoint looks like this: 

<pre>void Receive(Func&lt; object, Action &gt; receiver, TimeSpan timeout);
</pre>

With this new interface, the caller need only pass a method that accepts an object and returns a method that also accepts an object. The first method provides the caller an opportunity to inspect the message object to determine if the message will be consumed by the bus. If the bus is not interested, it can simply return null. If it is interested, it returns a method (either anonymous or a regular class method) that will consume the message. The endpoint will then call the returned method with the message once it has been received successfully. If the endpoint determines that the message is no longer available (if it were picked up by another process reading from the same queue for example), the returned method is not called. 

The calling method looks something like this: 

<pre>_endpoint.Receive(m =&gt; message =&gt; { doSomethingWith(message); });
</pre>

This interface is far less complex to implement, and also made it easy to make a clean separation of what is an endpoint and what is a transport. Which leads me to&#8230; 

### Endpoint and Transport Split?

Sadly that reads like a Hollywood headline, but it is true. **Endpoints** now deal only with address resolution of sending and receiving messages and translating between the transport format and a message object (including de/serialization). New **transport** classes are now responsible for the actual communication with the various queue implementations supported by MassTransit. 

For example, previously there was one class, MsmqEndpoint, that contained all the aspects of talking to MSMQ regardless of the type of queue (local non-transactional, local transactional, remote). Now beneath the endpoint itself, there are three MSMQ transports, one for each of these scenarios. Each of these transports cleanly deals with the particulars only, for example, the non-transactional transport has no transactional concerns in it at all. 

#### Introducing ITransport

The new ITransport interface is narrow, dealing only with the simplest form of communication &#8212; streams. The send and receive methods from the endpoint are matched, but instead of dealing with objects, streams are used. Every transport should provide stream support at a minimum. The receive method of the transport looks like:

<pre>void Receive(Func&lt; Stream, Action &gt; receiver, TimeSpan timeout);
</pre>

While all transports implement streams, there is a benefit to communicating at a level above streams for certain types of endpoints. For example, when using MSMQ there are advantages to communicating directly with the Message object such as having access to the transport level message ID, the message label, and other interesting properties. To support this, the MsmqEndpoint only accepts an IMsmqTransport interface, which inherits from ITransport and adds: 

<pre>void Receive(Func&lt; Message, Action &gt; receiver, TimeSpan timeout);
</pre>

Other transports may benefit from a custom interface as well, but it is only implemented for MSMQ at this point. ActiveMQ, Loopback, and Multicast UDP all use the base stream interface. 

### Looking Forward

This rewrite was not purely for entertainment value (well, it was fun). Latency when sending a message from a machine to a remote queue is orders of magnitude slower than writing to a local queue. And in addition, local queues have the advantage of being local &#8212; which is important considering the first fallacy of distributed computing &#8212; the network is reliable (NOT!). To compensate for this, a more reliable method of sending messages to a remote queue is needed. By ensuring that messages sent/published by an application are durable regardless of network failure, developers can use this fire-and-forget approach to messaging that is key to building event driven applications. 

To handle this, MassTransit now uses a store and forward transport for remote MSMQ queues. The store and forward transport will automatically create a local queue to cache the outbound messages destined for the remote queue. When a message is sent to the remote queue, the transport writes it to the local queue and returns to the caller. An asynchronous method then delivers the message in the background. The same transports that are used by the endpoint are reused by the store and forward transport, maintaining that high level of code reuse. 

_Note that on Windows Server 2003, I have observed that MSMQ will accept messages destined for a unreachable remote queue and attempt redelivery itself, but only for transactional queues (at least, that is what I have seen)._ 

### Wrapping Up

While it is always hopeful that changes like this will go by unnoticed, there is always the chance that there are some unintended consequences (read: bugs). Hopefully any of these will be weeded out quickly. In the meantime, I hope to start work on some availability features to support load balancing of command services.