---
id: 15
title: 'Silverlight Testing &#8211; Part 1 &#8211; Testing the untested.'
date: 2008-04-21T03:49:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/04/20/silverlight-testing-part-1-testing-the-untested.aspx
permalink: /2008/04/21/silverlight-testing-part-1-testing-the-untested/
dsq_thread_id:
  - "271121538"
categories:
  - 'c#'
  - silverlight
  - testing
---
<PRE><FONT face="Arial">The Silverlight testing framework was recently released and shows some great potential for being<BR /> a first class application platform. For more information about the test framework see this post from<BR /></FONT><A href="http://www.jeff.wilcox.name/2008/03/07/silverlight-unit-testing/"><FONT face="Arial">Jeff Wilcox</FONT></A><FONT face="Arial">. </FONT></PRE>

<PRE><FONT face="Arial">To start off I choose to use a code sample that had some complexity in it.  Brad Abrams just posted <BR />a Silverlight walk </FONT><A href="http://blogs.msdn.com/brada/archive/2008/04/17/end-to-end-data-centric-application-with-silverlight-2.aspx"><FONT face="Arial">End-to-End Data Centric Application with Silverlight 2</FONT></A><FONT face="Arial">.  This seemed like a good<BR /> sample to use, since the post did not consider how to test the code.</FONT></PRE>

<PRE><FONT face="Arial"><STRONG><EM>Step 1:  Add a test project and test class. <BR /></EM></STRONG>After the installing the assemblies and project templates, add a new unit test project to the solution.<BR />Change the test class to inherit from SilverlightTest.<BR />The following code demonstrates a simple integration test.  <BR /></FONT></PRE>

