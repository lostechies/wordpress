---
id: 200
title: 'Cool stuff in FubuCore No. 7: Model Binding'
date: 2011-06-08T11:30:46+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=200
permalink: /2011/06/08/cool-stuff-in-fubucore-no-7-model-binding/
dsq_thread_id:
  - "325819600"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the seventh post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

**\*UPDATE\*** – 10-JUN-2011 – I posted a [follow-up to this post](http://lostechies.com/chadmyers/2011/06/10/a-quick-follow-up-on-model-binding-in-fubucore/) which explains more clearly the distinctions between ValueConverter, IPropertyBinder, and IModelBinder.

**\*UPDATE\*** – 10-JUN-2011 – [Joshua Flanagan](http://joshuaflanagan.lostechies.com) pointed out, in the comments, a mistake I made about the ExpandEnvironmentVariablesAttribute.&nbsp; I’ve corrected that now. Thanks Josh!

FubuCore’s model binding framework is perhaps the most substantial and compelling feature of the entire FubuCore library.&nbsp; If you haven’t cared about any of the previous six posts, you might just be interested in this one.

I think I bit off more than I can chew with this post, however. Model binding in FubuCore/FubuMVC could easily fill a whole series by itself.&nbsp; For this post, I’m going to speak generally about Fubu’s model binding and where to get started.&nbsp; Delving into some of the deeper, cooler stuff will have to wait for other blog posts. [Jeremy](http://codebetter.com/jeremymiller/) has also said he’s planning on doing an in-depth post or two on the subject, so keep an eye out for that.

The model binding stuff in FubuCore is general purpose. It’s not meant only for binding models in a web framework like FubuMVC.&nbsp; We use it for all sorts of things such as [binding our configuration settings to the appSettings file](http://lostechies.com/chadmyers/2011/06/03/cool-stuff-in-fubucore-no-5-easy-configuration/), [binding command-line arguments](http://lostechies.com/chadmyers/2011/06/06/cool-stuff-in-fubucore-no-6-command-line/) to POCO input models for command objects, some ETL stuff we do at Dovetail, and [our automated regression test fixtures](https://github.com/DarthFubuMVC/bottles/tree/master/src/Bottles.Storyteller) in [StoryTeller](https://github.com/storyteller/storyteller). You can use it for all sorts of other things, too. I daresay, with some work, you might even be able to get it to work in ASP.NET MVC, but I haven’t confirmed this.

## ObjectConverter and ObjectResolver

If you’re touring through the FubuCore model binding code, you may notice two seemingly similar classes: [ObjectConverter](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/ObjectConverter.cs) and [ObjectResolver](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/ObjectResolver.cs).&nbsp; ObjectConverter is a simple, lightweight API for turning strings into other types of objects.&nbsp; It’s useful in reading stuff from XML files, from the command-line, etc. 

ObjectResolver, on the other hand, is more substantial and has support for more complex objects, enumerables, nested object structures, and all sorts of fun stuff.&nbsp; Since this blog post is about model binding, we’ll be talking about ObjectResolver.

## Getting Started with ObjectResolver

The entry point for model binding in FubuCore is the [IObjectResolver](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/ObjectResolver.cs) and the corresponding concrete implementation: [ObjectResolver](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/ObjectResolver.cs).&nbsp; 

The main method that you’re going to be dealing with on ObjectResolver is “BindResult **BindModel**(Type type, IRequestData data)”.&nbsp; The description of this method is:&nbsp; New up an instance of my model of type {type} and populate as many of its properties with a given a bag of {data}, returning the model object and any problems that were encountered during binding.&nbsp; That bag of data may be the current HTTP request in a web app, a bunch of settings loaded from a config file, a bunch of command-line arguments, a bunch of rows loaded from a database, a bunch of rows loaded from a CSV file, etc.

There are four layers of binding that ObjectResolver uses. Listed by most to least responsibility:&nbsp; model binders use property binders use conversion families use value converters. I’ll cover each layer of binding, but it’ll be easiest if I explain them in reverse order (least to most responsibility).

## Value Converters and Conversion Families

A [ValueConverter](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/ValueConverter.cs) is the lowest level of binding and is intended to deal with the actual minutiae of converting the raw data (usually a string) into the desired result type (for example, a DateTime, TimeZoneInfo, domain entity, etc).

A good example of this is the [BooleanFamily](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/BooleanFamily.cs), which is a combination [ValueConverter](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/ValueConverter.cs)/[IConverterFamily](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/IConverterFamily.cs) (more on this in a moment). This class deals with a lot of the odd ways that various browsers represent Boolean values (checkboxes, etc) in form post data.&nbsp; For example, you may get nothing (null/empty string) which means False, or you may get the property name itself (i.e. IsEnabled=”IsEnabled”) which means True. Or, you may just get “on” which means True. Of course “[tT]rue” and “[fF]alse” work as well.

A value converter needs to do two things: 1.) Tell FubuCore whether it can handle conversion for a given property (see the Matches method) and 2.) Actually perform the conversion on a supported property (see the Convert method).

Most value converters are stateless. That is, they are able to take the raw value, and a reference to the PropertyInfo which will be set and they can perform the conversion and return the correct converted value.&nbsp; These converters should inherit from [StatelessConverter](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/StatelessConverter.cs) which takes care of a few housekeeping things for you.

For those value converters which are stateful, they will need a corresponding [IConverterFamily](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/IConverterFamily.cs) implementation. A good example of this situation is the [TypeDescriptorConverterFamily](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/ValueConverterRegistry.cs#L55) (heretofore TDCF).&nbsp; Note how the TDCF caches value converter instances by property type and maintains this cache as state.&nbsp; This type of situation should generally be rare and most converters will just inherit from StatelessConverter and be ready to rock.

There are a number of converters built into FubuCore for your convenience:

  * HttpPostedFileBase – (in an ASP.NET context) if your model has a property of type HttpPostedFileBase, Fubu will automatically bind it to a file that was uploaded by the browser (or null if no files were posted) in the current HTTP request. The property name on your model must match the form post item name. 
      * HttpFileCollectionWrapper (in an ASP.NET context) – if your model has a property of type HttpFileCollectionWrapper, Fubu will bind it to a collection of posted files in the current HTTP request. The property name on your model must match the form post item name that contains the file collection. 
          * HttpCookie (in an ASP.NET context) – if there’s a cookie in the current HTTP request with the same name as a property (whose type is HttpCookie) on your model, that property will get bound. 
              * ASP.NET Request property name (in an ASP.NET context) – If your model has a property on it with the same name as one of the properties on the ASP.NET [HttpRequestBase](http://msdn.microsoft.com/en-us/library/system.web.httprequestbase.aspx) object (for example, “ContentLength”, “ContentType”, “LogonUserIdentity”, “PhysicalApplicationPath”), Fubu will bind it your property to the request property’s value. 
                  * Map from web path(in an ASP.NET context) – If your model’s property has the [MapFromWebPath] attribute, Fubu will take the raw value (for example “~/home”) and expand it to the current app relative URL (for example “/myapp/home”). 
                      * Map web to physical path (in an ASP.NET context) – If your model’s property has the [MapWebToPhysicalPath] attribute, Fubu will take the raw value (“~/App\_Data/file.txt”) and expand it to be a physical path (“c:\inetpub\wwwroot\myapp\app\_data\file.txt”). 
                          * Expand environment variables – If your model’s property has the [ExpandEnvironmentVariables] attribute on it and the raw value being bound to your model looks like this: “%systemdrive%\MyApp”, it will get expanded to be “c:\MyApp” 
                              * Connection string – If your model’s property has the [ConnectionString] attribute, Fubu will find the connection string in the [ConfigurationManager.ConnectionStrings](http://msdn.microsoft.com/en-us/library/system.configuration.configurationmanager.connectionstrings.aspx) collection whose key matches the name of the property on your model object (i.e. YourModel.MyAppConnectString will get set to the “MyAppConnectString” property in your web.config) 
                                  * Boolean – If your property is of type System.Boolean, FubuCore will try to convert various formats of boolean expressions (including web-friendly like the property name itself and “on” – see above where I talked about the BooleanFamily for specifics). 
                                      * Numeric – If your property is one of the numeric types (integer, decimal, etc) Fubu will try to convert values coming from the source (HTTP post, flat file, config file, etc) into the property type 
                                          * TypeDescriptor – failing everything else, Fubu will try to use the built-in .NET [TypeDescriptor](http://msdn.microsoft.com/en-us/library/system.componentmodel.typedescriptor.aspx)/[TypeConverter](http://msdn.microsoft.com/en-us/library/system.componentmodel.typeconverter.aspx) stuff.</ul> 
                                        Of course you can write your own IConverterFamily/ValueConverter implementations. In fact, this is probably where most of the common extensibility happens. All you have to do is register them in StructureMap and the scanning will pick it up automatically.&nbsp; Note that the first one in wins, so order of registration _does matter_.
                                        
                                        ## Property Binders
                                        
                                        [IPropertyBinder](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Binding/IPropertyBinder.cs) is the next level of responsibility in the ObjectResolver chain.&nbsp; It is very similar to ValueConverter and there is a little overlap, but the expressed intention is different.&nbsp; Property binders are meant to be more conventional and less concerned about the type.&nbsp; For example, if you wanted to enable model binding of Guid’s (for which there is no default string conversion in .NET), you would use a ValueConverter.&nbsp; However, if you wanted to bind all properties whose name ends in a certain word, or are decorated with a certain attribute, then you would want to use an IPropertyBinder.&nbsp; I realize the line is kind of blurry here and this is an area for improvement in FubuCore.
                                        
                                        In my mind, property binders are for conventions.&nbsp; The way we use them in our app is for stuff like this:
                                        
                                          * CurrentUserBinder – If a property is of type User (our domain entity representing a user of the system) and has the name “CurrentUser”, then automatically set it to the currently logged-on user from the current Principal. 
                                              * CurrentTimeZoneBinder – If a property is named “CurrentTimeZone” and is of type TimeZoneInfo, then bind it to the current logged-on user’s selected time zone. 
                                                  * CurrentEmailAddressBinder – You probably get the gist now. If it’s “CurrentEmailAddress” and of type string, set it to the current logged-on user’s email address.</ul> 
                                                These are great conventions that save us a lot of time and remove a lot of friction. It’s a way of setting dependencies in our controller actions without having to add more junk to the constructor (which is what we had been doing before Fubu model binding).&nbsp; You can base the conventions off just about anything. IPropertyBinder has a “Matches” method that takes in a PropertyInfo. So you can base your conventions on the property name, type, owner type, whether it has an attribute or not, etc.
                                                
                                                If you learn nothing else from this article, I hope you learn that using conventions in your model binding will save you \*lots\* of time and make your controller actions a \*lot\* easier to test!
                                                
                                                Like the converter families and value converters, all you have to do is register your property binders in StructureMap and the scanning will pick it up automatically.&nbsp; Note that the first one in wins, so order of registration _does matter_.
                                                
                                                ## Model Binders
                                                
                                                The IModelBinder interface is the highest-responsibility level of binding for ObjectResolver.&nbsp; Generally, you won’t have a lot (if any) of these.&nbsp; These are for more heavy-duty binding tasks.&nbsp; Like IPropertyBinder and ValueConverter, there is a little overlap here but, also like them, the intention is different.
                                                
                                                Perhaps an example will make things clearer.&nbsp; We have an IModelBinder implementation called “EntityModelBinder”.&nbsp; This will turn the raw value of a Guid (our choice for primary keys in the DB) in string format (i.e. “8205556c-2949-4a99-8373-82114004342c”) into a Domain Entity.&nbsp; Since we’re in a web context, imagine a form post variable named “RelatedCase” and the value for it was “8205556c-2949-4a99-8373-82114004342c”.&nbsp; Imagine our input model has a property of type Case (a domain entity) named RelatedCase. The EntityModelBinder will take that raw Guid string and look at the property type (Case) and attempt to load a Case entity from the database using that Guid as the primary key.&nbsp; 
                                                
                                                So you can see, our EntityModelBinder is doing far more substantial work than a simple TimeZoneInfo ValueConverter.&nbsp; And this is why I was saying that you generally won’t have a lot of these model binders in the majority of circumstances, so use with reserve and don’t get too crazy.
                                                
                                                Like the converters and property binders, all you have to do is register your IModelBinder implementations in StructureMap and the scanning will pick it up automatically.&nbsp; Note that the first one in wins, so order of registration _does matter._
                                                
                                                **\*UPDATE\*** – 10-JUN-2011 – I posted a [follow-up to this post](http://lostechies.com/chadmyers/2011/06/10/a-quick-follow-up-on-model-binding-in-fubucore/) which explains more clearly the distinctions between ValueConverter, IPropertyBinder, and IModelBinder.
                                                
                                                ## Summary
                                                
                                                I couldn’t get into all the specifics and details and why-fors of model binding (including best practices and such) in this post. But hopefully this will be enough to get you started if you’ve been interested in the Fubu model binding framework.