---
id: 70
title: 'Project anti-pattern: Many projects in a Visual Studio Solution File'
date: 2008-07-16T00:17:47+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/07/15/project-anti-pattern-many-projects-in-a-visual-studio-solution-file.aspx
permalink: /2008/07/16/project-anti-pattern-many-projects-in-a-visual-studio-solution-file/
dsq_thread_id:
  - "262401604"
categories:
  - .NET
---
I&#8217;ve been hearing from several colleagues about how their Visual Studio solution files have many (i.e. more than 10, and usually more than 30 &#8212; in one case, more than 100!).&nbsp; So far, none of them have been able to give me any good explanation for why this is and most of them hate it but they can&#8217;t change it because their architect/lead/whatever won&#8217;t let them.

I&#8217;m hoping that by getting the discussion going on this in the greater community, we can try to discourage everyone from having lots of projects in a solution.&nbsp; 

## Why are lots of projects in a single solution not good?

Aside from some of the more obvious arguments about performance, runtime optimization, PDB and assembly size, etc, etc, etc &#8212; actually, wait. [These are obvious, right?](http://blogs.msdn.com/brada/archive/2004/05/05/126934.aspx) Anyone who&#8217;s ever loaded a VS solution file with more than 20 projects should know exactly what I&#8217;m talking about.&nbsp; And if you&#8217;ve made the mistake of kicking off a build in Visual Studio with this solution, you know that you&#8217;re in for a 1-5 minute sit-on-your-hands party.&nbsp; And also &#8212; and I could be wrong about this, but it was true as of .NET 2.0 &#8212; the JIT cannot optimize code across assembly boundaries (or at least it can&#8217;t do ALL its optimizations).&nbsp; Then there&#8217;s the inherent overhead of each DLL file and assembly metadata being loaded for each assembly, not to mention the extra overhead of having so many PDB/symbols loaded in Debug mode, etc, etc, etc.&nbsp; If you need more proof of the performance problems caused by lots of assemblies, let me know and we&#8217;ll go deep. [I&#8217;m hoping that these facts are well established in the wide, wide world of .NET.](http://blogs.msdn.com/ricom/archive/2004/10/18/244242.aspx)

Ok, so hopefully we&#8217;re past the obvious arguments, let&#8217;s get back to some of the more subtle ones.&nbsp; Why do you need so many assemblies? Is it namespace control? Why not put them in one big assembly and use namespaces there?&nbsp; Is it Strong Naming? Ok, I&#8217;ll give you that one, strong naming does throw a wrench in things sometimes, but I&#8217;d still challenge whether you need 30+ assemblies in your solution just due to strong naming.&nbsp; Is it licensing? Security?&nbsp; All of these problems have a better solution that usually doesn&#8217;t require more assemblies.

One common argument I&#8217;ve heard is &#8216;dependency&#8217; management. That is, I don&#8217;t want my XYZ.Foo assembly to reference System.Web or something like that. My counter to this is: Why not? What does it matter? It&#8217;s usually an aesthetic argument that comes back and has little to do in the way of any real merit from a business value perspective.&nbsp; In fact, I can usually counter back with arguments that more business value is gained by having things easier to use and package and not worrying about dependencies for dependency&#8217;s sake.&nbsp; System.Web is in the GAC just as much as System or mscorlib are. You&#8217;re not saving yourself any problems by having an assembly that has references to all of those.

Another argument is that I don&#8217;t want my different &#8216;layers&#8217; all in the same assembly. Why not, I ask?&nbsp; Sometimes there&#8217;s a valid argument here because you need to deploy these things separately to separate physical layers. Ok, I&#8217;ll grant you that one, but remember, we&#8217;re talking 3-4 assemblies here, TOPS. If you&#8217;re over 20, something is probably seriously wrong. It&#8217;s a smell, not a sure sign of fire, so your mileage may vary here, but 20 is definitely a line that I would try very hard not to cross. In fact, 10 is probably pushing it.

## What are some exceptions when consolidating assemblies?

Utility/console application projects. Unit test projects. Integration/longer-running test projects might do well to be in their separate project.&nbsp; Interface assemblies for remoting/serialization/integration purposes. Plug-in/frequently changing assemblies, resource assemblies, etc.

In the case of utility/console application assemblies and things like resource or satellite assemblies, you might consider a separate solution for these since they are likely not built or used as often as the main-line code.&nbsp; You can have multiple SLN files reference a single project, so you can mix and max your SLN files. Be careful though, as the management of these things can get out of hand, so make sure you always have a core SLN file that you trust as the definitive source for what &#8216;works&#8217; in your project. 

Also, consider an automated build and test process (NAnt, Rake, Bake, etc) that can independently build and verify the fitness of the build after tests and such so that you remain honest.