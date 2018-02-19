---
id: 58
title: More on Quality
date: 2008-06-07T14:37:56+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/06/07/more-on-quality.aspx
permalink: /2008/06/07/more-on-quality/
dsq_thread_id:
  - "262113851"
categories:
  - Agile
  - Mangement
  - Principles
  - Quality
---
I started typing a comment to [John Teague&#8217;s](http://johnteague.lostechies.com) post about [Creating a Culture of Quality](http://www.lostechies.com/blogs/johnteague/archive/2008/06/06/creating-a-culture-of-quality.aspx#3581), but it got a little long so I decided to make it a post. If you would be so kind, please read John&#8217;s post first (linked in the last sentence) and then proceed with this post.

Here are some of my additional thoughts:

  1. There are three over-arching principles that form the basis for everything John said and what I&#8217;m about to say:&nbsp; 1.) Fast fail&nbsp; 2.) Quick feedback cycle and 3.) Automate it.
  1. Fast fail &#8211; To John&#8217;s point (&#8216;Make it Easy&#8217;), fast fail is crucial to avoid a long delay between change and corresponding failure. If something is wrong and it&#8217;s detected, fail ASAP so that it can be fixed. Don&#8217;t allow problems to persist.
  2. Quick feedback cycle &#8211; Whether it&#8217;s a success or failure, I need to know very fast (minutes, not hours).&nbsp; If your build/test cycle is necessarily long, consider breaking it up and doing the fastest, most critical tests first and then doing the lengthy setup and tests as part of a cascading build that only happens maybe a few times a day.
  3. Automate it &#8211; Whatever you&#8217;re doing for quality, try to automate it to the maximum extent possible. Leave the team and any future maintainers with automated paths to success. Eliminate magic and bubblegum/tooth picks/duct tape in your process ASAP.&nbsp; These things will continue to creep up during your project. Be vigilant and constantly scan for and eliminate them every time they appear.

  2. Automate as much as possible. If you&#8217;re doing anything manually more than just a few times, you&#8217;re a.) wasting time and b.) introducing variables and instability into the process that could and should be automated.&nbsp; If you think it&#8217;ll be hard to automate, but you plan on doing it manually more than a few times, I&#8217;ve observed that it&#8217;s always cheaper to bite the bullet and automate. Anyone who has doubts about whether quality-first (i.e. TDD, BDD, etc) slow down a project, I can tell you that you&#8217;re worried about premature optimization because I can guarantee that on most projects, MUCH more time is being wasted in other areas than would be affected by TDD/BDD/etc. 
    The interesting thing here is, though, that you probably don&#8217;t realize how many things that you&#8217;re currently doing manually that could be automated. Until I was on a team with someone who was automation-infected ([Jeremy Miller](http://codebetter.com/blogs/jeremy.miller/default.aspx)), I didn&#8217;t realize just how much time I had been wasting doing things that I didn&#8217;t think were automatable!&nbsp; (side note: I plan on blogging more about real-world examples of this in the next few months, so if you&#8217;re thinking &#8216;This guy is BS&#8217;, please check back later)</li> 
    
      * Add tests for conventions and tribal wisdom types of things. If you hear team members saying &#8220;Everyone:&nbsp; Please make sure that none of your controllers have a method called Floogle() because that will mess up XYZ&#8221;, this should be a big clue.&nbsp; Sure, that&#8217;s a contrived example, but you know what I mean.&nbsp; Anyhow, add tests for these to enforce that convention.&nbsp; When new developers come onto the team and don&#8217;t yet have the tribal knowledge, they&#8217;ll be protected from harm this way.&nbsp; When the convention tests break, you have to make the choice to change the convention or fix your code.&nbsp; Changing the convention requires everyone on the team to be aware and in agreement. 
        For your reference, Glen Block was working on a project with Ayende and they both wrote about a situation where they did this and it worked out really well. You can read [Glen&#8217;s Post](http://codebetter.com/blogs/glenn.block/archive/2008/05/04/prismshouldnotreferenceunity.aspx) and [Ayende&#8217;s Post](http://ayende.com/Blog/archive/2008/05/05/Actively-enforce-your-conventions.aspx) at their respective links.</li> 
        
          * John Teague mentioned this in his post, but I want to reiterate: Don&#8217;t get too focused on coverage.&nbsp; Tests should enforce that the code does what it should and, in most cases, not necessarily that everything is perfect. Use tests to help you flush out design issues. If tests are hard to write: design smell.&nbsp; If lots of tests break&nbsp; when you change a small aspect of your design, that&#8217;s either a design smell or, more likely, a smell that your tests are too brittle and too envious of the code.&nbsp; Tests should be there for ensure that the basic requirements and acceptance criteria are met, not to make sure that every line in the code actually executes (which is a common TDD beginner mistake &#8212; I did it a lot ;) ).&nbsp; This is why I tend to shy away from code coverage as a metric because it tends to encourage code envy from your tests. 
          * No one leaves the building without having committed their code for the day. If the code&#8217;s not ready to integrate, then create a branch and commit it there. Don&#8217;t walk out with your laptop and then drop it and lose a day&#8217;s-worth of work. Frequent checkins is a must, must, must!</ol>