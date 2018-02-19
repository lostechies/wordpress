---
id: 29
title: Time-to-Login-Screen, and the absolute basic requirements for good software
date: 2008-03-16T14:56:03+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/03/16/time-to-login-screen-and-the-absolute-basic-requirements-for-good-software.aspx
permalink: /2008/03/16/time-to-login-screen-and-the-absolute-basic-requirements-for-good-software/
dsq_thread_id:
  - "262113721"
categories:
  - Principles
  - Programming
---
I went and hung out with some fellow developers on Saturday (at the [Grist Mill in New Braunfels, TX](http://www.gristmillrestaurant.com/), incidentally &#8212; wonderful place!) and we talked about all sorts of things on the way down, there, and back up.&nbsp; One of the things that particularly stuck in my mind was a discussion how there are still software development teams out there not using things like source control or automated builds.&nbsp; Everything is by hand and magic.

It occurred to me that this is simply unacceptable and embarrassing. I don&#8217;t believe this is an elitist statement.&nbsp; We can debate the finer points of how to do unit testing with TDD or TAD, etc we can debate about what BDD is and whether and to which degree it&#8217;s useful, etc. But, and I hope this isn&#8217;t just my thought, there are certain things which are simply not debatable. If you&#8217;re not doing these things _on any sufficiently large project_ (although I could make an argument that these things are important enough for any project delivered to a customer and/or used in a production manner).

I&#8217;ll get to what these things I consider as &#8216;absolutes&#8217; in a minute, but before I do that, I want to explain why these things might be important &#8212; to define the values I think are important so that you can get a feel for where I&#8217;m coming from.

# Horrors of an Unrepeatable Setup

How many times have you walked into a software shop and picked up the maintenance on a project and it was in total tatters.&nbsp; It didn&#8217;t compile, you weren&#8217;t even sure you had the latest source code &#8211;in fact, no one was sure, you seemed to be missing all sorts of 3rd party components and their obnoxiously-installed licenses, etc, etc.&nbsp; To boot, your manager says that you need to fix a particular bug and get the fix in for testing by the end of the week.&nbsp; It&#8217;s Monday, you &#8216;fix&#8217; the &#8216;bug&#8217; in a matter of minutes, but now you about 4 days to figure out how to create a build and put it into the test environment.&nbsp; Fast forward 6 days later after you manage to get enough clues from co-workers and phone calls to ex-employees, you find out that the build you deployed is an OLD build that contains several already-fixed-and-deployed bugs.&nbsp; Now you begin the fun of trying to track down where the latest source code is so you can start everything over.

I&#8217;m willing to bet that almost every single one of you has had an experience like this.&nbsp; If not, then you are VERY lucky and I hate to be the one to tell you that, odds are, your time is coming.&nbsp; For me, this scenario has happened to me on almost every project.

# The Virtues of Repeatability

## No Magic

What this all points to is a failure of the dev team to create &#8216;repeatability&#8217; in their software infrastructure. While it&#8217;s unlikely, it&#8217;s possible that the code itself could be the best, most well-written code ever known to man. But since no one knows how to build, test, or deploy it, it might as well be crayon drawings from my 2 year old.&nbsp; One of the most important attributes of &#8216;good software&#8217; should be &#8216;repeatability&#8217; of its build, test, and deployment.&nbsp; So I&#8217;m gonna go out on a limb here and suggest that these things should be a must for any software project that is intended to be used in a production manner. If you don&#8217;t have these things, you have created a situation where serious and potentially irreconcilable problems will surface in the future.&nbsp; If you don&#8217;t have these things, you should be working soon on achieving these.&nbsp; One last thing: I don&#8217;t want to hear any argument about how long it will take to get this going. I can say without any hesitation that you&#8217;ve already spent or will be spending many orders of magnitude more time dealing with the problems that arise from NOT having repeatability, than you would setting your project up for repeatability. 

Without more adieu, the key points of achieving Repeatability (with more specifics on each will follow) are:

  * Source Control 
      * Automated Build 
          * Automated Testing 
              * Continuous Integration (for multi-dev teams) 
                  * Automated Deployment</ul> 
                ## Source Control
                
                _The code should have it&#8217;s primary home in a central, well-known location_
                
                This one should hopefully be pretty simple: The code should have it&#8217;s primary home in a central location and absolutely not in the &#8216;Visual Studio Projects&#8217; folder in someone&#8217;s My Documents folder on their desktop.&nbsp; Of course, if you don&#8217;t have an actual server box, the source control repository can be on someone&#8217;s desktop, as long as that&#8217;s the CENTRAL location for it and as long as it&#8217;s getting backed up somewhere. 
                
                In addition to simply having a central go-to location for the source code, I highly recommend you get a source control management software that tracks versions and enables you to do differences, branching, merging, reports, etc. I personally recommend &#8216;Subversion&#8217; for this task, but others have found software such as git, SourceGear Vault, Microsoft Visual SourceSafe, StarTeam, and many others useful.&nbsp; But whatever you do, for the love of software, PLEASE use SOMETHING.
                
                ## Automated Build
                
                > _The code should have an associated automated build script that requires no magic by the person running the script_
                
                Once a would-be software maintenance programmer (possibly yourself) pulls down the latest code from the source control repository, building the code into a runnable unit should be automated to the maximum extent possible (preferably 100%).&nbsp; Now, that doesn&#8217;t mean you have to install IIS/Apache on the box, it&#8217;s OK to have certain prerequisites (i.e. &#8216;Windows&#8217; or &#8216;Linux&#8217;, &#8216;IIS&#8217; or &#8216;Apache&#8217;, etc).&nbsp; If there are specific environmental requirements like this though, you should have the build script at least check for them and alert the human there&#8217;s something missing.
                
                A helpful side-effect of automating your build process is that you see what a pain it is to configure your app (and they&#8217;re all a pain) and it might motivate you to make configuration easier.
                
                ## Automated Testing
                
                > _The code should have at least a basic success indication check test and it should be able to run in an automated fashion_
                
                There should be some way to prove that a build was &#8216;successful&#8217; beyond the build script telling us so. We need real proof/verification.&nbsp; If you&#8217;re not doing unit tests, TDD, TAD, POUT, whatever, at least have ONE test that does SOMETHING with the app to verify that it doesn&#8217;t just crash on startup.
                
                A maintenance programmer who&#8217;s new on the project should have some indication as to whether the code he just built actually resembles a working product or not.&nbsp; The more tests you have, the more confident he/she&#8217;s going to be. Please give the gift of confidence to your successor.
                
                ## Continuous Integration
                
                > _When a developer commits code to the source control repository, a separate, objective, and impartial system should report the success and health of the build._
                
                I was strongly tempted to say that this should be a requirement all the time &#8212; even for a solo &#8216;team&#8217;. CI certainly helps even for a solo developer, but I wouldn&#8217;t consider it an absolute must.&nbsp; Having said that, if you have more than one developer committing code to the same project in the same source control repository, I _will_ say that CI is an absolute must. 
                
                It is important that the CI run on a non-developer machine install.&nbsp; It is, however, perfectly acceptable to run it in a virtual machine running on a developer&#8217;s desktop computer though if the budget is tight.&nbsp; The intention here is that you have a somewhat pristine OS install that isn&#8217;t polluted with SDK&#8217;s, developer tools, environment settings, etc. You want to try to create a production-like environment to the maximum extent possible. This doesn&#8217;t mean you need to replicate your production hardware requirements, but you should try to use a similar OS setup to what the production servers (or customer computers) are running. If the production server is running Windows 2003 Server, see if you can get your CI OS install to be Windows 2003 Server. If the budget is tight, you might consider using a 180-day trial version of Windows 2003 Server until you&#8217;re sure how you like your CI setup. Hopefully by then you&#8217;ll be making some money and you can afford a copy of Server or an MSDN Subscription or something.&nbsp; I&#8217;m not sure about the legality of re-building your CI virtual machine with 180-day trial versions of Win2K3 server over and over again. If it&#8217;s legal and doesn&#8217;t violate the EULA, that may be an option too. Please check with your corporate attorney, priest, or local fortune teller for clarification (since no one can really truly understand Microsoft EULA&#8217;s and divination is just as an acceptable means as legal review for getting it right).
                
                ## Automated Deployment
                
                > _The build product should be deployable to another environment with minimal human interaction_
                
                Having said that, it&#8217;s not usually possible (or feasible) to have one-button automatic deployment to any specified environment. In my experience, there&#8217;s always something required by a SysAdmin, a DBA, etc.&nbsp; If not perfection, you should at least strive to deliver a ZIP file or MSI to your SysAdmin and a well formatted change script to your DBA.&nbsp; Strive to make deployment convenient, coherent, and above all consistent.
                
                # A Metric of Success: Time-to-Login-Screen
                
                Now that we&#8217;ve established the virtues of repeatability &#8212; and I hope you are intent on practicing them &#8212; how do we measure our success in this effort?&nbsp; I propose a metric: &#8220;Time-to-Login-Screen&#8221; (TTLS).&nbsp; This of course assumes your app has a &#8216;login screen&#8217;, but it applies to any app. Perhaps it should say &#8216;Time-to-First-Screen-With-Functionality&#8217; but &#8216;TTFSWF&#8217; isn&#8217;t as sexy as &#8216;TTLS&#8217;.
                
                The general concept here is how long can I take a new-hire developer and get him/her coding/building/deploying (i.e. a productive member of the team).&nbsp; This metric can expand further to include how long HR takes, how long IT takes to set up the desktop, how long it takes to install any 3rd party components, etc.&nbsp;&nbsp; But for our purposes, let&#8217;s start with using TTLS to represent the time it takes from when the IT department hands your dev a desktop to the time when they&#8217;re committing code into your source control repository. Let&#8217;s exclude commonalities like Visual Studio (or your IDE of choice) and other basic tools.&nbsp; We should, however, include things like 3rd party components (Infragistics, Telerik, etc) and their licenses and such. 
                
                If your TTLS is over a day, that&#8217;s a problem. If it&#8217;s over a few days, the situation is highly dysfunctional. If it&#8217;s approaching a month (yes, I worked at a shop where it was a little over a MONTH before I was committing code into source control), then you should re-think how you do software entirely. Something is seriously wrong.
                
                &nbsp;
                
                <div class="wlWriterSmartContent" style="padding-right: 0px;padding-left: 0px;padding-bottom: 0px;margin: 0px;padding-top: 0px">
                  Technorati Tags: <a href="http://technorati.com/tags/continuous%20integration" rel="tag">continuous integration</a>, <a href="http://technorati.com/tags/automated%20build" rel="tag">automated build</a>, <a href="http://technorati.com/tags/repeatability" rel="tag">repeatability</a>
                </div>