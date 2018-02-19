---
id: 119
title: Oxite Review
date: 2008-12-20T17:05:03+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/12/20/oxite-review.aspx
permalink: /2008/12/20/oxite-review/
dsq_thread_id:
  - "262114228"
categories:
  - Design
  - Domain
  - NHibernate
  - ORM
  - Oxite
  - Repositories
---
Several folks, including Microsoft employees and members of the Oxite team, have politely requested I do a post or few on the problems I see with Oxite and why I [previously recommended](http://www.lostechies.com/blogs/chad_myers/archive/2008/12/15/my-quick-take-on-oxite.aspx) that it is not a good example/sample from which to base future products.

At first, I was reluctant to do this since I was afraid people might see it as some sort of attack or other negative. But since I have been encouraged by several folks as mentioned, I feel that this will be constructive and received as a “good thing”.

## Setup

First, I want to make sure that everyone knows there’s no attack here, nothing personal, this is purely about code and in no way a reflection on the individual.&#160; The way we roll at Dovetail is that we are dispassionate about our code and follow practices such as [collective code ownership](http://www.extremeprogramming.org/rules/collective.html), [refactoring mercilessly](http://www.extremeprogramming.org/rules/refactor.html), [pair programming](http://www.extremeprogramming.org/rules/pair.html), and [no premature optimization](http://www.extremeprogramming.org/rules/optimize.html), which help disassociate our passion, creativity, and soul from the code so that we can objectively look at parts and say “that is bad” or “this is good” and mean it.&#160; So I’m coming from a viewpoint that the code is code and should be mercilessly, objectively torn apart and made to stand on its own merits, independent of who wrote it and under what conditions.&#160; I say that code can be objectively determined to be “good” or “bad” and patterns and anti-patterns identified with certainty and no subjectivity.

Second, please consider Nate Kohari’s [recent great post](http://kohari.org/2008/12/18/altnet-is-the-opposition-party/) on debate vs. argument; ego, pride, personal attachment, etc. as this also helps to frame where I’m coming from.&#160; During this review, I’m not going to mention people, their motivations, their goals and desires, etc.&#160; I’m only going to talk about the code and the requirements of the features the code is trying to accomplish.

With these things in mind, let us now objectively view Oxite as a body of work, independent of any individuals involved in its creation, that must stand alone and be evaluated solely on its own merits.

## As a Sample Application…

Oxite is a “real world sample” and not necessarily official guidance (a la the Patterns & Practices type stuff).&#160; As a sample, the packaging of Oxite is good as it includes many facets of a project from the domain, to the database, to the front end, etc.&#160; Perhaps it could’ve included some more documentation (maybe I missed it? I didn’t look very hard, admittedly).&#160; Since this wasn’t positioned as a guidance project, people should avoid referring other people to it as any sort of best practice or official anything from Microsoft.&#160; As ASP.NET MVC matures after release, I expect we’ll start seeing more official guidance from P&P and other groups within Microsoft.

**Recommendation**: [For MS, primarily, as this problem is mostly unique due to MS’ position with respect to .NET] Perhaps MS could establish more official terms to set expectations for customers. “Sample” is not “Guidance” is not “Recommendation” is not “Stance”, etc.

## As an OSS project…

Oxite is an open-source project. It is released under the [Microsoft Public (Ms-PL) license](http://www.opensource.org/licenses/ms-pl.html) which is quite permissive and in line with generally accepted good practices for open source. This is very good.&#160; Oxite is hosted on the CodePlex project site and (correct me if I’m wrong) is not accepting patches from the public due to, I believe, concerns of patent/IP violations and such.&#160; This is not very good. Part of being open is allowing people to modify it without having to fork the code.&#160; At the very least, we can fork it which is certainly heads above what we normally get from large corporations which is either no visibility, or only push releases.&#160; Overall, I’m very pleased MS has taken this approach with Oxite and I’d like to greatly encourage them to pursue this method of release in the future.&#160; My only critique is that maybe they find a way to accept patches from the public (I’m ok if they need to fill out some affidavit or other legal form).&#160; 

As a .NET OSS project, I was particularly disappointed in the fact that the high-level Visual Studio Team \*.\* SKU’s were used in its creation. I don’t have the numbers, but I’m willing to bet that the vast majority of .NET developers do not have the full Visual Studio suite (Database, Test, etc) and so they won’t even be able to open the SLN file without having to hack CSPROJ files and such (like I had to).&#160; There is a SLN file for Visual Web Developer Express that will help get people going, but this seems like an afterthought, rather than a good strategy. 

Also missing is any sort of automated build script. What if I want to set up Oxite in my own CI server to pull down the trunk nightly and do builds in my environment?&#160; This is pretty standard among .NET OSS projects, so I was disappointed that this was missing.

**Recommendation**: [For MS and other companies seeking to release .NET OSS] Either let these things go out to be full OSS projects and release the copyright and liability to the public somehow to achieve full indemnity from possible patent or copyright infringement.&#160; And/or, find a legal framework for being able to accept patches from individuals in the community.

**Recommendation**: [For anyone managing an OSS project] Please take a little more care to ensure that you have respected generally accepted minimum expectations of an OSS project such as an automated build and decent test coverage.

## Tests!?!

Technically, this should just go under the previous section, but it’s significant enough that it should be called out on its own. Unless I’m missing something, there are around 51 tests for the entire project and those tests cover only the MetaWeblog API handling and the XmlRpc handling.&#160; Without having run a coverage tool, I’m guessing that coverage is below 10%. I’m very serious when I say that this would be considered unacceptable on most projects I’m involved with. I would be put on probation or possibly removed from a project at a corporate customer or removed as a committer on an OSS project for committing code with <10% coverage.&#160; Quite frankly, it is dangerous to have a large application with <10% test coverage.&#160; It is also a liability in that future changes become ever increasingly difficult with the friction and fear of change due to the unknown of how changes may break functionality and cause regression bugs.

The tests that are there (for example, I count 49 in the MetaWeblogServiceTests) are a little heavy. In my opinion, this indicates that [MetWeblogService](http://www.codeplex.com/oxite/SourceControl/changeset/view/27048#372212) has too many responsibilities and is putting too much burden on the tests to account for the excessive dependencies of [MetaWeblogService](http://www.codeplex.com/oxite/SourceControl/changeset/view/27048#372212).&#160; It’s also curious that no mocking framework was used, but instead (excessive, IMHO) use of fake, concrete test implementations were used.&#160; Several(though not most) of the tests are asserting too many things which leads to brittle tests and can cause friction during refactoring.&#160; 

Testing is not just about ensuring the current code works properly (that is important), but also explaining how the code works so that, in the future, when changes are made, maintenance programmers understand why the change they made broke other things.&#160; This enhances change confidence and encourages fearless refactoring which is key to maintaining a rapid, sustainable pace throughout the life of the development.

But I digress, this subject is perhaps too large and requires a post in an of itself. Suffices to say that&#160; there are too few tests and the tests that are there, while meaningful, will contribute to increased friction over the life of the product and should probably be refactored as the project goes on.

**Recommendation**: [For anyone managing an OSS project] Tests serve many purposes including encouraging contributors because they can see how things are supposed to work, and can be more confident in their changes, knowing that tests will most likely catch them if they make a big mistake.&#160; At this point, going BACK and adding tests would likely be a waste of time. Going forward, all new features should be developed with tests (preferably test-driven as this helps keep your design on track, it’s a curious side effect of writing client code FIRST, then the code to make it work).&#160; Any bugs that pop up between now and then should first have a test that reproduces the problem, then the fix should be implemented, and the tests should then pass (without modification). If they don’t pass, the fix isn’t quite right.&#160; If, during the fixing of bugs, you discover other problems or realize there’s more refactoring to do, do that code test-driven along with the bugfix. Try to keep changes minimal and focused, though, and with a high degree of coverage (preferably >90%, but that’s not a hard rule).

Test should be small, easy to write, and not require a lot of setup. If they’re not meeting ALL of these three criteria, you have a design problem and need to reinvestigate. It happens all the time that I find myself violating one or more of these rules, and the tests help to point me to where in my design I screwed up. This is a natural thing and shouldn’t be seen as negative. You caught the problem early and tests helped spot it and point you in the right direction. Just keep these criteria in mind as you proceed.

## Domain

The heart of any good project is its domain. The domain is the understanding and model of the core problem this application is trying to solve.&#160; The domain is king. It should be fat, juicy, and contain the core logic that constitutes how this application behaves. Everything else in the application serves the domain by either bringing information to it, or relaying information out of it to the customer (users, other applications, data storage, etc).&#160; Great care and investment should be placed on the domain of the application as it is your greatest and most important asset.&#160; Principles, patterns, and practices have evolved around this very integral part of application design. Entire books have been written. These include [_Domain Driven Design_](http://domaindrivendesign.org/) (Evans) and [_Applying Domain-Driven Design and Patterns: Using .NET_](http://www.amazon.com/Applying-Domain-Driven-Design-Patterns-Examples/dp/0321268202) (Nilsson), among many others.

An important part of key domain object model design is to do it independent of persistence concerns (known as “Persistence Ignorance”). Object Oriented Design is a fundamentally different problem than Relational Data Model Design and each should be done independent of the other to avoid the patterns of one being misapplied in the other.&#160; The intermediary between the contrary physics of these two worlds is the Object/Relational Mapper (ORM) such as NHibernate, LLBLGen Pro, and, to a lesser extent, ADO.NET Entity Framework and the [now defunct](http://ayende.com/Blog/archive/2008/10/31/microsoft-kills-linq-to-sql.aspx) Linq2SQL.

In Oxite, the domain appears to have been driven from the relational model (i.e. database) which has caused some interesting problems that had to be worked around and have hampered the domain (we’ll get to this later).&#160; The data provider used was Linq2SQL.&#160; Object/database design were achieved using the Linq2SQL designer-generated classes. These classes are partial classes which allow the application to create the other half of the partial class in another file. In these partial classes are added the property-changed, relationship, and other data-concerned handling/functionality. Also, each partial adds an interface (i.e. IPost for the oxite_Post object) presumably to hide away some of the details of Linq2SQL.

**Recommendation**: Domain objects should be POCO objects with no attachments to or knowledge of the database whatsoever. You can have class hierarchies (but proceed cautiously and light here) and entities can have interfaces, but this should be a rare occurrence and should not required of all of them.&#160; The objects should be able to be used and their functionality fully useful without requiring any backend infrastructure, services, database, etc. When it comes to persistence, the persistence framework should “just work” and support the objects naturally without them having to implement any special interfaces or have to do anything special (i.e. including support for transparent lazy loaded collections, and none of this EntitySet business).&#160; If your ORM can’t do that, consider one of the already available, major, post 1.x version offerings that have been proving themselves for years on the market in battle.

### Linq2SQL Problems

You may have noticed earlier when I said “to a lesser extent” when talking about Linq2SQL as an ORM. This is because Linq2SQL is missing a lot of key functionality to be considered as a full-fledged ORM.&#160; Among these are automatic change-tracking and cascade support, transparent lazy loading, and database data-type minutiae handling.&#160; These things are just a given in a more mature and full-featured ORM like NHibernate, for example.

I also said that the use of Linq2SQL has caused some interesting problems. Aside from having to manually do change tracking, deal with underlying SQL data-types, and having to deal with relationships manually, the Linq2SQL-based objects have the pernicious problem of not being able to be used (easily) without being connected to the database.&#160; This is the opposite of “Persistence Ignorance.”&#160; To counter this problem, Oxite has entity interfaces (i.e. IPost).&#160; Generally speaking, interfaces for entities is a smell. In this case, the smell is definitely pointing to a problem and using interfaces is merely a band-aid for that problem.

**Recommendation**: Don’t use Linq2SQL as it’s simply too much friction and lacks critical features.&#160; Use a full-featured ORM like NHibernate or several of the commercial ones available.

### Interface Entities

I mentioned above some of the problems with interface-based entities like IPost, ITag, etc. I wanted to call out a specific example of where something like this can go very wrong.&#160; In the partial class declaration of class _oxite_Tag_, the _Parent_ property has a significant problem for reuse and future maintenance. For reference, see [PartialClasses.cs](http://www.codeplex.com/oxite/SourceControl/changeset/view/27048#371337), line 646.

The problem with this property is that it means oxite\_Tag is only valid with other oxite\_Tag implementations of ITag. This is what’s known as a violation of the [Liskov](http://en.wikipedia.org/wiki/Liskov_substitution_principle) [Substituion](http://www.lostechies.com/blogs/chad_myers/archive/2008/03/09/ptom-the-liskov-substitution-principle.aspx) [Principle](http://www.objectmentor.com/resources/articles/lsp.pdf) and/or the [Open](http://en.wikipedia.org/wiki/Open/closed_principle) [Closed](http://msdn.microsoft.com/en-us/magazine/cc546578.aspx) [Principle](http://www.objectmentor.com/resources/articles/ocp.pdf). Put simply, anyone doing anything with ITag would be surprised if they started getting InvalidCastExceptions because of some problem lurking deep in your design.&#160; If the intention is that oxite\_Tag can only work with other oxite\_Tag’s, then it shouldn’t use an ITag interface when it doesn’t really mean it.

Is this nitpicking? Kinda. The oxite_Tag problem may never get hit, but it is a potential landmine in your code, waiting to explode on an unsuspecting maintenance programmer. If your design has special magic and gotchas, you have a problem. 

**Recommendation**: Interfaces should be intention revealing and their implementation contain no surprises.&#160; Interfaces also should only be used where true abstraction is needed. Entities/domain modeling is generally one of these places where abstraction is not necessary (and therefore interfaces shouldn’t be used).

### Database Assumptions

The entities in Oxite have several assumptions specifically about SQL Server (heavy use of SqlDateTime.Min/MaxValue).&#160; This is yet another problem that stems from the of usage of Linq2SQL.&#160; To address this, Oxite has abstracted entities (behind interfaces such as IPost, ITag, etc) and abstracted the repositories behind interfaces (good, actually!) and these repositories are accessed through an “IOxiteDataProvider” implementation, such as [OxiteLinqToSqlDataProvider](http://www.codeplex.com/oxite/SourceControl/changeset/view/27048#371330) (bad, more on this later).&#160; This is not the appropriate place to abstract database concerns.&#160; I’ll cover proper layering and proper concern separation later. For now, the relevant point is that concerns about the specific usage of the underlying database have seeped up too high in the layering of the application, necessarily requiring more and more complex architecture and abstractions to work around this. This means implementing an “IOxiteDataProvider” is more difficult for would-be implementers than it should be and much duplication of code will likely result.&#160; It also prohibits the use of a fat/rich domain model which leads me to the next section (Anemic Domain).

**Recommendation**: Keep database-specifics as close to the database as possible and, to the maximum extent possible, completely out of your application code. This is best handled by a persistence framework such as an ORM like NHibernate.&#160; Doing this will make it much easier to implement different data access strategies later in the product’s life and to support a wider range of database platforms with little to no change to most of the application code. You’ll still have to test on each database you plan on supporting, but the code should not have to change (much) when adding support for a new database.

### Anemic Domain

Another problem with the domain of Oxite is that all the entity objects are anemic with a few minor exceptions.&#160; An [anemic domain model](http://martinfowler.com/bliki/AnemicDomainModel.html) is one that is largely if not entirely comprised of getters/setters and are just data containers (DTOs for the database, if you will).&#160; This necessarily forces all the interesting logic of the domain to be the responsibility of other, perhaps less appropriate, parties which can lead to “service explosion” or “manager anti-pattern”, etc.

Like I said earlier, domains should necessarily be fat and contain all the relevant logic. They should contain concepts such as “required” and “unique”, etc and these concepts should flow out into the rest of the application including into the relational database model.&#160; The domain should prevent invalid states/situations and should enforce rules throughout the system.&#160; This is not to be confused necessarily with the antiquated concept of a Business Logic Layer, however.

**Recommendation**: The domain model should be “fat” and rich.&#160; It should be modeled according to the current understanding of how the domain SHOULD work (i.e. X is required, there can only be 1 Y per every X, When an A is added to a B, that B’s “A” property should be set to the newly-related A instance, etc, etc, etc).

## Conclusion of Part 1

It looks like this will be a multi-parter, because it’s already long and I haven’t even gotten to the majority of issues.&#160; By the time this review is done, I’d like to cover the following things by the time I’m done (wish me luck):

  * Problems with the Provider anti-pattern
  * Incorrect layering and slicing of abstractions
  * Lack of Dependency Injection (in some cases) and IoC causes cascading design problems
  * High Coupling, Low Cohesion
  * Single Responsibility Principle, Separation of Concerns, and Interface Segregation Principle violations causing problems
  * What is a “Controller” for?
  * What is a “View” for?
  * Mystery Meat, Magic Strings, and Bags of Holding +1
  * Presentation Models
  * Logic in Views Is Bad
  * ASP.NET MVC guts leaking up into all parts of the app
  * (other stuff that will probably come up in the comments that I didn’t think of)