---
id: 63
title: Building a Service Gateway Using MassTransit, Part 3
date: 2009-11-01T02:58:25+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/10/31/building-a-service-gateway-using-masstransit-part-3.aspx
permalink: /2009/11/01/building-a-service-gateway-using-masstransit-part-3/
dsq_thread_id:
  - "262089410"
categories:
  - masstransit
---
_This post is the third in a series on building a highly available service gateway. The implementation will be built in C# using [MassTransit](http://code.google.com/p/masstransit/), [StructureMap](http://structuremap.sourceforge.net/Default.htm), [ASP.NET MVC](http://www.asp.net/mvc/), and [NHibernate](http://nhforge.org/)._ 

### Did somebody say code?

The past two posts began to explain how to build a service gateway using MassTransit. In this post, I&#8217;m going to share some of the initial code that makes up the gateway service. The gateway itself consists of two components. The first implements the communication to the external service with a set of messages that are only used internally by the service. The second is the saga that provides the interface to the service gateway. 

### Service Contract

The interface exposed to the application consists of two messages, the first for the command and the second for the response. The message contracts are defined using interfaces, allowing the class for the message to be an internal implementation detail. 

The message contract representing a request for order details includes the CustomerId and the OrderId. 

<pre>public interface RetrieveOrderDetails
{
	string OrderId { get; }
	string CustomerId { get; }
}
</pre>

When the order details are received, the following message is published. 

<pre>public interface OrderDetailsReceived
{
	string OrderId { get; }
	string CustomerId { get; }
	DateTime Created { get; }
	OrderStatus Status { get; }
}

public enum OrderStatus
{
	Unknown = 0,
	Submitted = 1,
	Accepted = 2,
	InProcess = 3,
	Complete = 4,
}
</pre>

The CustomerId and OrderId are the same as the values passed in the request. Created is when the order was created, and Status is an enum representing the status of the order. Notice that no internal values are included &#8212; no primary key from the order table and no primary key from the customer table. The request and response are correlated on identifiers that make sense in the application domain. While SQL purists will point out that numeric primary keys are quicker for retrieving rows in a database, they make for a very fragile interface with other components in the system. Reliance on a primary key outside of the context of the system storing the order details is a path to friction or outright failure. 

### Time To Make the Saga

At this point in the design of our service, the need for a saga to manage the request state is not entirely obvious. While the TDD purists might want to call YAGNI at this point, let me assure you that &#8220;it will all be&#8230; revealed!&#8221; So for now, let us take a look at the first pass of our saga definition. 

<pre>public class OrderDetailsRequestSaga :
	SagaStateMachine&lt;OrderDetailsRequestSaga&gt;,
	ISaga
{
	static OrderDetailsRequestSaga()
	{
		Define(Saga);
	}
</pre>

Our saga state machine uses a static initializer to define the states, events, and transitions of a saga. The previous code merely defines our class as a saga and calls our saga initialization method (shown below). 

<pre>private static void Saga()
	{
		Correlate(RequestReceived)
			.By((saga, message) =&gt; saga.CustomerId == message.CustomerId &&
			                       saga.OrderId == message.OrderId &&
			                       saga.CurrentState == WaitingForResponse);

		Correlate(ResponseReceived)
			.By((saga, message) =&gt; saga.CustomerId == message.CustomerId &&
			                       saga.OrderId == message.OrderId &&
			                       saga.CurrentState == WaitingForResponse);
</pre>

Since our request criteria include our customer id and our order id, we use those to correlate the message to the saga. We also include the state of the saga to ensure that we do not match to a request that has already completed. We will look at some other ways we can enhance the performance of the service later on by using some additional states. 

<pre>public static State Initial { get; set; }
	public static State WaitingForResponse { get; set; }
	public static State Completed { get; set; }
</pre>

The three states we have defined, including an initial state when a new saga instance is created, a waiting for response state one our request has been sent to the service, and a completed state once the response has been received and published. 

<pre>public static Event&lt;RetrieveOrderDetails&gt; RequestReceived { get; set; }
	public static Event&lt;OrderDetailsResponse&gt; ResponseReceived { get; set; }
	public static Event&lt;OrderDetailsRequestFailed&gt; RequestFailed { get; set; }
</pre>

The three events that we have defined, including the message contract that maps to the event. The subscription logic for the saga will automatically map message handlers for these events that will invoke the actions depending upon the current state of the saga. 

<pre>Initially(
			When(RequestReceived)
				.Then((saga, request) =&gt;
					{
						saga.OrderId = request.OrderId;
						saga.CustomerId = request.CustomerId;
					})
				.Publish((saga, request) =&gt; new SendOrderDetailsRequest
					{
						RequestId = saga.CorrelationId,
						CustomerId = saga.CustomerId,
						OrderId = saga.OrderId,
					})
				.TransitionTo(WaitingForResponse));
</pre>

The first event handler, RequestReceived, is invoked when the saga is created in response to the RetrieveOrderDetails message. The handler copies the properties of the request, and then publishes the request message to the proxy that will call the external web service. After the message is published, the state of the saga transitions to the waiting for response state. When using transactional queues, the receipt of the message, creation of the saga in the database, sending of the command message to the proxy, and saving the saga are all part of a single distributed transaction. This ensures that everything completes as a single operation to ensure no requests are lost. 

<pre>During(WaitingForResponse,
			When(ResponseReceived)
				.Then((saga, response) =&gt;
					{
						saga.OrderCreated = response.Created;
						saga.OrderStatus = response.Status;
					})
				.Publish((saga, request) =&gt; new OrderDetails
					{
						CustomerId = saga.CustomerId,
						OrderId = saga.OrderId,
						Created = saga.OrderCreated.Value,
						Status = saga.OrderStatus,
					})
				.TransitionTo(Completed));
	}
</pre>

The second event handler, ResponseReceived, is invoked when the OrderDetailsResponse message is received. The results of the request are stored in the saga and a message is published containing the details of the order back to the original requestor. Another approach would be to capture the requestor address (via the ResponseAddress header from the message) and then resolve that address using the endpoint factory to send the response directly to the requestor. I don&#8217;t really encourage this approach without having a truly unique identifier for each request. 

<pre>public OrderDetailsRequestSaga(Guid correlationId)
	{
		CorrelationId = correlationId;
	}

	protected OrderDetailsRequestSaga()
	{
	}

	public virtual string CustomerId { get; set; }
	public virtual string OrderId { get; set; }
	public virtual OrderStatus OrderStatus { get; set; }
	public virtual DateTime? OrderCreated { get; set; }
	
	public virtual Guid CorrelationId { get; set; }
	public virtual IServiceBus Bus { get; set; }
}
</pre>

