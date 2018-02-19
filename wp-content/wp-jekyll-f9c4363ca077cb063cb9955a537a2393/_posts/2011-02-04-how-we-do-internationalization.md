---
id: 174
title: How we do Internationalization
date: 2011-02-04T18:10:30+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2011/02/04/how-we-do-internationalization.aspx
permalink: /2011/02/04/how-we-do-internationalization/
dsq_thread_id:
  - "262114586"
categories:
  - datetime
  - Dovetail
  - internationalization
---
Reading Josh’s post on [helpful Date/Time/TimeZone handling methods](http://www.lostechies.com/blogs/joshuaflanagan/archive/2011/02/03/helpful-datetime-extension-methods-for-dealing-with-time-zones.aspx) inspired me to write about how we deal with the complexities of internationalization and localization in our app.

When we started, we set out some principles for our framework, application, and any related code:

  * Data flowing into our system from external sources (human users, integrations, import, etc) will be normalized into a single unit to the maximum extent possible.
  * External recipients receiving data from our system will have the option of receiving the normalized or localized data (for example, export = normalized, web app = localized).
  * Raw unstructured input (such as the contents of text input fields) will not be normalized and will be treated as raw data (we won’t try to parse through text fields looking for dates, for example).

That first point requires a little bit of clarification because you quickly run into problems with, for example, currency.&#160; So we refined it a little to say that only data which represents a unit for which there is a standard conversion will be normalized. Otherwise, the value will be stored with appropriate extra information.&#160; A few examples might help explain this.

### Safely Convertible Data

Physical measurements like length, width, weight, temperature, etc all have standard conversions (feet to meters, pounds to kilograms, Fahrenheit to Celsius, etc). We convert these into a standard unit (metric, Celsius, etc).&#160; These kinds of measurements are pretty straightforward and the formulae for converting them are well known.&#160; So unless someone decides to [change the gravitational constant of the universe](http://memory-alpha.org/wiki/Gravitational_constant), you shouldn’t have much trouble here.

### Currency

Currency does not have a standard conversion and varies wildly. So we don’t convert these units. Instead, we store the appropriate information to establish definite context in the future: Value, Currency Unit, and Date/Time when the value was recorded.&#160; With these three things, we could reconstruct the value and convert it to whatever unit we needed anytime in the future. For example, what was the value of USD$12.57 in Italian Lira on February 4, 2011 at 11:08am?&#160; Note that Martin Fowler has covered this particular problem in [Patterns of Enterprise Application Architecture](http://martinfowler.com/books.html#eaa) with the “[Money Pattern](http://martinfowler.com/eaaCatalog/money.html).”&#160; This problem is not like the date/time problem below because there is no standard, immovable baseline for currency (no, [not even gold](http://en.wikipedia.org/wiki/Nixon_Shock)).&#160; With money, everything is relative.

### Date/Time

Date/Time is a complicated enough beast without tossing in the problem of time zones. Add to this the fact that governments can and frequently do change the meaning of time zones and you’ve got a recipe for future disaster.&#160; It’s not enough to store a date, time, and time zone because you’ll need to know what the legal definition of that time zone was at that date and time. And good luck trying to deal with the math on a range of dates that span time zones and/or cover a period where the government changed the definition of the time zone.&#160; This task is roughly equivalent in difficulty to a [muddy pig catching contest](http://www.youtube.com/watch?v=WUfg8IWChbg).&#160; It’s not impossible, but you’ll be covered in mud and smell like pig when you’re all done.&#160; Those who have worked with date/time math before know exactly what I mean by this.

So Date/Time appears to be like currency on its face, but it won’t take long before you strongly regret your decision to store it like money.&#160; What’s the answer then?&#160; Store everything in a constant time zone.&#160; Convert all incoming date/times into a standard time zone. When sending out or displaying dates/times, convert them into the recipient’s time zone according to the laws of right now.&#160; In this situation, all you have to worry about is the law \*right now\* for the time zone in question.&#160; There’s no going back in time and trying to figure out what the UTC offset for “Indiana (East)” was in 1996 versus 2011.&#160; When the date/time is coming in, convert it according to today’s law. When it’s going out, convert it according to today’s law. Easy as pie! Fortunately, the OS and your language framework usually handle the problem of figuring out what the law is right now (Windows/.NET BCL, [*nix/zone.tab](http://en.wikipedia.org/wiki/List_of_tz_database_time_zones), etc)

But then the question is, which time zone do you choose as the constant?&#160; The server’s time zone?&#160; This seems an obvious/easy one at first since that’s what most OS/frameworks make easiest. But if your app is going to last more than a few months, you will grow to regret this decision.&#160; There are a few problems with this decision:

  * What if the law changes the definition of the server’s time zone? 
  * What if you end up moving the server?
  * What if you end up having multiple servers in geographically diverse locations?

All of these problems will ruin your day and force you to go through your entire database and correct/adjust each date/time value.&#160; And the last problem will require changes to your code to support conversions depending on where a particular server is.

The correct answer here is to normalize all date/times into the UTC/GMT time zone.&#160; This time zone will never change and is not affected by any governing laws unless somehow the entire world decides to move to [a new time system](http://en.wikipedia.org/wiki/Decimal_time). I don’t have an answer for that one, but I’m guessing that you’ll have bigger problems to deal with besides your data at that point. There’s just [some things](http://en.wikipedia.org/wiki/Apocalypse) you can’t plan for, I guess.

### List Data

Another issue we ran into is how to store data selected by users from select boxes.&#160; We wanted localized language values to appear in the select box in the user’s language, but we wanted to store the value as language-agnostic.&#160; Fortunately, select boxes inherently support this separation of data-value and display-value. So the implementation here was relatively easy. Data values go into the database, display values are configurable, localized by culture, and displayed to the user.

## Summary

In the end, the hardest challenge we faced is being consistent. It seems every time we turned around, there was yet another way that data was received or displayed by the system.&#160; This particular problem is probably the #1 reason why [FubuMVC’s](http://fubumvc.com) UI facilities exist in the first place, and [are necessarily so conventional](http://codebetter.com/jeremymiller/2010/01/29/shrink-your-views-with-fubumvc-html-conventions/) (NOTE: due to the compositional architecture of FubuMVC, its conventional support is [available outside FubuMVC](http://www.google.com/search?q=FubuMVC+conventions))

Having data flow into and out of your database through a standard layer of conventions helps ensure that you consistently, always, and everywhere enforce your data conversion principles and make a truly localized application that stands the test of humans from every continent. Aside from the “storing date/times in UTC” lesson, the lesson on conventions was perhaps the greatest lesson we learned through this whole exercise.