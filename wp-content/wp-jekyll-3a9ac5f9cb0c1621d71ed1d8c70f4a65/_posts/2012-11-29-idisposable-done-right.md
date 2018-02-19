---
id: 103
title: IDisposable, Done Right
date: 2012-11-29T06:59:06+00:00
author: Chris Patterson
layout: post
guid: http://lostechies.com/chrispatterson/?p=103
permalink: /2012/11/29/idisposable-done-right/
dsq_thread_id:
  - "949732595"
categories:
  - 'c#'
---
_IDisposable_ is a standard interface in the .NET framework that facilitates the deterministic release of unmanaged resources. Since the Common Language Runtime (CLR) uses Garbage Collection (GC) to manage the lifecycle of objects created on the heap, it is not possible to control the release and recovery of heap objects. While there are methods to force the GC to collect unreferenced objects, it is not guaranteed to clear all objects, and it is highly inefficient for an application to force garbage collection as part of the service control flow.

## Implementing _IDisposable_

Despite _IDisposable_ having only a single method named _Dispose_ to implement, it is commonly implemented incorrectly. After reading this blog post it should be clear how and when to implement _IDisposable_, as well as how to ensure that resources are properly disposed when _bad things happen_ (also knows as _exceptions_).

First, the _IDisposable_ interface definition:

    public interface IDisposable
    {
        void Dispose();
    }
    

Next, the proper way to implement _IDisposable_ every single time it is implemented:

    public class DisposableClass :
        IDisposable
    {
        bool _disposed;
    
        public void Dispose()
        {
            Dispose(true);
            GC.SuppressFinalize(this);
        }
    
        ~DisposableClass()
        {
            Dispose(false);
        }
    
        protected virtual void Dispose(bool disposing)
        {
            if (_disposed)
                return;
    
            if (disposing)
            {
                // free other managed objects that implement
                // IDisposable only
            }
    
            // release any unmanaged objects
            // set the object references to null
    
            _disposed = true;
        }
    }
    

The pattern above for implementing _IDisposable_ ensures that all references are properly disposed and released. Using the finalizer, along with the associated dispose methods, will ensure that in every case references will be properly released. There are some subtle things going on in the code, however, as described below.

### Dispose()

The implementation of the _Dispose_ method calls the _Dispose(bool disposing)_ method, passing _true_, which indicates that the object is being _disposed_. This method is never automatically called by the CLR, it is only called explicitly by the owner of the object (which in some cases may be another framework, such as ASP.NET or MassTransit, or an object container, such as Autofac or StructureMap).

### ~DisposableClass

Immediately before the GC releases an object instance, it calls the object’s finalizer. Since an object’s finalizer is only called by the GC, and the GC only calls an objects finalizer when there are no other references to the object, it is clear that the _Dispose_ method will never be called on the object. In this case, the object should release any managed or unmanaged references, allowing the GC to release those objects as well. Since the same object references are being released as those that are released when _Dispose_ is called, this method calls the _Dispose(bool disposing)_ method passing _false_, indicating that the references objects _Dispose_ method should _not_ be called.

### Dispose(bool)

