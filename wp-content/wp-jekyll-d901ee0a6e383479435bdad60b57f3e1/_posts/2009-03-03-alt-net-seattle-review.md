---
id: 33
title: Alt.Net Seattle Review
date: 2009-03-03T03:03:36+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/03/02/alt-net-seattle-review.aspx
permalink: /2009/03/03/alt-net-seattle-review/
dsq_thread_id:
  - "265382907"
categories:
  - .Net
  - agile
  - altnetseattle
  - Asp.Net MVC
---
&#160;

I had the chance to go to the Alt.net Seattle open spaces this past weekend and it was a great experience. First of all I wanted to publicly thank my company for sending seven of us to the conference.&#160; Part of the reason for taking a position with Headspring systems is that I felt that their values for software development aligned with mine.&#160; Giving us the opportunity to go to this event and get outside of the Austin echo chamber was really good for us to get some perspective on what, how, and why we are doing what we are doing. 

**<font size="4">Open Source in .Net <br /></font>**What I took from this session, is that many companies are still scared to use open source projects.&#160; There is still a lot around licensing that scares software managers, CTOs, and corporate lawyers.&#160;&#160;&#160; In the past I really tried to stay away from using any of the Microsoft Open Source licenses, but as I started to think about why I do this, I really think my logic was flawed.&#160; I wanted to distance my projects from being associated with Microsoft. That is a really stupid thing for me to do considering,&#160; all of the open source projects that I run or participate in are written in .Net technologies and target .Net developers as the users of my projects.&#160; So, if there is a developer who wants to use my projects and they are in a very conservative company that is afraid of open source, it seems that the company would most likely be comfortable with a Microsoft Open Source license.&#160; As a result, if the license for any of my projects are preventing a company from adopting my project, I am willing to change the license.&#160; I plan on putting this on the homepage of each project so that no-one has the license as an excuse for adoption.

One of the action items that came out of this session was that Scott Hanselman was going to track down someone who could put together a License Matrix so that developers, like me who do not understand all the legalese, would be able to see which licenses are equivalent as well as where they fall on the scale from **_scary viral_** to friendly **_do what ever you want_**.&#160; This will really help open source project owners to make an educated decision about which license to pick.

**_<font size="4">Talking with others.</font>_**

I had a chance to sit down and share some of the things I am doing and see what others are doing.&#160; Aaron Jensen is doing some really cool work with the Spark view engine.&#160; After seeing some more complex work on top of Spark,&#160; I am convinced that there will realistically be two view engines that are used with the ASP.Net MVC framework.&#160; The Aspx engine and the Spark engine.&#160; While the other view engines are interesting and some people are using them, I just do not see the others really taking hold and getting wide spread adoption.&#160; I also think that as Spark gets more visibility that we could see some features of Spark show up in the aspx view engine.&#160; I really like the ability to add a foreach attribute inside of an html element to loop through a collection.&#160; It really cleans up a view compared to the aspx equivalent.

I spent some time with Alan Stevens and we talked a lot about Test Driven Development and some of the tools and ways to make using that practice frictionless in Visual Studio.&#160; I walked through my Resharper Plugin and showed him some options.&#160; I also got a chance to explain how frustrated I am with Resharper and the way that their API changes with every minor release.&#160; It is extremely painful to maintain a resharper plugin.&#160; That being said, I will release a new version of the TDD Productivity Plugin that will work with Resharper 4.5.&#160; By the way … I know I am bad at naming my projects so if someone has a better name for the plugin… comment on this post or email me or twitter me.&#160; I will be more than willing to change the name.

I spent some time talking with John Lam about Iron Ruby. After this conversation, I am looking into how I can host IronRuby in a Visual Studio add in so that I can add more productivity enhancements.&#160; The main sell for me is that in order to develop visual studio add-ins I cannot work using test driven development. This is because so much of the Visual Studio API objects have property dictionaries, and the only way to figure out what needs to be done is to debug into visual studio and poke around in the object model until I can find the property I am looking for.&#160; This in itself is painful because recompiling an add in and debugging it requires starting up a second instance of visual studio, which is a 30-35 second process. I am hoping that with a Ruby host add in, I can just run inside visual studio and interactively inspect the object model and produce a nice dsl (Domain Specific Language)&#160; for adding productivity scripts. I guess you can say that the macro engine does this now but writing in VB script is something I would like to put behind me.

**NGems / ROCKS**

