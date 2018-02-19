---
id: 368
title: 'Are your unit tests still hard to read ? &#8211;  Should Assertion Library'
date: 2013-01-13T07:49:42+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=368
permalink: /2013/01/13/shouldlibrary/
dsq_thread_id:
  - "1023434083"
categories:
  - .Net
  - CodeProject
  - Open Source Software
  - OSS
  - Should
  - testing
  - Unittests
---
I created the <a href="https://github.com/erichexter/Should/blob/master/README.markdown" target="_blank">Should library</a> to fill a gap in the testing ecosystem in the .Net space.  Simply put, I took what I liked about using extension methods to make a more readable set of assertions, but made the library independent of any specific unit test framework. The last point is important, because this library can be used with all unit test frameworks. There were similar tools to this previously, but they all were tied to specific libraries so I could not have a consistent language when I move between test frameworks.

## Cleaner syntax

First, consider the syntax and the readability of the assertions of a unit test. This is what a null check looks like using should.

> foo.ShouldBeNull();

versus the equivalent syntax using MSTest.

> Assert.Null(foo);

## Install it now

Should is available on <a href="http://nuget.org/packages/should" target="_blank">nuget</a>.

> install-package Should

## Learn more about it

Start by watching this short video


  
There are a number of place to learn more about Should.

  * Great 8 minute video on Channel 9 on using Should with ASP.Net MVC : [http://channel9.msdn.com/posts/ASPNET-MVC-With-Community-Tools-Part-12-Should-Assertion-Library](http://channel9.msdn.com/posts/ASPNET-MVC-With-Community-Tools-Part-12-Should-Assertion-Library "http://channel9.msdn.com/posts/ASPNET-MVC-With-Community-Tools-Part-12-Should-Assertion-Library")
  * Project Site on Github: [https://github.com/erichexter/Should](https://github.com/erichexter/Should "https://github.com/erichexter/Should")

There is a second dialect of Should called Should.Fluent.  Learn about it here:

  * [http://lunaverse.wordpress.com/2010/10/08/getting-started-with-should-assertion-library/](http://lunaverse.wordpress.com/2010/10/08/getting-started-with-should-assertion-library/ "http://lunaverse.wordpress.com/2010/10/08/getting-started-with-should-assertion-library/")
  * [http://lunaverse.wordpress.com/2010/10/08/goodbye-shouldit-hello-should-assertion-library/](http://lunaverse.wordpress.com/2010/10/08/goodbye-shouldit-hello-should-assertion-library/ "http://lunaverse.wordpress.com/2010/10/08/goodbye-shouldit-hello-should-assertion-library/")