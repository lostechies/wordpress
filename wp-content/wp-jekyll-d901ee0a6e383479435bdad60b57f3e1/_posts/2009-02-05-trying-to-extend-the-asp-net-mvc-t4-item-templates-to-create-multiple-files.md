---
id: 25
title: Trying to extend the Asp.Net MVC (T4) item templates to create multiple files.
date: 2009-02-05T14:00:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2009/02/05/trying-to-extend-the-asp-net-mvc-t4-item-templates-to-create-multiple-files.aspx
permalink: /2009/02/05/trying-to-extend-the-asp-net-mvc-t4-item-templates-to-create-multiple-files/
dsq_thread_id:
  - "265633040"
categories:
  - .Net
  - agile
  - Asp.Net MVC
  - 'c#'
  - mvc
  - testing
  - Tools
---
&nbsp;

One of the features I was really excited about for the MVC RC was the template/Model based scaffolding support in the Add View and Add Controller menu options inside of visual studio.&nbsp; I think that they have made a great first version effort that will be light years ahead of other Microsoft web technologies.&nbsp;&nbsp; (<a target="_blank" href="http://weblogs.asp.net/scottgu/archive/2009/01/27/asp-net-mvc-1-0-release-candidate-now-available.aspx">For more details see ScottGu&rsquo;s post.</a>)

&nbsp;

Here is the walkthrough of the Add controller feature.&nbsp; Click Add &ndash; > Controller.. &ndash;> Type in a Name and optionally select the Add action methods.

<table border="0" width="500" cellpadding="2" cellspacing="0">
  <tr>
    <td width="250" valign="top">
      <img src="http://www.scottgu.com/blogposts/mvcrc/mvcrc/step1.png" />
    </td>
    
    <td width="250" valign="top">
      <img src="http://www.scottgu.com/blogposts/mvcrc/mvcrc/step2.png" />
    </td>
  </tr>
</table>

&nbsp; This technology works by using T4 (<a target="_blank" href="http://www.olegsych.com/2007/12/text-template-transformation-toolkit/">Text Template Transformation Toolkit</a>) it is a technology that feels a lot like asp.net markup.&nbsp; So someone who is familiar with MVC should fee right at home.&nbsp; 

The real bang for your buck with this type of templates is to do the right thing and force the developer into the <a target="_blank" href="http://blogs.msdn.com/brada/archive/2003/10/02/50420.aspx">Pit of Success</a> .&nbsp; In terms of a Controller template the pit of success would mean.&nbsp; For a Data Edit / CRUD scenario doing the following:

  * Create a Model for what your controller displays and acts upon first. 
  * Create a Controller that knows about that model.. The model should be posted to the Save Method and potentially other methods as well. 
  * Creating the unit test class and have full test coverage over the controller that was just &ldquo;created&rdquo;.&nbsp; This is huge for me.&nbsp; With all the industry and the Microsoft community has learned about the value of unit tests, why would we want to generate code and not provide the testing of that code as well.&nbsp; How will we know that a change in the code did not cause other unintentional behavior? 
  * The views that use this model for each of the actions should be created as well. 

This is what the pit of success looks like to me.&nbsp; So how do we go about doing that.?

The first challenge is to create more than one file out of the template.&nbsp; I spiked out this in the following <a target="_blank" href="http://code.google.com/p/codecampserver/source/browse/trunk/src/UI/CodeTemplates/AddController/Controller.tt?spec=svn644&r=644">sample</a> from the <a target="_blank" href="http://codecampserver.org">Code Camp Server</a> project.

<textarea name="code"><#@ template language=&#8221;C#&#8221; HostSpecific=&#8221;True&#8221; debug=&#8221;true&#8221; #><br /> <#@ output extension=&#8221;cs&#8221; #><br /> <#@ assembly name=&#8221;System.Windows.Forms&#8221; #><br /> <#@ assembly name=&#8221;EnvDTE&#8221; #><br /> <#@ import namespace=&#8221;System.IO&#8221; #><br /> <# MvcTextTemplateHost mvcHost = (MvcTextTemplateHost)(Host);<br /> Microsoft.VisualStudio.TextTemplating.ITextTemplatingEngineHost host = (Microsoft.VisualStudio.TextTemplating.ITextTemplatingEngineHost)(Host);<br /> string templateDirectory = Path.GetDirectoryName(host.TemplateFile); #> <# WriteUnitTest(mvcHost);<br /> string fileName = String.Format(@&#8221;&#8230;&#8230;UnitTestsUIControllers{0}Tester.cs&#8221;, mvcHost.ItemName);<br /> string filePath = Path.Combine(templateDirectory ,fileName);<br /> File.WriteAllText(filePath , this.GenerationEnvironment.ToString());<br /> this.GenerationEnvironment.Remove(0, this.GenerationEnvironment.Length);<br /> #><br /> </textarea>

What this code does is runs through a method to generate the markup for the unit test, writes it to a file and than clears out the output of the unit test and allows the creation of the Controller to continue as normal.

This seems like a great solution until you look the unit test project and see that the unit test file is missing.&nbsp; It is not missing, but rather the file was not added to the Unit Test project.&nbsp; If you click on show all files you can see the file in the solution browser and see that it is not part of the project but it is in the correct space on the disk drive.&nbsp; The only way I know of overcoming this problem is to get a reference to the Visual Studio automation object.&nbsp; EnvDTE, than using that object we could add code to the template that could rectify this problem. Looking around the web this problem seemed to be solved, the visual studio T4 host automatically sends itself as the host to the T4 template. The problem with the MVC Template is that the host that is running the template is a custom host that was implemented just for the mvc project and they did not provide a mechanism for accessing the current DTE object.&nbsp; This leave me at a place where the solution ends and it is not complete.&nbsp; This method can be used to create views as well, but I do not see a lot of value for the following reasons.

  * The files cannot be added to the project so creating more files through this method actually adds more mouse clicks to show the hidden files and than including them in the projects.
  * The current MVC template host does not allow the <a target="_blank" href="http://www.olegsych.com/2008/02/t4-include-directive/">include directive</a> which would allow for more maintainable solution and have a one template file per project file created.
  * We could do more with the Add View scenario as well, but realistically the same limitations are in place so we cannot chain the creation of multiple views.&nbsp; Which would really increase productivity.

These are deal breakers for me.&nbsp; I wish this solution could work but it is half baked at this point.&nbsp; 

##### Closing Words

While I think the MVC Tooling team has actually lead the Visual Studio team with some innovations that really focus on improving productivity rather than putting all of their effort into the File New Project wizard, they still have a lot to do. I believe the Pit of Success for he creation of crud type operations in the MVC platform would force a developer to create a Model first.&nbsp; Than the rewards for this would be giving a way to have some customizable templates that can take away the 80% of the&nbsp; grudge work that is in visual studio for creating files and stubbing out code that can be easily inferred from a Model object. 

Where do we go next&hellip;?&nbsp; I am prototyping a scaffolding generator that will support the Pit of Success , more to come on this soon.. Here is what an example template would look like.&nbsp; [<span style="text-decoration: underline"><span style="color: #000080">http://code.google.com/p/codecampserver/source/browse/trunk/src/UI/CodeTemplates/Crud+Controller/View-Edit.tt?spec=svn647&r=647</span></span>](http://code.google.com/p/codecampserver/source/browse/trunk/src/UI/CodeTemplates/Crud+Controller/View-Edit.tt?spec=svn647&r=647) More samples are <a target="_blank" href="http://code.google.com/p/codecampserver/source/detail?r=647">here</a>.