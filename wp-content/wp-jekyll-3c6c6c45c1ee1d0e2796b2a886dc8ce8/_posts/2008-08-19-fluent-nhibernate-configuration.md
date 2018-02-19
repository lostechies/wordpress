---
id: 81
title: 'Fluent NHibernate &#8211; Configuration'
date: 2008-08-19T00:02:33+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/18/fluent-nhibernate-configuration.aspx
permalink: /2008/08/19/fluent-nhibernate-configuration/
dsq_thread_id:
  - "262113994"
categories:
  - Fluent NHibernate
---
Used NHibernate?&nbsp; Had to use the XML configuration (hibernate.cfg.xml)?&nbsp; Remember this?

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">&lt;?</span><span class="html">xml</span> <span class="attr">version</span><span class="kwrd">="1.0"</span> ?<span class="kwrd">&gt;</span>
<span class="kwrd">&lt;</span><span class="html">hibernate-configuration</span> <span class="attr">xmlns</span><span class="kwrd">="urn:nhibernate-configuration-2.2"</span> <span class="kwrd">&gt;</span>
    <span class="kwrd">&lt;</span><span class="html">session-factory</span><span class="kwrd">&gt;</span>
        <span class="kwrd">&lt;</span><span class="html">property</span> <span class="attr">name</span><span class="kwrd">="connection.provider"</span><span class="kwrd">&gt;</span>NHibernate.Connection.DriverConnectionProvider<span class="kwrd">&lt;/</span><span class="html">property</span><span class="kwrd">&gt;</span>
        <span class="kwrd">&lt;</span><span class="html">property</span> <span class="attr">name</span><span class="kwrd">="dialect"</span><span class="kwrd">&gt;</span>NHibernate.Dialect.MsSql2005Dialect<span class="kwrd">&lt;/</span><span class="html">property</span><span class="kwrd">&gt;</span>
        <span class="kwrd">&lt;</span><span class="html">property</span> <span class="attr">name</span><span class="kwrd">="connection.driver_class"</span><span class="kwrd">&gt;</span>NHibernate.Driver.SqlClientDriver<span class="kwrd">&lt;/</span><span class="html">property</span><span class="kwrd">&gt;</span>
        <span class="kwrd">&lt;</span><span class="html">property</span> <span class="attr">name</span><span class="kwrd">="connection.connection_string"</span><span class="kwrd">&gt;</span>Server=(local);Initial Catalog=dbname;User Id=user;Password=********<span class="kwrd">&lt;/</span><span class="html">property</span><span class="kwrd">&gt;</span>
    <span class="kwrd">&lt;/</span><span class="html">session-factory</span><span class="kwrd">&gt;</span>
<span class="kwrd">&lt;/</span><span class="html">hibernate-configuration</span><span class="kwrd">&gt;</span></pre>
</div>

Or maybe you write code like this:

<div class="csharpcode-wrapper">
  <pre>IDictionary&lt;<span class="kwrd">string</span>, <span class="kwrd">string</span>&gt; props = <span class="kwrd">new</span> Dictionary&lt;<span class="kwrd">string</span>, <span class="kwrd">string</span>&gt;();
String connectionString = <span class="str">"Server=server;Database=dbName;User ID=user;Password=passwd"</span>;
props.Add(<span class="str">"hibernate.dialect"</span>, <span class="str">"NHibernate.Dialect.MySQLDialect"</span>);
props.Add(<span class="str">"hibernate.connection.provider"</span>, <span class="str">"NHibernate.Connection.DriverConnectionProvider"</span>);
props.Add(<span class="str">"hibernate.connection.driver_class"</span>, <span class="str">"NHibernate.Driver.MySqlDataDriver"</span>);
props.Add(<span class="str">"hibernate.connection.connection_string"</span>, connectionString);
config.AddProperties(props);</pre>
</div>

&nbsp;

What if you could do this, instead?

<div class="csharpcode-wrapper">
  <pre>MsSqlConfiguration
   .MsSql2005
   .ConnectionString.Is(<span class="str">"Server=(local);Database=dbname;uid=user;pwd=password"</span>);
   .Configure( nhibConfig );</pre>
</div>

Hint: It&#8217;s already in the [FluentNHibernate](http://code.google.com/p/fluent-nhibernate/) trunk!

(At the time of this writing, we have MsSql, SQLite and PostgreSQL. It&#8217;s easy to add new configs, so we&#8217;ll be adding support for all the ones that NHibernate supports out of the box in the upcoming weeks).

-Chad