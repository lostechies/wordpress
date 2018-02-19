---
id: 146
title: 'Going Controller-less in MVC: The Way Fowler Meant It To Be'
date: 2009-06-18T07:06:09+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2009/06/18/going-controller-less-in-mvc-the-way-fowler-meant-it.aspx
permalink: /2009/06/18/going-controller-less-in-mvc-the-way-fowler-meant-it/
dsq_thread_id:
  - "262114418"
categories:
  - Controllerless
  - FubuMVC
  - MVC
---
This is sort of a stream-of-consciousness post. Several folks have been asking me what I mean by ‘Controllerless actions’ and what I’m thinking about doing in FubuMVC.&#160; The conversation has already started publically on twitter, so I thought I’d try to capture a brain-dump of my thoughts in a blog post so the conversation can continue.&#160; This post likely won’t be up to my normally high (read: barely legible) standards. Please forgive.

Before we go further, read this:

<http://www.martinfowler.com/eaaCatalog/frontController.html>

And then view this:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> ProductController : Controller
{
    <span class="kwrd">private</span> IProductRepository _repository;

    <span class="kwrd">public</span> ProductController()
    {
        <span class="rem">/// That is the only point you need to replace</span>
        <span class="rem">/// if the data source changes.</span>
         _repository = <span class="kwrd">new</span> EntityProductRepository();
    }

    <span class="kwrd">public</span> ProductController(IProductRepository repository)
    {
        <span class="kwrd">this</span>._repository = repository;
    }

    <span class="kwrd">public</span> ActionResult Index()
    {
        <span class="kwrd">return</span> View(_repository.GetAll());
    }

    <span class="kwrd">public</span> ActionResult Create()
    {
        <span class="kwrd">return</span> View();
    }

    [AcceptVerbs(HttpVerbs.Post)]
    <span class="kwrd">public</span> ActionResult Create([Bind(Exclude = <span class="str">"Id"</span>)] Product productToCreate)
    {
        <span class="kwrd">if</span> (_repository.Create(productToCreate))
            <span class="kwrd">return</span> RedirectToAction(“Index”);

        <span class="kwrd">return</span> View();
    }

    <span class="kwrd">public</span> ActionResult Edit(<span class="kwrd">int</span> id)
    {
        <span class="kwrd">return</span> View(_repository.Get(id));
    }

    [AcceptVerbs(HttpVerbs.Post)]
    <span class="kwrd">public</span> ActionResult Edit(Product productToEdit)
    {
        <span class="kwrd">if</span> (_repository.Update(productToEdit))
            <span class="kwrd">return</span> RedirectToAction(“Index”);

        <span class="kwrd">return</span> View();
    }

    <span class="kwrd">public</span> ActionResult Delete(<span class="kwrd">int</span> id)
    {
        <span class="kwrd">return</span> View(_repository.Get(id));
    }

    [AcceptVerbs(HttpVerbs.Post)]
    <span class="kwrd">public</span> ActionResult Delete(Product productToDelete)
    {
        <span class="kwrd">if</span> (_repository.Delete(productToDelete.ID))
            <span class="kwrd">return</span> RedirectToAction(“Index”);

        <span class="kwrd">return</span> View();
    }
}</pre>
</div>

I’m pretty sure this ProductController is not exactly what Martin Fowler had in mind.&#160; Yet, it’s probably an actually cleaner example of what most controllers that are currently being written “in the wild” for ASP.NET MVC and MonoRail (the two most popular MVC frameworks for .NET) look like.

ProductController is a somewhat monolithic controller in that it has many actions.&#160; It’s structured this way for several different reasons, a few of which I’ll list here:

  * The limitations of the framework upon which it’s built.&#160; ASP.NET MVC, MonoRail, FubuMVC, and others are structured around controllers and actions (yes, even the venerable, estimable Ruby on Rails [peace be upon it] has this mindset to one extent or another). 
  * The limitations of our imaginations: That’s how we’ve always done MVC! 
  * The habit of doing Model2 style MVC (from which the Heavy Controller/Action paradigm comes) 

Reading Fowler’s ideas on Front Controller, and looking at these Model2-esque controllers and actions, I scratched my head and said, ‘Huh. That isn’t right!’

## 

## Model 2

Model2-style MVC is concerned primarily with whole request handling and/or whole page rendering.&#160; This was OK in the days of non-AJAX whole page post-backs (uphill, both ways, in the snow, with bare feet).&#160; But in the modern day of heavily templated, composite UIs (think ASP.NET WebForms MasterPages, Spark Layouts, Partials, etc), and with heavy AJAX use for browser-initiated partial updates, the whole-page rendering concept doesn’t really hold up.

We usually end up contorting and bending the framework to do things that don’t really hold up that well under the Model2 way of thinking.

## Front Controller

In the Front Controller pattern, the only “Controller” present is the dumb front controller that has two methods on it: Get() and Post() and you could probably just boil those down to HandleRequest().&#160; If this sounds oddly reminiscent of IHttpHandler, you’re thinking correctly.&#160; An IHttpHandler is, in one manner of speaking, a Front Controller.&#160; Properly implemented, the Front Controller would load a series of commands for that particular URL/request context and then execute them either via round robin or via chain-of-responsibility (in serial).

In ASP.NET MVC, MonoRail, FubuMVC, and several other MVC frameworks for .NET, the Controller Action is essentially one BIG command that handles almost all aspects of the request.&#160; Action Filters and FubuMVC’s Behaviors serve as a way of achieving the more compositional benefits of Commands, but they both have some limitations.

