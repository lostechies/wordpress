---
id: 192
title: 'Cool stuff in FubuCore No. 3: Static Reflection'
date: 2011-06-01T15:33:00+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=192
permalink: /2011/06/01/cool-stuff-in-fubucore-no-3-static-reflection/
dsq_thread_id:
  - "319807515"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the third post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

NOTE: In case you weren’t aware, FubuCore [is available as a Nuget package](http://www.nuget.org/List/Packages/FubuCore) and is completely independent from [FubuMVC](http://fubumvc.com/). Other projects besides FubuMVC use it, such as [Storyteller](https://github.com/storyteller/storyteller) which has nothing to do with FubuMVC.

Static reflection.

Ayende was [doing it](http://ayende.com/blog/779/static-reflection) back in 2005 (before .NET 3.5!)

Daniel Cazzulino (kzu) was [doing it with linq](http://blogs.clariusconsulting.net/kzu/statically-typed-reflection-with-linq/) back in 2007.

[Jeremy Miller](http://codebetter.com/jeremymiller/) started [playing with it](http://codebetter.com/jeremymiller/2008/06/19/working-faster-and-fewer-mapping-errors-with-nhibernate/) and had the idea to use it to eliminate XML configuration from our NHibernate mappings.&nbsp; [James Gregory](http://lostechies.com/jamesgregory/) picked it up and it is [now known as Fluent NHibernate](http://jagregory.com/writings/introducing-fluent-nhibernate/). James later wrote a good post on the subject titled “[Introduction to static reflection](http://jagregory.com/writings/introduction-to-static-reflection/).”

Static reflection can be summarized simply as: Using the Reflection API, without using strings, by using the delayed execution features of Linq in order to get a Reflection/metadata reference to a code element (property, method, etc).

This technique of not using magic strings (either in code or XML) to represent code constructs (type names, method names, property names, etc) started catching on and can now be found in numerous projects, including [ASP.NET MVC](http://weblogs.asp.net/scottgu/archive/2010/01/10/asp-net-mvc-2-strongly-typed-html-helpers.aspx).

A simple example of where you might use it is if you want to render some HTML having to do with the property on one of your models.&nbsp; For example, Model.FirstName.&nbsp; You could just have a method like:&nbsp; “TextBoxFor(Model.FirstName)” which would render a textbox. The problem is, TextBoxFor only gets the \*value\* of FirstName. It doesn’t know any of the metadata about FirstName.&nbsp; What if we wanted to do some conventional stuff like slap a “required” CSS class on input element so that our [validation framework](http://bassistance.de/jquery-plugins/jquery-plugin-validation/) could attach validation behavior to it? What if we had authorization in our app that prevented you from editing certain fields if you didn’t have the privilege?&nbsp; If our TextBoxFor method were smart enough and had the metadata for FirstName, it could run it through an authorization checker to see if it should slap a “readonly” attribute on the textbox or not.&nbsp; So you see, having more than just the value can really help. But how do we pass a reference to the FirstName property itself, instead of just the value?&nbsp; This is what static reflection is for.

We use it extensively in almost all our projects at Dovetail.&nbsp; It’s core to [StructureMap](https://github.com/structuremap/structuremap), [Storyteller](https://github.com/storyteller/storyteller), and [FubuMVC](http://fubumvc.com/).&nbsp; One of the biggest features of FubuMVC is that it works with the fact that you’re in a strongly, statically-typed environment. In Rails, everything is a string and that’s OK.&nbsp; Anyone who’s worked on a large project, however, knows that managing strings-as-route-identifiers can get problematic (yes, even in Rails, praise be upon it). BEFORE YOU FLAME – I’m not saying that Fubu is better than Rails or anything like that. [ASP.NET MVC has the same problem](http://wekeroad.com/post/6012451652/referencing-routes-in-asp-net-mvc-the-rails-way). In FubuMVC, we wanted to take as much advantage of strong typing as possible (hey, if we’re going to be using C#, let’s make the most of it, right?).&nbsp; We wanted routes to be ReSharper-navigable (CTRL+click or CTRL+B navigation) and we wanted easy rename support (F2 rename refactoring).

This has paid for itself as we’ve been able to significantly rearrange our routes several times in the life of our product with little to no thrashing through views.&nbsp; Also, by not using magic strings, we can get a full, complete list of all our routes, at config-time to be able to do things like [advanced diagnostics](http://guides.fubumvc.com/getting_started.html#howdidthatstuffgetthere) (Joshua Flanagan also showed [diagnostics in action](http://lostechies.com/joshuaflanagan/2010/01/18/fubumvc-define-your-actions-your-way/)). We were doing it years before the [Glimpse](http://getglimpse.com/) guys were, by the way (but they do some cool stuff that Fubu could integrate with, so I look forward to seeing that integration one day).&nbsp; On a big project (where “big” means dozens of routes, runtime-loaded packages with their own routes and views being added to the app, etc), having the ability to see all the possible routes and how they’re wired up at config-time is invaluable.

But I digress. Static reflection is a really useful tool if you happen to be working in a statically-typed environment as it can help you take advantage of all the typing data the compiler knows about at compile-time.

Now that I’ve hopefully sold you&nbsp; on the idea that static reflection is useful and profitable when in a statically-typed environment, I’ll show you how you can use FubuCore to bring it to reality in your project.

## How it works

Remember our TextBoxFor example earlier? The signature, before static reflection, might look like this:

public string TextBoxFor(object value);

But now, it will look like this:

public string TextBoxFor<T>(Expression<Func<T,object>> expression);

That “Expression<>&#8221; business is the key. This tells the compiler to treat this as metadata. It doesn’t actually \*compile\* the Func<T,object>, it returns a new type of object called a [System.Linq.Expressions.Expression](http://msdn.microsoft.com/en-us/library/bb335710.aspx) that represents all the metadata the compiler had about this expression that it would’ve normally used to actually compile the code. But instead it stopped there and turned all that metadata into an “[Expression Tree](http://msdn.microsoft.com/en-us/library/bb397951.aspx)”.&nbsp; Using this, we can get all the reflection data you’d otherwise get with [Type.GetMethod](http://msdn.microsoft.com/en-us/library/system.type.getmethod.aspx) or [Type.GetProperty](http://msdn.microsoft.com/en-us/library/system.type.getproperty.aspx) using the method or property name as a string. Using static reflection is a lot faster than dynamic reflection because the compiler has already done the work of looking everything up at compile-time. There’s no parsing strings and looking through the assembly metadata to try to find the MethodInfo or PropertyInfo by name.

There’s still a small chunk of work left to turn an Expression into a MethodInfo or PropertyInfo. That’s where ReflectionHelper comes in…

## ReflectionHelper

All the magic starts with a little static helper class known as “[ReflectionHelper](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Reflection/ReflectionHelper.cs).”&nbsp; This has some helpful methods on it like GetMethod, GetProperty, and GetAccessor.

Inside our method (i.e. TextBoxFor), we will have the “expression” variable which is of type System.Linq.Expressions.Expression.&nbsp; If we know the expression references a method, we can use ReflectionHelper.GetMethod. If we know it represents a property, we can use ReflectionHelper.GetProperty. Otherwise, if we don’t know for sure, we can use ReflectionHelper.GetAccessor and then interrogate the result to see whether it’s a method or property.

So our TextBoxFor method might look something like:

<pre class="brush:csharp">public string TextBoxFor&lt;T&gt;(Expression&lt;Func&lt;T,object&gt;&gt; expression)
{
    // Get the metadata
    var property = ReflectionHelper.GetProperty(expression);
    // Get the actual value from the 
    var value = expression.Compile()(_model);
    // Generate the HTML with the metadata and value
    return generateHtml(property, value);
}</pre>

&nbsp;

Assuming we have a strongly-typed view that already knows its model type (let’s say it’s a type called ViewUserModel for the view ViewUser.aspx), we could call our TextBoxFor like this:

<pre class="brush:csharp">&lt;%= this.TextBoxFor(model =&gt; model.FirstName); %&gt;</pre>

With the actual PropertyInfo from GetProperty and the value retrieved, we have everything we need to generate the proper HTML to render a textbox for this property including any validation or read-only attributes.

### Accessor

I mentioned earlier that calling ReflectionHelper.GetAccessor can be used if you’re unsure whether the Expression that was passed in is a method or a property. It has another important use: Expressions with a chain of properties.

If you use GetAccessor, you can get the whole chain of properties so you can inspect each property in the chain, if necessary. Using GetAccessor, our TextBoxFor could get a lot smarter and be able to handle situations like this:

<pre class="brush:csharp">&lt;%= this.TextBoxFor(model =&gt; model.Case.Owner.FirstName); %&gt;</pre>

&nbsp;

The interface that comes back from GetAccessor is called, coincidentally enough, [Accessor](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Reflection/Accessor.cs).&nbsp; It has some nifty methods on it such as GetValue and SetValue. But the best part of it (for property chains, at least), is the PropertyNames property which returns a string[] of all the names in the chain.&nbsp; If you wanted to walk the chain yourself and inspect them, you can call&nbsp; the Getters() method which will return a list of [IValueGetter](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Reflection/IValueGetter.cs)s which may be [PropertyValueGetter](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Reflection/PropertyValueGetter.cs)s or [MethodValueGetter](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Reflection/MethodValueGetter.cs)s.&nbsp; You can then query the IValueGetter for the name or call GetValue to get the value at that point in the chain.

## Summary

<p align="left">
  There’s lots more that could be said for static reflection, but this is enough hopefully to get you started and thinking about it.&nbsp; If you want to see how static reflection can be used for serious fun and profit, you can look at some of the examples in <a href="https://github.com/DarthFubuMVC/fubumvc/blob/master/src/FubuMVC.Core/UI/FubuPageExtensions.cs#L95">FubuMVC</a>, <a href="http://fluentnhibernate.org">Fluent Nhibernate</a>, <a href="http://www.asp.net/mvc">ASP.NET MVC</a>, and others.
</p>