---
id: 210
title: 'Cool stuff in FubuCore No. 9: Stringification'
date: 2011-06-10T17:16:08+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=210
permalink: /2011/06/10/cool-stuff-in-fubucore-no-9-stringification/
dsq_thread_id:
  - "328148485"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the ninth post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

It’s a funny title, but it captures the point perfectly.&nbsp; What do you do when you have something (a domain entity or model object of some kind, or maybe a value type, etc) that you need to convert to a string?&nbsp; “Duh, ToString()!” you might say, and that’s how we started. But in our app we quickly ran into situations where one “ToString()” method wasn’t enough. We needed context. In this context, it should look like this and in that context, it should look like that.&nbsp; So then we had ToString() methods that took arguments. Soon we needed to have services that could do things like figure out the correct time zone for the current user when display date/time values.&nbsp; It got out of hand.&nbsp; We needed to be able to string-ify anything in any way we needed to in the current context, possibly using services from the container. Stringifier and IDisplayFormatter were born.

## Why?

I started writing a whole mini-post on the circuitous route we took to finally arrive at centralizing and conventionalizing our display formatting, but it got too long.&nbsp; So I moved it to it’s own post: [Convention over lots of code](http://lostechies.com/chadmyers/2011/06/10/convention-over-lots-of-code/). You might want to read that before continuing, but if you already understand the “Why”, please proceed.

## How

Stringifier does all the real work, IDisplayFormatter is a nice veneer around Stringifier to make it easier.&nbsp; We’ve baked IDisplayFormatter deep into FubuMVC and HtmlTags so that, generally, your code won’t have to mess with it too much. That’s been beautiful for us.&nbsp; We have a few places where we need to use IDisplayFormatter such as formatting grid columns with our AJAX-y [jqGrid](http://www.trirand.com/blog/) supporting code.&nbsp; FubuMVC’s FubuRegistry has the stringification convention registration built-in. Once you set it up there, you generally don’t have to worry about it. It just works.

But this post is about FubuCore. So let’s assume you’re not using FubuMVC but you still want to use Stringification in your app (say, an ASP.NET MVC app in which [you’re already using the HtmlTag library](http://paceyourself.net/2010/07/30/fubu-htmltags-with-aspnet-mvc/)).&nbsp; Fine, here’s how you go about it.&nbsp; I’m going to post a big chunk of code and then break it down:

<pre class="brush:csharp">public class StringifierExample
{
    [Description("This is an example date time value")]
    public DateTime? ExampleDateTime { get; set; }

    public void FullExample()
    {
        ExampleDateTime = DateTime.Now;

        // [1, 2] Setup stringifier and DisplayConversionRegistry
        var stringifier = new Stringifier();
        var registry = new DisplayConversionRegistry();
        // [3] Setup convention to grab description from property
        registry.IfPropertyMatches(p =&gt; 
               p.PropertyType.IsTypeOrNullableOf&lt;DateTime&gt;() 
               && p.HasAttribute&lt;DescriptionAttribute&gt;()
            ).ConvertBy(r =&gt; r.Property
               .GetAttribute&lt;DescriptionAttribute&gt;()
               .Description);</pre>

<pre class="brush:csharp">// [4] Dump the conventions to Stringifier
        registry.Configure(stringifier);
            
        // [5] Setup display formatter
        var locator = new StructureMapServiceLocator(ObjectFactory.Container);
        var formatter = new DisplayFormatter(locator, stringifier);
        var accessor = ReflectionHelper.GetAccessor&lt;StringifierExample&gt;(
            s =&gt; s.ExampleDateTime);

        // [6] Perform the conversion
        Console.WriteLine("Unconverted: {0}", ExampleDateTime);
        Console.WriteLine("Converted: {0}", 
            formatter.GetDisplay(accessor, ExampleDateTime));
    }
}
</pre>

Now, normally you wouldn’t be doing this all in one class. Parts of it would be scattered in your app (mostly in your StructureMap config/bootstrapping).&nbsp; It’s only the last part about the DisplayFormatter would you really be touching once everything is wired up.

Let’s break that code sample down:

  1. First, set up the Stringifier 
      * Second, new up a DisplayConversionRegistry to help you register your conventions with Stringifier (you don’t have to do this, but it makes it easier unless you want to write your own API for doing convention registration). 
          * Then we explain our conventions to the registry. In this case, I’m using a silly example of grabbing the text of the “Description” attribute hanging off the property. I chose to do it this way to show you your conventions can do more than just grab the value of the property. They can work with the type metadata and not just the value itself. A quick aside: When you here us Fubu guys going on and on about making the most of static typing while we’re using a statically typed language, this is the kind of stuff we’re talking about. 
              * Next we have the registry dump all its conventions into Stringifier. This would normally be done during app start-up/config time. 
                  * New up a DisplayFormatter and satisfy its dependencies. Also use ReflectionHelper to get a [static reflection reference](http://lostechies.com/chadmyers/2011/06/01/cool-stuff-in-fubucore-no-3-static-reflection/) to the property. Normally HtmlTags does this for you in a web app situation. I would recommend if you’re using a web app to use HtmlTags, otherwise, make sure to bake IDisplayFormatter into whatever framework you’re using. 
                      * Perform the actual conversion. You’ll notice what I did her. I print out the simple ToString() value, and then I print out what DisplayFormatter did.</ol> 
                    Here are the console output results:
                    
                    <font face="Courier New">Unconverted: 6/10/2011 4:52:30 PM<br />Converted: This is an example date time value</font>
                    
                    ## In practice, huge pay-off
                    
                    If you bake Stringifier and IDisplayFormatter into your app, and use DisplayConversionRegistry to registry all your conventions in your app configuration/bootstrapping, you can achieve a consistent, conventional approach to displaying values throughout your app. You can stop worrying about which method to call to convert this date/time into whichever format you need it in in a given context.
                    
                    One really cool effect this has is that now your display formatting is also \*PLUGGABLE\*.&nbsp; For us, this is huge since our customers like to customize our app significantly. Some want to display Cases this way and Date/Time’s that way and so on and so forth.&nbsp; We can very easily register different conventions into StructureMap for each individual customer to achieve different formatting strategies according to their whims. Try to do \*that\* in \*your\* app without using conventions and IoC container pluggability :)
                    
                    ## Some other ideas
                    
                    Before I leave you, I wanted to mention a few other conventions that we use that I thought were cool and might help you to grok the power of stringification.
                    
                    On our domain entities, we have some properties of type DateTime that we only really use the Date portion. For example, contract expiration date. We generally don’t care about the time, just the day.&nbsp; We established a convention in our domain that if a property is of type DateTime and the property ends in the word “Date” (for example “ExpirationDate”), then it’s a date-only property.&nbsp; When we display these, we use a custom DateTime format that only displays the Date portion.&nbsp; Likewise, if the property ends in the word “DateTime”, then it’s a date and a time (for example, “CreatedDateTime”).
                    
                    We also had another problem in that we wanted dates on this one portion of a page to be displayed in a certain format (long date/time, “Friday June 10, 2011 5:09 PM”).&nbsp; The portion of the page happened to be a FubuMVC partial with an input model (because partials in FubuMVC are also “[one model in, one model out](http://codebetter.com/jeremymiller/2008/10/23/our-opinions-on-the-asp-net-mvc-introducing-the-thunderdome-principle/)”).&nbsp; So what we did is to bind a convention to type DateTime but only if the property was on a specific view model. Here’s the code:
                    
                    <pre class="brush:csharp">IfPropertyMatches&lt;DateTime&gt;(p =&gt; 
    p.DeclaringType == typeof(LogSeparatorDateViewModel))
.ConvertWith&lt;IDateTimeFormatter&gt;(
    (formatter, date) =&gt; formatter.Format(date, "{0:D}"));
</pre>
                    
                    &nbsp;
                    
                    (IDateTimeFormatter is a class we have that encapsulates all the DateTime / TimeZone handling logic)
                    
                    This gave us tons of flexibility to keep our views and controllers nice and trim and not having to call a bunch of crazy extension methods to do one-off formatting all the time. All our conventions (even one-offs) are in ONE PLACE – easy to look at and, more importantly, easy to test!