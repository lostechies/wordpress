---
id: 76
title: Query Objects with Repository Pattern Part 2
date: 2008-08-02T05:29:27+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/02/query-objects-with-repository-pattern-part-2.aspx
permalink: /2008/08/02/query-objects-with-repository-pattern-part-2/
dsq_thread_id:
  - "262166868"
categories:
  - LINQ
---
As promised in [my previous post](http://www.lostechies.com/blogs/chad_myers/archive/2008/08/01/query-objects-with-the-repository-pattern.aspx), I’m going to make our query object a little more flexible and dynamic.

First, this is what I really want to be able to do something like this:

<div class="csharpcode-wrapper">
  <pre>var customers = repo.FindBy(
                <span class="kwrd">new</span> TopCustomersWithLowDiscountQuery()
                    .IncludePreferred()
                    .BelowDiscountThreshold(3)
                    .WithMoreSalesThan(500)
                    .As_Expression()
);</pre>
</div>

Better yet, maybe even something like this:

<div class="csharpcode-wrapper">
  <pre>var customers = repo.FindBy(
        <span class="kwrd">new</span> TopCustomersWithLowDiscountQuery()
            .IncludePreferred()
            .BelowDiscountThreshold(3)
            .WithMoreSalesThan(500)
        .AndAlso(
            <span class="kwrd">new</span> DeliquentCustomersQuery()
                .WithDebtOver(9999))
            
);</pre>
</div></p> 

Strongly typed query objects, completely testable outside of the repository, chain-able together with other like-typed query objects using AndAlso or OrElse.

Ok, now how do we do it?

## Expression Tree Helper (Naive)

First, I started with an extension method class to make dealing with some of the Expression<Func<ENTITY, bool>> expressions (which can get old to type) easier.&#160; What I needed was the ability to take two expressions and AndAlso or OrElse them together.&#160; AndAlso (&&) and OrElse (||) are both binary expressions represented by the BinaryExpression class in System.Linq.Expressions.&#160; You can combine two expressions together with any binary expression type by using the Expression.MakeBinary() method.&#160; One problem though is that both Expressions start with a different parameter (i.e. the ‘c’ in (c=>c.AnnualSales > 999)).&#160; So you can’t just join them together because, unfortunately, the Expression Tree compiler will get the ‘c’ parameters jumbled and it won’t work. 

The way I found to deal with this problem is to basically wrap an ‘Invoke()’ expression around the other lambda using the first lambda’s parameter.&#160; In C# parlance, it’s the difference between these two things:

<div class="csharpcode-wrapper">
  <pre>c =&gt; c.AnnualSales &gt; 99 && c.Discount &lt; 4
    -- VS.--
c =&gt; c.AnnualSales &gt; 99 && <span class="kwrd">new</span> Func&lt;Customer, <span class="kwrd">bool</span>&gt;(x=&gt; x.Discount &lt; 4)(c));</pre>
</div></p> </p> </p> </p> </p> </p> </p> </p> </p> </p> 

See how the second one actually involves wrapping the other Lambda (.Discount < 4) with a function and then invokes it?&#160; I’m not sure if that’s EXACTLY what goes on when you use Expression.Invoke(), but that’s what I like to tell myself when I’m working with Expression Trees. It also helps to keep me from ending up in the corner in the fetal position drooling and babbling incoherently which is, unfortunately, a frequent occurrence when dealing with Expression Trees.

You may notice that I put the condition “naive” on this section. This is because my expression tree helper is very naive and doesn’t account for a lot of the crazy things you can do with Expression Trees. This means that you will probably bump against its limitations and have problems. Sorry in advance for this, but I’m stretching the limits of my knowledge here and doing well to write coherently about it. If you have problems, let me know and maybe we can work it out together.

Anyhow, once you’ve invoked the other lambda, you can join them together with whatever binary expression you want, and then you have to re-wrap them in a Lambda again in order to continue working with it.&#160; Without further ado, here’s my expression helper extension methods:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">static</span> <span class="kwrd">class</span> ExpressionHelpers
{
    <span class="kwrd">public</span> <span class="kwrd">static</span> Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; AndAlso&lt;T&gt;(
        <span class="kwrd">this</span> Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; left,
        Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; right)
    {
        <span class="kwrd">return</span> BinaryOnExpressions(left, ExpressionType.AndAlso, right);
    }

    <span class="kwrd">public</span> <span class="kwrd">static</span> Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; OrElse&lt;T&gt;(
        <span class="kwrd">this</span> Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; left,
        Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; right)
    {
        <span class="kwrd">return</span> BinaryOnExpressions(left, ExpressionType.OrElse, right);
    }
        

    <span class="kwrd">public</span> <span class="kwrd">static</span> Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; BinaryOnExpressions&lt;T&gt;(
        <span class="kwrd">this</span> Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; left,
        ExpressionType binaryType,
        Expression&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt; right)
    {
        <span class="rem">// Invoke that lambda with my parameter and give me the bool back, KKTHX</span>
        var rightInvoke = Expression.Invoke(right, left.Parameters.Cast&lt;Expression&gt;());

        <span class="rem">// make a binary expression between the results (i.e. AndAlso(&&), OrElse(||), etc)</span>
        var binExpression = Expression.MakeBinary(binaryType, left.Body, rightInvoke);

        <span class="rem">// Wrap it in a lambda and send it back</span>
        <span class="kwrd">return</span> Expression.Lambda&lt;Func&lt;T, <span class="kwrd">bool</span>&gt;&gt;(binExpression, left.Parameters);
    }
}</pre>
</div>

&#160;