There was talk about some existing work being done to provide a Gems like experience for delivering extensions to the .Net framework.&#160; Gems is a feature in ruby where any developer can create a class or package, register that package on a central server so that all other Ruby developers can than use the Gem command to download the package to their machine.&#160; It pulls down all the files and correct versions of any dependencies that are needed as well. The thinking is that if we had this in the .Net space&#160; a developer could pull down a project, say MvcContrib and they could get the latest version or a specific version.&#160; They would not have to go to our project site to get it and they would not need to pull down some of the dependencies individually. I really like the idea of getting this working.&#160; There has been a lot of talk about doing this in the past Alt.Net events,&#160; but at the end of the day everyone is busy and cannot spare the time to get this implemented.&#160; The group decided to try to reuse as much of the existing Ruby infrastructure as possible, this means we could produce the package files in the ruby format and even use Iron Ruby to pull down these packages.&#160; 

We talked more about how we can do this and get something that is usable as quickly as possible and the solution we that came up was to write a small .Net&#160; wrapper (code name Rocks) and that would load up iron ruby and call the gems command to pull down assemblies from the internet.&#160; Everyone in the room was pretty hard core command line guys so the focus was to to this for the command line.&#160;&#160; I would be more than willing to make a VS add into work with this once we get the command line running.&#160; I am exited for this.! I could also tie in a “Remote Reference” feature to my _Solution Factory_ add in, which would be really cool.

**Code Camp Server Code Review**

We had a session that walked through the code camp server source code.&#160; We were looking for feedback on what was good , but more importantly what was bad or hard to understand.&#160; Here are my raw notes:

  * In the Conference domain object it seemed like having the Attendees collection have specific Add and Remove methods and not exposing the actual collection to the rest of the domain seemed to be unnecessary.&#160; There was a suggestion to just make the Attendees collection a public field and get rid of the Add and Remove methods. 
  * The lock implementation in the dependency registrar module has a bug and was not implemented correctly.&#160; see file DependencyRegistrarModule.cs line 30 
  * General application style: The conventions are hard to understand as a total collection. When each convention is explained it is pretty easy to understand individually, but at first glance all of the conventions together are hard / overwhelming to digest. The suggestion was to pull back some to be more inline with the conventions of the base framework. 
  * There were some questions about using lambdas in our UrlHelpers to create strongly typed links to the controller actions.&#160; Code that looks like&#160; c => c.Index(null,null) is really strange.&#160; The null arguments in method parameters really bothered some of the reviewers.&#160; The counter argument was that this is a limitation of the current c# language and that since this syntax is used in some of the Mocking frameworks that it is just something developers are getting used to seeing.&#160; (I am looking at some ways to use T4 Templates to possibly generate extension methods that would be able to clean up the syntax and avoid the pain of having to maintain special code just to get the strong typing with a nice syntax) 
  * In the view pages where forms are rendered.&#160; The suggestion was across the board to make the inputFor to be intention revealing.&#160;&#160; Everyone would rather see something like TextBoxFor or CheckBox for.&#160; For me the part that is tough is that the InputFor made it really easy to generate these view using the scaffolding that comes in RC1. I think we can still support this suggestion, we will just have to move some logic from the InputBuilders classes into the T4 new item templates. 
  * Expect that the html forms elements in the view.. cant see the textbox, version radio buttons.   
    -would like to see a more obvious list of the input elements. 
  * There was a comment that the short one/two line methods in controllers seems like a waist.. it was suggested taht pulling the dependency up into those methods would be better.&#160;&#160; We actually than showed a controller that had 10 + actions and than the value in having small action methods started to become&#160; a good thing.&#160; Than we actually pulled up the code from one of the Mapper services into the controller that we were looking at and it became a total mess in the class file because that required brining up 5 additional private methods which made the controller class break the Single Responsibility Principle.&#160; It was a great discussion and once we stopped talking about the possibilities and just tried implementing these suggestions on the projector we really could really make some good decisions.&#160; 

I wanted to thank everyone who participated in this review, it was great to get your points of view and as a result we will make changes to address these concerns and have a better reference for line of business MVC Applications.

**Abstract Test Assertions**

