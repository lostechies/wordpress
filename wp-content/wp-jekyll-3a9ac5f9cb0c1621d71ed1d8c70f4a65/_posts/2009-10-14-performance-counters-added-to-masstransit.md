---
id: 60
title: Performance Counters Added to MassTransit
date: 2009-10-14T15:57:16+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2009/10/14/performance-counters-added-to-masstransit.aspx
permalink: /2009/10/14/performance-counters-added-to-masstransit/
dsq_thread_id:
  - "266663761"
categories:
  - .net
  - 'c#'
  - masstransit
---
One feature that is often overlooked in software development is the output of information that can be observed by operations once the application is in production. Fortunately, many open source projects are leveraging [log4net](http://logging.apache.org/log4net/index.html) to provide a configurable level of runtime information that can be useful in figuring out why a system is behaving a certain way (and face, if you&#8217;re looking, it&#8217;s more than likely behaving badly). Logging, however, is only one view into an application &#8212; one that might not deliver the appropriate information in a useful way. 

Anyone who has used a computer with any interest is familiar with system monitoring tools. Task Manager (or if you&#8217;re really cool Process Explorer) is the first place Windows users look when their system starts to crawl, Mac users turn to Activity Monitor, and I&#8217;m sure Linux users have some really obscure command-line tool as well. These coarse grained tools are usually enough for users, however, an operations team needs a higher degree of visibility into application &#8212; particularly if they are expected to determine how to tune the application for better performance. 

For operations on Windows, Performance Monitor provides detailed information for running applications in real-time. On a web server, it is easy to find out how many threads your ASP.NET application is using, as well as how many requests are queued. That information can be correlated with processor utilization to help determine if the bottleneck is the CPU, the network, or possibly even the database server. When it comes to troubleshooting issues on a live system, more information is always helpful to determine the source of the problem. 

To support this level of visibility in [MassTransit](http://code.google.com/p/masstransit/), performance counter support has been added. Performance counters in .NET are part of the System.Diagnostics namespace. There are various counter types that can be defined, including counts, rates, and averages. When an application wants to output performance counters, it has to create a category and specify the counters that are included in the category. For instance: 

<pre>ConsumerThreadCount = new RuntimePerformanceCounter("Consumer Threads",
	"The current number of threads processing messages.",
	PerformanceCounterType.NumberOfItems32);

ReceiveRate = new RuntimePerformanceCounter("Received/s",
	"The number of messages received per second",
	PerformanceCounterType.RateOfCountsPerSecond32);
</pre>

These are two of the counters defined by the MassTransit category. The first is a count that is updated when the number of threads in use changes. The second is a rate which gets incremented once for every message received. The actual calculation and display of the rate is handled by the performance monitoring tools &#8211; the application does not need to calculate it. 

<pre>ConsumerDuration = new RuntimePerformanceCounter("Average Consumer Duration",
	"The average time a consumer spends processing a message.",
	PerformanceCounterType.AverageCount64);

ConsumerDurationBase = new RuntimePerformanceCounter("Average Consumer Duration Base",
	"The average time a consumer spends processing a message.",
	PerformanceCounterType.AverageBase);
</pre>

This counter is used to report the average consumer duration of a message. For an average, two counters are used. One is the base which is incremented for each occurrence and the counter is the actual count that is added. So for each message, the base is incremented once and the duration is incremented by the amount of time spent executing the consumer. 

In adding performance counter support, I wanted to do it in a way that didn&#8217;t leak the details of updating performance information throughout the framework. It was at this point that I turned to the [Magnum Pipeline](http://blog.phatboyg.com/2009/07/27/event-aggregator-using-the-magnum-pipeline/). Using the pipeline to publish the metrics allowed me to isolate the actual performance counter interface to a single method in a single class for the service bus. So instead of passing interfaces around all the components that make up the bus, a single event aggregator is passed instead. When you start up the bus, the performance counter code subscribes to the events as shown: 

<pre>_eventAggregatorScope.Subscribe(message =&gt;
	{
		_counters.ReceiveCount.Increment();
		_counters.ReceiveRate.Increment();
		_counters.ReceiveDuration.IncrementBy((long) message.ReceiveDuration.TotalMilliseconds);
		_counters.ReceiveDurationBase.Increment();
		_counters.ConsumerDuration.IncrementBy((long) message.ConsumeDuration.TotalMilliseconds);
		_counters.ConsumerDurationBase.Increment();
	});
</pre>

Now, when the bus receives a message, it sends the event to the event aggregator (an instance of the Magnum Pipeline). 

<pre>var message = new MessageReceived
	{
		MessageType = messageType,
		ReceiveDuration = receiveTime,
		ConsumeDuration = consumeTime,
	};

	_eventAggregator.Send(message);
</pre>

Since the Magnum Pipeline is publish/subscription, additional consumers could also opt-in to the MessageReceived event and perform other actions as well. I also plan to add counters per message type, allowing a finer grained view at message counts and consumer durations. 

While the main story behind this post is the new counters available in MassTransit, my hope is that this brief introduction to performance counters was useful as well. You can learn more about performance counters from various articles that have been posted (such as [a good one](http://www.codeproject.com/KB/aspnet/DOTNETBestPractices3.aspx) on CodeProject). You can check out the [Magnum Pipeline](http://blog.phatboyg.com/2009/07/27/event-aggregator-using-the-magnum-pipeline/) in the [Magnum](http://magnum-project.net/) project which is [hosted at GoogleCode](http://code.google.com/p/magnum/).