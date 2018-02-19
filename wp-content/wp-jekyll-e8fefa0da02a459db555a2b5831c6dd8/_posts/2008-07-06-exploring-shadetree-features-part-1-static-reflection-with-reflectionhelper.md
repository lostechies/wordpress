---
id: 67
title: 'Exploring ShadeTree Features, Part 1: Static Reflection with ReflectionHelper'
date: 2008-07-06T23:38:56+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/07/06/exploring-shadetree-features-part-1-static-reflection-with-reflectionhelper.aspx
permalink: /2008/07/06/exploring-shadetree-features-part-1-static-reflection-with-reflectionhelper/
dsq_thread_id:
  - "262113929"
categories:
  - ShadeTree
  - Static Reflection
---
At work, [Jeremy](http://codebetter.com/blogs/jeremy.miller/) and I have been using &#8212; and contributing to &#8212; some of the code he&#8217;s put together over the past few years.&#160; He&#8217;s created the &#8216;ShadeTree&#8217; project which is currently housed in the [Storyteller Project](http://storyteller.tigris.org/) source repository. I&#8217;d like to do a few blog posts to share with you some of the really neat gems in this project that you can you use in your projects to help accelerate your development. 

The first thing I&#8217;d like to cover in ShadeTree is the ReflectionHelper class. ReflectionHelper aids with static reflection and the elimination of many &#8216;magic strings&#8217;.&#160; Static reflection is a process I first became aware of on Daniel Cazzulino&#8217;s blog post "[Statically-typed Reflection with Linq](http://www.clariusconsulting.net/blogs/kzu/archive/2007/12/30/49063.aspx)."&#160; With the new [Expression Trees](http://davidhayden.com/blog/dave/archive/2006/12/18/ExpressionTrees.aspx) feature of .NET 3.5, there are some interesting things you can do that aren&#8217;t necessarily query-related.&#160; The subject of Expression Trees is a very complicated one, but they are very powerful and worth some cursory investigation.&#160; Fortunately, you can "dip your toe" into Expression Trees without understanding how everything works and build up from there (at least, that&#8217;s what I&#8217;m doing, so there!).

First, let&#8217;s start with a problem&#8230;

## Classic Reflection with Magic Strings

Let&#8217;s pretend we had an object-to-object mapping problem. Let&#8217;s say that we have some sort of web service which returns a simple DTO (data transfer object &#8212; a flattened, simple object usually used for the purpose of communicating between two different systems with different models).&#160; So we want to take our rich domain model object graph and flatten it into a DTO in order to send to our remote client. Let&#8217;s also say that we have a lot of these situations and that it&#8217;s going to be too much work to write one-off mapping functions for each scenario.&#160; We&#8217;ve decided we need to build a basic object-to-object mapper that can handle common problems like nulls, string conversion, etc. Please don&#8217;t get hung up on these details, the point is: We need a scenario that involves some sort of reflection. Please use your own imagination if my scenario isn&#8217;t working for you.

Consider this simple model with the red lines representing the intended mapping from the model to the DTO:

[<img style="border-top-width: 0px;border-left-width: 0px;border-bottom-width: 0px;border-right-width: 0px" height="486" alt="CustomerDTODiagram" src="http://lostechies.com/chadmyers/files/2011/03ExploringShadeTreeFeaturesPart1_9C98/CustomerDTODiagram_thumb.png" width="451" border="0" />](http://lostechies.com/chadmyers/files/2011/03ExploringShadeTreeFeaturesPart1_9C98/CustomerDTODiagram_2.png)&#160; 

In the past, we may have pulled out our Mighty Hammer of XML +1 for this problem and ended up with something like this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">&lt;</span><span class="html">DtoMap</span> <span class="attr">dtoClass</span><span class="kwrd">="SomeProject.CustomerDTO, SomeProject"</span> 
        <span class="attr">srcRootClass</span><span class="kwrd">="SomeProject.Domain.Customer, SomeProject"</span><span class="kwrd">&gt;</span>

    <span class="kwrd">&lt;</span><span class="html">DtoProperty</span> <span class="attr">name</span><span class="kwrd">="Name"</span> <span class="attr">mapsToSrcProperty</span><span class="kwrd">="Name"</span><span class="kwrd">/&gt;</span>

    <span class="kwrd">&lt;</span><span class="html">DtoProperty</span> <span class="attr">name</span><span class="kwrd">="SiteName"</span><span class="kwrd">&gt;</span>
        <span class="kwrd">&lt;</span><span class="html">DtoSourcePropertyMap</span> <span class="attr">propretyOnSourceObject</span><span class="kwrd">="Site"</span> <span class="attr">propertyToAccess</span><span class="kwrd">="Name"</span><span class="kwrd">/&gt;</span>
    <span class="kwrd">&lt;/</span><span class="html">DtoProperty</span><span class="kwrd">&gt;</span>

    <span class="kwrd">&lt;</span><span class="html">DtoPropety</span> <span class="attr">name</span><span class="kwrd">="PostalCode"</span><span class="kwrd">&gt;</span>
        <span class="kwrd">&lt;</span><span class="html">DtoSourcePropertyMap</span> <span class="attr">propretyOnSourceObject</span><span class="kwrd">="Site"</span><span class="kwrd">&gt;</span>
            <span class="kwrd">&lt;</span><span class="html">DtoSourcePropertyMap</span> <span class="attr">propretyOnSourceObject</span><span class="kwrd">="PrimaryAddress"</span> <span class="attr">propertyToAccess</span><span class="kwrd">="PostalCode"</span><span class="kwrd">/&gt;</span>
        <span class="kwrd">&lt;/</span><span class="html">DtoSourcePropertyMap</span><span class="kwrd">&gt;</span>
    <span class="kwrd">&lt;/</span><span class="html">DtoPropety</span><span class="kwrd">&gt;</span>
    
<span class="kwrd">&lt;/</span><span class="html">DtoMap</span><span class="kwrd">&gt;</span></pre>
</div>

This would probably work with a little tweaking, but the fundamental problem with this is: Magic strings everywhere!&#160; Our refactoring tools are now likely defeated.&#160; If we ever rename the &#8216;Site&#8217; property on &#8216;Customer&#8217;, it&#8217;s unlikely most refactoring tools would know to change this XML map appropriately.&#160; It&#8217;s possible we&#8217;d catch this and other similar problem through tests, but it&#8217;s just more work and more friction that we don&#8217;t need (in this case, at least).&#160; One other problem with this XML is that it&#8217;s very verbose, there&#8217;s lots of&#160; language overhead here (extra angle brackets, etc). In general, it&#8217;d be nice to stick to code if we can (with nice, safe compilers to keep us on the straight and narrow).

You could accomplish this in other ways (without XML). But the code ends up looking something like this:

<div class="csharpcode-wrapper">
  <pre>Type srcType = Type.GetType(<span class="str">"SomeProject.Domain.Customer, SomeProject"</span>);
PropertyInfo nameProp = srcType.GetProperty(<span class="str">"Name"</span>);</pre>
</div>

This code has much of the same problem that the XML-based mapping syntax has (i.e. some refactoring tools may not pick up changes, etc).

Magic strings cause problems, let&#8217;s face it. So what can we do, instead?

## Static Reflection with Expression Trees and ShadeTree.Core.ReflectionHelper

With static reflection we can build maps in code that reference the types and members directly. This is made easier using [ShadeTree.Core.ReflectionHelper](http://storyteller.tigris.org/source/browse/storyteller/trunk/src/ShadeTree.Core/ReflectionHelper.cs?rev=170&view=markup).

First, let me show you what our end-result mapping code might look like now that we can use Static Reflection:

<div class="csharpcode-wrapper">
  <pre>DtoMap&lt;CustomerDto&gt; map = <span class="kwrd">new</span> DtoMap&lt;CustomerDto&gt;();

map.AddPropertyMap(
    <span class="kwrd">new</span> DtoMapProperty&lt;CustomerDto, Customer&gt;
        {
            DtoPropertyReference = (dto =&gt; dto.Name),
            SourcePropertyReference = (src =&gt; src.Name)
        }
    );

map.AddPropertyMap(
    <span class="kwrd">new</span> DtoMapProperty&lt;CustomerDto, Customer&gt;
        {
            DtoPropertyReference = (dto =&gt; dto.SiteName),
            SourcePropertyReference = (src =&gt; src.Site.Name)
        }
    );

map.AddPropertyMap(
    <span class="kwrd">new</span> DtoMapProperty&lt;CustomerDto, Customer&gt;
        {
            DtoPropertyReference = (dto =&gt; dto.PostalCode),
            SourcePropertyReference = (src =&gt; src.Site.PrimaryAddress.PostalCode)
        }
    );</pre>
</div>

&#160;

Not bad, but pretty verbose.&#160; Maybe we could tighten it up a bit with a Fluent API: 

<div class="csharpcode-wrapper">
  <pre>var map = <span class="kwrd">new</span> DtoMap&lt;CustomerDto, Customer&gt;()
    .Property(dto =&gt; dto.Name).ToSource(src =&gt; src.Name)
    .Property(dto =&gt; dto.SiteName).ToSource(src =&gt; src.Site.Name)
    .Property(dto =&gt; dto.PostalCode).ToSource(src =&gt; src.Site.PrimaryAddress.PostalCode);</pre>
</div>

Now, that&#8217;s pretty funky, huh? It threw me for a loop when I first saw that.&#160; My first thought was: "But _src=>src.Name_ isn&#8217;t a valid expression in this context! You can&#8217;t just reference a member without an assignment, for the compiler tells me so!"

You might, rightly, expect to get this compile error:

<div class="csharpcode-wrapper">
  <pre>error CS0201: Only assignment, call, increment, decrement, 
and new object expressions can be used as a statement</pre>
</div>

So why don&#8217;t you?&#160; Well, the trick is that your method or property must take a parameter of type Expression<Func<T,object>>.&#160; Not just a System.Func<T,object>, but you have to have the Expression<> around it. This causes the C# compiler to behave strangely &#8212; namely it does not treat the code inside the expression as executable code, but as a parsed language element for LATER evaluation.&#160; "dto.Name" is a valid expression in certain contexts, so the compiler allows it as an Expression<>. <strike>If you later try to execute/invoke that expression, THEN you&#8217;ll get an error similar to the CS0201 above.</strike>&#160; But for right now, the compiler lets it pass, and will generate the IL to pass your method or property a type of Expression<>.

> UPDATE: (HT to commenter Paul Batum for catching me on this): Lambda expressions have an implied “return” statement in them, so they will compile \*and execute\* without the CS0201 issue because they are not a pure member access expression they are a return statement combined with a member access expression.

What can you do with this Expression<> type?&#160; Well, lots of things, but that&#8217;s a much larger topic. For right now, you can pass it to the ShadeTree ReflectionHelper and request to get a PropertyInfo from it.&#160; Here, let me show you.&#160; Remember our mapping Fluent API up above? Here&#8217;s a crude start on what the DtoMap<DTO, SRC> class might look like:

<div class="csharpcode-wrapper">
  <pre>public class DtoMap<span class="kwrd">&lt;</span><span class="html">DTO</span>, <span class="attr">SRC</span><span class="kwrd">&gt;</span>
{
    private PropertyInfo _lastDtoProperty;

    public DtoMap<span class="kwrd">&lt;</span><span class="html">DTO</span>, <span class="attr">SRC</span><span class="kwrd">&gt;</span> Property(Expression<span class="kwrd">&lt;</span><span class="html">Func</span><span class="kwrd">&lt;</span><span class="html">DTO</span>, <span class="attr">object</span><span class="kwrd">&gt;&gt;</span> expression)
    {
        _lastDtoProperty = ReflectionHelper.GetProperty(expression);
        return this;
    }
}</pre>
</div>

So I have an Expression<> of a lambda (Func<T,object>). That lambda currently holds an expression which can be evaluated into a direct member reference (i.e. the Name property).&#160; We can use some LINQ stuff under the covers to turn that Expression<> into a .NET reflection element: a PropertyInfo.&#160; We&#8217;ve now accomplished the same thing as someType.GetProperty("Name"), but without any magic strings!

Now, your refactoring tool should be able to directly pick up the dto.Name reference and, if you ever change the name of the Name property, change that reference for you automatically.

## Deep Access Static Reflection and the Accessor interface

We have a big problem with that last code sample, though.&#160; GetProperty() will explode if you pass it something like _src.Site.Name_ (n-level deep property accessors).&#160;&#160; ReflectionHelper, fortunately, has a way of dealing with this. It will create the accessor graph for you and return to you the path it took from &#8216;dto&#8217; to &#8216;Name&#8217; and add some nifty convenience in there for you as well!&#160; There&#8217;s a method on ReflectionHelper called &#8216;GetAccessor()&#8217;.&#160; It&#8217;s very similar to GetProperty(), but it handles deep accessor paths.

Let&#8217;s look at the &#8216;ToSource()&#8217; method of our DtoMap now.&#160; ToSource is going to need this deep access because our second call to it uses &#8216;src.Site.Name&#8217; which would cause GetProperty() to throw an exception.&#160;&#160; Here&#8217;s the updated DtoMap source with new Accessor goodness:

<div class="csharpcode-wrapper">
  <pre>public class DtoMap<span class="kwrd">&lt;</span><span class="html">DTO</span>, <span class="attr">SRC</span><span class="kwrd">&gt;</span>
{
    private Accessor _lastDtoAccessor;
    private Accessor _lastSrcAccessor;

    public DtoMap<span class="kwrd">&lt;</span><span class="html">DTO</span>, <span class="attr">SRC</span><span class="kwrd">&gt;</span> Property(Expression<span class="kwrd">&lt;</span><span class="html">Func</span><span class="kwrd">&lt;</span><span class="html">DTO</span>, <span class="attr">object</span><span class="kwrd">&gt;&gt;</span> expression)
    {
        _lastDtoAccessor = ReflectionHelper.GetAccessor(expression);
        return this;
    }

    public DtoMap<span class="kwrd">&lt;</span><span class="html">DTO</span>, <span class="attr">SRC</span><span class="kwrd">&gt;</span> ToSource(Expression<span class="kwrd">&lt;</span><span class="html">Func</span><span class="kwrd">&lt;</span><span class="html">SRC</span>, <span class="attr">object</span><span class="kwrd">&gt;&gt;</span> expression)
    {
        _lastSrcAccessor = ReflectionHelper.GetAccessor(expression);
        return this;
    }
}</pre>
</div>

You should notice that I changed the Property() method to use GetAccessor and I&#8217;ve added the new ToSource() method which uses GetAccessor as well.

The [ShadeTree.Core.Accessor interface](http://storyteller.tigris.org/source/browse/storyteller/trunk/src/ShadeTree.Core/Accessor.cs?rev=162&view=markup) gives us some extra information above and beyond just the straight PropertyInfo as well as two very important methods: SetValue() and GetValue().&#160; These methods expect an object of the root type (in our case, Customer) and will navigate the graph to get or set the value on the property on the object in which we&#8217;re interested.&#160; For example, if I have my _lastSrcAccessor we just built in our ToSource() method, we can call GetValue() and pass in a Customer object and get, for example, it&#8217;s Site&#8217;s Name property.&#160; Consider this example:

<div class="csharpcode-wrapper">
  <pre>var customer = _customerRepository.GetCustomer(9);
customer.Site.Name = "NewSiteName";

string ourName = (string) _lastSrcAccessor.GetValue(customer);

// the _ourName_ variable will now equal "NewSiteName"</pre>
</div>

&#160;

So Accessor.GetValue() will walk down the path from Customer to Site and from Site to Name and return the Name property value.&#160; If any value in the chain is null, GetValue() will return null.&#160; This is the current behavior, if you don&#8217;t like it, please submit a patch (take a look at the [ShadeTree.Core.PropertyChain](http://storyteller.tigris.org/source/browse/storyteller/trunk/src/ShadeTree.Core/PropertyChain.cs?rev=162&view=markup) implementation for starters).

## Conclusion

There&#8217;s one other thing on ReflectionHelper I didn&#8217;t mention: GetMethod() which allows you to pass an Expression that references a method and get a MethodInfo back from it so you can use static reflection on more than just properties.&#160; There are a few other things on Accessor that I didn&#8217;t mention either that I think are worth you giving a glance at.

I plan on doing a few more of these ShadeTree posts, so please check back later.