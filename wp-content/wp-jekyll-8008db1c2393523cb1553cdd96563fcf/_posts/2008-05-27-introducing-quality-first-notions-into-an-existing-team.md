---
id: 54
title: Introducing Quality-first Notions Into an Existing Team
date: 2008-05-27T17:16:02+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/05/27/introducing-quality-first-notions-into-an-existing-team.aspx
permalink: /2008/05/27/introducing-quality-first-notions-into-an-existing-team/
dsq_thread_id:
  - "272260917"
categories:
  - TDD
---
In a [recent discussion](http://tech.groups.yahoo.com/group/altdotnet/message/8734) on the [altdotnet mailing list](http://tech.groups.yahoo.com/group/altdotnet/), a question was raised: How to you start introducing TDD into an existing team?&nbsp; Bill Barry had some [good thoughts on how the process might work](http://tech.groups.yahoo.com/group/altdotnet/message/8735), I suggest you check out his post. 

It got me thinking about things and three questions came to mind:

  1. If the team is functioning and delivering software, why introduce anything at all &#8212; especially such a radical change as TDD? 
      * When implementing TDD, what&#8217;s the best way to get it going (i.e. mandatory/imposed, weaving in little by little, separate project, etc)? 
          * Won&#8217;t this just add a bunch of time to my process?</ol> 
        ## First Question: Why introduce TDD into an existing, functioning team?
        
        What if the team is already having success with their current process? Why add something so different as TDD and risk potentially screwing everything up?&nbsp; Bill touched on this in his post, but I&#8217;d like to expound upon his point. His point was essentially: Is it really working, or does it just appear to work? Shipping software is not the only metric. Is what they&#8217;re shipping as high quality as it could be? Could they ship faster? Are they working as efficiently on the code as they could be, or is a large percentage of their time spent on up-front design, bug reproduction and resolution, and other otherwise-avoidable activities?&nbsp; The first thought that came to mind is: Sure, you may have a bunch of heroes on your team that, through blood and sweat manage to pull off successful releases, but at what cost? 
        
        I get this a lot when talking to people about TDD. I hear things like, &#8220;But our process is working great, we&#8217;re shipping software on time and customers are happy!&#8221;&nbsp; That&#8217;s wonderful and I applaud your success. So now that you&#8217;re making customers happy, could you be making them happier? Could you be saving your company money by making your successes even more efficient? Let&#8217;s take it to the next level! Let&#8217;s make customers ECSTATIC! One vision that comes to my mind when people say they are having &#8216;success&#8217; is a circus performer juggling balls in the air while riding a unicycle.&nbsp; Sure, that performer is an amazing expert in his field and extremely talented. However, if his task is to deliver the balls to a customer, he&#8217;s spending way too much effort when he could just walk them over to their destination.&nbsp; Are the talented experts on your team juggling on unicycles, or are they taking the easiest, shortest path?&nbsp; Which delivery method will make the customer more successful?&nbsp; Juggling my impress them, but it&#8217;s not really helping them.
        
        On the other hand, I have seen teams (yes, including teams I&#8217;ve been on and even lead &#8212; I&#8217;m as guilty of this as anyone!) declaring success, but when probed for more details, it turns out that the customers don&#8217;t necessarily share the same enthusiasm for the success as the development team does. Many times, in this situation, if you ask customers how they really feel, they may say that quality is &#8216;acceptable&#8217; or &#8216;good enough&#8217; or &#8216;I can work around the problems&#8217;.&nbsp; I will ask the development team what metrics they&#8217;re using for measuring success (and the sustainability of that success), quality, efficiency, etc.&nbsp; Very frequently there is no answer, or everyone stares at their shoes. We can ALWAYS do better. We can ALWAYS improve and eek out more efficiency, more automation, more clarity, and, most importantly, more success for our customers. We should be relentlessly seeking out these opportunities and taking whatever reasonable risks we can to make sure that we&#8217;re not missing things. 
        
        In my mind, TDD is more than just a coding practice, it institutes this culture of relentless self-examination and improvement &#8212; a culture of quality, measurement, sustainability, and repeatability (all summed into the word I use a lot: &#8216;maintainability&#8217;).&nbsp; TDD is the tip of the iceberg, but it is supported by other good practices such as Source Control, Continuous Integration, Automation, and Code Refactoring &#8212; among many others.
        
        ## Second Question: What&#8217;s the best way to go about introducing it?
        
        So, how does one go about bringing this culture to their organization.&nbsp; Given that I propose that TDD is the tip of a cultural iceberg within your organization, the key is to change the culture and the focus of your team back to quality and customer satisfaction and away from merely shipping the software. OK, OK, I know some of you are going to slam me and say that &#8216;here those TDD guys go again&#8230;&#8217;&nbsp; Yes, shipping is important. Shipping is critical, Shipping is one of the most important features of your project. There, I said it. But I&#8217;m also concerned that what&#8217;s being shipped is going to make the customer&#8217;s happy. And I&#8217;d even lean towards the side of ensuring customer satisfaction over hitting imaginary deadlines.&nbsp; Real deadlines (i.e. the money&#8217;s going to run out, we have a legal requirement to implement X by such-and-such date, etc) are a different story, but the values are still very similar.
        
        Anyhow, on to the meat. Here&#8217;s one possible recipe for implementing a culture of quality and customer satisfaction in your development team:
        
          1. Get source control setup if you don&#8217;t have it already. _Note: this can be the hardest step sometimes._ 
              * Encourage frequent source control commits and the taking of source control seriously &#8212; _not just infrequent code backups_ 
                  * Get NAnt, MSBuild, Rake or FinalBuilder and automate the build. _I&#8217;ve never met anyone who resisted this._ 
                      * Set up CruiseControl.NET/TeamCity and get CI going with your new automated build. 
                          * Slowly encourage developers to install the CCTray or TeamCity agent tray thingee and encourage them to take build failures seriously. _Eventually they will get the build-failure-fever and work to prevent it from happening_. 
                              * Add in a few unit tests to the build, preferably things that won&#8217;t break easily _to give positive feelings about there being some tests in the build that pass consistently._ 
                                  * Encourage people to add tests whenever they find a bug to ensure that the bug won&#8217;t happen again. _This is usually an easy sell as doing the test as a repro case helps fix the bug faster_. 
                                      * Eventually add a few tests that are brittle to get people used to caring when the build breaks due to tests. _Then use that opportunity to discuss the best way to write tests in your environment_. 
                                          * Pick a few of the developers who are most interested and/or who have the best attitude and introduce them to the TDD concept and _do a short ping-pong pairing session with them on a simple feature to win a quick success._ 
                                              * Keep doing more of #9 until someone else gets it and wants to help. 
                                                  * Start doing more and more until it catches on throughout the whole (or most of the) team.</ol> 
                                                ## Third Question: Won&#8217;t this just add a bunch of time to my process?
                                                
                                                This one is easy. In my experience, these practices pay for themselves rather quickly. The ROI on &#8216;sharpening your saw&#8217; is usually very quick.&nbsp; [An ounce of prevention is worth a pound of cure](http://www.lostechies.com/blogs/chad_myers/archive/2008/04/25/the-problem-preventer.aspx), after all.&nbsp; There is a startup cost, to be sure, but as long as you focus on the values and principles and ditch what doesn&#8217;t work and try what you think might work and constantly re-evaluate your practices, you will quickly shake out a set of practices that are right for your team and amount to force multipliers.