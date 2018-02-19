---
id: 49
title: Declarative Workflow with MassTransit
date: 2009-04-08T01:53:36+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/04/07/declarative-workflow-with-masstransit.aspx
permalink: /2009/04/08/declarative-workflow-with-masstransit/
dsq_thread_id:
  - "262089319"
categories:
  - .net
---
One of the really cool features that is available in the 0.6 release of MassTransit is the ability to declaratively define a saga/workflow using a nested-closure syntax in combination with a fluent builder. While some wonder if fluent interfaces are going to [become the &#8220;aluminum wiring&#8221;](http://odetocode.com/Blogs/scott/archive/2009/03/16/12651.aspx) of the current generation of software development, I find them incredible valuable for building an expressive representation of logic. 

A saga is a way of defining a long-lived transaction, typically involving multiple transactional actors. A workflow is a way of orchestrating a number of actors into a process. Both sagas and workflows can be modeled using the new declarative syntax. First, let&#8217;s look at what this new language looks like in code: 

<pre>static DrinkPreparationSaga()
{
	Define(() =&gt;
		{
			Initially(
				When(NewOrder)
					.Then((saga, message) =&gt; saga.ProcessNewOrder(message))
					.TransitionTo(WaitingForPayment)
				);

			During(WaitingForPayment,
			       When(PaymentComplete)
			       	.Then((saga, message) =&gt;
			       		{
			       			Console.WriteLine("Payment Complete for '{0}' got it!", saga.Name);
			       			saga.ServeDrink();
			       		})
			       	.Complete()
				);
		});
}
</pre>

_(I&#8217;ve removed the class structure around the constructor to keep the code short)_ 

If we read from the top down, it is easy to understand the behavior for this saga. Initially (which signifies the creation of a new saga based on an event in this block), when a NewOrder is received, then we&#8217;re going to call the ProcessNewOrder method on the saga passing it the message that was received. Once that method completes, the saga will transition to the WaitingForPayment state. During the WaitingForPayment state, if a PaymentComplete is received, the saga will output a message, call the ServeDrink method on the saga, and complete. 

The states and events of the saga are defined by adding some static properties to the class: 

<pre>public static State Initial { get; set; }
public static State Completed { get; set; }
public static State PreparingDrink { get; set; }
public static State WaitingForPayment { get; set; }

public static Event NewOrder { get; set; }
public static Event PaymentComplete { get; set; }
</pre>

The static constructor for the state machine initializes these properties during the definition of the behavior as part of the Define() call. It is nice to be able to see all the states and events for the saga in one place, as well as the messages that are related to the events. 

Another great feature allows us to ask the saga state machine engine to tell us what it is going to do based on how we defined the behavior of the saga. The StateMachineInspector class is a tool that will output a trace of the defined behavior of the state machine. For the above saga, the output looks like: 

<pre>During Initial
		When NewOrder Occurs Containing NewOrderMessage
			(custom action)
			Transition To WaitingForPayment
	During PreparingDrink
	During WaitingForPayment
		When PaymentComplete Occurs Containing PaymentCompleteMessage
			(custom action)
			Transition To Completed
	During Completed
</pre>

This information is generated by using expressions and reflecting over the class and types contained. The above example is taken from the Starbucks example in the MassTransit trunk. For a service to subscribe and handle sagas like this, the service only needs to call: 

<pre>var unsubscribe = bus.Subscribe();
</pre>

Like all component-based consumers in MassTransit, the container should know how to build the saga and needs to have a ISagaRepository implementation for the saga as well. 

I hope as more people start to use this syntax that it evolves in a really rich was of doing code-first workflow and saga definitions. One thing we definitely want to do is take the text-based visualization of the saga and output it in a format that can be used by GraphViz or MSGLEE to get a nice diagram of the behavior of the saga. Hopefully that will be coming sooner rather than later! 

So that&#8217;s one of the really cool features of MassTransit that have been added.