With that out of the way, we can get on to the less complicated stuff which is chaining all these things together.&#160; The next thing I did was to create a simple abstract base class for my query objects (I’m sure there’s a million better ways to do this, but to get things running, this was the simplest thing that worked for right now).

## Query Base Class

The query base is quite simple, actually. It just shuffles around the expressions and provides some convenience methods for you to chain them together:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">abstract</span> <span class="kwrd">class</span> QueryBase&lt;ENTITY&gt;
{
    <span class="kwrd">private</span> Expression&lt;Func&lt;ENTITY, <span class="kwrd">bool</span>&gt;&gt; _curExpression;

    <span class="kwrd">public</span> Expression&lt;Func&lt;ENTITY, <span class="kwrd">bool</span>&gt;&gt; AsExpression()
    {
        <span class="kwrd">return</span> _curExpression;
    }

    <span class="kwrd">public</span> Expression&lt;Func&lt;ENTITY, <span class="kwrd">bool</span>&gt;&gt; AndAlso(QueryBase&lt;ENTITY&gt; otherQuery)
    {
        AsExpression().AndAlso(otherQuery.AsExpression());
    }

    <span class="kwrd">public</span> Expression&lt;Func&lt;ENTITY, <span class="kwrd">bool</span>&gt;&gt; OrElse(QueryBase&lt;ENTITY&gt; otherQuery)
    {
        AsExpression().OrElse(otherQuery.AsExpression());
    }

    <span class="kwrd">protected</span> <span class="kwrd">void</span> addCriteria(Expression&lt;Func&lt;ENTITY, <span class="kwrd">bool</span>&gt;&gt; nextExpression)
    {
        _curExpression = (_curExpression == <span class="kwrd">null</span>)
                            ? nextExpression
                            : _curExpression.AndAlso(nextExpression);
    }
}</pre>
</div></p> </p> </p> </p> </p> 

You can AND and OR two queries together (must be of the same type, for now).&#160; Sub-classes can add their own expressions in a nice, easy-to-use lambda expression style.

## Query Implementation

And now, on to one of the actual query classes. Remember our ridiculously named and implemented TopCustomersWithLowDiscountQuery from my last post?&#160; Here it is in its more simplified form complete with Fluent-API bonus material:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> TopCustomersWithLowDiscountQuery : QueryBase&lt;Customer&gt;
{
    <span class="kwrd">public</span> TopCustomersWithLowDiscountQuery IncludePreferred()
    {
        addCriteria(c =&gt; c.Preferred);
        <span class="kwrd">return</span> <span class="kwrd">this</span>;
    }

    <span class="kwrd">public</span> TopCustomersWithLowDiscountQuery BelowDiscountThreshold(<span class="kwrd">decimal</span> discountThresh)
    {
        addCriteria(c =&gt; c.Discount &lt; discountThresh);
        <span class="kwrd">return</span> <span class="kwrd">this</span>;
    }

    <span class="kwrd">public</span> TopCustomersWithLowDiscountQuery WithMoreSalesThan(<span class="kwrd">int</span> salesThresh)
    {
        addCriteria(c =&gt; c.AnnualSales &gt; salesThresh);
        <span class="kwrd">return</span> <span class="kwrd">this</span>;
    }
}</pre>
</div>

To use it, just chain the methods together. Consider this test case:

<div class="csharpcode-wrapper">
  <pre>[Test]
<span class="kwrd">public</span> <span class="kwrd">void</span> low_discount_high_sales_customers_should_be_selected()
{
    _query = <span class="kwrd">new</span> TopCustomersWithLowDiscountQuery()
        .BelowDiscountThreshold(3)
        .WithMoreSalesThan(500);

    var high = 15m;
    var low = 1m;

    _customers.AddRange(<span class="kwrd">new</span>[]
    {
        <span class="kwrd">new</span> Customer {Id = 1, Discount = low, AnnualSales = 200},
        <span class="kwrd">new</span> Customer {Id = 2, Discount = low, AnnualSales = 800},
        <span class="kwrd">new</span> Customer {Id = 3, Discount = high, AnnualSales = 1000}
    });

    Results.Count().ShouldEqual(1);
    Results.ElementAt(0).Id.ShouldEqual(2);
}</pre>
</div>

&#160;

If you want to chain them together, just use the AndAlso or OrElse methods.&#160; Consider this other test case which uses OrElse:

<div class="csharpcode-wrapper">
  <pre>[Test]
<span class="kwrd">public</span> <span class="kwrd">void</span> preferred_customers_that_are_also_bad()
{
    _query = <span class="kwrd">new</span> TopCustomersWithLowDiscountQuery()
        .IncludePreferred();

    var otherQuery = <span class="kwrd">new</span> DeliquentCustomersQuery()
        .WithPendingLitigation()
        .WithDebtOver(999);

    _customers.AddRange(<span class="kwrd">new</span>[]
    {
        <span class="kwrd">new</span> Customer {Id = 1, Preferred = <span class="kwrd">true</span>, PendingLitigation = <span class="kwrd">false</span>, OutstandingDebts = 4000},
        <span class="kwrd">new</span> Customer {Id = 2, Preferred = <span class="kwrd">false</span>},
        <span class="kwrd">new</span> Customer {Id = 3, Preferred = <span class="kwrd">false</span>,  PendingLitigation = <span class="kwrd">true</span>, OutstandingDebts = 4000}
    });

    var results = _customers
        .AsQueryable()
        .Where(_query.OrElse(otherQuery));

    results.Count().ShouldEqual(2);
    results.ElementAt(0).Id.ShouldEqual(1);
    results.ElementAt(1).Id.ShouldEqual(3);
}</pre>
</div>