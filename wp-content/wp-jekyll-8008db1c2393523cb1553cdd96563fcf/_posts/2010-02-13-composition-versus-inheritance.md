---
id: 161
title: Composition versus Inheritance
date: 2010-02-13T01:23:04+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2010/02/12/composition-versus-inheritance.aspx
permalink: /2010/02/13/composition-versus-inheritance/
dsq_thread_id:
  - "262114522"
categories:
  - Advice
  - composition
  - Principles
---
One score (minus five) years ago, in the age of yore and of our programming forefathers, there was written a little book. A seminal book. A book that would change things. That book was called [Design Patterns: Elements of Reusable Object-Oriented Software](http://www.amazon.com/Design-Patterns-Elements-Reusable-Object-Oriented/dp/0201633612/).&#160; 

There were many other greater and some lesser (but still great) works that were released around the same time (1995), but this one has remained a popular favorite among the object-oriented development crowd for some time.&#160; Recently (as in the last 4-5 years) this book has seen a resurgence of popularity due to the increasing use of and references to various design patterns contained in the book.&#160; These “recipes” help us to build software and our object systems designs more consistently and thoughtfully. Sure, patterns can be abused and can be used by less knowledgeable people to stamp out bad software just as bad as if they didn’t have them, but for the knowledgeable, they are a powerful tool.

But this post isn’t about design patterns. No, it’s about the arguably more important portions of this book which deal with fundamentals of object systems design. These principles, upon which those design patterns are based, are more important to learn. These principles are at least partially enumerated in the book’s first chapter. Yet, seemingly, they appear to be all but lost today – at least in the .NET programming crowd.&#160; I have seen elements of this in the Java space, I know they still do it this way in C++. Ruby and Python are a little different in this regard, but their user bases are also not immune to a lack of OO principles like all the other OO languages to one degree or another.&#160; I’m talking specifically about the over-use (or indeed abuse) of inheritance when composition is clearly superior for object designs.

As I have grown in my understanding of design and architecture, I have come to realize that the first chapter &#8212; titled “Introduction” &#8212; of this book is actually the most valuable part of it. I think the entire crowd of us OO brethren and [sistren](http://www.askoxford.com/asktheexperts/faq/aboutwords/brethren) should read it again and absorb it if we can.&#160; If you already own this book, I suggest you re-read chapter 1 again.&#160; If you don’t own it, borrow it from a friend (likely you know someone who owns it – just ask), check it out from the library, or go buy a copy.&#160; If you’re really short on time or don’t like reading heavy architecture books, then at least just read starting at Section 1.6 near the bottom of page 17 (heading: _Programming to an Interface, not an Implementation_) and continuing through to page 20, stopping (if you want) before the heading _Delegation_.

In this post, I’d like to go through a few of the important points in this short, but powerful portion of the book to drive them home.

## Programming to an Interface, Not an Implementation

This one was a little more difficult to pull off in C++ due to its peculiar way of typing objects. It didn’t have the concept of “interface” as we know it today in C# and Java (though you could achieve this type of functionality). I have a strong suspicion that this is where C# and Java users’ preoccupation with inheritance comes from.

In the book, the author says:

> [Manipulating objects solely in terms of their interface and not their implementation] so greatly reduces implementation dependencies between subsystems that it leads to the following principle of reusable object-oriented design:
> 
> <p align="center">
>   <em>Program to an interface, not an implementation.</em>
> </p>
> 
> Don’t declare variables to be instances of particular concrete classes. Instead, commit only to an interface defined by an abstract class.

This point is profound and if it isn’t already something you religiously practice, I suggest you do some more research on this topic. Coupling between types directly is the hardest, most pernicious form of coupling you can have and thus will cause considerable pain later.

Consider this code example:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">string</span> GetLastUsername()
{
  <span class="kwrd">return</span> <span class="kwrd">new</span> UserReportingService().GetLastUser().Name;
}</pre>
</div>

As you can see, our class is directly new()’ing up a UserReportingService.&#160; If UserReportingService changes, even slightly, so must our class. Changes become more difficult now and have wider-sweeping ramifications. We have now just made our design _more brittle_ and therefore, costly to change. Our future selves will regret this decision.&#160; Put plainly, the “new” keyword (when used against non-framework/core-library types) is potentially one of the most dangerous and costly keywords in the entire language – almost as bad as “goto” (or “on error resume next” for the VB/VBScript veterans out there).&#160; 

What, then, can a good developer do to avoid this? Extract an interface from UserReportingService (-> IUserReportingService) and couple to that. But we still have the problem that if my class can’t reference UserReportingService directly, where will the reference to IUserReportingService come from? Who will create it? And once its created, how will my object receive it? This last question is the basis for the _[Dependency Inversion](http://www.lostechies.com/blogs/jimmy_bogard/archive/2008/03/31/ptom-the-dependency-inversion-principle.aspx)_ principle. Typically, dependencies are injected through your class’ constructor or via setter methods (or properties in C#).

## Creational Patterns Considered Obsolete

The very next paragraph in the book addresses the issue of who will create the UserReportingService by mentioning the “Creational” patterns. Consider this quote from the book:

> You have to instantiate concrete classes (that is, specify a particular implementation) somewhere in your system, of course, and the creational patterns let you do just that.&#160; By abstracting the process of object creation, these patterns give you different ways to associate an interface with its implementation transparently at instantiation.&#160; Creational patterns ensure that your system is written in terms of interfaces, not implementations.

It’s also the case that the act of creating (new()’ing) an object is actually a responsibility in and of itself. A responsibility that your object, which is focused on getting the username of the last user who accessed the system, should not be doing. This concept is known as the [_Single Responsibility Principle_](http://www.lostechies.com/blogs/sean_chambers/archive/2008/03/15/ptom-single-responsibility-principle.aspx)_&#160;_(also see [this article](http://lostechies.com/blogs/jason_meridth/archive/2008/03/26/ptom-single-responsibility-principle.aspx)).&#160; It’s a subtle distinction, and we usually don’t think of the “new” keyword as a responsibility until you consider the ramifications of that simple keyword.&#160; What if UserReportingService itself has dependencies that need satisfied?&#160; Your class would have to satisfy them.&#160; What if there are special conditions that need to be met in order for UserReportingService to be instantiated properly (existing connection to the database/open transaction, access to the file system, etc). The direct use of UserReportingService could substantially impact the functioning of your class and therefore must be carefully used and designed.&#160; To restate, in order to use another class like UserReportingService, your class must be fully responsible and aware of the impacts of using that class.

The Creational patterns are concerned with removing that responsibility and concern from your class and moving it to another class or system that is designed for and prepared to handle the complex dependencies and requirements of the classes in your system.&#160; This notion is very good and has served us well over the last 15 years. However, the _Abstract Factory_ and _Builder_ pattern implementations, to name two, became increasingly complicated and convoluted. Many started reaching the conclusion that, in a well-designed and interface-based object architecture, dealing with the creation and dependency chain management of all these types/classes/objects (for there will be many more in an interface-based architecture and that is _OK_), a tool was needed.&#160; People experimented with generating code for their factories and such, but that turned out not to be flexible enough.

## Inversion of Control Containers

To combat the increasing complexity and burden of managing factories, builders, etc, the Inversion of Control Container was invented.&#160; It is, in a sense, an intelligent and flexible amalgamation of all the creational patterns. It is an _Abstract Factory_, a _Builder_, has _Factory Method_s, is a (usually) and can manage _Singleton_ instances, and provides _Prototype_ capabilities. It turns out that even in small systems, you need all of these patterns in some measure or another.&#160; As people turned more and more of their designs over to interface-dependencies, dependency inversion and injection, and inversion of control, they rediscovered a new power that was there all along, but not as easy to pull off: composition.

By centralizing and managing your dependency graph as a first class part of your system, you can more easily implement all the other patterns such as _Chain of Responsibility_, _Decorator_, etc. In fact, you could implement many of these patterns with little to no code. Objects that had inverted their control over their dependencies could now benefit from that dependency graph being managed and composited via an external entity: the IoC container.

## Composition Realized

As the use of IoC Containers (also just known as ‘containers’) grew wider and deeper, new patterns of use emerged and a new world of flexibility in architecture and design was opened up.&#160; Composition which, before containers, was reserved for special occasions could now be used more often and to fuller effect. Indeed, in some circumstances, the container could implement the pattern for you!

Why is this important? Because composition is important. Composition is preferable to inheritance and should be your first route of reuse, NOT inheritance. I repeat, NOT inheritance. Many, certainly in the .NET space, will go straight for inheritance. This eventually leads to a dark place of many template methods (abstract/virtual methods on the base class) and large hierarchies of base classes (only made worse in a language that allows for multiple inheritance). A common example of template method abuse are methods named “OnBefore” or “OnAfter.”&#160; 

Don’t just take my word for it, let’s go back to the Design Patterns book (with inline comments and emphasis added by me):

> [Inheritance] can cause problems when you’re trying to reuse a subclass.&#160; Should any aspect of the inherited implementation not be appropriate for new problem domains, the parent class must be rewritten or replaced by something more appropriate.&#160; This dependency limits flexibility and ultimately reusability. 
> 
> …
> 
> Object composition is defined dynamically at run-time (_at startup, config-time in most IoC containers –Chad_) through objects acquiring references to other objects.&#160; Composition requires objects to respect each others’ interfaces, which in turn requires carefully designed interfaces that don’t stop you from using one object with many others.&#160; But there is a payoff.&#160; Because objects are accessed solely through their interfaces, we don’t break encapsulation.&#160; Any object can be replaced at run-time by another as long as it has the same type.&#160; Moreover, because an object’s implementation will be written in terms of object interfaces, there are substantially fewer implementation dependencies (_!!! Very important –Chad_)
> 
> Object composition has another effect on system design.&#160; Favoring object composition over class inheritance helps you keep each class encapsulated and focused on one task.&#160; **_Your classes and class hierarchies will remain small and will be less likely to grow into unmanageable monsters_**.&#160; On the other hand, a design based on object composition will have more objects (if fewer classes), and the system’s behavior will depend on their interrelationships instead of being defined in one class (_configured and managed by the IoC container –Chad_).

Anyone who has maintained a large system with more than a few objects should hopefully appreciate these sentiments. It is highly likely you’ve had large (as in lines of code) classes, complicated base class inheritance chains, many abstract or virtual methods (template methods) and a tangled web of interconnected dependencies. Even if you had implemented any of the creational patterns, you still should’ve experienced significant pain (whether you felt it or not) any time a more-than-minor change came along. The friction and pain would grow with time and as the complexity of the application grew leading, invariably, to “The Great Rewrite.” Either that, or you left the project and the next team rewrote it because they immediately felt the pain you may have grown accustomed to.

For many of us, this led to seeking out a better way and thus a sort of “rediscovery” of what was lost: The relevant wisdom contained in the first chapter of the Design Patterns book that most of us just skipped past or didn’t comprehend the first time around.

This leads me to the the most important point of this whole blog post and the culmination of everything I’ve been learning, saying, and teaching in the past 2 years (quoting from the book):

> That leads us to our second principle of object-oriented design:
> 
> <p align="center">
>   <em>Favor object composition over class inheritance</em>
> </p>

## Are You Thinking Compositionally?

<p align="left">
  So if you’re still with me, and you’re buying what I’m selling here (composition over inheritance), then you’re likely thinking: What can I be doing (more)?&#160; Strive to think more compositionally. Make more, smaller classes. Use interfaces to separate the dependencies of classes. Limit how many dependencies classes take. Push more and more of the work of assembling your object dependency graph into your Container. Don’t have a container? Get <a href="http://structuremap.sourceforge.net/Default.htm">a good one</a>!
</p>

<p align="left">
  Once you’re heavily using a container, you can start to do more and fancier things with it. You can begin layering behavior instead of modifying existing behavior (thinking compositionally makes the <a href="http://www.lostechies.com/blogs/joe_ocampo/archive/2008/03/21/ptom-the-open-closed-principle.aspx">Open Closed principle</a> easy to pull off and, in fact, natural).
</p>

<p align="left">
  If you’re still not getting it, ask yourself this:&#160; Would adding a new major area of functionality to your application involve changing any base classes?&#160; Would changing your existing functionality to work differently (say adding layers of caching, or exposing services as JSON or WCF services) involve making lots of changes to existing classes? If you needed to layer on error handling or logging, could you do it without touching any existing code?&#160; With composition, you can do all these things easily by simply configuring it through your container.
</p>

## Final Thoughts

<p align="left">
  Composition is not something you add on to an existing inheritance-based designed &#8212; without significant re-engineering effort that is. You can add <em>some</em> composition, but to make it fully compositional involves a different way of thinking and a fundamentally different architecture. Going from composition to inheritance is easy because it’s a degradation. Going from inheritance to composition is difficult and significant because it’s major improvement and fundamentally different concept.
</p>

<p align="left">
  Therefore, if you find yourself on the cusp of starting a new design, framework, API, product, or whatever it is you’re going to do: Please consider starting from a compositional approach and sparingly adding a little inheritance where it makes sense and doesn’t compromise the larger design.
</p>

<p align="left">
  In conclusion, I don’t think I can say it any better than the “Gang of Four” did in the Design Patterns book, so I’ll leave you with their last thoughts on composition over inheritance:
</p>

> <p align="left">
>   Ideally you shouldn’t have to create new components to achieve reuse.&#160; You should be able to get all the functionality you need just by assembling existing components through object composition (<em>via the container –Chad</em>). But this is rarely the case, because the set of available components is never quite rich enough in practice.&#160; Reuse by inheritance makes it easier to make new components that can be composed with old ones. Inheritance and object composition thus work together (<em>preferably with composition being the primary mode, inheritance being the finer-grained mode of change -Chad</em>).
> </p>
> 
> <p align="left">
>   Nevertheless, our experience is that designers overuse inheritance as a reuse technique and designs are often made more reusable (and simpler) by depending more on object composition. You’ll see object composition applied again and again in the design patterns.
> </p>