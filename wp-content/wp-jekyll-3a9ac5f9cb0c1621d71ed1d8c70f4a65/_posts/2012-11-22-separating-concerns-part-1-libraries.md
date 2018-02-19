---
id: 101
title: 'Separating Concerns &#8211; Part 1: Libraries'
date: 2012-11-22T11:21:23+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=101
permalink: /2012/11/22/separating-concerns-part-1-libraries/
dsq_thread_id:
  - "939458023"
categories:
  - Uncategorized
---
## Introduction

In large applications, particularly in enterprise applications, [separation of concerns](http://en.wikipedia.org/wiki/Separation_of_concerns) is critical to ease maintainability. Without proper separation of concerns, applications become too large and too complex, which in turn makes maintenance and enhancement extremely difficult. Separating application concerns leads to high [cohesion](http://en.wikipedia.org/wiki/Cohesion_%28computer_science%29), allowing developers to better understand code behavior which leads to easier code maintenance.

### History

In the previous decade, architects designed applications using an [n-tier approach](http://en.wikipedia.org/wiki/Multitier_architecture), separating the application into horizontal layers such as user interface, business logic, and data access. This approach is incomplete, however, as it fails to address partitioning applications vertically. Unrelated concerns are commingled, resulting in a confusing architecture which lacks clearly defined boundaries and has low cohesion.

The other problem with an n-tier architecture is how it is organized from top to bottom, with the topmost layer being the presentation layer or user interface, and the bottommost layer representing the persistence layer or database. Instead of thinking of the architecture as horizontal layers, think of them as rings, as described by the [Onion Architecture](http://jeffreypalermo.com/blog/the-onion-architecture-part-1/) described by [Jeffrey Palermo](http://jeffreypalermo.com/). (_While Jeffrey proposed the pattern name, the architectural patterns have been defined previously by others._)

## Separating Concerns

Given that a separation of concerns and increasing cohesion are the goals, there are several mechanisms towards achieving them. The solutions that follow include the use of libraries, services, and frameworks as ways to reach these goals.

## The Library

A [library](http://en.wikipedia.org/wiki/Library_%28computing%29) is a set of functions used to build software applications. Rather than requiring an application to be a single project containing every source file, most programming languages provide a means to segregate functionality into libraries. While the facility name varies, a partial list of which includes _package_, _module_, _gem_, _jar_, and _assembly_, the result is enabling developers to separate functions physically from the main application project, improving both cohesion and maintainability.

### Core, the new Manager

A library should not be a collection of unrelated functions, it should contain related functions so that it is highly cohesive. An application developer should be able to select a library for use based on its name and purpose, rather than having to pour through the source code to find the function or functions needed. A library should have a descriptive name and contain a cohesive set of functions towards a singular purpose or responsibility.

> Creating a library named _Core_ containing a large set of unrelated functions is separation of the sake of separation, and that library should not be treated as a library but as part of the application — it should not be reused by other applications.

### Coupling (aka, the Path of Pain)

When an industry analyst shares their observations about code reuse in the enterprise, the findings indicate that actual code reuse is very low. A main reason that code reuse is so low is tight coupling. [Coupling](http://en.wikipedia.org/wiki/Coupling_%28computer_science%29) refers to how two libraries (or functions) rely on each other. When a library relies upon another library, the library relied on is referred to as a dependency. When an application relies on a library, it implicitly relies on the library’s dependencies as well. In many larger applications, this can lead straight to [dependency hell](http://en.wikipedia.org/wiki/Dependency_hell).

Since tight coupling can lead to serious maintenance issues during an application’s lifecycle, limiting dependencies should be first and foremost in application and library design. If a function is to be moved from an application to a library, and that function must bring with it a dependency that was not previously required by the target library, the cost of adding the new dependency to the library must be considered. Too often, particularly in the enterprise where code is only reviewed internally by a single development team, poor choices are made when creating libraries. Functions are routinely moved out of the main project and placed into arbitrary libraries with little thought given to the additional dependencies of the library.

### An Example

As an example, a web application has a set of functions for validating email addresses. The simplest validation methods may only depend upon regular expression functions, which are part of every modern language runtime used today. A more complete validation of an email address may check that the domain is actually valid and has a properly registered MX record in DNS. However, validating the domain involves sending a request to a service and waiting for the response indicating a valid domain before the email address is determined to be valid.

There are many things wrong in this example. First, the email validation function has a dependency on a domain validation function. Due to the fact that the set of valid domains is continuously changing, the domain validation function itself has a dependency on a domain name service. Of course, the domain name service depends upon a network domain name service, which may subsequently depend upon an internet service as well. By calling one library function, the application has managed to send a request to another machine and block a thread waiting for a response.

In the case of an error, the disposition of the email address is then unknown. Is it a valid email address that could not be validated due to a network error? Or is it a valid email address but flagged as invalid because the domain name could not be validated due to an internal DNS server not allowing external domains to be returned?

The coupling in the email validation library is clearly a problem, but what happens as the business requirements evolve over the life of the application? Consider the situation where new accounts are being created by spammers from other countries. To combat the spam accounts, email addresses must now be validated to ensure that the IP address originates from within the United States. The email validation function now has a new dependency, a geolocation service that returns the physical address of a domain. However, the service requires the use of separate endpoints for testing and production. The email address validation function is now dependent upon two services and configuration data to determine which service endpoint to use.

At this point, it is obvious that the complexity of validating an email address is not something that can be accomplished in a library function.

This article will continue with Part 2 on services.