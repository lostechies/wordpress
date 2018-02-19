---
id: 52
title: MassTransit Now Speaks XML By Default
date: 2009-05-27T14:12:00+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/05/27/masstransit-now-speaks-xml-by-default.aspx
permalink: /2009/05/27/masstransit-now-speaks-xml-by-default/
dsq_thread_id:
  - "262089338"
categories:
  - .net
  - masstransit
  - msmq
---
**Last night, I made a major update to the trunk of MassTransit that changes the default message format from binary to XML.** 

Since the first drop of [MassTransit](http://code.google.com/p/masstransit/), the default format for messages was _binary_. This had several advantages, one being the ability to take any object and just use it as a message. The BinaryFormatter in .NET is pretty hard core about making sure that the object will come out the other end without any changes. The disadvantage of using binary as a message format is it makes it very difficult to interoperate with other systems. For this reason, we are embracing XML as the new default message format. 

The road to XML was not easy. Many months ago when we opened up the endpoints to a configurable serialization format, we ran into some issues with our first attempt at XML. We used the .NET XmlSerializer at first, and found it to be too limited to meet our needs. There was no support for serializing dictionaries (which I would call a smell in your message contract anyway), and you had to register the type of every object being serialized in advance in order for it work properly. With all these problems, we continued to keep binary as the default with XML being experimental. 

I started writing a new XML serializer from the ground up nearly a year ago. I went through a lot of approaches and just didn&#8217;t find something that I liked using .NET 2.0 as the framework. I looked at a more Google Protocol Buffers technique for a while, but found it a little cumbersome to deal with compared to just using XML. Then, a month or two ago, I started to seriously look at how we could do a solid XML serialization attempt again using the .NET 3.5 framework features. From that research, the current default XML serializer was founded. 

Like many ORMs such as NHibernate, the use of the XML message serializer requires that the objects being serialized have a no-argument constructor. It can be protected to hide it from developers, but it must exist. Also, only properties are serialized as they represent the public contract that the message object is sharing. And the properties must be read/write so that the serializer can get and set the value of the property. Here is an example of one of our messages: 

<pre>public class NewUserRegistered : 
	CorrelatedBy&lt; Guid &gt;
{
	public Guid CorrelationId { get; set; }
	public string Username { get; set; }
	public string Email { get; set; }
	public DateTime RegisteredAt { get; set; }
}
</pre>

Since messages are DTOs (data transfer objects), I try to keep them clean and simple. They are pure data containers and are not meant to have any behavior associated with them. While I treat my messages as immutable, I don&#8217;t find I need to express that in the message class itself since it just tends to make the object more confusing. And quite honestly, there are better ways to express immutable message contracts, such as using interfaces. 

The resulting XML for the above message looks like: 

<pre>&lt;?xml encoding="utf-8" version="1.0"?&gt;
&lt;x:XmlMessageEnvelope 
	xmlns:x="MassTransit.Serialization.XmlMessageEnvelope, MassTransit"
	xmlns:m="MassTransit.Tests.Serialization.NewUserRegistered, MassTransit.Tests" 
	xmlns:s="System.String, mscorlib" 
	xmlns:d="System.DateTime, mscorlib" 
	xmlns:g="System.Guid, mscorlib" 
	xmlns:i="System.Int32, mscorlib"&gt;
  &lt;m:Message&gt;
    &lt;s:Username&gt;billg&lt;/s:Username&gt;
    &lt;s:Email&gt;billg@microsoft.com&lt;/s:Email&gt;
    &lt;d:RegisteredAt &gt;2009-05-27T13:50:21.106875Z&lt;/d:RegisteredAt&gt;
    &lt;g:CorrelationId &gt;acb709df-7e32-45e2-a48c-9c160091aa5d&lt;/g:CorrelationId&gt;
  &lt;/m:Message&gt;
  &lt;s:SourceAddress &gt;loopback://localhost/source&lt;/s:SourceAddress&gt;
  &lt;s:DestinationAddress &gt;loopback://localhost/destination&lt;/s:DestinationAddress&gt;
  &lt;s:MessageType &gt;MassTransit.Tests.Serialization.NewUserRegistered, MassTransit.Tests&lt;/s:MessageType&gt;
&lt;/x:XmlMessageEnvelope&gt;
</pre>

Namespaces are created for each type of object that is serialized. This makes it fast and easy for the deserialization process to figure out what type to use when reading the value from the XML. It&#8217;s easy to look and see the actual data that belongs to the message, as well as the headers used by MassTransit. 

I wanted to post this as quickly as possible after committing the changes to the trunk so I will wrap up. I&#8217;m pretty excited about having a nice, readable message format. Since finding [MSMQ Studio](http://www.geekproject.com/tools.aspx#10), I&#8217;ve really wanted to improve the diagnosis story for looking at messages inside the queues. I think this is a solid move towards that goal and a great first steps towards interoperability with other systems.