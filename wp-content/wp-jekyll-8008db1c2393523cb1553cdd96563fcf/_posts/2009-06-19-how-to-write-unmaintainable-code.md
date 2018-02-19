---
id: 147
title: How to Write Unmaintainable Code
date: 2009-06-19T22:05:46+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/06/19/how-to-write-unmaintainable-code.aspx
permalink: /2009/06/19/how-to-write-unmaintainable-code/
dsq_thread_id:
  - "262114448"
categories:
  - Humor
  - Unmaintainability
---
A friend showed this one to me a long time ago, and I still chuckle every time I remember a snippet or two from it.

[How to Write Unmaintainable Code](http://mindprod.com/jgloss/unmain.html) by Roedy Green

Perhaps my most favorite section is the ‘Naming’ section:

<http://mindprod.com/jgloss/unmainnaming.html>

&#160;

And within that, lies the pièce de résistance of that entire body of work (in my opinion):

(NOTE: Make sure you check out the 5th bullet point, it’s a real gem)

> #### Hungarian Notation
> 
> Hungarian Notation is the tactical nuclear weapon of source code obfuscation techniques; use it! Due to the sheer volume of source code contaminated by this idiom nothing can kill a maintenance engineer faster than a well planned Hungarian Notation attack. The following tips will help you corrupt the original intent of Hungarian Notation: 
> 
>   * Insist on using "c" for const in C++ and other languages that directly enforce the const-ness of a variable. 
>   * Seek out and use Hungarian warts that have meaning in languages other than your current language. For example insist on the PowerBuilder "l\_" and "a\_ " {local and argument} scoping prefixes and always use the VB-esque style of having a Hungarian wart for every control type when coding to C++. Try to stay ignorant of the fact that megs of plainly visible MFC source code does not use Hungarian warts for control types. 
>   * Always violate the Hungarian principle that the most commonly used variables should carry the least extra information around with them. Achieve this end through the techniques outlined above and by insisting that each class type have a custom wart prefix. Never allow anyone to remind you that **no** wart tells you that something **is** a class. The importance of this rule cannot be overstated: if you fail to adhere to its principles the source code may become flooded with shorter variable names that have a higher vowel/consonant ratio. In the worst case scenario this can lead to a full collapse of obfuscation and the spontaneous reappearance of English Notation in code! 
>   * Flagrantly violate the Hungarian-esque concept that function parameters and other high visibility symbols must be given meaningful names, but that Hungarian type warts all by themselves make excellent temporary variable names. 
>   * Insist on carrying outright orthogonal information in your Hungarian warts. Consider this real world example: "a_crszkvc30LastNameCol". It took a team of maintenance engineers nearly 3 days to figure out that this whopper variable name described a const, reference, function argument that was holding information from a database column of type Varchar[30] named "LastName" which was part of the table’s primary key. When properly combined with the principle that "all variables should be public" this technique has the power to render thousands of lines of source code obsolete instantly! 
>   * Use to your advantage the principle that the human brain can only hold 7 pieces of information concurrently. For example code written to the above standard has the following properties: 
>       * a single assignment statement carries 14 pieces of type and name information. 
>       * a single function call that passes three parameters and assigns a result carries 29 pieces of type and name information. 
>       * Seek to improve this excellent, but far too concise, standard. Impress management and coworkers by recommending a 5 letter day of the week prefix to help isolate code written on &#8216;Monam&#8217; and &#8216;FriPM&#8217;. 
>       * It is easy to overwhelm the short term memory with even a moderately complex nesting structure, **especially** when the maintenance programmer can’t see the start and end of each block on screen simultaneously. </blockquote>