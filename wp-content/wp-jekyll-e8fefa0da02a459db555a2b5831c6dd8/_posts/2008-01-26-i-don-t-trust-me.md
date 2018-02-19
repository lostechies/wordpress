---
id: 15
title: 'I don&#8217;t trust me'
date: 2008-01-26T16:02:10+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/01/26/i-don-t-trust-me.aspx
permalink: /2008/01/26/i-don-t-trust-me/
dsq_thread_id:
  - "262113614"
categories:
  - Uncategorized
---
## Where I&#8217;m Coming From

[<img style="border-top-width: 0px;border-left-width: 0px;border-bottom-width: 0px;margin: 0px 0px 0px 20px;border-right-width: 0px" height="184" alt="HAL 9000 - I can't allow you to do that, Dave." src="http://lostechies.com/chadmyers/files/2011/03Idonttrustme_9B01/hal9000_thumb.jpg" width="244" align="right" border="0" />](http://lostechies.com/chadmyers/files/2011/03Idonttrustme_9B01/hal9000_2.jpg)I&#8217;ve learned that, in general, I can&#8217;t trust humans&#8217; judgement, knowledge, or experience when working on software&nbsp; projects, among other things. I&#8217;m not saying that humans are bad, I&#8217;m just saying that humans are creatures and subject to mistakes and failure. Quite so, as a matter of fact.

The past couple years I have worked in predominately old-style software development modes. I have seen success in spite of everything &#8212; in spite of the non-developers on the team, in spite of the politics, in spite of the command/control management, in spite of waterfall-esque project structure. Despite all these things, we were usually able to get something out and help the customer somewhat, but not nearly as effectively as we could have with a highly motivated team, focused on a goal, working towards total success with minimal interference in the creative process known as &#8216;software development&#8217;.

This frustrated me, and it has made clear, in my mind, the value of the processes I preach/endorse and attempt to practice in this environment (occasionally strides are made, but they&#8217;re hard to sustain).

## Managing Human Weaknesses

Ultimately, what I&#8217;ve come to realize is that software development is really all about the people. With good people and processes that enable them to work effectively, you will have success to one degree or another (usually a good degree). So the goal is really to make sure that everyone on the team (including non-developers) are properly motivated and share the goal of the project. If not, they shouldn&#8217;t be on the team, or the project manager (or similar role) needs to work with that person and persuade them to cooperate (find out why they&#8217;re not cooperating and work with them to resolve the issues).&nbsp; Once you have a good team with everyone interested in accomplishing the goal, the next task is to try to implement processes to appeal to their higher nature and set them up for success rather than crush them with threat of looming failure. 

There are many processes out there, and I have found the following to be very effective in my own practice, and through observing other teams who have been practicing them.&nbsp; The only failures I have seen is when the team is not properly motivated, has conflicting goals, or there are personality issues that are not properly managed by the manager.

These processes (detailed below), can be summed up with this statement:&nbsp; 

## Setting Yourself up for Success

### I don&#8217;t trust the customer

I don&#8217;t trust the customer or the target consumer for the software we&#8217;re building. I don&#8217;t trust them to know thoroughly what their problem is. I don&#8217;t trust them to be able to communicate effectively to me what picture of a solution they have in their mind. I don&#8217;t trust them to be able to know, beforehand, everything that they would need to have their problem solved to complete satisfaction. They will change their mind, remember things they missed mid-way through the project, remember that what they asked for earlier on was wrong and needs corrected, etc.

So we put in processes to help achieve better, more structured communication &#8212; but not too much, and the kind of structure that facilitates dialogue and interaction versus lengthy 500 page Word documents.&nbsp; We talk with the customer more often (every few weeks) and show them what we&#8217;ve got so far to help them coalesce in their mind what it is we&#8217;re all trying to accomplish and what steps we need to take to finally accomplish it.&nbsp; Finally, we (the team) hold ourselves accountable by keeping tabs on what we understood from the customer, what we promised them, and how long we said it would take us to accomplish it.&nbsp; We help achieve better accuracy by promising smaller things and promising them more often since more promises over longer periods of time virtually guarantees failure.

### I don&#8217;t trust the team, in general

I don&#8217;t trust the team, in general (including myself). So we have daily stand-up meetings to keep each other apprised of our situations and to keep tabs on any problems that may be brewing. It&#8217;s also a chance to allow the manager to get a feel for what roadblocks are hampering development (including non-technical ones like personnel issues).

I don&#8217;t trust the team (including myself) to deliver on what we promise, so we break promises into more manageable chunks and estimate them the best we can. After the chunks are done, we review our promises and estimates and grade ourselves on how well we did. We use this information to get better at promising and estimating in the future, and also to help us plan how close we are to being &#8216;finished&#8217; based on our accuracy.

### I don&#8217;t trust the developers

I don&#8217;t trust the developers (including myself). I don&#8217;t trust the developers (including myself) to:

  * make sure they don&#8217;t lose their work 
      * not overwrite each other&#8217;s work. 
          * not make changes that break the build and cause a work stoppage among the developers. 
              * be able to manage the complexity of building new software while maintaining an existing, production branch of the software. </ul> 
            So I use source control/revision control/version control (whatever you want to call it).&nbsp; I, personally, have found [Subversion](subversion.tigris.org) to be most effective at addressing all of these problems, but there are other similar products that are also effective. I have found the Microsoft Visual SourceSafe product to be inadequate at addressing all of the above concerns. I would recommend not using Microsoft VSS for a team development project like I have been describing.
            
            I don&#8217;t trust the developers, including myself, to write code:
            
              * that, first and foremost, accomplishes the acceptance criteria 
                  * that is well tested and has good code coverage (where &#8216;good&#8217; is subjective and relative) 
                      * that works as expected with all the other code in the system 
                          * that is acceptable to the coding standards/policies we have set as a team 
                              * that doesn&#8217;t break the build and cause work stoppage among all the other developers 
                                  * that works on a system that is not a developer workstation (i.e. &#8216;It works on my box!&#8217;)</ul> 
                                So I use an automated build process with continuous integration. The build process compiles the code on non-developer workstation/server that doesn&#8217;t have all the developer tools on it (only the bare minimum necessary to compile).&nbsp; The build process then executes the tests (unit, integration, acceptance, etc) to ensure the fitness and working condition of the software, as well as it&#8217;s cohesiveness as an entire unit.&nbsp; The build process then runs code coverage, complexity, and policy analysis to determine whether it is of the quality standards we have set for ourselves as a team.&nbsp; If any of these steps are not met to our high standards of satisfaction, the build will fail and our Continuous Integration software will alert us to this fact.&nbsp; Personally, I have used NAnt and MSBuild as the build tool, CruiseControl.NET as the continuous integration software, FXCop as the policy analysis tool, NCover as the code coverage analysis tool.&nbsp; I have heard good things about Rake and FinalBuilder as build tools and JetBrains&#8217; TeamCity as a Continuous Integration server.
                                
                                ### I don&#8217;t trust me or any other developer, individually
                                
                                I don&#8217;t trust my ability to estimate, so I track my estimation accuracy as the project progresses.&nbsp; I don&#8217;t trust my ability to understand the requirements placed before me. So I encourage the customer not to write big long requirements specification, but rather to discuss the requirements with me using conversation starters like User Stories. I get a greater understanding of the problem and the desired solution (including the technical component of that solution) and participate in defining the specification for that requirement WITH the customer.&nbsp; We then develop the actual specification and codify it in documentation, the code, and any other necessary artifacts (i.e. auditor documentation for later review).
                                
                                I don&#8217;t trust my ability to actually accomplish the requirement, even if I understand it completely.&nbsp; But I know that I am not likely to ever understand any requirement completely &#8212; or even that the customer himself understands the requirement completely &#8212; so I make sure to design my code such that it can be easily tested, and easily refactored later. I make sure that I don&#8217;t code too much of my assumptions in one place because it&#8217;ll be harder to unravel later.&nbsp; I also write lots of tests that assert my assumptions and understanding of the problem.&nbsp; I write integration tests to ensure that the code I write works well within the entire system (and not just the specific unit in which I&#8217;m working). I write acceptance tests at a higher level that serve as a customer-driven sanity check of my code which isn&#8217;t concerned with how the code is implemented as much as the end result of it&#8217;s function (i.e. when I say &#8216;debit from account&#8217;, it really debits from the account).
                                
                                #### I don&#8217;t trust our tests
                                
                                I don&#8217;t trust my testing discipline enough to ensure that I will achieve acceptable coverage of the code unit and cover all the edge cases and any other important scenario worth testing. I don&#8217;t trust my discipline to avoid writing a bunch of code that isn&#8217;t directly necessary to accomplishing the requirement. I don&#8217;t trust myself that I won&#8217;t go code happy and write a bunch of unnecessary code just for the pure joy of writing &#8216;cool code&#8217;.
                                
                                So I write my tests first. I write the tests first while I&#8217;m fresh and not burnt out on writing code. I write the tests to get some of the non-interesting, non-cool stuff out of the way first.&nbsp; I do this to ensure that when I get to the &#8216;fun&#8217; coding, I can feel comfortable knowing that I&#8217;ve boxed my creativity and directed it into the areas I want it to go and will provide the most value for the client.&nbsp; Now I don&#8217;t have the dark specter of having to come back and test my code after-the-fact which is not very enjoyable.&nbsp; I also know that my code is inherently more testable because it was written to be testable in the first place and necessarily must be so. Even when trying to write code with tests in mind, I have found that I can never quite do it 100% and, when writing the tests afterwards, I end up having to refactor the main code a little to get it to work right with the tests. So writing test makes my life a lot easier. It also helps me ensure that I&#8217;ve met all the requirements and achieved quality up front instead of afterwards.
                                
                                #### Even after all that, I still don&#8217;t trust my tests
                                
                                Doing the tests first, up-front helps a lot, but it still requires some discipline and creativity to come up with test scenarios. The temptation is to take it easy and not test every case you can think of. Or maybe one day you&#8217;re tired, after a big lunch, and you just don&#8217;t feel like it. The project will suffer.
                                
                                So, I pair with another developer. We keep each other honest. We work in a friendly, but adversarial/competitive mode where we write tests for the other developer and ask them to implement the code to pass the test. This keeps things interesting and adds some incentive to write good tests as well as good code.
                                
                                ### Finally, I don&#8217;t trust the testers or the code release itself
                                
                                I don&#8217;t trust the testers to test everything they should properly. I don&#8217;t trust that they won&#8217;t also fall into human nature and not test everything every time.&nbsp; So I work with them to automate things to the maximum extent possible and give them the tools they need to set themselves up for success like we have on the development side.&nbsp; Monkey testing (banging on the keyboard or mouse) is tedious and soul-sucking. Few people in this world enjoy it.&nbsp; So, we try to minimize monkey testing and, instead, give the testers tools to automate things and add in their own test cases into the automated suite.&nbsp; Then, they only have to monkey test as a last resort for some very specific, complicated case. These are usually somewhat interesting to set up and discover (but not always), so it helps to keep the testers focused and interested.
                                
                                Once the testers are done and the software is ready for release, I still don&#8217;t trust that it&#8217;s ready or that any human involved at this point won&#8217;t introduce a problem at the last minute. So I make sure that releases are automated and I test this release process with the testers and other team members so we can trust the automated release packaging system.&nbsp; For this, I usually use NAnt or MSBuild to automate the final packaging of the build, the documentation, licenses, or any other &#8216;final build&#8217; type tasks that need to be done. I try to avoid doing anything after the testers, but, at least in my cases, I have never been able to avoid having to do SOMETHING to gather up the final package for pressing onto a CD or pushing out to a download server and sending out notifications to customers.