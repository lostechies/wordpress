---
id: 196
title: 'Cool stuff in FubuCore No. 5: Easy Configuration'
date: 2011-06-03T18:16:00+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=196
permalink: /2011/06/03/cool-stuff-in-fubucore-no-5-easy-configuration/
dsq_thread_id:
  - "321667257"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the fifth post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

In the whole history of FubuMVC, we’ve developed and innovated a bunch of cool stuff. [Some of it](http://guides.fubumvc.com/advanced_behaviors.html) can be complicated but has a big payoff.&nbsp; But there are also a bunch of small, little cool things that make a big difference. One of those things was the [ISettingsProvider](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Configuration/ISettingsProvider.cs).&nbsp; It was one of those ideas that we could’ve come up with a long time ago, before FubuMVC, but it had just never occurred to us.&nbsp; I wish I had this way back when, because it would’ve been invaluable to me on many projects.&nbsp; I can’t tell you how much stupid code I’ve written in my .NET career just to work around a lot of the System.Configuration nonsense. “Nonsense?” you say. Perhaps I should have said “mystery” as in, a mystery that needs to be [unraveled](http://www.codeproject.com/KB/dotnet/mysteriesofconfiguration.aspx), [decoded](http://www.codeproject.com/KB/dotnet/mysteriesofconfiguration2.aspx), and [cracked](http://www.codeproject.com/KB/dotnet/mysteriesofconfiguration3.aspx).&nbsp; I’m sure someone once had problems that this framework solved, but for most of us, we just need something less complicated than [this](http://msdn.microsoft.com/en-us/library/ff648130.aspx).

I kept finding myself saying, “Dang, I wish I could just get my settings injected like everything else” (settings are a dependency, after all).&nbsp;&nbsp; And I don’t want some sort of “SettingsFactory” that needs injected that I then have to go query for my configuration because that gets nasty to test (lots of mocks and interaction testing). What I _really_ want is just a POCO object that represents my settings and have [someone else](http://structuremap.net/structuremap/) figure out how to get those settings from whatever configuration source and bind them to my POCO settings class.&nbsp; 

## The Settings Provider

This is where ISettingsProvider comes in. It works behind the scenes with my IoC container to set up my settings class. Consider this simple POCO settings class:

<pre class="brush:csharp">public class SampleSettings
{
    public string Name { get; set; }
    public int Age { get; set; }
    public bool Active { get; set; }
}</pre>

Let’s say I want this thing injected (via constructor injection, for example) into my controller.&nbsp; Then I can use my settings in my action(s) just like normal. My controller would never have to even know about System.Configuration or AppSettings or anything like that.

My controller might look like this:

<pre class="brush:csharp">public class SampleController
{
    private SampleSettings _settings;
    
    public SampleController(SampleSettings settings)
    {
        _settings = settings;
    }
    
    public SampleOutputModel Index(SampleInputModel model)
    {
        return new SampleOutputModel{ Aget = _settings.Age };
    }
}</pre>

As a side note: In FubuMVC, controllers don’t have to derive from any base classes and actions just take in and return models because [controller actions shouldn’t have the extra responsibility](http://codebetter.com/jeremymiller/2008/10/23/our-opinions-on-the-asp-net-mvc-introducing-the-thunderdome-principle/) of choosing what type of output goes back to the client. In FubuMVC, you describe how actions are wired up to views or JSON or whatever the appropriate response is to the requesting HTTP client. But I digress…

In this SampleController example, you can see that my settings are injected via the constructor and then used in a controller action just like you would expect.

## How it all gets wired up

### Scan for Settings classes

In your StructureMap Registry class, add a “Scan” block that uses the [SettingsScanner](https://github.com/DarthFubuMVC/fubumvc/blob/master/src/FubuMVC.StructureMap/SettingsScanner.cs) from FubuMVC. If you just want to use FubuCore in your project and not FubuMVC, then [just copy](https://github.com/DarthFubuMVC/fubumvc/blob/master/license.txt) SettingsScanner into your project, it’s not that big.

The new “Scan” section in your Registry would look something like this:

<pre class="brush:csharp">x.Scan(s =&gt;
{
    s.TheCallingAssembly();
    s.Convention&lt;settingsscanner&gt;();
});
</pre>

SettingsScanner will scan all the assemblies you tell it about (“TheCallingAssembly” in this case) for any concrete classes whose names end with “Settings”.&nbsp; It will then wire them up in StructureMap so that whenever a class has a dependency on a *Settings class, StructureMap will use the configured ISettingsProvider to “fill” your Settings POCO class from whatever configuration source(s) you’re using. For those familiar with StructureMap configuration parlance, that would be:

<pre class="brush:csharp">For(type)
   .LifecycleIs(InstanceScope.Singleton)
   .Use(c =&gt; c.GetInstance&lt;ISettingsProvider&gt;()
       .SettingsFor(type));
</pre>

&nbsp;

### Register a settings provider

The next thing you have to do is tell StructureMap which ISettingsProvider you want to serve up your *Settings classes.

Currently, FubuCore ships with one built-in: the [AppSettingsProvider](https://github.com/DarthFubuMVC/fubucore/blob/master/src/FubuCore/Configuration/AppSettingsProvider.cs).&nbsp; As you might imagine, this will bind your settings classes and their properties to appSettings keys in your .config files.&nbsp; It follows a specific convention for appSettings keys, which is:&nbsp; [SettingsClassName].[PropertyName].&nbsp;&nbsp; Consider the example class above (SampleSettings).&nbsp; To wire up the Age property, the resulting appSettings entry would look like this:

<pre class="brush:xml">&lt;appSettings&gt;
    &lt;add key="SampleSettings.Age" value="29"/&gt;
&lt;/appSettings&gt;
</pre>

&nbsp;

That’s pretty much it. Wire up the scanner, wire up an ISettingsProvider implementation, make a Settings class, and add it as a constructor dependency and it should just all work.

### Future

Hopefully you can see a bunch of possibilities with the ISettingsProvider. We’ve imagined doing all sorts of things which should be possible:

  * Loading settings from the Database 
      * Loading settings from an encrypted storage source 
          * Loading settings dynamically every time they’re requested (allowing for runtime setting changes without needing to restart the app) 
              * Loading settings from multiple config sources (some in the DB, some in config files, some in encrypted storage)</ul> 
            (the more observant among you probably noticed our imagination of the future does not involve System.Configuration if we can help it).
            
            In fact, the Bottles deployment stuff that Jeremy and Dru are doing that I mentioned in the last post involves a multi-config source settings provider that provides a lot of flexibility in configuration and deployment. Keep an eye out for that in the near future from either [Jeremy](http://codebetter.com/jeremymiller) or [Dru](http://codebetter.com/drusellers/).
            
            ## Summary
            
            Hopefully you got some useful ideas and practical next steps from this post. If you come up with any cool ISettingsProviders in your usage, please let us know and contribute them back if they’re not “secret sauce” for you.