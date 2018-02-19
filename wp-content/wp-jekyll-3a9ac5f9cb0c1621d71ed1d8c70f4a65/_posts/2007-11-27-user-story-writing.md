---
id: 9
title: User Story Writing
date: 2007-11-27T05:03:37+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2007/11/27/user-story-writing.aspx
permalink: /2007/11/27/user-story-writing/
dsq_thread_id:
  - "262089158"
categories:
  - agile
---
Since we had our agile fishbowl at work, we&#8217;ve moved ahead with adapting agile practices in our development process. For our projects, we&#8217;re working on creating user stories to fill our product backlog. I&#8217;ve read several threads on writing good user stories and gotten advice from several people on what makes a good user story, but I never realized how hard it is to actually write good user stories.

For user stories, we&#8217;re using a format that includes:

  * The role for the story, is it a user, a specific type of user, or a customer
  * The context of the story, describing what the user is doing
  * The want of the story, describing how the feature should behave

The clarity of user stories over requirements is both amazing and overwhelming. The amazing part is understanding the intent of the story in the context of the user and how it affects their usage of the system as a whole. The overwhelming part is negotiating with the stakeholder to ensure both the context and the behavior have been properly captured and an adequate number of acceptance criteria have been defined. While this certainly increases the amount of time spent on a particular story, the number of details revealed by the discussion is well worth the effort.

**Finding Good Examples**

One of the stumbling blocks I found when learning to write user stories is finding good examples that go beyond the typical &#8220;As an account holder, I want to withdraw money from my checking account so I can buy crack.&#8221; These textbook examples don&#8217;t really provide a significant level of depth, something I deal with when identifying improvements to an existing system. For example, here is a story that could be written:

> As a customer, I want to verify the correct billing codes were included on the claim before sending it to the payer to avoid rejections.

This enhancement to an existing claim submission system might include a number of checkpoints where such a verification could be performed. The context really helps clarify this story to ensure it is properly implemented:

> When importing claims, the billing codes in the 2100 loop of the 837 file should be compared to a list of known, valid billing codes and claims with invalid codes should held.

This additional context indicates that the billing codes should be checked when importing claims, a process that likely occurs on a daily basis. It is assumed that the user would then take the list of claims containing invalid codes and correct them in the originating system. This assumption, however, is just that as the story doesn&#8217;t attempt to describe any behavior of how held claims should be handled.

> When a user is modifying a held claim, changes to the billing code elements should cause those elements to be reverified. If the billing codes are changed to valid codes, the claim hold should be removed.

This one gets a bit tricky. While dealing with the verification of billing codes on a claim, what is really being described is a new behavior. In my eyes, this means it is a different story.

> As a user, I want to be able to correct the billing codes on a held claim so that I don&#8217;t have to re-import the claim for it to be sent to the payer.

Here we are describing the new behavior &#8212; the ability to modify the billing codes on the held claim. For this story, the previous context would be more applicable since it is dealing with the user activity of modifying the billing codes on a claim.

**Stories That Aren&#8217;t User Stories**

So what about things that are needed to support the above stories? No, really, that&#8217;s a question since I don&#8217;t have a really good answer at this point. Do you write a story to import a list of valid billing codes? Or do you write a user story to automatically download and import a list of valid billing codes from the payer every night? Where do those system-level stories go and how are they written? There really isn&#8217;t a role associated with the story, so I&#8217;m still struggling with that type of story.

One such example might be something like:

> As an application administrator, I want to be able to import a list of valid billing codes so that I can update the verification tables.

The context of such a story might include:

> When an application administrator uploads a file containing billing codes, the existing billing code table should be cleared and the new codes added.

**Onward**

I didn&#8217;t really get into acceptance criteria in this post because that in itself is a series of posts. I will mention that having a deep set of acceptance criteria on a story will make it easier to estimate (size) the story, as well as improve your chance at success in implementing the story.

If you as the reader have some good examples of stories that aren&#8217;t associated with a particular role, please share them in the comments as I&#8217;m really looking for some better examples of how these stories would be written.