The rest of the saga class is shown above for completeness. The properties are part of the saga and get saved when the saga is persisted (using the NHibernate saga persister, or in the case of the sample the in-memory implementation). The constructor with the Guid is used to initialize the saga when a new one is created, the protected one is there for NHibernate to be able to persist the saga. 

### The Service Proxy

The saga uses the external service proxy to perform the actual work, which is shown in the proxy class below. 

<pre>public class OrderDetailsWebServiceProxy :
	Consumes&lt;SendOrderDetailsRequest&gt;.All
{
	public void Consume(SendOrderDetailsRequest request)
	{
		// make the call to the service to get the order details here

		var details = new OrderDetailsResponse
			{
				OrderId = request.OrderId,
				CustomerId = request.CustomerId,
				Created = (-1).Days().FromUtcNow(),
				Status = OrderStatus.InProcess,
			};

		CurrentMessage.Respond(details, x =&gt; x.ExpiresAt(5.Minutes().FromNow()));
	}
}
</pre>

The message handler uses the criteria from the SendOrderDetailsRequest message (which was published by the saga) to call the external service and retrieve the order details. The details are then returned to the saga in the form of an OrderDetailsResponse message which is internal to the service (and therefore not part of the interface assembly that is provided to applications that want to use the order details service). 

### Test That Thang

Now that our saga has been developed, we need to be able to test it. A unit test will be created that creates a testing instance of the service bus (see the sample for the implementation details) and verifies that the saga responds properly to the request. To request order details, a very simple client would subscribe to the response message and then publish the request. 

<pre>const string orderId = "ABC123";
const string customerId = "12345";

LocalBus.Subscribe&lt; OrderDetailsReceived &gt;(message =&gt;
	{
		response.Set(message);
	},
	x =&gt; x.OrderId == orderId && x.CustomerId == customerId);

RetrieveOrderDetails request = new RetrieveOrderDetailsRequest(customerId, orderId);
LocalBus.Publish(request, x =&gt; x.SendResponseTo(LocalBus.Endpoint));
</pre>

The subscribe method used above specifies that when a message of type OrderDetailsReceived is received, if the contents of the message match the predicate specified (which in this case, is checking the OrderId and CustomerId contained in the message) then the statement specified should be called. Our example is from the integration test (built using NUnit) that verifies the service performs from end-to-end. 

The syntax above is functional, and it will work, but it does not represent the most scalable approach. In the next post, I&#8217;ll start to explain how to build a much more scalable method of handling thousands of concurrent requests on a single machine using IIS. 

In the meantime, the sample code is available in the MassTransit trunk as a standalone solution. You can find it in the trunksrcSamplesServiceGatewaySample folder. There are unit tests that verify the calling syntax shown above and a service that hosts the services (both the saga, and the proxy service).