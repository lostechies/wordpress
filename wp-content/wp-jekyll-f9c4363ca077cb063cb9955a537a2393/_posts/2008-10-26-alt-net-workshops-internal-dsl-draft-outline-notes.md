---
id: 100
title: 'ALT.NET Workshops: Internal DSL Draft Outline, Notes'
date: 2008-10-26T04:30:00+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/10/26/alt-net-workshops-internal-dsl-draft-outline-notes.aspx
permalink: /2008/10/26/alt-net-workshops-internal-dsl-draft-outline-notes/
dsq_thread_id:
  - "262262258"
categories:
  - .NET
  - Design
  - DSL
---
I&rsquo;ve been preparing for the upcoming [ALT.NET Workshop](http://altdotnet.org/events/6) (associated with [KaizenConf](http://kaizenconf.com/workshops)) on Internal Domain Specific Languages (DSL).&nbsp; The schedule hasn&rsquo;t been released yet, but I&rsquo;m pretty sure the Internal DSL workshop will be on Friday 31-OCT (don&rsquo;t quote me just yet, David Laribee is the final arbiter of such things).

I decided to collect my thoughts here in a blog post similar to the way [Matthew Podwysocki](http://codebetter.com/blogs/matthew.podwysocki) (&ldquo;F# is my MIDDLE name!&rdquo;) has done with his [workshop on Functional Programming](http://codebetter.com/blogs/matthew.podwysocki/archive/2008/10/24/kaizenconf-functional-programming-is-it-a-game-changer.aspx). 

**NOTE**: This is a WORK IN PROGRESS. I will be updating this post over the next few weeks and adding/removing/updating things. I may break sections out into separate posts or move this content entirely to another medium. For now, I wanted to get my ideas down and I hope it helps someone in the meantime.

### EDIT HISTORY

26-OCT-2008 : First (rough) Draft

&nbsp;

# Introduction

The concept of a DSL (Domain Specific Language) is not a new one, but it has seen recent favor, certainly in the .NET space, as of late.&nbsp; Currently, the primary (or at least, most authoritative) source of _research on-going_ and _ideas generating_ on this subject resides within [Martin Fowler&rsquo;s Bliki](http://martinfowler.com/), specifically within his &ldquo;[work-in-progress](http://martinfowler.com/dslwip/)&rdquo; area for is upcoming book on DSLs.&nbsp; He also has a [post specifically about DSLs](http://www.martinfowler.com/bliki/DomainSpecificLanguage.html) which may be of interest to the reader.&nbsp; Fowler&rsquo;s DSL WIP area will be referenced often in my workshop and in this blog post. Please take a moment and scan the topics on the left, especially those around Internal DSLs as that is primarily what we&rsquo;ll be concentrating on during the workshop and this and related posts.

# Internal DSL Concept

&ldquo;Internal DSL&rdquo; is really a fancy pants (i.e. well-bearded, tweed-jacketed, British-accented &ndash; props to Fowler) way of talking about bending your primary language of choice to create a special syntax that&rsquo;s easier for the consumers of your API to use to accomplish some otherwise complicated task.&nbsp; We use the term &ldquo;Internal DSL&rdquo; to describe the process of building a special type of API for accomplishing a specific task (i.e. the &lsquo;domain&rsquo;). If you&rsquo;ve done .NET development for more than a year or two, you&rsquo;ve more than likely used both external and internal DSLs and may not have known it. The reason we use the fancy term is because there are a collection of practices, patterns, and principles involved in making a &ldquo;good&rdquo; internal DSL and so a formal name for it is required (as opposed to saying &ldquo;that cool API that looks kinda like the ICriteria API in NHibernate&rdquo;, etc).&nbsp; &ldquo;Internal DSL&rdquo; is jargon, to be sure, and so the use of this term should be carefully explained or qualified when used in mixed companies or among groups of individuals of varying levels of experience. Hopefully this workshop will help explain most everything that is meant/implied by the term &ldquo;Internal DSL.&rdquo;&nbsp; We want to make sure that people know we&rsquo;re following a formal process here, and not just making API magic up as we go along.&nbsp; 

As an aside, for this workshop, we&rsquo;ll be primarily dealing with .NET and C#, though these concepts apply to just about any modern language and a few antique languages.&nbsp; 

Most APIs written in .NET are not &ldquo;Internal DSLs&rdquo;, though many of them include some of the elements/techniques mentioned below. They are usually a push-button style API (i.e. call this method, set this property, hook this event &ndash; all over many, many lines of code). Currently, most APIs you use in .NET are this way.&nbsp; Examples of Internal DSLs from the .NET arena include things like the [Fluent NHibernate project](/controlpanel/blogs/posteditor.aspx/fluent-nhibernate.googlecode.com), the ICriteria API in [NHibernate](http://www.hibernate.org/343.html), the configuration APIs in [StructureMap](http://structuremap.sf.net/) 2.5 and [Ninject](http://ninject.org/), among others.&nbsp; Syntactically speaking, they are perfectly valid .NET APIs, but they&rsquo;re not &ldquo;normal&rdquo; compared to what we might usually expect from APIs in the BCL itself and from 3rd party component vendors (think &ldquo;UltraSuperMegaGrid&rdquo; from _MadeUp Grids &lsquo;R Us, Inc._).&nbsp; In this workshop, we&rsquo;ll talk about what constitutes an Internal DSL and how to build one including an examination of the key component parts of an Internal DSL and how to systematically apply them when creating your DSL.

To gain more context, consider this heavily contrived &ldquo;Push-button&rdquo; style API example for configuring what action should be taken when a scheduled event occurs:

<div class="csharpcode-wrapper">
  <div class="csharpcode">
    <pre><span class="lnum">   1:</span> var action = <span class="kwrd">new</span> NotifyAction();</pre>
    
    <pre><span class="lnum">   2:</span> action.MessageTemplate = <span class="kwrd">new</span> MessagingTemplate(<span class="str">"foo"</span>);</pre>
    
    <pre><span class="lnum">   3:</span> action.Recipients.Add(<span class="kwrd">new</span> QueueMembersNotificationGroup());</pre>
    
    <pre><span class="lnum">   4:</span> schedule.Action = action;</pre>
  </div>
</div>

Now, let&rsquo;s say that this was a common scenario and that it might be nice to have a slightly more expressive, yet concise way of expressing our intentions without having as much language noise in the way:

<div class="csharpcode-wrapper">
  <pre>schedule.Action.Send().Message(<span class="str">"foo"</span>).To.QueueMembers();</pre>
</div>

There are pros and cons to this approach, as I&rsquo;m sure you have already concluded.&nbsp; Internal DSLs are not appropriate in every situation. However, when they are appropriate, they can deliver a lot of value and accelerate the development effort of your API consumer and allow for greater discoverability and ease of use when consuming your API.

# Internal DSL Motivations and Purpose

An internal DSL can involve extra development effort to achieve, and so its use should be carefully considered (cost vs. benefit to API consumer). It is an investment that can pay off quite nicely if initiated appropriately and executed properly. There are some specific scenarios and problems that are particularly suited for Internal DSLs as a solution. Among these scenarios are: complex (more-than-a-little) configuration, assembly of a complex object graph for some purpose (usually configuration, but there are others), making repetitive or otherwise &ldquo;chatty&rdquo; APIs more streamlined for the 80% case at the expense (or not) of the 20% case, etc.&nbsp; In the wild, I have observed the following common excuses for building an Internal DSL:

## Excuses for Creating an Internal DSL (in no particular order)

### XML abuse reduction (conducting an &ldquo;XML Intervention&rdquo;)

A good example of this excuse is the Fluent NHibernate project &ndash; a project that aims to place a .NET fluent-style API over the generation of NHibernate entity XML mappings.&nbsp; The reasons for not using XML in most circumstances have been [well](http://www.codinghorror.com/blog/archives/001114.html) [covered](http://www.codinghorror.com/blog/archives/001139.html). If you disagree please allow &ndash; for the moment &ndash; that in some circumstances XML is/was a bad choice and that there are sometimes better alternatives.&nbsp; In this particular case, NHibernate&rsquo;s HBM XML mapping files have, in my opinion, a critical weakness: Lack of good refactoring support.&nbsp; Rename a property on a mapped entity class, even with great refactoring tools, and your XML&rsquo;s are still (usually) left behind.&nbsp; Worse still, you likely won&rsquo;t discover this fact until runtime.&nbsp; Fluent NHibernate uses a fluent-style Internal DSL to (eventually) achieve the same functionality as the HBM XML mapping, but with key refactor-ability, easier testability, and slightly less &ldquo;noise&rdquo; than what XML&rsquo;s angle brackets present. 

### Streamlining an existing, complicated, and/or tediously repetitive push-button API

The StructureMap &ndash; a popular IoC container tool &ndash; configuration API (especially the one currently in the trunk, pre-Version 2.5 release) will serve as my primary example for this excuse.&nbsp; StructureMap has a configuration model it uses to describe how objects are to be constructed and how they should be assembled post-construction. This model can be rather tedious to create and drive on your own via code.&nbsp; This is why there is an Internal DSL in StructureMap for generating the configuration model using a more streamlined approach.

Instead of having to write code like this frequently and in great quantities just to configure StructureMap&hellip;

<div class="csharpcode-wrapper">
  <pre>var messageTemplates = _useTestMessageTemplate
    ? (Instance) <span class="kwrd">new</span> LiteralInstance(MessageTemplateGroup.TestTemplateGroup)
    : <span class="kwrd">new</span> FindEntityInstance&lt;MessageTemplateGroup&gt;(x =&gt; x.Name == _templateName);
<span class="kwrd">return</span> <span class="kwrd">new</span> SmartInstance&lt;NotifyAction&lt;ENTITY, LOG&gt;&gt;()
    .TheArrayOf&lt;INotificationGroup&lt;ENTITY, LOG&gt;&gt;().Contains(_notificationGroups.ToArray())
    .CtorDependency&lt;MessageTemplateGroup&gt;().Is(messageTemplates);</pre>
</div>

You could instead write code like this&hellip;

<div class="csharpcode-wrapper">
  <pre>ForRequestedType&lt;ICachedSet&gt;().TheDefaultIsConcreteType&lt;CachedSet&gt;()
   .CacheBy(InstanceScope.Hybrid);

ForRequestedType&lt;IControlBuilder&gt;().TheDefault.Is.OfConcreteType&lt;AspNetControlBuilder&gt;();
ForRequestedType&lt;IPartialRenderer&gt;().TheDefault.Is.OfConcreteType&lt;PartialRenderer&gt;();</pre>
</div>

### Making an existing API more expressive and intention revealing

This excuse involves taking an existing API and either wrapping it with your own API, or extending it via C# 3.0 Extension Methods. Perhaps the simplest and best illustrative example of this are the [SpecificationExtensions extension methods](http://code.google.com/p/specunit-net/source/browse/trunk/src/SpecUnit/SpecificationExtensions.cs) for NUnit originally created by [Scott Bellware](/controlpanel/blogs/posteditor.aspx/www.scottbellware.com) for his [SpecUnit.net project](http://code.google.com/p/specunit-net/). Perhaps a code sample is best to demonstrate:

Before:

<div class="csharpcode-wrapper">
  <pre>Assert.That(record2.Name, Is.EqualTo(<span class="str">"Stan"</span>));<br />
<span class="rem">// -or-<br /></span>
Assert.AreEqual(<span class="str">"Stan"</span>, record2.Name);</pre>
</div>

After:

<div class="csharpcode-wrapper">
  <pre>record2.Name.ShouldEqual(<span class="str">"Stan"</span>);</pre>
</div>

As you can see here, the ShouldEqual() serves the same purpose as the previous two &ldquo;Before&rdquo; examples, yet somehow flows better and is more expressive and intention revealing.&nbsp; It achieves the same functional goal of the underlying API while adding extra beneficial qualities. These qualities might be relatively insignificant by themselves, but when combined over hundreds or thousands of instances across all your tests, it adds up.

## Goals

An Internal DSL must serve a purpose and accomplish some goal in order to justify the cost invested.&nbsp; Personally, of the Internal DSLs I have used, written, or participated in writing, the following 4 results have been realized such that I feel the investment of cost into that particular DSL&rsquo;s creation was well worth the effort (especially if it wasn&rsquo;t my effort to create it :) ).

### Goal #1: Expressiveness

First and foremost, we must keep in mind that we&rsquo;re building a domain-specific **_LANGUAGE._** This means that the expression and later comprehension of ideas (i.e. the fundamental purpose of language). The DSL must be able to be easy to express as well as later be comprehended by a viewer or maintenance programmer (who may just so happen to be yourself in the future).&nbsp; This means that we can and should use every capability of the language at our disposal to achieve this goal. This also means that some of these techniques may, in other contexts, be bad practice or harmful. In this context, however, they are quite beneficial and contribute overall to the other goals of the DSL.

Weight should be placed on making the DSL flow from a language and syntactical perspective.&nbsp; It is not necessary to achieve proper English syntax or grammar, but an English speaking person should be able to reasonably identify what is trying to be expressed by the DSL. For example, instead of saying &ldquo;ShouldEqualTheValue(&lsquo;Stan&rsquo;)&rdquo;, &ldquo;ShouldEqual(&lsquo;Stan&rsquo;)&rdquo; is sufficient.&nbsp; Generally speaking, PascalCasing is not as easy to read as normal, properly spaced English so you should try to avoid adding extra words unnecessarily. Though the concept is quite clearly expressed by both, the lack of extra noise in the later example makes it the preferred one.

As mentioned previously, accomplishing this particular goal may involve violating several generally accepted rubrics of API design.&nbsp; Carefully considered, this is usually OK as long as it is confined to the DSL itself and not encouraged or required beyond direct usage of the DSL. Consumers should be able to write otherwise acceptable code around your DSL. If your DSL is so dramatically different from normative forms of the language, you may consider requiring the entire file to be in the form of your DSL so as to avoid mixing normative and DSL style syntax. A good example of this scenario might be the specification syntax used by [Aaron Jensen](http://codebetter.com/blogs/aaron.jensen)&rsquo;s [Machine.Specifications framework](http://codebetter.com/blogs/aaron.jensen/archive/2008/05/08/introducing-machine-specifications-or-mspec-for-short.aspx).&nbsp; In this case, the syntax is quite different from what you might see in a normal C# class or test fixture and so, while not required, the entire file should probably have consistent syntax (i.e. don&rsquo;t mix traditional test fixture-type code with Machine.Specifications code in the same class or file).

### Goal #2: Efficiency/Productivity

It seems obvious to say it, but it&rsquo;s not always obvious when designing and developing a DSL: Using the DSL should be easier and more straightforward than not using it.&nbsp; If your DSL is improving upon an existing process it should generally be easier to use and be a boon for productivity of the consumer.&nbsp; The DSL should be making the common cases easy, while still allowing for the uncommon cases. It may also be the case that the DSL only handles common cases and uncommon cases are still handled by the non-DSL way.

The DSL should encourage the correct/conventional way of doing things (see the next Goal for more on this) and should accelerate the consumer&rsquo;s ability to accomplish the task or tasks at hand.&nbsp; As a side effect, usually, the DSL reveals intent faster than the non-DSL way, allowing maintenance coders to be able to quickly pick up what was going on and determine what the next appropriate step should be. This can save a dramatic amount of time by not requiring maintenance programmers having to spend as much time &ldquo;spinning up&rdquo; to learn the API. This point also bleeds into the &ldquo;Discoverability&rdquo; goal mentioned below and so I will cover more on this in that topic.

In the case of replacing XML configuration, for example, the DSL serves the purpose of having better compiler and refactoring support. If you have XML that references code elements (type names, property names, etc), the XML can quickly get out of sync with the underlying code. Using an internal DSL to generate the XML from code can greatly efficiency of generating and refactoring that XML in the future.

### Goal #3: Conventional

The DSL should enforce or at least promote/encourage the use of conventions within the domain. If this is way things are done in the domain, the DSL should either just do it intrinsically, or strongly encourage the consumer to make things happen that way. The DSL should also allow for the processing of similar topics similarly requiring the consumer to supply only a lambda expression/delegate for individual case-by-case variances. For example, in Fluent NHibernate, every entity that needs persisted should have a mapping. Entities, for example, might derive from a domain layer super type (i.e. DomainEntity).&nbsp; Fluent NHibernate can discover all your entities and automatically map them. Some entities have special circumstance. These can be handled by passing a delegate to Fluent NHibernate for processing those types of objects specially.

For more complex variances or convention support, simple lambdas or nested closures may not be enough, and so you may want to consider allowing a custom implementation of an interface to be plugged into your DSL.&nbsp; A good example of this is StructureMap which uses this approach for its type scanner support using the syntax &ldquo;x.With<ControllerConventionScanner>()&rdquo; where ControllerConventionScanner is a custom implementation of ITypeScanner that performs complex analysis on types to determine if they are, in this case, an implementation of IController (for ASP.NET MVC) and will wire them up appropriately in the controller factory.

### Goal #4: Discoverability

The DSL should make it clear where to go next and what the next options are. This is especially useful in editing environments that include auto-complete or Visual Studio IntelliSense-like functionality.&nbsp; When I type &ldquo;.&rdquo; to move on to the next step, my list of available members should be a little cluttered with ancillary/unnecessary stuff as possible. It should always be clear when I&rsquo;m moving on, where my next step or the next likeliest 2-3 steps should be.

For items that don&rsquo;t fit into an IntelliSense like scenario, consistent patterns should be used so that as a consumer uses your DSL, they become aware of more and more features and can go deeper as necessary. Also, consistency allows for discovery of similar features in other parts of the DSL where the consumer may not have expected to find it otherwise.

## Purposes

There are two main purposes of any DSL: Generating something (common) and performing actions (uncommon).

### Generative

Generative DSLs produce some output: An assembled model/object graph, an XML file, HTML output, the result of an equation/algorithm, etc. They are used to make tedious construction and assembly tasks easier, or at least more straightforward. They can be used to encapsulate conventions and common procedures associated with a given goal and achieve other such efficiency/time-saving goals.&nbsp; Generative DSLs usually maintain some sort of internal state either in the form of a semantic model (described below), or in the form of internal simple data structures (dictionaries, local storage, etc).&nbsp; They usually have a prescribed path to navigate and lead the consumer along the correct path (see Goal: Discoverability above).&nbsp; These DSLs tend to be larger and more involved as they are designed for larger, more complex tasks. 

Overall, generative DSLs are the most commonly used and found in the wild.

### Non-Generative

Non-generative DSLs are less common, but still worth mentioning. They usually fit into the &ldquo;No Model&rdquo; form described below. Non-generative DSLs usually add a small amount of extra functionality to an existing API or fill in gaps to ease its use. These DSLs may modify the state of the underlying API they extend or they may merely perform actions associated with the API such as executing an unrelated action based on the data contained in the model (for a very simplistic example: &ldquo;Hello, Friend&rdquo;.SendAsEmailBodyTo(<&ldquo;bob@test.test>&rdquo;)).

# Forms of Internal DSLs

<a name="semanticmodel"></a>

## Semantic Model

Fowler&rsquo;s Take: [Semantic Model](http://martinfowler.com/dslwip/SemanticModel.html)

In the semantic model form, DSLs straddle a model of some sort that may have a more complex, push-button style API.&nbsp; Usually they are of the &ldquo;Generative&rdquo; variety described above and the end product of the DSL with this form is to deliver a fully assembled and populated model which can then be used for various sundry purposes by the consumer. The idea here is that the model is usually cumbersome and tedious to assemble or populate by hand, but is very useful once assembled. To save the consumer time, the DSL will help assemble and populate the model via a much easier to use API.&nbsp; StructureMap&rsquo;s configuration API takes this form in that it builds up the various &ldquo;Instance&rdquo; classes in the container that describe how objects should be constructed and assembled. In this case, the various &ldquo;Instance&rdquo; classes in StructureMap are simultaneously the semantic and&nbsp; domain models of the framework. The ICriteria API in NHibernate also takes this form as it builds up &ldquo;expressions&rdquo; internally which are later rendered as platform-specific SQL queries when executed. 

The DSL should not expose elements of the underlying model directly except in specific and rare circumstances where it&rsquo;s actually easier to use the regular model versus the DSL to accomplish some specific task.&nbsp; Concepts and conventions established by the model should be well represented and encouraged (if not enforced) by the DSL such that someone familiar with the domain will be able to easily use the DSL.&nbsp; Likewise, someone not familiar with the domain should become more familiar with it as they stumble through using the DSL.

As Fowler suggests, you should prefer to use the Semantic Model form.&nbsp; One of the primary benefits of this form is that you can test the model and the DSL separately. It makes testing the DSL easier in that you can do simple state based testing without a lot of mocking or interaction tests. Another benefit is that you separate the logic from the form of the DSL, making it easier to change or extend the DSL or even add additional/alternate DSLs which operate upon that same model.&nbsp; The freedom offered by having the DSL and the model separate allows the DSL to be more radically efficient without as much concern for constraints inherent to the model.

There are two variants of the semantic model form: Internal Model and External Model.

### Internal Semantic Model

Internal Model forms use a model internally to produce its end result. The ICriteria API uses this model. Its model is not fully exposed to the consumer. The model is used to eventually build SQL which is the ultimate goal of the ICriteria API. 

### External Semantic Model

External Model forms straddle an existing model of some type and manipulate it to some end. StructureMap uses this approach in that the model can be used directly without the aid of the DSL. The DSL merely provides a convenient way for building up the stand-alone configuration model.

## No Model

In this form, there is no model or a very minimal internal model usually required to maintain state or context.&nbsp; For generative DSLs, the primary use case for this form is for generating code in another form or language. For example, Fluent NHibernate uses this approach to generate XML.&nbsp; Fluent NHibernate uses minimal state and model internal and generates XmlElements as a last step which is then saved as an XML document file.&nbsp; 

Some DSLs do not produce anything (neither model nor code), but instead perform actions or assertions.&nbsp; SpecUnit&rsquo;s SpecificationExtensions is an example of this. ShouldEqual() performs an NUnit assertion and does not modify any state nor produce any output.&nbsp; These are, for lack of a better term, non-generative, no model DSLs. That is, they produce nothing and maintain very little or no state. Their purpose is usually highly focused and highly constrained for a specific task.

# Building Elements of Internal DSLs in C#

Internal DSLs are comprised of the use of various patterns. The list below is the list Fowler lists on his DSL WIP site. It&rsquo;s possible there may be others that have not yet been discovered or conceived of. As languages evolve, Fowler&rsquo;s list (and, consequently this one) may grow to include new emerging patterns.

Each pattern serves a specific purpose, solves a particular problem or set of problems, and creates one or more new challenges. Learning to recognize when you&rsquo;re heading into a problem and which pattern or combination of patterns to use to correct the course is key to building an effective DSL.

When examining the source guts of an existing DSL, it is useful to identify which patterns are in play as this will greatly help you maintain your bearing when navigating the source structure. I have found that DSLs, while friendly and pleasant on the outside, are generally not to pleasant on the inside. At this point, this is simply a sacrifice worth making. Perhaps as the C# language evolves, these effects will not be quite so dramatic.

Now, on to the patterns (in a rough building/dependency order)&hellip;

## Method Chaining

[Internal DSL Pattern: Method Chaining](/blogs/chad_myers/archive/2008/10/26/internal-dsl-pattern-method-chaining.aspx)

## Nested Function

[TODO &ndash; Separate article]

## Expression Builder

[Internal DSL Pattern: Expression Builder](/blogs/chad_myers/archive/2008/10/26/internal-dsl-pattern-expression-builder.aspx)

## Function Sequence

[TODO &ndash; Separate post]

## Nested Closure

[TODO &ndash; Separate article]

## Literal Collection Expressions

[TODO &ndash; Separate article]

## ** Literal Type Expressions

[TODO &ndash; Separate article]

## Dynamic Reception

[TODO &ndash; Separate article]

## Annotation

[TODO &ndash; Separate article]

## Parse Tree Manipulation

[TODO &ndash; Separate article]