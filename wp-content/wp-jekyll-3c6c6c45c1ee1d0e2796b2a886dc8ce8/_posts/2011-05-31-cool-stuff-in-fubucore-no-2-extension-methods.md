---
id: 189
title: 'Cool stuff in FubuCore No. 2: Extension Methods'
date: 2011-05-31T14:35:16+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=189
permalink: /2011/05/31/cool-stuff-in-fubucore-no-2-extension-methods/
dsq_thread_id:
  - "318801126"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the second post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

This post covers the various and plentiful extension methods contained in the [FubuCore project](https://github.com/darthfubumvc/fubucore). We have built up these extensions methods over the last 3-4 years in anger. Some of them may be a little sloppy and not up to your liking or taste level, but all of them are used heavily and have been running in multiple production systems for quite a while (some of them over 2 years). We find most of them to be invaluable and use them every day. I hope you find some value in them as well.

## IfNotNull

Various overloads ([Source](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/BasicExtensions.cs))

This one is super handy.  How many times have you written code like this?

<pre class="brush:csharp">if( value != null )
{
    doSomething();

}</pre>

&nbsp;

Well, it really stinks when you’re in the middle of a code flow and you need to do something only if “value” is not null. Well, now you can do stuff like this:

<pre class="brush:csharp">var name = employee.IfNotNull(e =&gt; e.FullName);
// or
employee.IfNotNull(e =&gt; doSomething(e));</pre>

&nbsp;

## Hiding Data In Views With If/IfNot

([Source](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/BooleanExtensions.cs))

With Fubu authorization, you can hide pieces of information in the view if the current ser doesn’t have access to it.  We wrote short-hand methods to assist us with this in the view. Assume the view’s model has a property called “CanSeeSalaryInformation” which represents the result of an authorization check for a user permission.

<pre class="brush:csharp">&lt;span&gt;&lt;%= employee.Salary.If(()=&gt; Model.CanSeeSalaryInformation)%&gt;&lt;/span&gt;</pre>

&nbsp;

## Making Dictionary.Get Not As Annoying

Various overloads ([Source](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/DictionaryExtensions.cs))

If you do manage to find yourself using a Dictionary instead of a [Cache](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-no-1-cache/), you can get around some of the pain of having to do the “ContainsKeys” checks by using the Get extension methods. A lot of times you want to get a value from a dictionary but don’t want to do all the “[ContainsKey](http://msdn.microsoft.com/en-us/library/kw5aaea4.aspx)” checking or messing with the “out” variable in the “[TryGetValue](http://msdn.microsoft.com/en-us/library/bb347013.aspx)” method.

Let’s say you want to get the value of a key from a dictionary which may not be there. And if it’s _not_ there, then return a default value (let’s say, empty string).

<pre class="brush:csharp">dictionary.Get("mykey", "");</pre>

## Enumerable Extensions

([Source](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/EnumerableExtensions.cs))

Like most programmers, we do a lot of stuff with enumerables (lists, arrays, and other fun list-y type structures). So we’ve evolved a lot of enhancements and extensions to make them easier to use in various situation.

### IList<T> Extensions

**Fill(T value)**: Add an item to a list if it isn’t already in the list.

**RemoveAll(Func<T, bool> whereEvaluator)**: Removes items from the list that match the function/predicate.

**AddRange(IEnumerable<T> items)**: For some reason, [AddRange](http://msdn.microsoft.com/en-us/library/z883w3dc.aspx) is only on List<T> and not on IList<T>, so we added it to IList<T>.

**AddMany(params T[] items)**: Just like AddRange, but allows for many param arguments as well as method chaining.

### IEnumerable<T> Extensions

**Each(Action<T> action)**: Just like “foreach”, but is inline and allows method chaining.

**FirstValue(Func<T, UReturn> returnFunc)**: Kinda like [FirstOrDefault](http://msdn.microsoft.com/en-us/library/bb549039.aspx), but more like combining a [Where](http://msdn.microsoft.com/en-us/library/bb534803.aspx) and a [Select](http://msdn.microsoft.com/en-us/library/bb548891.aspx) and a [FirstOrDefault](http://msdn.microsoft.com/en-us/library/bb549039.aspx) in one method.  This method will iterate over the enumerable, executing your _returnFunc_ until it gets a non-null result.  If none was found, it just returns null.

**IsEqualTo(IEnumerable<T> expected):** This one we use (almost?) exclusively for testing to ensure the result of some method returns exactly what we expected. It will check the lengths/count of each enumerable and then verify that each item in each list passes a call to “.Equals()”.

### String Extensions

**Join(string separator)**: Just like [String.Join](http://msdn.microsoft.com/en-us/library/57a79xd0.aspx) except it allows method chaining.

## Stream Extensions

([Source](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/StreamExtensions.cs))

**ReadAllText:** This does the tedium of new()’ing up a StreamReader and calling [ReadToEnd](http://msdn.microsoft.com/en-us/library/system.io.streamreader.readtoend.aspx).  It saves a few lines of code when all you want to do is open a stream and read the whole thing in. I think we use this for reading text embedded assembly resources  If you’re working with files, it’s better to just call [File.ReadAllText](http://msdn.microsoft.com/en-us/library/system.io.file.readalltext.aspx).

## String Extensions

([Source](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/StringExtensions.cs))

**CombineToPath(string root):** If the path is rooted, just returns the path.  Otherwise, this combines the root and path. (Uses [Path.IsPathRooted](http://msdn.microsoft.com/en-us/library/system.io.path.ispathrooted.aspx) and [Path.Combine](http://msdn.microsoft.com/en-us/library/fyy7a5kt.aspx))

**ToFullPath()**: Just like [Path.GetFullPath](http://msdn.microsoft.com/en-us/library/system.io.path.getfullpath.aspx), but allows method chaining.

**AppendPath(params string[] paths):** Repeatedly calls Path.Combine on a list of paths (i.e. /bar/baz/zab/rab).

**PathRelativeTo(string root):** Makes the current string (assumed to be a path) rooted against the specified root. (i.e. “/bar/baz”.PathRelativeTo(“c:”) will result in “c:/bar/baz”).

**IsEmpty():** Same as [String.IsNullOrEmpty](http://msdn.microsoft.com/en-us/library/system.string.isnullorempty.aspx), but hangs off the string itself as an extension method.

**IsNotEmpty():** Opposite of IsEmpty.

**IsNotEmpty(Action<string> action):** Same as IsNotEmpty() but will execute an action if the string is, in fact, not empty. This is useful for keeping statements in-line.

**ToBool:** Converts a string to boolean. It handles the null/empty check, and then calls [Bool.Parse](http://msdn.microsoft.com/en-us/library/system.boolean.parse.aspx).

**ToFormat**: (My personal favorite) Calls String.Format, but allows for method chaining. Example:

<pre class="brush:csharp">return "You have {0} turns remaining.".ToFormat(numTurnsLeft);</pre>

**EqualsIgnoreCase(string otherString):** Calls String.Equals with StringComparison.InvariantCultureIgnoreCase.

**Capitalize**: A more convenient way to call: CultureInfo.CurrentCulture.TextInfo.ToTitleCase(value)

**HtmlAttributeEncode, HtmlEncode, HtmlDecode, UrlEncode, UrlDecode:** A more convenient way to call the corresponding methods on [System.Web.HttpUtility](http://msdn.microsoft.com/en-us/library/system.web.httputility.aspx).

**ConvertCRLFToBreaks(string plainText)**: Converts “\r\n” or “\n” to “<br/>” (handy for html-izing some plain text&#8221;).

**ToDateTime(string dateTimeValue)**: A more convenient way of calling [DateTime.Parse](http://msdn.microsoft.com/en-us/library/1k1skd40.aspx).

**ToGmtFormattedDate:** Prints out a log-file friendly date/time stamp in full format in the GMT timezone (i.e. “yyyy-MM-dd hh:mm:ss tt GMT”).

**ToDelimitedArray:** A more convenient way of calling [String.Split](http://msdn.microsoft.com/en-us/library/system.string.split.aspx), plus it strips away extra whitespace so “a  “,”b”, and ”    c” get turned into “a,b,c”.

**IsValidNumber**: Uses regex to attempt to determine if the string contains something recognizable as a number. If memory serves, this was written in anger at [Decimal.Parse](http://msdn.microsoft.com/en-us/library/system.decimal.parse.aspx) which never seemed forgiving enough and would frequently miss values that were clearly (to humans) numbers.

**getPathParts:** Breaks down a string like “c:/bar/baz/zab” into a list of strings “c:”, “bar”, “baz”, and “zab”.

**DirectoryPath:** A more convenient way of calling [Path.GetDirectoryName](http://msdn.microsoft.com/en-us/library/system.io.path.getdirectoryname.aspx).

## Type Extensions

([Source](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/TypeExtensions.cs))

These are some \*really\* handy methods if you do a lot of work with generics, expression trees, or both.

Unfortunately, this blog post would be four times larger if I mentioned all the great extension methods.  I strongly suggest you browse through this source file (linked above) because you will definitely find at least one thing that you can use.

I hand-picked a few ones that I thought were especially useful and might whet your appetite :

**IsNullableOfT():** Determines if the given type implements Nullable<> or not (i.e. DateTime?).

**IsNullableOf(Type otherType):** Determines if the given type is a Nullable<otherType> or not. For example, typeof(DateTime?).IsNullableOf(typeof(DateTime)) would be True.

**IsTypeOrNullableOf<T>**:  Useful for checking if this type is one of DateTime or a DateTime?, for example.

**CanBeCastTo<T>:** This helps to rectify the oft-confusing backward logic of [Type.IsAssignableFrom](http://msdn.microsoft.com/en-us/library/system.type.isassignablefrom.aspx).

**IsConcreteWithDefaultCtor**: Determines if this type is a concrete type with a default/open constructor (i.e. you could call Activator.CreateInstance() on it with no exceptions).