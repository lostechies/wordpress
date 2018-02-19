---
id: 112
title: 'Separating Concerns &#8211; Part 2: Services'
date: 2014-01-03T10:13:01+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=112
permalink: /2014/01/03/separating-concerns-part-2-services/
dsq_thread_id:
  - "2089720203"
categories:
  - Uncategorized
---
In the previous article on Separation of Concerns, libraries were explained as a way to decompose an application into separate sets of functions, resulting in code that is easier to maintain and has higher cohesion. This article continues the subject, explaining how applications can benefit from using services and what differentiates them from libraries.

## Services

A [service](http://en.wikipedia.org/wiki/Service_%28systems_architecture%29) is a set of related functions usable by multiple applications and accessible through one or more public interfaces. What differentiates a service from a library is the way an application uses it. In the case of a library, functions run in the execution context of the calling application, inheriting the application’s environment, which includes the process, thread, and user context. A service, however, runs in its own execution context and has its own set of policies that govern how it can be used.

Due to framework limitations and/or the complexity of asynchronous programming, many applications invoke services synchronously — leaving the developer with the impression that the service has “taken control” of the execution context. In reality, the calling application is only _blocked_ while waiting for the service to respond. And since the application is blocked, it behaves like a library function call, at least from the perspective of the debugger. Service invocation, however, invokes a complex exchange of information between the calling application’s process and the service’s process. This exchange is even further complicated by the fact that the application and service processes may exist on separate machines, be written using different languages, and be running on different operating systems. Also, it’s important to recognize that at any time during service invocation, the operating system, the process, the service, or the network can (and eventually will) fail.

### Service Interface

The blocking scenario above pertains to applications that invoke services using a remote procedure call (or, RPC) form of inter-process communication. Examples include a web browser using a REST implementation over HTTP, a mobile client using a SOAP implementation (also over HTTP), and an intranet application using a binary implementation over TCP. A single service can support one or more of these implementations simultaneously, making the service available to a broader range of applications.

Another form of inter-process communication is message passing, where the application sends a message to the service. Message passing is inherently asynchronous, the application can send the message and continue processing without waiting for the service to complete. There are many advantages to using asynchronous message passing instead of synchronous RPC, but an asynchronous programming model is also more complex for developers. Messages can also be passed using a durable message store, making it easier to recover from failure without losing service requests and/or commands. Message passing also eliminates temporal coupling, preventing the application from being dependent upon the availability of the service.

### And the advantage is… what?

Given the complexity of a service, particularly in comparison to a library, why would anyone want to deal with the complexity of a service?

Quite simply, with a service, the implementation details of the public interface are encapsulated within the service itself and do not become dependencies of the calling application. And since the application is only calling the public interface, the only dependency added to the application is the service interface. The application does not inherit the dependencies of the service, as those dependencies are private implementation details. For this reason alone, when a function has a dependency on another service or when a function depends upon dynamic data, it is better to create a service, encapsulating those dependencies and enabling the service to be managed separately from the applications using it.

> For example, a domain name validation function requires a list of valid domain names. However, the current list of valid domain names is constantly changing. If domain name validation was implemented as a library, the application must also be responsible for maintaining the list of valid domain names. Rather than adding these additional requirements to the application, a service is used to valid the domain name instead.

So, the advantage of encapsulating dependencies while retaining the ability to reuse functionality is the key benefit of a service. The benefits of a library are also benefits of a service, including high cohesion, as long as the service focuses on a single concern or responsibility.

In the next installment, frameworks will be explained.