I hosted this session as a way to address a problem that came up in the MvcContrib.TestHelpers library.&#160; In that library we have some extension methods that make testing the URL Routing features in the MVC framework&#160; much clearer to read than without the extensions.&#160; This could be called a DSL around route testing.&#160; The problem that we have is that our implementation uses NUnit assert statements and some developers want to use this DSL with other testing frameworks.&#160; I went into this session thinking that would could produce some sort of abstract class or interface that&#160; each developer that wanted to use the DSL would have to implement and wire up to our library.&#160; 

This session took a little bit to get started but a few people came in a little late and we even had some people participating with the Live internet feed.&#160; 

The result of this session was that we determined the easy way to become Test Framework independent was to create a MvcContrib.TestHelper.AssertException and that instead of calling into a test framework our DSL would just through an expectation with an informative message just like the test frameworks do.&#160; Charlie Poole ,the nunit developer, said that this is how the unit test frameworks integrate with the mocking frameworks. The recognize that when an exception is thrown and they know the namespace of the exception comes from the mocking framework , nunit does a little magic to remove the call stack frames that are in the mocking framework.. That then creates a good experience for the developers using the two tools.&#160; He said that if the unit test framework maintainers wanted to provide a better experience than they would treat the MvcContrib.TestHelpers namespace the same way. 

As a result of this session, I am going to implement this feature this way and that means that we will remove the reference to nunit from the TestHelpers assembly.&#160; I think the next step after this would be to contribute patches to the open source test frameworks and I think that we will just have to live with MSTest being an experience that will not be as good as the other test runners. I like the solution and I am going to look at the nBehave project and see if I can do something similar their.

**Demo of Macro and Micro Code Generation.**

> I had a chance to demo my to Visual Studio add ins Solution Factory and Flywheel to a number of people. I got some really good feedback about the tools and was encouraged to blog about them more.&#160; So here we go.
> 
> **Solution Factory –** This is a visual studio add in that will export an entire solution as well as its parent and sibling directories into a Visual Studio Project Template. The reason it pulls along the parent and sibling directories to the solution folder is that most of the developers that I have talked to put all of their project dependencies in a folder that is a sibling of the solution folder and than all the projects reference those assemblies using a relative path.&#160; This means that the template produced by solution factory follows the **_Flat Tire Principle_**, which is: When you have to perform maintenance our your code, All of your dependencies and tools are located in your solution Trunk.
> 
> This is a tool that Headspring systems will use to turn the project format&#160; that we use in our Agile Boot Camp, into a template that our attendees can easily create a new solution using all of the pieces need to get up and running fast.&#160; My hope with this project is that other companies and projects could use this add in to easily share their solutions.&#160; I could see nServiceBus , S#arp Architecture and Fubu using this tool to easily create the File –> New Project experience. I am hoping that the development community will be able to start sharing more knowledge and make this process frictionless for newbie. You can get Solution Factory by going to the project site: <http://www.CodePlex.com/SolutionFactory> 
> 
> **FlyWheel –** This&#160; is an add-in that was inspired by the new MVC New Item T4 templates.&#160; The idea behind this add-in is that instead of Generating Code from a database schema,Flywheel will generate new files based off an existing Code Class in your project.&#160; I also wanted to solve the problem of really making it easy to create multiple files at once.&#160; So when you generate scaffolding against a code class, the add-in lets you select a Template collection and run each of the templates in one click/keyboard stroke. I have two examples to demonstrate how powerful this can be.
> 
> 1. Given a Domain object/ Aggregate Root object: , I would have a template set that generates the following files / classes:
> 
>   * Repository Interface 
>   * Repository Class 
>   * Repository Integration Test Class 
>   * ORM Mapping File (this template would correctly set the Build Action to Embedded Resource automatically) 
>   * ORM Mapping File Integration Test Class 
>   * Presentation Model Object 
>   * Mapping File to Map from the Domain Object to the Presentation Model 
>   * Unit Test class to validate the Mapping from the Domain Object to the Presentation Model works correctly. 
> 
> 2. Given a Presentation Model object in an MVC project.
> 
>   * Controller Class that handles the CRUD operations 
>   * Controller unit test Class to validate the CRUD operations are functioning. 
>   * Index (listing ) view file 
>   * Show (detail) view file 
>   * Edit (new and edit) view file 
> 
> I think that using a scaffolding command like this gets you through the 80% of work that is literally some sort of a copy and paste.&#160; By reducing the friction of creating files generated off of a model, this lets the developer focus on the actual domain logic inside each of these files that provide value to your application.
> 
> This project is hosted at <http://www.CodePlex.com/FlyWheel>