<PRE><FONT face="Arial">This test does the following: </FONT></PRE>


  



  


  * <PRE><FONT face="Arial">Instantiates the page.</FONT></PRE>
    
    
  
      * <PRE><FONT face="Arial">Clears the local storage.</FONT></PRE>
        
        
  
          * <PRE><FONT face="Arial">Adds the page to the Test framework TestSurface.</FONT></PRE>
            
            
  
              * <PRE><FONT face="Arial">Enters the letter s into the text box.</FONT></PRE>
                
                
  
                  * <PRE><FONT face="Arial">Clicks the search button.</FONT></PRE>
                    
                    
  
                      * <PRE><FONT face="Arial">Verifies that 9 products are displayed in the DataGrid.</FONT></PRE>
                        
                        
  
                          * <PRE><FONT face="Arial">Removes the page from the TestSurface.</FONT></PRE></UL>
                        
                        <PRE><FONT face="Arial"><BR />Here is the code for the test class:</FONT></PRE>
                        
                        
  
                        > 
  
                        > 
                        > 
                        > <DIV class="csharpcode">
                        >   <br /> 
                        >   
                        >   <DIV class="csharpcode">
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   1:  </SPAN>    [TestClass]</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   2:  </SPAN>    <SPAN class="kwrd">public</SPAN> <SPAN class="kwrd">class</SPAN> The_data_page_should_load:SilverlightTest</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   3:  </SPAN>    {</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   4:  </SPAN>        </FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   5:  </SPAN>        [TestMethod]</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   6:  </SPAN>        <SPAN class="kwrd">public</SPAN> <SPAN class="kwrd">void</SPAN> When_searching_for_products_starting_with_s_nine_products_should_be_displayed()</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   7:  </SPAN>        {</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   8:  </SPAN>            EndToEndSilverlightDemo.Page pageUnderTest = <SPAN class="kwrd">new</SPAN> EndToEndSilverlightDemo.Page();</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">   9:  </SPAN>            IPageTestDriver testDriver = pageUnderTest;</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  10:  </SPAN>            testDriver.ClearLocalStorage();</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  11:  </SPAN>            <SPAN class="kwrd">this</SPAN>.Silverlight.TestSurface.Children.Add(pageUnderTest);</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  12:  </SPAN>            testDriver.TypeSearchPrefix(<SPAN class="str">&#8220;s&#8221;</SPAN>);</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  13:  </SPAN>            testDriver.ClickSearchButton();</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  14:  </SPAN>            Assert.AreEqual(9,testDriver.DisplayedProductRows);</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  15:  </SPAN>            <SPAN class="kwrd">this</SPAN>.Silverlight.TestSurface.Children.Remove(pageUnderTest);</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  16:  </SPAN>        }</FONT></PRE>
                        >     
                        >     <PRE><FONT color="#000000"><SPAN class="lnum">  17:  </SPAN>    }</FONT></PRE>
                        >   </DIV>
                        > </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          &nbsp;
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          Here is the Test Driver interface:
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          <br /> 
                          
                          <BLOCKQUOTE>
                            <br /> 
                            
                            <DIV class="csharpcode">
                              <PRE><SPAN class="lnum">   1:  </SPAN><SPAN class="kwrd">public</SPAN> <SPAN class="kwrd">interface</SPAN> IPageTestDriver</PRE>
                              
                              <PRE><SPAN class="lnum">   2:  </SPAN>   {</PRE>
                              
                              <PRE><SPAN class="lnum">   3:  </SPAN>       <SPAN class="kwrd">void</SPAN> TypeSearchPrefix(<SPAN class="kwrd">string</SPAN> searchPrefix);</PRE>
                              
                              <PRE><SPAN class="lnum">   4:  </SPAN>       <SPAN class="kwrd">void</SPAN> ClickSearchButton();</PRE>
                              
                              <PRE><SPAN class="lnum">   5:  </SPAN>       <SPAN class="kwrd">int</SPAN> DisplayedProductRows { get; }</PRE>
                              
                              <PRE><SPAN class="lnum">   6:  </SPAN>       <SPAN class="kwrd">void</SPAN> ClearLocalStorage();</PRE>
                              
                              <PRE><SPAN class="lnum">   7:  </SPAN>       <SPAN class="kwrd">bool</SPAN> WebserviceHasReturnedData();</PRE>
                              
                              <PRE><SPAN class="lnum">   8:  </SPAN>   }</PRE>
                            </DIV>
                          </BLOCKQUOTE>
                          
                          <PRE>Here is the portions of the Page class that implement the IPageTestDriver interface. It is a good idea to <BR />hide the complexity of the Page classes internal controls from the test class.  This is equivalent to <BR />creating a Test Fixture in other frameworks.  <BR /><BR /></PRE>
                          
                          <br /> 
                          
                          <BLOCKQUOTE>
                            <br /> 
                            
                            <DIV class="csharpcode">
                              <PRE><SPAN class="lnum">   1:  </SPAN>        <SPAN class="kwrd">void</SPAN> IPageTestDriver.TypeSearchPrefix(<SPAN class="kwrd">string</SPAN> searchPrefix)</PRE>
                              
                              <PRE><SPAN class="lnum">   2:  </SPAN>        {</PRE>
                              
                              <PRE><SPAN class="lnum">   3:  </SPAN>            <SPAN class="kwrd">this</SPAN>.txtProductString.Text = searchPrefix;</PRE>
                              
                              <PRE><SPAN class="lnum">   4:  </SPAN>        }</PRE>
                              
                              <PRE><SPAN class="lnum">   5:  </SPAN>&nbsp;</PRE>
                              
                              <PRE><SPAN class="lnum">   6:  </SPAN>        <SPAN class="kwrd">void</SPAN> IPageTestDriver.ClickSearchButton()</PRE>
                              
                              <PRE><SPAN class="lnum">   7:  </SPAN>        {</PRE>
                              
                              <PRE><SPAN class="lnum">   8:  </SPAN>            <SPAN class="kwrd">this</SPAN>.Button_Click(<SPAN class="kwrd">this</SPAN>.btnOne,<SPAN class="kwrd">null</SPAN>);</PRE>
                              
                              <PRE><SPAN class="lnum">   9:  </SPAN>        }</PRE>
                              
                              <PRE><SPAN class="lnum">  10:  </SPAN>&nbsp;</PRE>
                              
                              <PRE><SPAN class="lnum">  11:  </SPAN>        <SPAN class="kwrd">int</SPAN> IPageTestDriver.DisplayedProductRows</PRE>
                              
                              <PRE><SPAN class="lnum">  12:  </SPAN>        {</PRE>
                              
                              <PRE><SPAN class="lnum">  13:  </SPAN>            get { <SPAN class="kwrd">return</SPAN> (<SPAN class="kwrd">new</SPAN> List&lt;<SPAN class="kwrd">object</SPAN>&gt;((IEnumerable&lt;<SPAN class="kwrd">object</SPAN>&gt;) <SPAN class="kwrd">this</SPAN>.dataGridResults.ItemsSource)).Count; }</PRE>
                              
                              <PRE><SPAN class="lnum">  14:  </SPAN>        }</PRE>
                              
                              <PRE><SPAN class="lnum">  15:  </SPAN>&nbsp;</PRE>
                              
                              <PRE><SPAN class="lnum">  16:  </SPAN>        <SPAN class="kwrd">void</SPAN> IPageTestDriver.ClearLocalStorage()</PRE>
                              
                              <PRE><SPAN class="lnum">  17:  </SPAN>        {</PRE>
                              
                              <PRE><SPAN class="lnum">  18:  </SPAN>            settings.Clear();</PRE>
                              
                              <PRE><SPAN class="lnum">  19:  </SPAN>            settings.Save();</PRE>
                              
                              <PRE><SPAN class="lnum">  20:  </SPAN>            dataGridResults.ItemsSource = <SPAN class="kwrd">null</SPAN>;</PRE>
                              
                              <PRE><SPAN class="lnum">  21:  </SPAN>        }</PRE>
                              
                              <PRE><SPAN class="lnum">  22:  </SPAN>&nbsp;</PRE>
                              
                              <PRE><SPAN class="lnum">  23:  </SPAN>        <SPAN class="kwrd">bool</SPAN> IPageTestDriver.WebserviceHasReturnedData()</PRE>
                              
                              <PRE><SPAN class="lnum">  24:  </SPAN>        {</PRE>
                              
                              <PRE><SPAN class="lnum">  25:  </SPAN>            <SPAN class="kwrd">return</SPAN> dataGridResults.ItemsSource != <SPAN class="kwrd">null</SPAN>;</PRE>
                              
                              <PRE><SPAN class="lnum">  26:  </SPAN>        }</PRE>
                              
                              <PRE><SPAN class="lnum">  27:  </SPAN>    }</PRE>
                            </DIV>
                          </BLOCKQUOTE>&nbsp;
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          Now run the test and everything is good right?&nbsp; Not so.&nbsp; But why is that?<BR />
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          <BR /><A title="sl-test-failed" href="http://www.flickr.com/photos/45074821@N00/2430481984/"><IMG height="396" alt="sl-test-failed" src="http://static.flickr.com/3223/2430481984_1997e3ac7e.jpg" width="318" border="0" /></A>
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          <BR />The test has failed because the application is making an Asynchronous call to the web service.&nbsp; This means <BR />our test runs and completes before the remote call to return data can complete and load the data into the data grid.
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          &nbsp;
                        </DIV>
                        
                        
  
                        ### Solution:&nbsp; Use the Asynchronous features of the test framework.
                        
                        
  
                        <DIV class="csharpcode">
                          The framework provides the functionality to be able to drive unit tests in an async fashion.&nbsp; This allows the <BR />test to run and wait for a condition to be met before proceeding.&nbsp; In this case on line 10 the EnqueueConditional<BR />call waits until the helper method returns true before the test proceeds with the next call.
                        </DIV>
                        
                        
  
                        > 
  
                        > 
                        > 
                        > <DIV class="csharpcode">
                        >   <PRE><SPAN class="lnum">   1:  </SPAN>        [TestMethod,Asynchronous]</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   2:  </SPAN>        <SPAN class="kwrd">public</SPAN> <SPAN class="kwrd">void</SPAN> When_searching_for_products_starting_with_s_nine_products_should_be_displayed_async()</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   3:  </SPAN>        {</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   4:  </SPAN>            EndToEndSilverlightDemo.Page pageUnderTest = <SPAN class="kwrd">new</SPAN> EndToEndSilverlightDemo.Page();</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   5:  </SPAN>            IPageTestDriver testDriver = pageUnderTest;</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   6:  </SPAN>            testDriver.ClearLocalStorage();</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   7:  </SPAN>            <SPAN class="kwrd">this</SPAN>.Silverlight.TestSurface.Children.Add(pageUnderTest);</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   8:  </SPAN>            EnqueueCallback(() =&gt; testDriver.TypeSearchPrefix(<SPAN class="str">&#8220;s&#8221;</SPAN>));</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">   9:  </SPAN>            EnqueueCallback(() =&gt; testDriver.ClickSearchButton());</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">  10:  </SPAN>            EnqueueConditional(testDriver.WebserviceHasReturnedData);</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">  11:  </SPAN>            EnqueueCallback(() =&gt; Assert.AreEqual(9, testDriver.DisplayedProductRows));</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">  12:  </SPAN>            EnqueueCallback(() =&gt; <SPAN class="kwrd">this</SPAN>.Silverlight.TestSurface.Children.Remove(pageUnderTest));</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">  13:  </SPAN>            EnqueueTestComplete();</PRE>
                        >   
                        >   <PRE><SPAN class="lnum">  14:  </SPAN>        }</PRE>
                        > </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          &nbsp;
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          And the results?&#8230;.<BR />
                        </DIV>
                        
                        
  
                        <DIV class="csharpcode">
                          <A title="sl-test-passed" href="http://www.flickr.com/photos/45074821@N00/2429689269/"><IMG alt="sl-test-passed" src="http://static.flickr.com/2187/2429689269_cd56db94ae.jpg" border="0" /></A>
                        </DIV>
                        
                        [](http://11011.net/software/vspaste)
  
                        The test passes and verifies the full remote call to the web service as well as getting the data back into the user interface.   
                        Pretty cool?&nbsp; This sample demonstrates that it is possible to test drive the user interface.&nbsp; The code to do so is far from   
                        being readable and comprehendible.&nbsp; The next post in this series will address the readability of the testing code and put a   
                        fluent interface around the ugly Enqueue method calls.&nbsp; 
                        
                        
  
                        &nbsp;
                        
                        
  
                        The source code for this sample is available here; <http://erichexter.googlecode.com/svn/trunk/EndToEndSilverlightDemo/EndToEndSilverlightDemo/>&nbsp;
                        
                        
  
                        [](http://11011.net/software/vspaste)</p>