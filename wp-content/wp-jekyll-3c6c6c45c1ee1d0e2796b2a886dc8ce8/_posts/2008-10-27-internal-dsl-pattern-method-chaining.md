---
id: 102
title: 'Internal DSL Pattern: Method Chaining'
date: 2008-10-27T03:22:43+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/10/26/internal-dsl-pattern-method-chaining.aspx
permalink: /2008/10/27/internal-dsl-pattern-method-chaining/
dsq_thread_id:
  - "262114129"
categories:
  - .NET
  - Design
  - DSL
---
This is a portion of a larger set of posts on the [subject of Internal DSLs](http://www.lostechies.com/blogs/chad_myers/archive/2008/10/26/alt-net-workshops-internal-dsl-draft-outline-notes.aspx). 

Method Chaining is a pattern explained by Martin Fowler as part of his DSL book work in progress. Fowler’s take on [Method Chaining](http://martinfowler.com/dslwip/MethodChaining.html) is useful to more fully understand this post (and probably realize some of this post’s flaws).

# Method Chaining

Fowler defines method chaining as:

> “Make modifier methods return the host object so that multiple modifiers can be invoked in a single expression.”

This approach is fairly common in all APIs. An easy example is the System.DateTime API in .NET which allows you to do things like: DateTime.Today.AddHours(4).&#160; DateTime doesn’t exactly fit Fowler’s definition since DateTime is an [immutable object](http://beginnermediate.com/blogs/buddylindsey/archive/2008/10/17/immutable-and-mutable-objects-in-c.aspx) following the [Value Object pattern](http://www.martinfowler.com/bliki/ValueObject.html).&#160; The outward appearance, however, is very much like method chaining and is perhaps most familiar to the widest audience of reader.

Depending on what type of DSL you’re building, method chaining takes different shape and serves different purposes.

## First, Some Examples

### Model-based, Generative Example

In this circumstance, method chaining would involve acting upon the [semantic model](http://www.lostechies.com/blogs/chad_myers/archive/2008/10/26/alt-net-workshops-internal-dsl-draft-outline-notes.aspx#semanticmodel) instead of returning new instances of a value object as in the case of DateTime.

For this example, imagine that we’re building an internal DSL to build up various HTML elements. In this case, we’re building the portion that deals with input type=text elements (textboxes) and we want to make it a password textbox instead (type=password). Our host class is of type TextBoxExpression and we’re defining the PasswordMode() method.

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> TextBoxExpression
{
    <span class="rem">//...</span>

    <span class="kwrd">public</span> TextBoxExpression PasswordMode()
    {
        _element.IsPasswordType = <span class="kwrd">true</span>;
        <span class="kwrd">return</span> <span class="kwrd">this</span>;
    }
}</pre>
</div>

### Model-based, Non-Generative Example

In this circumstance, method chaining would act upon the semantic model in some way by execute some action or assert some condition.

For this example, imagine that we’re building a DSL for an external model that allows functionality like pretty-printing our entities. 

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> PersonFormatter
{
    <span class="kwrd">public</span> PersonFormatter(Person person, TextWriter writer)
    {
        _person = person;
        _writer = writer;
    }

    <span class="kwrd">public</span> PersonFormatter WriteDisplayName()
    {
        _writer.Write(<span class="str">"{0}, {1}"</span>, 
            _person.LastName,
            _person.FirstName);

        <span class="kwrd">return</span> <span class="kwrd">this</span>;
    }

    <span class="kwrd">public</span> PersonFormatter WithAddress()
    {
        _writer.Write(<span class="str">"{0} {1}, {2} {3}"</span>,
            _person.Address1,
            _person.City,
            _person.StateOrProvince,
            _person.PostalCode);

        <span class="kwrd">return</span> <span class="kwrd">this</span>;
    }
}

<span class="rem">// example</span>
_formatter.WriteDisplayName().WithAddress();</pre>
</div>

## Key Points

The key points to know with method chaining are:

  1. Manipulating or acting upon the underlying model (__element_ in the first example, __person_ in the second example) . 
  2. Returning the host object itself (TextBoxExpression, PersonFormatter) from the method to allow repeated calls to the same object. 

### Context Variables

In order to achieve point #1, your&#160; host object will have to maintain a reference a to the model in its internal state. Fowler calls this a “Context Variable.”&#160; In our examples above, these are represented by __element_ and __person._ Context variables do not have to only be of the model type, they can be other objects including intrinsic types (int, string, etc).

### Returning the same host object reference

One of the benefits of method chaining is to keep up the flow of the DSL and allow for greater discoverability (i.e. “Where do I go next?”).&#160; Returning the object from calls upon itself allows for repeated calls to each act upon the host object (and underlying model) as a series of related commands.

## Other Topics

The use of method chaining is often tightly related to the [Expression Builder](http://www.lostechies.com/blogs/chad_myers/archive/2008/10/26/internal-dsl-pattern-expression-builder.aspx) pattern such that any discussion of one is incomplete without discussion of the other.&#160; There are several other complex topics around method chaining (such as progressive interfaces, depth navigation, etc).&#160; Method chaining is a relatively simple subject. When used during the process of building a DSL, however, it can lead to complex situations requiring complex solutions. In my experience, these problems are most commonly encountered in conjunction with the Expression Builder pattern, and not often without.&#160; Therefore, I believe these other, more complex subjects are best covered under the topic of [Expression Builder](http://www.lostechies.com/blogs/chad_myers/archive/2008/10/26/internal-dsl-pattern-expression-builder.aspx).