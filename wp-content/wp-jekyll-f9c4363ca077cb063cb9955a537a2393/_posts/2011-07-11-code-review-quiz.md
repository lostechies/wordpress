---
id: 306
title: Code Review Quiz
date: 2011-07-11T10:39:26+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/2011/07/11/code-review-quiz/
permalink: /2011/07/11/code-review-quiz/
dsq_thread_id:
  - "355356852"
categories:
  - .NET
  - code-review
  - quiz
---
I’ve been following Ayende’s series of reviews on the Microsoft N Layer App Sample V2.&nbsp; His [most recent post in the series](http://ayende.com/blog/32769/review-microsoft-n-layer-app-sample-part-viindash-data-access-layer-is-good-for-you?utm_source=feedburner&utm_medium=feed&utm_campaign=Feed%3A+AyendeRahien+%28Ayende+%40+Rahien%29&utm_content=Google+Reader) explored a little bit of the data access layer in the app. Specifically, this interface (which has since been removed):

<pre class="brush:csharp">public interface IMainModuleUnitOfWork : IQueryableUnitOfWork
{
    #region ObjectSet Properties

    IObjectSet&lt;BankAccount&gt; BankAccounts { get; }
    IObjectSet&lt;BankTransfer&gt; BankTransfers { get; }
    IObjectSet&lt;Country&gt; Countries { get; }
    IObjectSet&lt;Customer&gt; Customers { get; }
    IObjectSet&lt;Order&gt; Orders { get; }
    IObjectSet&lt;OrderDetail&gt; OrderDetails { get; }
    IObjectSet&lt;Product&gt; Products { get; }
    IObjectSet&lt;CustomerPicture&gt; CustomerPictures { get; }
        
    #endregion
}
</pre>

&nbsp;

I couldn’t find the source for the IQueryableUnitOfWork base interface, but I assume it exposes a significant amount of methods and properties.

Ayende alluded to the fact that this interface has several significant problems with it, but didn’t go into detail.&nbsp; So I thought that this would be a good opportunity for a quiz.&nbsp; How many wrong things can you spot with this interface?

I counted at least 6 major problems, though I’m sure there are a few others.