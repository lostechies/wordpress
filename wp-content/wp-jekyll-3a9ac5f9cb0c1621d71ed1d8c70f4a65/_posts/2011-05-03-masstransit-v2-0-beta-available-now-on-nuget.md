---
id: 75
title: MassTransit v2.0 Beta Available Now on NuGet!
date: 2011-05-03T21:48:17+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=75
permalink: /2011/05/03/masstransit-v2-0-beta-available-now-on-nuget/
dsq_thread_id:
  - "294711062"
categories:
  - 'c#'
  - masstransit
  - msmq
---
<div>
  <p>
    After what seems like a long slumber, along with work being done on other projects such as Topshelf and Stact, it is our great pleasure to announce the first beta release of MassTransit v2.0. What originally started out as a minor “1.3” update has turned into a full-out cleanup of the codebase, including a refinement of the configuration API. Since there were some breaking changes to the configuration, we felt a 2.0 moniker was better to ensure users of the framework understood the depth of the changes made.
  </p>
  
  <p>
    And what a list of changes it is (TL;DR = We filled it with awesomeness):
  </p>
  
  <ol>
    <li>
      <p>
        Configuration <br />MassTransit v2.0 now includes a streamlined configuration model built around an extensible fluent interface (inspired by Stact and Topshelf and sharing a common, consistent design). As a result, getting started with MassTransit is now easier than ever. In version 2.0, all configuration starts with the <em>ServiceBusFactory</em> and Intellisense guides you from there forward. The result is a clean, understandable API and a quicker out-of-the-box experience.
      </p>
    </li>
    
    <li>
      <p>
        Container-Free Support<br />With the release of MassTransit 2.0, using a dependency injection container is now <strong>optional</strong>. When we started MassTransit, we leveraged the container extensively to assemble the internal workings of the bus. As we added support for other containers, required features that were not supported by a particular container led to some creative solutions (read: hacks) that were less than optimal. By moving away from a “container-first” approach, we have increased the reliability of the software and now provide container-specific extensions to subscribe consumers from the container in one simple step. We also threw in support for Autofac!
      </p>
    </li>
    
    <li>
      <p>
        Quick-Start<br />By simplifying the configuration, and dropping the need for a container, it is now fast and easy to get started using our new QuickStart:<br /><a href="http://docs.masstransit-project.com/en/latest/configuration/quickstart.html">http://docs.masstransit-project.com/en/latest/configuration/quickstart.html</a>
      </p>
    </li>
    
    <li>
      <p>
        #NuGet<br /><a href="http://nuget.org/List/Search?packageType=Packages&searchCategory=All+Categories&searchTerm=MassTransit&sortOrder=package-download-count&pageSize=10">NuGet packages have been added for the base MassTransit</a> project, with any external dependencies (log4net and Magnum) resolved using the proper NuGet packages. Any additional references are downstream in additional NuGet packages, such as support for persisting sagas using NHibernate (MassTransit.NHibernate), and the various dependency injection containers supported.
      </p>
    </li>
    
    <li>
      <p>
        Multiple Subscription Service Options<br />In addition to the existing <em>RuntimeServices</em> included with MassTransit, an all-new peer-to-peer subscription service has been added. By leveraging the reliable multi-cast support in MSMQ, services can now exchange subscription information without the need for a centralized subscription service. To ensure everything is setup correctly, a <em>VerifyMsmqConfiguration</em> method has been added that will check the installation of MSMQ and install any missing components. This is the first iteration of multi-cast support, and we need to get some mileage on it. In the meantime, the original run-time services continue to work as expected.
      </p>
    </li>
    
    <li>
      <p>
        Documentation<br />Which brings us to the next big update. DOCS! They’re not perfect, and they’re far from complete, but we have focused on the configuration story to help get you up and running. As we see a need for more documentation in a given area, we will continue to flush out the docs appropriately. The docs are located at <a href="http://docs.masstransit-project.com/">http://docs.masstransit-project.com/</a> and are being hosted by the fine people at <a href="http://readthedocs.org/">http://readthedocs.org</a>. [Thanks <a href="http://ericholscher.com/">Eric</a>!]
      </p>
    </li>
    
    <li>
      <p>
        Support for .NET 4.0 and .NET 3.5<br />The project files and solution have all been updated to Visual Studio 2010 SP1. By default, all projects are now built in the IDE targeting .NET 4.0. The command-line build (which has been revamped to use Rake and Albacore) builds both .NET 3.5 and .NET 4.0 assemblies, including the run-time services and System View. The NuGet packages also include the proper bindings for the target project run-time version (you must use the <strong>full .NET 4.0 profile</strong> with MassTransit, the client profile is not supported).
      </p>
    </li>
    
    <li>
      <p>
        Transport Support<br />Internally, the transports and endpoints have been redesigned to improve the support for new transports like RabbitMQ (and improve our ActiveMQ support). For example, transports are now inbound, outbound, or both, allowing us to properly leverage fan-out exchanges on RabbitMQ for publishing and subscribing to messages. There is more to come in this area as we take greater advantage of these advanced transport features. If you’re a RabbitMQ or ActiveMQ user and don’t mind getting your hands dirty, now is a great time to jump in and help improve transport support.
      </p>
    </li>
    
    <li>
      <p>
        Distributor Consumer And Saga Support<br />Work on the MassTransit distributor subsystem continues to be improved. Testing on a multi-master system has been completed which will allow it to serve multiple distributors to improve load balancing efficiency. Support for all sagas (previously only state machine sagas were supported) has been added as well.
      </p>
    </li>
    
    <li>
      <p>
        Swinging the Feature Axe<br />Some previous troublesome and poorly supported features (Batching and Message Grouping) were removed from the 2.0 release to reduce code complexity. Also in light of the new Parallel Tasks work in the framework the Parallel namespace has been removed.
      </p>
    </li>
  </ol>
  
  <p>
    In the next few days, I&#8217;ll be posting an annotated walkthrough of the new configuration API. In the meantime, fire up Visual Studio 2010, create ConsoleApplication69, switch to the full .NET 4.0 framework, and Add a Library Package Reference to MassTransit using NuGet. Paste the code from the <a href="http://docs.masstransit-project.com/en/latest/configuration/quickstart.html">Quick Start</a> into your program.cs and check it out!
  </p>
</div>