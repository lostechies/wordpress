---
id: 18
title: 'Don&#8217;t take encryption and hashing lightly'
date: 2008-02-12T19:15:00+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/02/12/don-t-take-encryption-and-hashing-lightly.aspx
permalink: /2008/02/12/don-t-take-encryption-and-hashing-lightly/
dsq_thread_id:
  - "262113627"
categories:
  - Uncategorized
---
A word to the wise for framework and product-shipping designers: Don&#8217;t take encryption, signing, and hashing lightly. Also, choose your cryptographic algorithms well and even consider making the cryptographic algorithm choice a configurable item.

We were using a licensed 3rd party component that used RijndaelManaged for encryption of some sort (relating to the license key) and it turns out that our servers have the [FIPS algorithm policy requirement](http://blogs.msdn.com/shawnfa/archive/2005/05/16/417975.aspx) [](http://therajahs.blogspot.com/2007/10/fips-validated-cryptographic-algorithms.html)enabled.&nbsp; This means that when we deployed our code, we got the following somewhat cryptic error message: &#8220;This implementation is not part of the Windows Platform FIPS validated cryptographic algorithms.&#8221;

I later found out that the RijndaelManaged symmetric encryption cryptographic algorithm used (hard-coded) by the 3rd party component vendor is not among [the list of FIPS-certified cryptographic algorithms](http://therajahs.blogspot.com/2007/10/fips-validated-cryptographic-algorithms.html) and is, therefore, disabled by Windows and .NET when the FIPS policy is enabled.

As you can imagine, this is cause for a lot of concern and consternation among the developers here as we try to find a suitable work around.

Moral of the Story: Use FIPS-certified algorithms or provide a special build that uses FIPS-ceritifed algorithms in case one of your customers runs into this problem.&nbsp;

&nbsp;