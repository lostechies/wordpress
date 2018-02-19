---
id: 30
title: Managing Long-Lived Transactions with MassTransit.Saga
date: 2008-08-29T03:48:15+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/08/28/managing-long-lived-transactions-with-masstransit-saga.aspx
permalink: /2008/08/29/managing-long-lived-transactions-with-masstransit-saga/
dsq_thread_id:
  - "268812530"
categories:
  - .net
---
One of the first applications we built with [MassTransit](http://code.google.com/p/masstransit/) provides messaging for a long-running transaction started by an application submitting a request. The request is formatted into a X12 envelope and sent to a web service. An intermediate response is returned (a X12 997) with a correlation identifier for the request. Another web service is polled for the response, which can be the result or an indication that the request is still pending. When the response is received, the X12 document is translated and stored in the database. Finally, the user is notified that the transaction is complete and the result is displayed. 

As work proceeded on this application, I started to recognize the need for something to coordinate the different steps in a transaction involving multiple loosely-coupled services. Due to the duration of these transactions (the example above can take anywhere from three to sixty seconds), it is unreasonable to keep a single System.Transactions style transaction open the entire time. I started researching how others approached the problem and found a couple of articles that helped. After reading _Sagas_ by Hector Garcaa-Molrna and Kenneth Salem (&copy; 1987 ACM, [PDF](http://www.cs.cornell.edu/andru/cs711/2002fa/reading/sagas.pdf)) and the chapter on sagas in the upcoming book _Practical SOA_ by Arnon Rotem-Gal-Oz ([PDF](http://www.rgoarchitects.com/Files/SOAPatterns/Saga.pdf)), I started to think about how this could be implemented within [MassTransit](http://code.google.com/p/masstransit/). 

I should note that [NServiceBus](http://www.nservicebus.com/) (another open source service bus) also supports sagas, but I purposely avoiding taking a look at how [Udi Dahan](http://www.udidahan.com/) implemented them. Once saga support in MassTransit is complete I plan to review the source for NServiceBus to see how the implementations differ. I spoke with Udi at ALT.NET Seattle and his writing has been both educational and inspirational. A lot of great discussions in the [NServiceBus mailing list](http://tech.groups.yahoo.com/group/nservicebus/) have been an excellent resource as well. 

So after a few weeks of trying to flesh out the structure (using TDD, of course), I finally arrived at what I think will be a highly usable infrastructure for handling sagas. In the project [MassTransit.Saga.Tests](http://code.google.com/p/masstransit/source/browse/#svn/trunk/MassTransit.Saga.Tests), I&#8217;ve created a test that simulates a user registering for a web site. The class for the registration is shown below. 

`<br />
public class RegisterUserSaga :<br /><br />
	<blockquote>InitiatedBy< RegisterUser >,<br /><br />
	Orchestrates< UserVerificationEmailSent >,<br /><br />
	Orchestrates< UserValidated >,<br /><br />
	ISaga< RegisterUserSaga ></blockquote><br />
{<br />
	<blockquote>private string _displayName;<br /><br />
	private string _email;<br /><br />
	private string _password;<br /><br />
	private string _username;<br /><br />
<br /><br />
	public RegisterUserSaga(Guid correlationId)<br /><br />
	{<br />
	<blockquote>	CorrelationId = correlationId;</blockquote><br />
	}<br /><br />
<br /><br />
	public Guid CorrelationId { get; private set; }<br /><br />
	public IObjectBuilder Builder { get; set; }<br /><br />
	public IServiceBus Bus { get; set; }<br /><br />
	public Action< RegisterUserSaga > Save { get; set; }<br /><br />
<br /><br />
	public void Consume(RegisterUser message)<br /><br />
	{<br />
	<blockquote>	_displayName = message.DisplayName;<br /><br />
		_username = message.Username;<br /><br />
		_password = message.Password;<br /><br />
		_email = message.Email;<br /><br />
<br /><br />
		Save(this);<br /><br />
		Bus.Publish(new SendUserVerificationEmail(CorrelationId, _email));</blockquote><br />
	}<br /><br />
<br /><br />
	public void Consume(UserVerificationEmailSent message)<br /><br />
	{<br />
		<blockquote>// once the verification e-mail has been sent, we allow 24 hours to pass before we<br /><br />
		// remove this transaction from the registration queue<br /><br />
		Bus.Publish(new UserRegistrationPending(CorrelationId));<br /><br />
		Bus.Publish(new UpdateSagaTimeout(CorrelationId, TimeSpan.FromHours(24)));</blockquote><br />
	}<br /><br />
<br /><br />
	public void Consume(UserValidated message)<br /><br />
	{<br />
		<blockquote>// at this point, the user has clicked the link in the validation e-mail<br /><br />
		Bus.Publish(new UserRegistrationComplete(CorrelationId));<br /><br />
		Bus.Publish(new CompleteSaga(CorrelationId));</blockquote><br />
	}</blockquote><br />
}<br />
` 

At the top of the class, the messages consumed by the saga are specified. InitiatedBy indicates the message initiates a new instance of the saga. Orchestrates is for messages that are part of the saga once it has been initiated. All saga instances are identified by a Guid and all messages consumed by the saga should have the CorrelatedBy< Guid > interface. A saga must also implement the ISaga generic interface to allow certain properties to be set giving the saga instance access to the bus and the object builder. 

Once the saga class is added to the bus (via the AddComponent method), any messages consumed by the saga will be dispatched to the saga instance. A generic ISagaRepository must also be registered in the container so that sagas can be persisted between messages. The saga dispatcher uses the repository to either load or create the instance of the saga. Since instances of the saga class are saved, the class can expect the members to also be persisted between messages allowing state to be retained. 

There is still some work to be done, including a service to handle timeouts and retries. It will be up to the developer to handle any compensating actions that need to be taken in the case of a failure. Therefore, it is highly suggested that the saga also consume any Fault< T > messages that are published when a message consumer throws an exception &#8212; particularly if the consumer is not part of the saga (such as an application or domain service). 

The code is currently in the [trunk](http://code.google.com/p/masstransit/source/browse/) and slated to be part of the 0.3 release.