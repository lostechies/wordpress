---
id: 167
title: A Brief History of Programming
date: 2010-09-08T03:21:28+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2010/09/07/a-brief-history-of-programming.aspx
permalink: /2010/09/08/a-brief-history-of-programming/
dsq_thread_id:
  - "262114537"
categories:
  - ad nauseum
  - Humor
  - sanctus bovis
---
In 1977, Bill Gates invented programming. Working closely with Steve Jobs, together they invented the SQL language (Steve being particularly responsible for the JOIN keyword).&#160; That is a story for another blog post, however. In this blog post, I endeavor to relate to you how the West was Won, or rather, how we ended up with Stored Procedures as the primary way in which programmers glean business value out of computer systems.

A few years into the process of designing SQL, it was quickly discovered (many say by Jobs himself) that stored procedures produced the best hope of achieving performance on the meager hardware of the era.&#160; At this time maintainability (that is, the process of paying consultants to rewrite whatever code was already existing before they arrived), was less of a concern.&#160; As the process of re-inventing stored procedures evolved (as well as the various languages that evolved in order to invoke them: C, Ada, Eiffel, Java, C#, and later Assembler), the concept of “maintainability” was eventually eradicated in the favor of maintaining consultants permanently on staff.&#160; 

With “maintainability” firmly in the rear view mirror, second generation leaders (Linus Torvalds, ESR, RMS) emerged to propel the invocation of stored procedures into new, previously unimagined heights.&#160; For example, ESR and Torvalds collaborated on a project known as “EMACS” which stands for “Emulator [and] Machine Assembler for Commanding StoredProcedures.”&#160; RMS then used EMACS to produce a new editor known as “VI” (and it’s red-haired stepchild, VIM).&#160; This, some say, was the golden age of stored procedures.&#160; Their full height not yet realized, but their growth and research unfettered.

Eventually, Oracle emerged as a leading corporate bulldog leveraging the research of Torvalds, ESR, and RMS to achieve massive profits of (SELECT [Revenue] &#8211; [Cost] FROM dbo.Accounting) in FY 1995.&#160; The stored procedure community, realizing that its golden age had ended, resented Oracle and its ruthless, avaricious profiteering.&#160; They turned to an old mentor and ally, Bill Gates.&#160; Thus ensued one of the more bloody (figuratively speaking – but not to discount the many post-INSERT triggers that were lost during this tumultuous time) periods of stored procedure history: The Tabs vs. Spaces war.&#160; Microsoft emerged as a leader and settled on using tabs for indentation – unawares as to the huge schism this would cause within the community.&#160; Oracle also emerged as a leader and settled on using spaces for indentation.&#160; Neither of these formats were portable and they could not run on each others’ systems causing much consternation among the programming community and much delight among the consultant community.&#160; 

Oracle strove to end the stalemate.&#160; For over a decade, they had quietly been amassing patents for space (that is ASCII 0&#215;20) interpreters, stored procedure performance enhancement algorithms, and generally any patent involving a technology that had the words “stored” and “procedures” in it.&#160; As an aside, this is why Oracle now owns one of the nation’s largest chains of climate-controlled personal storage facilities.&#160; But I digress.&#160; 

Finally, in 2010, Oracle bought out Sun Microsystems for the paltry sum of (execute sp_lookupSECdoc( ‘Oracle’, ‘Sun’, 9998974098 )).&#160; With this they had achieved their means to affect a Coup de Grace on Microsoft.&#160; They executed one of the greatest flurry of lawsuits filed on a single day by one plaintiff against a single defendant in the history of western civilization.&#160; In fact, so monumental was the tide of lawyers descending upon Redmond, Washington, that it’s quite certain that had King John known of this, he would’ve rather been killed by the barons than put his seal upon the Magna Carta (a document credited with creating a new industry known as ‘ambulance chasing’).

You, of course, know how this story ended. Microsoft eventually prevailed against the villainous Oracle, thus firmly entrenching VIM and tab-based-indentation as the de facto “correct” way of authoring stored procedures.&#160; Perhaps the future will hold another golden age for stored procedures, now that many of the obstacles to its growth have been removed.&#160; Alas, Torvals, ESR, and RMS are still alive and awaiting their chance to regain former glory.&#160; In fact, they have gone so far as to create their own SQL operating environments (Linux, Windows Me, and HURD respectively).&#160; RMS has gone on to form a new international standards body with the aims of establishing Microsoft’s principles of VIM and tabs (versus spaces) as a universally accepted norm.&#160; He calls this new international body the “GNU Neo-StoredProcedure Universality” or GNU for short.

The battles are not all fought and the war is far from over. New fronts emerge every year and old enemies become allies and old allies become new enemies.&#160; Only time will tell what will become of festering debates such as “WebForms vs. Rails” (though WebForms is clearly emerging as the dominant leader due to is comprehensiveness and appeal to the new generation of programmers).

Un-dealt with also has been the growing menace of the horde of PHP developers on one side and the cold, calculating ORM users on the other side.&#160; One seeks utter chaos with direct SQL language placed directly in web pages and the other seeks to eliminate SQL entirely by accessing the database through unmentionable means.&#160; Both options offer such horrible performance that one must conclude the world would be put back to the stone age.&#160; 

Though there is no clear moral to this story, I might be inclined to proffer that it is: A DBA’s work is never done.