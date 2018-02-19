---
id: 26
title: 'Pablo&#8217;s Topic of the Month &#8211; March: SOLID Principles'
date: 2008-03-08T02:01:16+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/03/07/pablo-s-topic-of-the-month-march-solid-principles.aspx
permalink: /2008/03/08/pablo-s-topic-of-the-month-march-solid-principles/
dsq_thread_id:
  - "262113714"
categories:
  - Uncategorized
---
# Pablo&#8217;s Topic of the Month &#8211; March: SOLID Principles[<img style="border-top-width: 0px;border-left-width: 0px;border-bottom-width: 0px;margin: 15px;border-right-width: 0px" height="240" alt="pablos_topic" src="http://lostechies.com/chadmyers/files/2011/03PablosTopicoftheMonthMarchSOLIDPrinciple_12781/pablos_topic_thumb.png" width="240" align="right" border="0" />](http://lostechies.com/chadmyers/files/2011/03PablosTopicoftheMonthMarchSOLIDPrinciple_12781/pablos_topic_2.png)

Over the next few days and weeks, the Los Techies crew will be writing a number of blog posts focused a particular subject in addition to their regular blogging.&nbsp; Pablo&#8217;s Topic of the Month for the month of March is Bob Martin&#8217;s S.O.L.I.D. design principles. We&#8217;ll try to cover all of them by the end of the month or we might focus in on a few of them and go really deep.&nbsp; Please stay tuned and please give us some feedback of how you like this format because we&#8217;re considering doing it in upcoming months.

If you haven&#8217;t already, please consider subscribing to the Los Techies Main Feed so that you can see the various post from the other Los Techies bloggers.

The main feed is here:&nbsp; [http://feeds.feedburner.com/lostechies](http://feeds.feedburner.com/lostechies "http://feeds.feedburner.com/lostechies")&nbsp;

# What is S.O.L.I.D.? 

S.O.L.I.D. is a collection of best-practice object-oriented design principles that you can apply to your design to accomplish various desirable goals like loose-coupling, higher maintainability, intuitive location of interesting code, etc.&nbsp; S.O.L.I.D. is an acronym for the following principles (which are, themselves acronyms &#8212; confused yet?).

These principles were pioneered and first collected into a written work by Robert &#8216;Uncle Bob&#8217; Martin. You can find more details here: [http://butunclebob.com/ArticleS.UncleBob.PrinciplesOfOod](http://butunclebob.com/ArticleS.UncleBob.PrinciplesOfOod "http://butunclebob.com/ArticleS.UncleBob.PrinciplesOfOod")

I&#8217;m going to give you a teaser here of each one, but I won&#8217;t go into much detail here as that&#8217;s what the other Los Techies articles are going to be about.&nbsp; Please check back to this post as I&#8217;ll be updating it with links to other posts as they appear so you can keep tabs on what&#8217;s going on.&nbsp; 

The attribution of the following snippets goes to Robert Martin from various publications.

## [SRP: Single Responsibility Principle](http://www.objectmentor.com/resources/articles/srp.pdf)

> _THERE SHOULD NEVER BE MORE THAN ONE REASON FOR A CLASS TO CHANGE._

  * [PTOM: The Single Responsibility Principle by Sean Chambers](http://www.lostechies.com/blogs/sean_chambers/archive/2008/03/15/ptom-single-responsibility-principle.aspx)
    
      * [POTM: The Single Responsibility Principle by J.D. Meridth](http://lostechies.com/blogs/jason_meridth/archive/2008/03/26/ptom-single-responsibility-principle.aspx)</ul> 
    
    ## [OCP: Open Closed Principle](http://www.objectmentor.com/resources/articles/ocp.pdf)
    
    > _SOFTWARE ENTITIES (CLASSES, MODULES, FUNCTIONS, ETC.) SHOULD BE OPEN FOR EXTENSION BUT CLOSED FOR MODIFICATION_. 
    
      * [PTOM: The Open Closed Principle by Joe Ocampo](http://www.lostechies.com/blogs/joe_ocampo/archive/2008/03/21/ptom-the-open-closed-principle.aspx) 
          * [PTOM: OCP Revisited in Ruby by Joe Ocampo](http://www.lostechies.com/blogs/joe_ocampo/archive/2008/03/30/ptom-ocp-revisited-in-ruby.aspx)</ul> 
        ## [LSP: Liskov Substitution Principle](http://www.objectmentor.com/resources/articles/lsp.pdf)
        
        > _FUNCTIONS THAT USE &#8230; REFERENCES TO BASE CLASSES MUST BE ABLE TO USE OBJECTS OF DERIVED CLASSES&nbsp; WITHOUT KNOWING IT._
        
          * [PTOM: The Liskov Substition Principle by Chad Myers &#8212; My own post on the subject](http://www.lostechies.com/blogs/chad_myers/archive/2008/03/09/ptom-the-liskov-substitution-principle.aspx)
        ## [ISP: Interface Segregation Principle](http://www.objectmentor.com/resources/articles/isp.pdf)
        
        > _CLIENTS SHOULD NOT BE FORCED TO DEPEND UPON INTERFACES THAT THEY DO NOT USE_
        
          * [PTOM: The Interface Segregation Principle by Ray Houston](http://www.lostechies.com/blogs/rhouston/archive/2008/03/14/ptom-the-interface-segregation-principle.aspx)
        ## [DIP: Dependency Inversion Principle](http://www.objectmentor.com/resources/articles/dip.pdf)
        
        > _A. HIGH LEVEL MODULES SHOULD NOT DEPEND UPON LOW LEVEL MODULES. BOTH SHOULD DEPEND UPON ABSTRACTIONS_
        > 
        > _B. ABSTRACTIONS SHOULD NOT DEPEND UPON DETAILS. DETAILS SHOULD DEPEND UPON ABSTRACTIONS_
        
          * [PTOM: The Dependency Inversion Principle by Jimmy Bogard](http://www.lostechies.com/blogs/jimmy_bogard/archive/2008/03/31/ptom-the-dependency-inversion-principle.aspx)