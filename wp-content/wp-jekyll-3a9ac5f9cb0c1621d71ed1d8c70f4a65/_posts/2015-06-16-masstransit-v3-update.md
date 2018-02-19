---
id: 114
title: MassTransit v3 Update
date: 2015-06-16T00:26:56+00:00
author: Chris Patterson
layout: post
guid: https://lostechies.com/chrispatterson/?p=114
permalink: /2015/06/16/masstransit-v3-update/
dsq_thread_id:
  - "3852070426"
categories:
  - masstransit
---
# MassTransit v3 Update

It has been nearly six months since the first alpha of MassTransit v3 was released, and a lot of progress has been made. It turns out that rewriting an entire code base takes time and attention. Nonetheless, the new architecture is working out wonderfully and the code is nicely separated by concerns.

# So, about the TPL&#8230;

Make no mistake, the TPL (introduced in .NET 4.0), followed by the addition of async/await (in C# 5) has made the creation of asynchronous code clean and concise. That being said, knowing the exact behavior of the language constructs, and how the compiler translates the keywords is very important. Add to the mix the fact that many third-party assemblies were not designed for asynchronous invocation, and the resulting cesspool is quite a mess. However, it&#8217;s not that bad.

At every layer, MassTransit has been built around the TPL, leveraging async/await for the best performance, and providing pipe and filter composition at every possible extension point. The middleware injection is extensive, and new filter can be created easily to support many advanced use cases such as rate limiting, concurrency restriction, and asynchronous transactions. More filters will be coming, but an initial release has to happen at some point&#8230;

# Some New Features

The past six months have not been entirely about stabilization of the code. There have been several tasty new features added as well.

## External Message Data Storage

Big messages are inevitable, and big messages can really clog up the works making small message suffer. And there are some brokers that just can&#8217;t deal with big messages (cough, Azure Service Bus, cough) at all. To support the transfer of big messages (those messages with large byte arrays or strings), MassTransit now has the ability to send and receive message data outside of the message body.

A couple of standard repositories are available (in-memory, and file system) with more to come, including Azure Blob Storage and perhaps Amazon S3.

    _repository = new FileSystemMessageDataRepository(dataDirectory);
    

When sending a message, during message construction the repository is used to store the message data, which returns an address which is written to the message property.

    string data = "Some really long string (or byte array)";
    var message = new BigMessage
    {
        Body = await _repository.PutString(data)
    };
    await endpoint.Send(message);
    

Like all of MassTransit, the repository is async aware, so the _Put_ is awaited. Then, the message is sent and the reference to the message data is saved in the message body. Reading the message data is as easy as decorating the consumer with the message data behavior, and then just using the property directly.

    x.ReceiveEndpoint("my_queue", e =>
    {
        e.UseMessageData<BigMessage>(_repository);
    
        e.Handle<BigMessage>(context =>
        {
            string body = await context.Message.Body.Value;
            Console.WriteLine(body);
        });
    }
    

Big message consumers need not be aware of the external storage implementation in use. The consumer only needs to await on the message data property, and the resulting content (either a stream, or the byte[] or string) will be returned asynchronously. 

## Message Transformation

To support external message data, a mechanism for modifying the properties of a message as it passed through the consume pipeline was required. To that end, MassTransit now has the ability to specify a message transform.

To specify a message transform, add a transform to the receive endpoint configuration.

    x.ReceiveEndpoint("my_queue", e =>
    {
        e.Transform<A>(t =>
        {
            t.Set(p => p.Second, context => "World");
        });
        e.Handle<A>(context => Console.WriteLine(context.Message.Second));
    });
    

In the example above, the transform is applied to any _A_ message type, and the _Second_ property has the value &#8220;World&#8221; for any subsequent message filters, including any consumers, handlers, or sagas.

> By using the _Set_ method, the original A message is not modified. A new version of the message is created that contains the new property value. This is in contrast to the _Replace_ method, which changes the original message property. 

Instead of defining a message transform inline, a separate transform specification class can be created. There are many reasons to do this, including separation of code concerns, etc. but it&#8217;s become very useful.

    class MessageATransform :
        ConsumeTransformSpecification<A>
    {
        public MessageATransform()
        {
            Set(x => x.First, context => "Hello");
            Set(x => x.Second, context => "World");
        }
    }
    

The transform is then applied to the receive endpoint.

    x.ReceiveEndpoint("my_queue", x =>
    {
        x.UseTransform<A>(x => x.Get<MessageATransform>());        
        x.Handle<A>(context => Console.WriteLine(context.Message.Second));
    });
    

## Simplified Saga Repository

To make creating new saga repositories easy, the actual behavior required by a new saga implementation is reduced to two methods. The repository has also been redesigned to support composition and middleware, as well as full async operation, making it a clean and consistent implementation &#8212; on par with every other type of message consumer. 

There is probably some tuning and adjustments yet to be addressed, but it&#8217;s super sweet so far.

# What&#8217;s Left?

There are a few more things to wrap up before making MassTransit v3 ready for the primary NuGet feed (it&#8217;s currently hidden behind the pre-release flag). The exception handling pipeline needs to be well tested and verified, including adding context to the messages in error queues. Really, it&#8217;s just a lot of exception and sad-path testing at this point. The majority of the functionality is working very well, including Azure Service Bus.

If you are ambitious and ready to get started with the latest and greatest, I highly recommend pulling down the most recent pre-release packages and taking them for a spin. There are a couple of complete samples that demonstrate how to use MassTransit in a variety of scenarios.

## Sample-RequestResponse

A complete request/response example, leveraging the `IRequestClient` to encapsulate the configuration and endpoint mapping, keeping the requestor code clean and simple. [Source Code](https://github.com/MassTransit/Sample-RequestResponse)

## Sample-Courier

A complete sample for using Courier, the Routing Slip implementation that is included with MassTransit. Examples of how to create and execute routing slips, as well as track the routing slip events and orchestrate those events using **[Automatonymous](https://github.com/MassTransit/Automatonymous/tree/mt3)** are included, as well as using SQLite as a saga repository for the state machine instances. [Source Code](https://github.com/MassTransit/Sample-Courier)

## Documentation

Okay, the documentation still needs a lot of work, but it&#8217;s [coming along](http://docs.masstransit-project.com/en/mt3/). If you&#8217;re a great writer, the more help the better on this part.

# Stay Tuned

This was meant as an interim update, just to give a status on the development of MassTransit. The initial feedback and encouragement has been great, both on the much simpler API, the overall design of the message pipeline, and the Azure Service Bus support. It&#8217;s feedback from developers that helps determine when it is ready for stable release, so test drive the alphas and keep the feedback coming!