---
id: 29
title: Distributed Processing with MassTransit.Grid
date: 2008-08-23T13:18:04+00:00
author: Chris Patterson
layout: post
guid: /blogs/chris_patterson/archive/2008/08/23/distributed-processing-with-masstransit-grid.aspx
permalink: /2008/08/23/distributed-processing-with-masstransit-grid/
dsq_thread_id:
  - "270739423"
categories:
  - .net
---
I was reading through the Xgrid documentation for OS X yesterday after reading an article on Integrating Xgrid Into Cocoa Applications. The article gave me some ideas and I decided to see what it would take to build a distributed processing system on top of MassTransit. The result is a new MassTransit.Grid namespace that includes support for building distributed task processing into an application. The following sections define the language used in the distributed task classes.

**Distributed Tasks**

A distributed task contains one or more subtasks that need to be processed concurrently across multiple systems. To create a distributed task, create a class that implements IDistributedTask. The input and output types for the subtasks must also be defined by the distributed task class.

public interface IDistributedTask< TTask , TInput, TOutput >
  
{
  


> int SubTaskCount { get; }
      
> TInput GetSubTaskInput(int subTaskId);
      
> void DeliverSubTaskOutput(int subTaskId, TOutput output);
      
> void NotifySubTaskException(int subTaskId, Exception ex);
      
> void WhenCompleted(Action< TTask > action);</p>
} 

**Subtasks**

A subtask is an individual unit of work within a distributed task. Each subtask should be completely standalone and not depend upon the completion of any other subtask within the distributedtask. There is no attempt to execute the subtasks within a distributed task in order. A subtask has specific input and output types, each of which are defined by a class (POCO style). These input types are used to determine which workers are used to process the subtasks.

**DistributedTaskController**

To insulate the application from the details of coordinating the subtasks, a generic DistributedTaskController is used. This class is built from the class that implements IDistributedTask, along with the input and output types. Once created, the application can call .Start() to being processing the distributed task. The controller performs any initial identification of workers that are available to process the subtasks, along with the coordination to ensure that workers are not overloaded.

public class DistributedTaskController< TTask , TInput, TOutput > 

TTask is the class that implements IDistributedTask, TInput is the subtask input type, and TOutput is the subtask output type. 

**Workers** 

To make it easy to create workers to handle subtasks, a default worker implementation is available. This worker handles the coordination with the DistributedTaskController, along with the delegation of the messages to the actual subtask worker. For example, a worker that accepts a GenerateFileHash object and outputs a FileHashGenerated object would be setup as shown: 

public class FileHashGenerator :
         
ISubTaskWorker< GenerateFileHash , FileHashGenerated >
     
{
  


> public void ExecuteTask(GenerateFileHash input, Action< FileHashGenerated > output)
         
> {
  
> 
> 
> > string path = input.Path;</p> 
> > 
> > // do work here
> > 
> > output(new FileHashGenerated());
> 
> }

} 

The worker can then be added to the container for servers that will be processing the subtasks using: 

_container.AddComponent< FileHashGenerator >();
  
_bus.AddComponent< SubTaskWorker < FileHashGenerator, GenerateFileHash, FileHashGenerated > >(); 

This will register the SubTaskWorker for the worker as a message handler for the messages that are used on the transport to transfer the input and output data between the controller and the subtask workers. 

**Exception Handling** 

If an exception occurs in a subtask, the worker and controller leverage the built-in fault handling support of MassTransit to notify the distributed task that an exception has occurred. The controller will call the NotifySubTaskException method with the subTaskId and the exception that was thrown by the worker allowing the distributed task to determine the next course of action based on that failure. Options would include simply aborting the distributed task, fixing the input data and adding it to the end of the subtask list, or some other application-defined behavior. 

**Dynamically Adding Subtasks** 

To reduce the impact of setup time on the overall duration of a distributed task, it is not necessary to have all of the subtasks loaded before starting the distributed task. This also allows additional subtasks to be added based on the output from other subtasks. For example, a task to parse a remote file system may identify additional folders that need scanned for content. The distributed task could just add those folders to the end of the subtask list and they would be picked up by the controller. By allowing this, the distributed task is responsible for calling the delegate set by the controller to indicate that all of the subtasks have completed. The DistributedTaskController will then release any resources that were in use. 

**Sample in Unit Tests** 

A quick sample was built in the unit tests (MassTransit.Grid.Test) that shows an integer factoring service. The distributed task creates a bunch of very large integers and processes them as a distributed task between the workers that are available. Hopefully this demonstrates how the classes are hooked together since this was used to drive out the feature set. 

**Wrapping Up** 

This is just a brief introduction to the distributed processing capabilities that were added to MassTransit. There are likely some additional features to add that will hopefully be identified as the feature it put to use. Therefore, it is important to note that this feature is still in development and should go through some considerable testing before putting it into use in a production application. Any feedback is always welcome (including patches) so try it out!