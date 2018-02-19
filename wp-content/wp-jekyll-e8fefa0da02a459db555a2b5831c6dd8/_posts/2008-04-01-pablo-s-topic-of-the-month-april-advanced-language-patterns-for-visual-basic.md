---
id: 30
title: 'Pablo&#8217;s Topic of the Month &#8211; April: Advanced Language Patterns for Visual Basic'
date: 2008-04-01T01:04:30+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/03/31/pablo-s-topic-of-the-month-april-advanced-language-patterns-for-visual-basic.aspx
permalink: /2008/04/01/pablo-s-topic-of-the-month-april-advanced-language-patterns-for-visual-basic/
dsq_thread_id:
  - "262113733"
categories:
  - "1998"
  - Humor
---
# Pablo&#8217;s Topic of the Month &#8211; April: Advanced Language Patterns for Visual Basic

Following on the coat tails of [last months&#8217; Pablo&#8217;s Topic of the Month &#8211; March: Leveraging XML for Computationally Expensive Operations](http://www.lostechies.com/blogs/chad_myers/archive/2008/03/07/pablo-s-topic-of-the-month-march-solid-principles.aspx), I&#8217;d like to announce the new PTOM for April:&nbsp; Advanced Language patterns (for Visual Basic).

We (the Los Techies crew) have been discussing this month&#8217;s topic vigorously for the past few weeks and we&#8217;re really excited to announce the highlights of this month&#8217;s topic.&nbsp; Over the next few days and weeks we&#8217;ll be doing an article storm (the new &#8216;weblog&#8217; people call it &#8216;blogging&#8217;, but that will probably never catch on) on the subject of advanced language patterns in Visual Basic.&nbsp; With the recent SP6 release of Visual Basic last summer (1998), several new and exciting features have opened up new possibilities with this exciting, robust (and enterprise Hah! Take that C++ know nothings!) language.&nbsp; We plan on going pretty deep on these subjects, so please stay tuned and we welcome all your feedback and comments (except those from the the C++ guys &#8212; don&#8217;t bother, they&#8217;ll be summarily deleted without ceremony because we don&#8217;t need to free pointers. SNAP!).

If you haven&#8217;t already, please consider subscribing to the Los Techies Main Feed so that you can see the various post from the other Los Techies bloggers.

The main feed is here:&nbsp; <http://feeds.feedburner.com/lostechies>
  


# Advanced Topics for Visual Basic

With the advent of much-anticipated Visual Basic 6, we now have the possibility to explore the benefits of having a fully object-oriented language with modern language concepts such as &#8216;memory handling&#8217;, &#8216;reference counting&#8217;, &#8216;string concatenation&#8217;, and the (magical and wonderful, in my opinion) advanced IDispatch support. 

The topics we plan on covering are quite broad and include:
  


## Advanced Error Handling

Visual Basic 6 will be known for a long time for how it eliminated bugs due to it&#8217;s comprehensive and first-rate structured error handling system. We&#8217;ll do a series of posts on advanced features such as:

  * On Error Resume Next 
      * On Error Goto (label) 
          * On Error GoTo 0</ul> 
        ## Advanced Web Page Creation with WebClasses
        
        Much to our chagrin, it appears the Web is here to stay. Fortunately, Microsoft has provided for us a world-class, top-notch Enterprise web framework that is sure to be the mainstay of web programming for the forseeable future known as [&#8216;Visual Basic WebClasses&#8217;](http://msdn2.microsoft.com/en-us/library/zh5976bw.aspx).&nbsp; Just imagine the sheer, raw power of in-memory, in-process VB6 code executing directly in IIS&#8217; main process space. This will definitely put to shame anyone who thought parsing script text files in ASP will ever catch on. Sorry folks, WebClasses is the future.
        
          * Stateful web patterns using VB6 Web Classes 
              * Making the web seem more like regular Windows Programs 
                  * Avoid writing any HTML and use advanced, high-performance VB6 string concatenation techniques</ul> 
                ## Advanced Object Oriented Programming
                
                For many years we have been chided and derrided by the C++ slogs about how VB isn&#8217;t &#8216;really OO&#8217; whatever that means. Well, with the advent of VB6, we finally have a FULL OO implementation including Interfaces. Take THAT C++. Don&#8217;t bring no weak pure virtual abstract class action here! This is hard core enterprise programming now!
                
                  * Defining and using interfaces with VB6
                
                That concludes the list of OO features in VB6.
                
                ## Strongly Typed Data: Variant V_TYPEs
                
                When dealing with more crude systems which do not have VB&#8217;s wonderfully adaptive and presumptive typing system (\*cough\* C++), it may be necessary to actually have to pigeon-hole your data into &#8216;strong types&#8217; by understanding how VB stores data in memory&nbsp; and how it&#8217;s marshaled to systems outside the glorious VBRuntime.&nbsp; I know, I know, I thought we were past this too, but apparently some people find it necessary to still run code outside of a managed runtime environment like VB6 and so we must come down to their level.&nbsp; Posts about this subject include:
                
                  * Defining variant subtype with V_TYPE 
                      * Rewriting C++ code in VB6 without having to understand pointers (not sure if we&#8217;ll get this one done by the end of April, that remains to be seen)</ul> 
                    ## Ergonomic Considerations for new Drag and Drop Coding Features
                    
                    VB6 has brought us even more opportunities to drag and drop our way to success without having to write <strike>much</strike> any code! But with great power also comes great responsibility. Many VB6 users have reported &#8216;mouse hand&#8217;, so it&#8217;s important to remember that, despite our ridiculous RAD productivity, we still are mere mortals and our hands CAN break. So take care, the VB6 programmer hands are a temple, after all.
                    
                      * Using other fingers for the Left Mouse Button: The Double Deuce 
                          * Using your left hand for dragging 
                              * Add-ons with Mouse Gesturing capabilities</ul> 
                            ## Many different OPTIONs
                            
                            VB6 is frighteningly customizable. In fact, one of the customizations is to control how the <strike>interpreter</strike> compiler treats your finely crafted code. We&#8217;ll explore these various options and how they can be helpful or harmful
                            
                              * OPTION BASE 
                                  * OPTION EXPLICIT 
                                      * OPTION STRICT (warning: Avoid this one like the plague, it restricts your creative expression entirely!) 
                                          * OPTION COMPARE (Love this feature, totally change the way the entire app works with one keystroke, totally awesome!)</ul>