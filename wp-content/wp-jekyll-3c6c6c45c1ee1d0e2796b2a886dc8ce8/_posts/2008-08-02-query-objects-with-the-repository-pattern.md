---
id: 75
title: Query Objects with the Repository Pattern
date: 2008-08-02T03:17:46+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/01/query-objects-with-the-repository-pattern.aspx
permalink: /2008/08/02/query-objects-with-the-repository-pattern/
dsq_thread_id:
  - "262113978"
categories:
  - LINQ
  - Repositories
---
[Nate Kohari](http://kohari.org/) (whose primate brain is far too small to comprehend this post [inside joke, he’s actually really sharp]) was asking on Twitter today about how to structure his repositories: Per aggregate root, Per entity, or just one repository for everything?

The two suggestions that rose to the top were the per-aggregate and one repository approaches. Jeremy and I use a the one repository approach at work and it’s working well for us so far.&#160; The was one compelling argument for the per-aggregate repository and that is that you could encapsulate your aggregate-specific queries inside your aggregate-specific repositories.

Thinking about this a little more, I felt it had a little smell to it, namely the potential for business logic (also known as ‘where’ clauses) to creep into the repository which would be [bad](http://en.wikipedia.org/wiki/Proton_pack#Crossing_the_Streams). Perhaps a better alternative would be to encapsulate the specific logic of a given query into an object. You could then have this object produce something that the repository could (blindly, decoupled) use to query on. 

This approach allows you to maintain the one repository approach, yet still have encapsulated domain-specific queries. Plus, you can test your queries independently of the repository which is a huge benefit.

## Creating and Passing Around Expression Trees

What might the query object produce that the repository could blindly use?&#160; In the .NET 3.5 world, you could use expression trees!&#160; These come in quite handy and play well with LINQ-style (IQueryable) behavior of Linq2NHibernate, Linq2Objects, and Linq2JustAboutAnythingThatInvolvesAListOfThings.

Producing an expression tree is actually quite simple:&#160; Have a method or property that returns Expression<Func<T,bool>>. Yep. That’s it. We can all go home now.&#160; In case you actually wanted to see some code, here’s a simple, extremely naive example of what I mean. Let’s say we wanted to find all our customers that have significant sales with our company, but whose discount is really low (for some reason).&#160; We’d like to find these customers and give them a better discount since they do so much business with us. Your query probably (wouldn’t) look something like this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> TopCustomersWithLowDiscountQuery
{
    <span class="kwrd">public</span> <span class="kwrd">bool</span> IncludePreferred { get; set; }
    <span class="kwrd">public</span> <span class="kwrd">decimal</span> DiscountThreshold { get; set; }
    <span class="kwrd">public</span> <span class="kwrd">int</span> SalesThreshold { get; set; }

    <span class="kwrd">public</span> Expression&lt;Func&lt;Customer, <span class="kwrd">bool</span>&gt;&gt; AsExpression()
    {
        <span class="kwrd">return</span> (c =&gt;
                c.Preferred == IncludePreferred
                && c.Discount &lt; DiscountThreshold
                && c.AnnualSales &gt; SalesThreshold);
    }
}</pre>
</div>

Using this query object, we can still get all the benefits of delayed execution that LINQ/IQueryable provides us without forcing us to sprinkle little surprises of business logic everywhere in LINQ queries.

## Using the Expression Tree to Query</p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> </p> 

To actually use the expression tree, you can call the Where() method on any IEnumerable<T> or IQueryable<T>.&#160; Consider this silly/contrived example:

<div class="csharpcode-wrapper">
  <pre>var query = <span class="kwrd">new</span> TopCustomersWithLowDiscountQuery
{
    IncludePreferred = <span class="kwrd">true</span>,
    DiscountThreshold = 3,
    SalesThreshold = 100000
};

var customerList = <span class="kwrd">new</span> List&lt;Customer&gt;
{
    <span class="kwrd">new</span> Customer {Id = 1, Preferred = <span class="kwrd">true</span>},
    <span class="kwrd">new</span> Customer {Id = 2, Preferred = <span class="kwrd">false</span>},
    <span class="kwrd">new</span> Customer {Id = 3, Preferred = <span class="kwrd">true</span>}
};

var filteredCustomers = 
    customerList
        .AsQueryable()
        .Where(query.AsExpression());</pre>
</div>

&#160;

Once GetEnumerator() is called on filteredCustomers, the magic happens and you’ll end up with an IEnumerable<T> that has only 2 elements in id (ID=1, and ID=3).</p> 

## Full Code Example

Here’s the full code of the test fixture I was using for these examples. Yes, I know it’s not very realistic and there are lots of potential problems with the logic in the query object, but the point was to illustrate how you might go about encapsulating LINQ where clauses, so please go easy on me :)

<div class="csharpcode-wrapper">
  <pre>[TestFixture]
    <span class="kwrd">public</span> <span class="kwrd">class</span> TopCustomersWithLowDiscountQueryTester
    {
        [Test]
        <span class="kwrd">public</span> <span class="kwrd">void</span> preferred_customers_should_be_selected_when_IncludePreferred_is_true()
        {
            _customers.AddRange(<span class="kwrd">new</span>[]
            {
                <span class="kwrd">new</span> Customer {Id = 1, Preferred = <span class="kwrd">true</span>},
                <span class="kwrd">new</span> Customer {Id = 2, Preferred = <span class="kwrd">false</span>},
                <span class="kwrd">new</span> Customer {Id = 3, Preferred = <span class="kwrd">true</span>}
            });

            Results.Count().ShouldEqual(2);
            Results.ElementAt(0).Id.ShouldEqual(1);
            Results.ElementAt(1).Id.ShouldEqual(3);
        }

        [Test]
        <span class="kwrd">public</span> <span class="kwrd">void</span> high_discount_customers_should_not_be_selected()
        {
            _query.IncludePreferred = <span class="kwrd">false</span>;

            var high = 15m;
            var low = 1m;

            _customers.AddRange(<span class="kwrd">new</span>[]
            {
                <span class="kwrd">new</span> Customer {Id = 1, Discount = high},
                <span class="kwrd">new</span> Customer {Id = 2, Discount = low},
                <span class="kwrd">new</span> Customer {Id = 3, Discount = high}
            });

            Results.Count().ShouldEqual(1);
            Results.ElementAt(0).Id.ShouldEqual(2);
        }

        [SetUp]
        <span class="kwrd">public</span> <span class="kwrd">void</span> SetUp()
        {
            _query = <span class="kwrd">new</span> TopCustomersWithLowDiscountQuery
            {
                IncludePreferred = <span class="kwrd">true</span>,
                DiscountThreshold = 3,
                SalesThreshold = 100000
            };

            _customers = <span class="kwrd">new</span> List&lt;Customer&gt;();
            _resultsCached = <span class="kwrd">null</span>;
        }

        <span class="kwrd">private</span> TopCustomersWithLowDiscountQuery _query;
        <span class="kwrd">private</span> List&lt;Customer&gt; _customers;
        <span class="kwrd">private</span> IEnumerable&lt;Customer&gt; _resultsCached;

        <span class="kwrd">public</span> IEnumerable&lt;Customer&gt; Results
        {
            get { <span class="kwrd">return</span> _resultsCached ?? _customers.AsQueryable().Where(_query.AsExpression()); }
        }
    }

    <span class="kwrd">public</span> <span class="kwrd">static</span> <span class="kwrd">class</span> SpecificationExtensions
    {
        <span class="kwrd">public</span> <span class="kwrd">static</span> <span class="kwrd">void</span> ShouldEqual(<span class="kwrd">this</span> <span class="kwrd">object</span> actual, <span class="kwrd">object</span> expected)
        {
            Assert.AreEqual(actual, expected);
        }
    }</pre>
</div>

&#160;

## Coming up…</p> </p> </p> 

Stay tuned: I’m going to do a follow-on post on how you can make the query object code a little more elegant, as well as chain them together with AndAlso and OrElse expressions.