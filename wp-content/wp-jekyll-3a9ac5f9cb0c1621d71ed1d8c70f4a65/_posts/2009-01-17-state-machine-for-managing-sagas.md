---
id: 45
title: State Machine for Managing Sagas
date: 2009-01-17T04:42:00+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/01/16/state-machine-for-managing-sagas.aspx
permalink: /2009/01/17/state-machine-for-managing-sagas/
dsq_thread_id:
  - "262089272"
categories:
  - .net
  - masstransit
---
MassTransit supports sagas, which are long-lived transactions consisting of multiple events. The saga support makes it easy to orchestrate the events into a process, but it doesn&#8217;t do much to help with state management. Since state management is fairly common, I felt it necessary to add some support for a state machine. 

In MassTransit, a _saga_ is defined by creating a class and attaching some interfaces for the messages that will be consumed. The messages are the _events_, and the class is the saga. An example saga is shown below. 

&nbsp;

<pre style="width: 626px;height: 104px;margin: 2px">public class DrinkPreparationSaga :
        InitiatedBy &lt; NewOrderMessage &gt;,
        Orchestrates &lt; PaymentCompleteMessage &gt;,
        ISaga
    {
        public void Consume(NewOrderMessage message)
        {
        }
        public void Consume(PaymentCompleteMessage message)
        {
        }
    }
</pre>

&nbsp;

I&#8217;ve omitted the code for each consumer to keep it short, but the business logic defined would handle the fact that once the drink is prepared, it should not be served until the PaymentCompleteMessage has been received. Storing this state is an application concern. 

While I was [at QCon San Francisco](http://blog.phatboyg.com/2008/11/21/qcon-in-san-francisco-getting-started/), I attended a tutorial session on DSLs. It was here that I got the idea to somehow make a DSL for defining the behavior of a state machine that could be used with sagas in MassTransit. It&#8217;s taken a couple of months, but I think I&#8217;ve managed to put something together that simplifies state management in sagas. With the addition of a new state machine in Magnum, along with persistence support for NHibernate, it is now easy to manage this state automatically. 

To demonstrate this, below is the state machine for the above process. 

&nbsp;

<pre>public class DrinkPreprationStateMachine :
		StateMachine &lt; DrinkPreprationStateMachine &gt;,
		ISaga,
		InitiatedBy &lt; NewOrderMessage &gt;,
		Orchestrates &lt; PaymentCompleteMessage &gt;,
		Orchestrates &lt; DrinkPreparedMessage &gt;
	{
		static DrinkPreprationStateMachine()
		{
			Define(() =&gt;
				{
					Initially(
						When(NewOrder)
							.Then(saga =&gt;
								{
									// start preparing the drink
								})
							.TransitionTo(PreparingDrink));
					During(PreparingDrink,
						When(DrinkPrepared)
					       	.TransitionTo(WaitingForPayment),
						When(PaymentComplete)
					       	.TransitionTo(WaitingForDrink));
					During(WaitingForPayment,
					    When(PaymentComplete)
					       	.Then(saga =&gt;
					       		{
					       			// publish drink ready message
					       		})
					       	.Complete());
					During(WaitingForDrink,
						When(DrinkPrepared)
					       	.Then(saga =&gt;
					       		{
					       			// publish drink ready message
					       		})
					       	.Complete());
				});
		}
		// event and state definitions not shown, but are simple properties
	}
</pre>

&nbsp;

As shown above, all the logic of states, events, and transitions is wrapped into a clean fluent interface. The During() blocks define what is to be done when events are received during a particular state. The When() blocks define the behavior when the specified events occur. All state transitions are explicit, allowing them to be captured as part of the state machine. 

There are two types of events. BasicEvent supports an event without any accompanying data. The DataEvent < V > allows data to be associated with an event. In MassTransit, each DataEvent would have a matching Consume() handler. For example, _Event < NewOrder >_ would have a _public void Consume(NewOrder message)_ that would call _RaiseEvent(NewOrderEvent, message)_ to pass the event to the state machine along with the message. 

The state machine also supports inspection, allowing the definition to be output for verification that the intent was properly conveyed by the interface. This not only makes it possible to verify the flow between states, but also could allow the creation of a graph to display the states, events, and transitions in a visual manner. The provided state machine inspector currently only outputs to the trace window, but could easily be enhanced by somebody with some skills. 

Also, not shown above, is the ability to specify an expression using the .And() method to evaluate the data associated with an event to determine if that event is handled by that state event action. This expression is kept as an expression, allowing the details to be output using the inspector as well. 

Currently, the saga must still implement the Consume() method for each message and call RaiseEvent() on the state machine to pass the message and trigger the event. I plan to add some new message sinks to the message pipeline to make those methods unnecessary, mapping the messages directly into the event handlers within the state machine. This isn&#8217;t done yet, but it is planned. 

The StateMachine also provides an IUserType implementation for NHibernate in the Magnum.Infrastructure assembly. This makes it easy to persist the state using NHibernate, storing the current state as a string. This is just the default implementation, any other could be built if your needs are different. 

I originally presented this syntax during the [Virtual ALT.NET meeting last week](http://zachariahyoung.com/zy/post/2009/01/Recording-for-VAN-meeting-on-1709.aspx). It was a last minute presentation, so I wasn&#8217;t sure I covered all the details. Hopefully this will help provide some guidance on how it is used, along with plans for the future.