All object references and unmanaged resources are released in this method. However, the argument indicates whether or not the _Dispose_ method should be called on any managed object references. If the argument is _false_, the references to managed objects that implement _IDisposable_ should be set to _null_, however, the _Dispose_ method on those objects should _not_ be called. The reason being that the owning objects _Dispose_ method was not called (_Dispose(false)_ is only called by the finalizer, and not the _Dispose_ method.

## Overriding _Dispose_

In the example above, the _Dispose(bool disposing)_ method is declared as _protected virtual_. This is to allow classes that inherit from this class to participate in the disposable of the object without impacting the behavior of the base class. In this case, a subclass should override the method as shown below.

    public class SubDisposableClass : 
        DisposableClass
    {
        private bool _disposed;
    
        // a finalizer is not necessary, as it is inherited from
        // the base class
    
        protected override void Dispose(bool disposing)
        {
            if (!_disposed)
            {
                if (disposing)
                {
                    // free other managed objects that implement
                    // IDisposable only
                }
    
                // release any unmanaged objects
                // set object references to null
    
                _disposed = true;
            }
    
            base.Dispose(disposing);
        }
    }
    

The subclass overrides the method, releasing (and optionally disposing) object references first, and then calling the base method. This ensures that objects are released in the proper order (at least between the subclass and the base class, the proper order of releasing/disposing objects within the subclass itself is the responsibility of the developer).

## Exceptions, Happen

Prior to .NET 2.0, if an object’s finalizer threw an exception, that exception was swallowed by the runtime. Since .NET 2.0, however, throwing an exception from a finalizer will cause the application to crash, and that’s bad. Therefore, it is important that a finalizer never throw an exception.

But what about the _Dispose_ method, should it be allowed to throw an exception? The short answer, is _no_. Except when the answer is yes, which is almost never. Therefore, it is important to wrap any areas of the Dispose(bool disposing) method that could throw an exception in a try/catch block as shown below.

    protected virtual void Dispose(bool disposing)
    {
        if (_disposed)
            return;
    
        if (disposing)
        {
            _session.Dispose();
        }
    
        try
        {
            _channelFactory.Close();
        }
        catch (Exception ex)
        {
            _log.Warn(ex);
    
            try
            {
                _channelFactory.Abort();
            }
            catch (Exception cex)
            {
                _log.Warn(cex);
            }
        }
    
        _session = null;
        _channelFactory = null;
    
        _disposed = true;
    }
    

In the example, **_session_ is a reference to an NHibernate _ISession_ and _</strong>channelFactory_ is a reference to a WCF _IChannelFactory_. An NHibernate _ISession_ implements _IDisposable_, so the owner must call _Dispose_ on it when the object is no longer needed. In the case of the _IChannelFactory_ reference, there is no _Dispose_ method, however, the object must be closed (and subsequently aborted in case of an exception). Because either of these methods can throw an exception, it is important to catch the exception (and, as shown above, log it for troubleshooting or perhaps just ignore it) so that it doesn’t cause either the _Dispose_ method or the object’s finalizer to propagate the exception.</p> 

## Constructor Exceptions

On a related topic, when an object’s constructor throws an exception, the runtime considers the object to have never existed. And while the GC will release any object allocated by the constructor, it will _not_ call the _Dispose_ method on any disposable objects. Therefore, if an object is creating references to managed objects in the constructor (or even more importantly, unmanaged objects that consume limited system resources, such as file handles, socket handles, or threads), it should be sure to dispose of those resources in the case of a constructor exception by using a try/catch block.

> While one might be tempted to call \_Dispose\_ from the constructor to handle an exception, don’t do it. When the constructor throws an exception, technically the object does not exist. Calling methods, particularly virtual methods, should be avoided.

Of course, in the case of managed objects such as an _ISession_, it is better to take the object as a dependency on the constructor and have it passed into the object by an object factory (such as a dependency injection container, such as Autofac) and let the object factory manage the lifecycle of the dependency.

## Container Lifecycle Management

Dependency injection containers are powerful tools, handling object creation and lifecycle management on behalf of the developer. However, it is important to have a clear understanding of how to use the container in the context of an application framework.

For example, ASP.NET has a request lifecycle for every HTTP request received by the server. To support this lifecycle, containers typically have integration libraries that hook into the framework to ensure proper object disposal. For instance, Autofac has a number of integration libraries for ASP.NET, ASP.NET MVC, ASP.NET Web API, and various other application frameworks. These libraries, when configured into the stack as HttpModules, ensure that objects are properly disposed when each request completes.

## Conclusion

The reason for _IDisposable_ is deterministic release of references by an object (something that used to happen manually with unmanaged languages by calling _delete_ on an object). Implementing it both properly and consistently helps create applications that have predictable resource usage and more easy to troubleshoot. Therefore, consider the example above as a reference point for how objects should be disposed.

References:
  
- [Autofac Web Integration](http://code.google.com/p/autofac/source/browse/#hg%2FCore%2FSource%2FAutofac.Integration.Web)
  
- [Microsoft Documentation](http://msdn.microsoft.com/en-us/library/b1yfkh5e%28v=vs.100%29.aspx)

Bonus:
  
- [Resharper Template](https://blogs.relayhealth.com/wp-content/uploads/2012/11/DisposeTemplates.DotSettings.zip)