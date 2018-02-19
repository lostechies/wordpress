---
id: 6
title: 'Using DB4Objects as a prototyping tool.  Part I'
date: 2008-02-26T19:16:00+00:00
author: Eric Hexter
layout: post
guid: /blogs/hex/archive/2008/02/26/using-db4objects-as-a-prototyping-tool-part-i.aspx
permalink: /2008/02/26/using-db4objects-as-a-prototyping-tool-part-i/
dsq_thread_id:
  - "264345380"
categories:
  - 'c#'
  - DB4O
---
I have been looking at DB4Objects [http://db4objects.com](http://db4objects.com/) as a persistence layer that could help with prototyping work. If you are not familiar with db4objects ( DB4O ), it is an object oriented database.&nbsp; What does that mean?&nbsp; If I boil it down in laymen&#8217;s terms : it is a database without tables or columns. 


  


&nbsp;**Sample of DB4Objects**


  


Here is a sample of storing a simple domain object:


  


<DIV>
  <br /> 
  
  <DIV class="csharpcode">
    <br /> 
    
    <DIV>
      <br /> 
      
      <DIV>
        <PRE><SPAN>   1:</SPAN> User  user = <SPAN>new</SPAN> User {Username = <SPAN>&#8220;testuser&#8221;</SPAN>, Password = <SPAN>&#8220;password&#8221;</SPAN>};</PRE>
        
        <PRE><SPAN>   2:</SPAN> user.Roles = <SPAN>new</SPAN> List&lt;Role&gt; {<SPAN>new</SPAN> Role {RoleType = UserRepositoryTester.RoleType.User}};</PRE>
        
        <PRE><SPAN>   3:</SPAN> <SPAN>using</SPAN>( IObjectContainer objectContainer = PersistanceContainerFactory.Create())</PRE>
        
        <PRE><SPAN>   4:</SPAN> {</PRE>
        
        <PRE><SPAN>   5:</SPAN>     objectContainer.Store(user);</PRE>
        
        <PRE><SPAN>   6:</SPAN> }</PRE>
      </DIV>
    </DIV>
  </DIV>
  
  <br /> 
  
  <P class="csharpcode">
    The magic sauce is in line 5. I did not have to do anything to setup how to save a User object in the database.&nbsp; It just serializes the object to the database. No need to worry about table names, column names or data types. This all comes for free with this engine, allowing a developer to focus on the domain model and the value-add code, rather than data persistence.
  </P>
  
  <br /> 
  
  <P class="csharpcode">
    <STRONG>Why use it for prototypes?</STRONG>
  </P>
  
  <br /> 
  
  <P class="csharpcode">
    My thought here is this.&nbsp; The sooner that I can deliver software, the sooner I can start getting to the actual requirements of what it needs to do. My experience is that once the designers and/or product owners see software in working form, they get inspired to really work on making the most of the application. This could be from a User eXperience perspective or sometimes it is just a realization that they did not know what they needed until they saw it in executable form. It really does not matter why they want to make a change. If the end product of a change is better software, than that is a good thing.&nbsp; To help facilitate getting to software that can be demonstrated, I think that using a persistence engine like DB4O could really help with the time to delivery.&nbsp; Once the changes/churn has slowed down, than you can take the time to implement the persistence layer. I think writing business logic rather than persistence code that will be changed later, is the best use of developers time.
  </P>
  
  <br /> 
  
  <P class="csharpcode">
    <STRONG>There are some Caveats</STRONG>
  </P>
  
  <br /> 
  
  <DIV class="csharpcode">
    <br /> 
    
    <UL>
      <br /> 
      
      <LI>
        First and foremost using infrastructure technology like DB4O has to be used in a manor that promotes Separation Of Concerns from a dependency and design point of view.<br /> <LI>
          You need to use the least common denominators as far as functionality, between the prototyping framework and the production persistence framework.<BR />&nbsp;
        </LI></UL></DIV>
        <br /> <P>
          <STRONG>A working sample</STRONG>
        </P>
        
        <PRE>The following sample code is available at <A href="http://erichexter.googlecode.com/svn/trunk/DB4O-sample/">http://erichexter.googlecode.com/svn/trunk/DB4O-sample/</A></PRE>
        
        <PRE>&nbsp;</PRE>
        
        <PRE>So to keep with test first development, lets look at the tests:</PRE>
        
        <br /> <DIV>
          <br /> 
          
          <DIV>
            <PRE><SPAN>   1:</SPAN> [TestFixture]</PRE>
            
            <PRE><SPAN>   2:</SPAN> <SPAN>public</SPAN> <SPAN>class</SPAN> Given_that_a_user_exist_in_repository:Db4oBaseTester</PRE>
            
            <PRE><SPAN>   3:</SPAN> {</PRE>
            
            <PRE><SPAN>   4:</SPAN>     <SPAN>private</SPAN> IUserRepository repository;</PRE>
            
            <PRE><SPAN>   5:</SPAN>     <SPAN>private</SPAN> User user;</PRE>
            
            <PRE><SPAN>   6:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>   7:</SPAN>     <SPAN>protected</SPAN> <SPAN>override</SPAN> <SPAN>void</SPAN>  OnStartup()</PRE>
            
            <PRE><SPAN>   8:</SPAN>     {</PRE>
            
            <PRE><SPAN>   9:</SPAN>         repository = <SPAN>new</SPAN> UserRepository(objectContainer);</PRE>
            
            <PRE><SPAN>  10:</SPAN>         user = <SPAN>new</SPAN> User {Username = <SPAN>&#8220;testuser&#8221;</SPAN>, Password = <SPAN>&#8220;password&#8221;</SPAN>};</PRE>
            
            <PRE><SPAN>  11:</SPAN>         user.Roles = <SPAN>new</SPAN> List&lt;Role&gt; {<SPAN>new</SPAN> Role {RoleType = UserRepositoryTester.RoleType.User}};</PRE>
            
            <PRE><SPAN>  12:</SPAN>         objectContainer.Store(user);</PRE>
            
            <PRE><SPAN>  13:</SPAN>     }</PRE>
            
            <PRE><SPAN>  14:</SPAN>     [Test]</PRE>
            
            <PRE><SPAN>  15:</SPAN>     <SPAN>public</SPAN> <SPAN>void</SPAN> When_a_linq_query_is_executed_the_user_should_be_returned()</PRE>
            
            <PRE><SPAN>  16:</SPAN>     {</PRE>
            
            <PRE><SPAN>  17:</SPAN>         IEnumerable&lt;User&gt; users = from User u <SPAN>in</SPAN> repository.Query()</PRE>
            
            <PRE><SPAN>  18:</SPAN>                                   <SPAN>where</SPAN> u.Username.Equals(<SPAN>&#8220;testuser&#8221;</SPAN>) && u.Roles.Count == 1</PRE>
            
            <PRE><SPAN>  19:</SPAN>                                   select u;</PRE>
            
            <PRE><SPAN>  20:</SPAN>         IList&lt;User&gt; userList = <SPAN>new</SPAN> List&lt;User&gt;(users);</PRE>
            
            <PRE><SPAN>  21:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  22:</SPAN>         Assert.That(userList.Count, Is.EqualTo(1));</PRE>
            
            <PRE><SPAN>  23:</SPAN>     }</PRE>
            
            <PRE><SPAN>  24:</SPAN>     [Test]</PRE>
            
            <PRE><SPAN>  25:</SPAN>     <SPAN>public</SPAN> <SPAN>void</SPAN> When_a_user_is_deleted_the_user_should_be_removed_from_the_repository()</PRE>
            
            <PRE><SPAN>  26:</SPAN>     {</PRE>
            
            <PRE><SPAN>  27:</SPAN>         repository.Delete(user);</PRE>
            
            <PRE><SPAN>  28:</SPAN>         </PRE>
            
            <PRE><SPAN>  29:</SPAN>         IObjectSet retrievedUser = objectContainer.QueryByExample(user);</PRE>
            
            <PRE><SPAN>  30:</SPAN>         Assert.That(retrievedUser.Count, Is.EqualTo(0));</PRE>
            
            <PRE><SPAN>  31:</SPAN>     }</PRE>
            
            <PRE><SPAN>  32:</SPAN>     [Test]</PRE>
            
            <PRE><SPAN>  33:</SPAN>     <SPAN>public</SPAN> <SPAN>void</SPAN> When_a_username_is_supplied_the_repository_should_return_the_user()</PRE>
            
            <PRE><SPAN>  34:</SPAN>     {</PRE>
            
            <PRE><SPAN>  35:</SPAN>         User retrivedUser = repository.Get(user.Username);</PRE>
            
            <PRE><SPAN>  36:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  37:</SPAN>         Assert.That(user,Is.EqualTo(retrivedUser));</PRE>
            
            <PRE><SPAN>  38:</SPAN>     }</PRE>
            
            <PRE><SPAN>  39:</SPAN>     [Test]</PRE>
            
            <PRE><SPAN>  40:</SPAN>     <SPAN>public</SPAN> <SPAN>void</SPAN> When_the_user_object_is_changed_the_repository_should_save_the_changes()</PRE>
            
            <PRE><SPAN>  41:</SPAN>     {</PRE>
            
            <PRE><SPAN>  42:</SPAN>         user.Username += <SPAN>&#8220;1&#8243;</SPAN>;</PRE>
            
            <PRE><SPAN>  43:</SPAN>         repository.Save(user);</PRE>
            
            <PRE><SPAN>  44:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  45:</SPAN>         User retrievedUser = (User) objectContainer.QueryByExample(<SPAN>new</SPAN> User() {Username = user.Username})[0];</PRE>
            
            <PRE><SPAN>  46:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  47:</SPAN>         Assert.That(user, Is.EqualTo(retrievedUser));</PRE>
            
            <PRE><SPAN>  48:</SPAN>     }</PRE>
            
            <PRE><SPAN>  49:</SPAN>     <SPAN>protected</SPAN> <SPAN>override</SPAN> <SPAN>void</SPAN> OnTearDown()</PRE>
            
            <PRE><SPAN>  50:</SPAN>     {</PRE>
            
            <PRE><SPAN>  51:</SPAN>         objectContainer.Delete(user);</PRE>
            
            <PRE><SPAN>  52:</SPAN>     }</PRE>
            
            <PRE><SPAN>  53:</SPAN> }</PRE>
          </DIV>
        </DIV>
        
        <PRE>Here I have implemented some basic functionality of a persistence engine.  My goal was to provide an interface which </PRE>
        
        <PRE>could be used to deliver the bare minimum persistence layer so that I can concentrate on user defined features.  </PRE>
        
        <PRE>Here is the implementation using DB4Objects.  The IObjectContainer is a DB4o interface which is returned when you open up a new db4o database.</PRE>
        
        <PRE>&nbsp;</PRE>
        
        <br /> <DIV>
          <br /> 
          
          <DIV>
            <PRE><SPAN>   1:</SPAN> <SPAN>public</SPAN> <SPAN>class</SPAN> UserRepository : IUserRepository, IDisposable</PRE>
            
            <PRE><SPAN>   2:</SPAN> {</PRE>
            
            <PRE><SPAN>   3:</SPAN>     <SPAN>private</SPAN> <SPAN>readonly</SPAN> IObjectContainer objectContainer;</PRE>
            
            <PRE><SPAN>   4:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>   5:</SPAN>     <SPAN>public</SPAN> UserRepository(IObjectContainer ObjectContainer)</PRE>
            
            <PRE><SPAN>   6:</SPAN>     {</PRE>
            
            <PRE><SPAN>   7:</SPAN>         objectContainer = ObjectContainer;</PRE>
            
            <PRE><SPAN>   8:</SPAN>     }</PRE>
            
            <PRE><SPAN>   9:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  10:</SPAN>     <SPAN>public</SPAN> <SPAN>void</SPAN> Dispose()</PRE>
            
            <PRE><SPAN>  11:</SPAN>     {</PRE>
            
            <PRE><SPAN>  12:</SPAN>         objectContainer.Close();</PRE>
            
            <PRE><SPAN>  13:</SPAN>         objectContainer.Dispose();</PRE>
            
            <PRE><SPAN>  14:</SPAN>     }</PRE>
            
            <PRE><SPAN>  15:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  16:</SPAN>     <SPAN>public</SPAN> <SPAN>void</SPAN> Save(User user)</PRE>
            
            <PRE><SPAN>  17:</SPAN>     {       </PRE>
            
            <PRE><SPAN>  18:</SPAN>         objectContainer.Store(user);        </PRE>
            
            <PRE><SPAN>  19:</SPAN>     }</PRE>
            
            <PRE><SPAN>  20:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  21:</SPAN>     <SPAN>public</SPAN> User Get(<SPAN>string</SPAN> ID)</PRE>
            
            <PRE><SPAN>  22:</SPAN>     {</PRE>
            
            <PRE><SPAN>  23:</SPAN>         <SPAN>return</SPAN> GetByUsername(ID);</PRE>
            
            <PRE><SPAN>  24:</SPAN>     }</PRE>
            
            <PRE><SPAN>  25:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  26:</SPAN>     <SPAN>public</SPAN> IEnumerable&lt;User&gt; Query()</PRE>
            
            <PRE><SPAN>  27:</SPAN>     {</PRE>
            
            <PRE><SPAN>  28:</SPAN>         <SPAN>return</SPAN> objectContainer.Cast&lt;User&gt;();</PRE>
            
            <PRE><SPAN>  29:</SPAN>     }</PRE>
            
            <PRE><SPAN>  30:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  31:</SPAN>     <SPAN>public</SPAN> <SPAN>void</SPAN> Delete(User user)</PRE>
            
            <PRE><SPAN>  32:</SPAN>     {</PRE>
            
            <PRE><SPAN>  33:</SPAN>         objectContainer.Delete(user);</PRE>
            
            <PRE><SPAN>  34:</SPAN>     }</PRE>
            
            <PRE><SPAN>  35:</SPAN>&nbsp; </PRE>
            
            <PRE><SPAN>  36:</SPAN>     <SPAN>public</SPAN> User GetByUsername(<SPAN>string</SPAN> username)</PRE>
            
            <PRE><SPAN>  37:</SPAN>     {</PRE>
            
            <PRE><SPAN>  38:</SPAN>         IObjectSet set = objectContainer.QueryByExample(<SPAN>new</SPAN> User() {Username = username});</PRE>
            
            <PRE><SPAN>  39:</SPAN>         <SPAN>if</SPAN> (set.Count &gt;= 1)</PRE>
            
            <PRE><SPAN>  40:</SPAN>             <SPAN>return</SPAN> set[0] <SPAN>as</SPAN> User;</PRE>
            
            <PRE><SPAN>  41:</SPAN>         <SPAN>else</SPAN></PRE>
            
            <PRE><SPAN>  42:</SPAN>             <SPAN>return</SPAN> <SPAN>null</SPAN>;</PRE>
            
            <PRE><SPAN>  43:</SPAN>     }</PRE>
            
            <PRE><SPAN>  44:</SPAN> }</PRE>
          </DIV>
        </DIV></DIV>
        
        <br /> <P>
          &nbsp;
        </P>
        
        <br /> <P>
          <STRONG>Its all in the LINQ</STRONG>
        </P>
        
        <br /> <P>
          The biggest challenge to using one persistence framework for prototyping and another for production code boils down to the ability to query the objects being persisted.&nbsp; That makes me think that without .Net 3.5 and the LINQ features of the languages than too much time would be spent developing a persistence independent querying /criteria domain model to get any real advantages as far as developer productivity.&nbsp; I believe that the real power comes in by using LINQ to query your objects in your service layer when it uses the repositories. This separation really forces the persistence layer to deal specifically with persistence&nbsp; work and infrastructure optimizations.&nbsp; The bigger benefit (than separation of infrastructure concerns)&nbsp; is that the querying criteria can be moved into a service layer that deals specifically with logic around selecting the appropriate objects or projections. I think LINQ addresses the caveat of the Least Common Denominator for querying syntax. This is a huge win in developer productivity (once you get your head around linq)
        </P>
        
        <br /> <P>
          <STRONG>Where do we go next?</STRONG>
        </P>
        
        <br /> <P>
          The next step is to implement a UserRepository which would be acceptable for production. I am not suggesting that DB4O cannot be used in production, but in my world of ecommerce, our operations team is willing to support SQL Server, end of conversation. So I need to focus on that requirement for production ready code. We will look at developing a persistence layer for production in <EM><STRONG>Part II</STRONG></EM> of this series.
        </P></p>