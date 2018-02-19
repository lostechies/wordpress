---
id: 28
title: 'PTOM: The Liskov Substitution Principle'
date: 2008-03-12T03:57:00+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/03/11/ptom-the-liskov-substitution-principle.aspx
permalink: /2008/03/12/ptom-the-liskov-substitution-principle/
dsq_thread_id:
  - "262113727"
categories:
  - .NET
  - Principles
  - Programming
  - PTOM
---
# The Liskov Substitution Principle

In my first (of hopefully more than one) post for [The Los Techies Pablo&#8217;s Topic of the Month &#8211; March: SOLID Principles](http://lostechies.com/blogs/chad_myers/archive/2008/03/07/pablo-s-topic-of-the-month-march-solid-principles.aspx) effort, I&#8217;m going to talk about The Liskov Substitution Principle, as made popular by [Robert &#8216;Uncle Bob&#8217; Martin in The C++ Report](http://www.objectmentor.com/resources/articles/lsp.pdf).

I&#8217;m going to try as much as possible not to repeat everything that Uncle Bob said in the afore-linked PDF as you can go read the important stuff there. I&#8217;m going to try to give some real examples and relate this to the .NET world.

In case you&#8217;re too lazy to read the link, let me start off with a quick summary of what LSP is: If you have a base class BASE and subclasses SUB1 and SUB2, the rest of your code should always refer to BASE and **_NOT_** SUB1 and SUB2.

## A case study in LSP ignorance

The problems that LSP solves are almost always easily avoidable. There are some usual tell-tale signs that an LSP-violation is coming up in your code. Here&#8217;s a scenario that walks through how an LSP-violation might occur. I&#8217;m sure we&#8217;ve all run into situations like this. Hopefully by walking through this, you can start getting used to spotting this trend up front and cutting it off before you paint yourself into a corner.

Let&#8217;s say that somewhere in your data access code you had a nifty method through which all your DAO&#8217;s/Entities passed and it did common things like setting the CreatedDate/UpdatedDate, etc.

<pre><span>public</span> <span>void</span> SaveEntity(<span>IEntity</span> entity)<br />{<br />    <span>DateTime</span> saveDate = <span>DateTime</span>.Now;<br />    <br />    <span>if</span>( entity.IsNew )<br />        entity.CreatedDate = saveDate;<br /><br />    entity.UpdatedDate = saveDate;<br /><br />    DBConnection.Save(entity);<br />}</pre>

[](http://11011.net/software/vspaste)

Clever. Works like a champ.&nbsp; Many of you will hopefully have cringed at this code. I had a hard time writing it, but it&#8217;s for illustration. There&#8217;s a lot of code out there being written like this.&nbsp; If you didn&#8217;t cringe and you don&#8217;t see what&#8217;s wrong with that code, please continue reading. Now, the stakeholders come to you with a feature request:

> Whenever a user saves a Widget, we need to generate a Widget Audit record in the database for tracking later.

You might be tempted to add it to your handy-dandy SaveEntity routine through which all entities pass:

<pre><span>public</span> <span>void</span> SaveEntity(<span>IEntity</span> entity)<br />{<br />    <span>WidgetEntity</span> widget = entity <span>as</span> <span>WidgetEntity</span>;<br />    <span>if</span>( widget != <span>null</span> )<br />    {<br />        GenerateWidgetAuditEntry(widget);<br />    }<br /><br />    <span>// ...</span></pre>

&nbsp;

Great! Also works like a champ. But a few weeks later, they come to you with a list of 6 other entities that need similar auditing features.&nbsp; So you plug in those 6 entities. A few weeks later, the come to you and ask you something like this:

> When an Approval record is saved, we need to verify that the Approval is of the correct level. If it&#8217;s not the correct level, we need to prompt the user for an excuse, otherwise they can&#8217;t continue saving.

Oh boy, that&#8217;s tricky. Well, now our SaveEntity looks something like this:

<pre><span>public</span> <span>void</span> SaveEntity(<span>IEntity</span> entity)<br />{<br />    <span>if</span>( (entity <span>as</span> <span>WidgetEntity</span>) != <span>null</span> ){<br />        GenerateWidgetAuditEntry((<span>WidgetEntity</span>) entity);<br />    }<br /><br />    <span>if</span> ((entity <span>as</span> ChocolateEntity) != <span>null</span>){<br />        GenerateChocolateAuditEntry((ChocolateEntity)entity);<br />    }<br /><br />    <span>// ...<br /><br /></span>    ApprovalEntity approval = entity <span>as</span> ApprovalEntity;<br />    <span>if</span>( approval != <span>null</span> && approval.Level &lt; 2 ){<br />        <span>throw</span> <span>new</span> RequiresApprovalException(approval);<br />    }<br /><br />    <span>// ...</span></pre>

[](http://11011.net/software/vspaste)&nbsp;

Pretty soon your small, clever SaveEntity method is 1,500 lines long and knows everything about every entity in the entire system.

## Where&#8217;d we go wrong?

Well, there&#8217;s several places to start here. Centralizing the saving of entities isn&#8217;t the greatest idea.&nbsp; Putting the logic for whether audit entries need created or not into the SaveEntity method was definitely the wrong thing to do.&nbsp; And, finally, due to the complexities of handling wildly differing business logic for different entities, you have a control flow problem with the approval level that requires the use of an thrown exception to break out of the flow (which is akin to a &#8216;goto&#8217; statement in days of yore).

The concerns of auditing, setting created/updated dates, and approval levels are separate and orthogonal from each other and shouldn&#8217;t be seen together, hanging around in the same method, generally making a mess of things.&nbsp; 

But, more to the point of this blog post: SaveEntity violates the Liskov Substitution Principle.&nbsp; That is to say, SaveEntity takes an IEntity interface/base class but deals with specific sub-classes and implementations of IEntity. This violates a fundamental rule of object-oriented design (polymorphism) since SaveEntity pretends to work with any particular IEntity implementation when, in fact, it doesn&#8217;t. More precisely, it doesn&#8217;t treat all IEntity&#8217;s exactly the same. Some get more attention than others.

Why is this a problem? What if you were reusing your terribly clever SaveEntity method on another project and have dozens of IEntity implementations over there and the stakeholders for that project also wanted the auditing feature. Now you&#8217;ve got a problem.

## Solutions

One fine approach to this problem of having to do things a-the-moment-of-saving would be to use the [Visitor Pattern](http://en.wikipedia.org/wiki/Visitor_pattern) as described by [Matthew Cory](http://chocolatefordogs.com) in [this post](http://chocolatefordogs.com/2008/01/25/visitor-pattern-one-fix-for-lsp-violations/).&nbsp; Though, I would say in this particular example, there is a much more deep-rooted and systemic design problem which revolves around the centralization of data access.

Another, in our case more preferable, way to go might be to use the [repository pattern](http://martinfowler.com/eaaCatalog/repository.html) for managing data access.&nbsp; Rather than having &#8220;One Method to Rule them All&#8221;, you could have your repositories worry about the Created/Updated date time and devise a system whereby all the repository implementations share some of the Created/Updated date entity save/setup logic.

As specific one-off problems arise (such as auditing, extra approval/verification,etc) they can be handled in a similarly one-off manner by the individual entity&#8217;s related repository (who knows all about that one type of entity and that&#8217;s it).&nbsp; If you notice that several entities are doing the same sort of thing (i.e. auditing) you can, again, create a class and method some where for handling auditing in a common manner and providing the various repositories who need auditing with that functionality.&nbsp; Resist, if at all possible, the urge to create an &#8216;AuditingRepositoryBase&#8217; class that provides the auditing functionality. Inevitably, one of those audit-requiring entities will have another, orthogonal concern for which you will have another *Base class and, since you can&#8217;t do multiple inheritance in .NET, you are now stuck.&nbsp; Prefer [composition of functionality over inheritance of functionality](http://www.artima.com/lejava/articles/designprinciples4.html) whenever possible.

If you have a rich domain model, perhaps the most elegant approach of all would be to make things like auditing a first-class feature of the domain model whereas every Widget always has at least one WidgetAuditEntry associated with it and this association is managed through the domain logic itself.&nbsp; Likewise, the approval level would be best handled higher up in the logic chain to prevent last minute &#8220;gotchas&#8221; in the lifecycle that would require something less than elegant like an exception as a thinly veiled &#8216;goto&#8217; bailout.