If you’ve been doing any serious MVC work with any of the popular frameworks recently, you will have certainly felt the pain of controller actions getting too large, or having too many concerns.&#160; You may also have noticed that your views require data that’s otherwise totally unrelated to the current request (i.e. the user’s current login status for a request to retrieve a list of all products in the persistence store).&#160; So you might use Action Filters or FubuMVC Behaviors to compose all the data the view will eventually need.&#160; Action Filters, being attributes on the Action and thus explicitly declared, present a strong challenge to proper compositional assembly of the data needed by the view for that request. FubuMVC behaviors certainly handle this better, but the configuration can get a little messy and verbose wiring them up explicitly or even conventionally to your actions. So they are not without their drawbacks also.

This all leads inexorably to the questions: Why even have a controller at all?&#160; Aren’t actions really just things-to-do in their own right? And aren’t Actions only a part of the responsibility of fulfilling the request (the rest being satisfied by Action Filters/Behaviors)?

What if we promoted that idea of action filters/behaviors, and the stuff-to-do-for-this-request to equal footing – each simply being a command that gets executed for a particular request?

There’s one little tiny problem in that, when in your Master Page, for example, you may need one tiny nugget of information that’s completely unrelated to the current request, but otherwise needs to be satisfied.&#160; Rendering the view, then, becomes yet another command that can actually trigger more commands to be executed.

## Explicitly Configured combined with View-Driven Command Resolution and Execution

After several talks with folks like Mark Nijhof, Jeremy Miller, Jimmy Bogard, and others, it soon became clear that we needed to rethink how we were approaching our MVC-based designs and to try to get more in touch with our “Inner Fowler” so to speak (but not too much).

I have observed that there are, in any MVC request, explicit things that need to happen (NHibernate Session-per-Request, load the current IPrincipal for ASP.NET Authorization, load the current user’s culture and timezone information, etc).&#160; There are also things that MAY need to happen based on whether the View needs some particular type of information.&#160; The view generally shouldn’t be making decisions other than to simply declare that it needs a partial rendered (or a MasterPage, etc).&#160; Theoretically with WebForms or Spark views, we could, at config-time, figure out just exactly what information the view and its various partials are going to require. This way you could resolve everything at config-time and avoid any nasty runtime problems with missing information and such. I’m somewhat down on this theory and I’m anticipating this won’t work out like I hope and that there will always be runtime gotchas here.

At any rate, if we have to live with runtime surprises while we flush out this idea, that’s OK for right now.&#160; But I really feel that the general idea (that is, demand-based command execution) is going on the right track.

## Explicitly Configured Command Resolution and Execution

This one is easy: Just configure it!&#160; We’ll have a fluent API or some sort of conventional way (or both) of automatically determining which commands need to be executed for a given request/URL.&#160; FubuMVC currently has this with behaviors so this is achievable today, but I think we can do better and I intend to.

## View-Driven Command Resolution and Execution

This one is a little tricky since the View will be requesting this at render time, on-the-fly and may result in YSOD’s if something it depends upon isn’t available.&#160; 

I’m thinking that the View would have access to the IoC Container (or Common Service Locator as the case may be) and will request something like IFubuCommand<TModel> where TModel is the particular type of model that partial requires. So you might see something like this:

<%= this.RenderPartialFor<LoginStatusModel>().Using<LoginStatusPartial>() %>

The RenderPartialForExpression would then access the IoC container and retrieve an implementation of IFubuCommand<LoginStatusModel> and then pass that to the LoginStatusPartial (which may turn around and request other IFubuCommand<XYZ>’s.

## Command Registration

Commands would be registered at config-time via the normal IoC container configuration.&#160; Using StructureMap, for example, you would simply scan all or certain assemblies for any class implementing ICommand<TModel> and load them automatically into the container as handlers.

## Diagnostics

This is also somewhat complicated since the views may request different things at runtime (they may request an IFubuCommand<MODEL> where MODEL may not be known until runtime in which case things may go awry.

You could probe the Container for all IFubuCommand<TModels>’s and then simply observe Views as they execute and deliver a report after-the-fact to show what was used, by whom, and how much.&#160; While this won’t necessarily be exhaustive, it would likely help a developer who’s troubleshooting a particular issue (or perhaps a transient, occasional error).

## URL Resolution

This is perhaps the biggest change. Since there are no controllers or actions, the URL becomes the only distinguishing characteristic between two “actions” (or chains of commands) to be performed server-side.&#160; That means the URL (or URL stub like /blah/baz/{Id}) becomes a first-class citizen – probably even its own class/type.&#160; 

One thought I’ve been kicking around about this is that you would have a class per URL Stub which has c’tor parameters or properties representing the various options of the URL.&#160; For example, consider this “URL object” or “Action object”:

<div class="csharpcode-wrapper">
  <pre><span class="kwrd">public</span> <span class="kwrd">class</span> EditProduct
{
  <span class="rem">// /products/edit</span>
  <span class="kwrd">public</span> EditProduct()
  {
  }
  
  <span class="rem">// /products/edit/9</span>
  <span class="kwrd">public</span> EditProduct(<span class="kwrd">int</span> id)
  {
    Id = id;
  }
  
  <span class="kwrd">public</span> Id{ get; set;}
}</pre>
</div>

And to render a hyperlink to this action, for example, you might: <%= this.LinkTo<EditProduct>(Model.ProductId) %>

or even:&#160; <%= new EditProduct(Model.ProductId) %>

Which is a lot cleaner than: <%= this.HyperLinkTo<ProductController>((p,i)=>p.EditProduct(i)) %>

## Wrapping Up

So this is my brain dump and currently the rough plan I’m using to spike out some of these things in FubuMVC.&#160; Some of it is working out, other things I’m still skeptical.

I’d love to hear what you’re thinking with your MVC-based designs.&#160; How are YOU handling the composition problems?