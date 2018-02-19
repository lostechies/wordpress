---
id: 84
title: Thoughts on MVP and WebForms
date: 2008-08-30T03:31:35+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/08/29/thoughts-on-mvp-and-webforms.aspx
permalink: /2008/08/30/thoughts-on-mvp-and-webforms/
dsq_thread_id:
  - "262114010"
categories:
  - ASP.NET
  - MVP
---
I got an email from a friend asking about MVP in WebForms and how the view should do databinding.&#160; There was talk of using a FormView and various *DataSource objects, so I thought I’d do a brain-dump of MVP and Presentation Model.&#160; I’ve had a few other people ask me about this recently, so I hope it benefits all of you.

Also, I’d like to credit Jeremy with most of my knowledge on this. NOTE: Don’t blame him for any inaccuracies or misunderstandings I may have, they are my own :)

So, here goes:

> First, there’s a few points of clarification/context that you should know about my advice:
> 
>   1. It’s fairly well established that there is no good pattern for dealing with ASP.NET WebForms (i.e. <form runat=server>) that won’t break down after significant use. 
>       * If you’re writing internal/intranet line-of-business type apps and you can get away with lower quality and poor usability, WebForms are good enough because you can bang out apps pretty fast without as much emphasis on quality as you might need to have with a public-facing or shipping premise product&#160;&#160; 
>       * The alternative would be ASP.NET MVC (all the good stuff about ASP.NET without the form runat=server), MonoRail, or even a home-grown MVC framework. Just about anything is better than WebForms at this point. 
>   2. Given #1, MVP is about the best you can do for yourself if you’re stuck in WebForms land, but keep in mind that it’s not a great solution and it’ll wear thin and cause problems at various points.&#160; 
>       * … but less problems than you’d have if you DIDN’T use it 
>       * … assuming that you’re using MVP to afford you some testability also 
>   3. IMHO, views should NEVER hit a database, ever. Period. They shouldn’t even have a concept of a database, nor that the data comes from one. 
>       * Unless you’re building a strict forms-over-data app where there’s almost no logic and you need a dirt simple UI for putting stuff into a DB and editing stuff already in there 
>       * In which case, you should consider the ASP.NET Dynamic Data Services (Astoria) in .NET 3.5 and be done with the whole thing 
> 
> Ok, now, on to the meat!
> 
> There are generally two major flavors of MVP: Supervising Controller and Passive View. In short:
> 
>   * Supervising Controller (aka Supervising Presenter) has the presenter doing very little, merely “supervising” but not actually doing a lot of legwork. In this case, the View and the various Services take care of the heavy lifting. The Controller/presenter just responds to events and shuffles things between the View and Services&#160;   
>     &#160;
>   * Passive View has the view doing almost nothing. The view is just a dumb data displayer and user-entered data-and-events catcher + dispatcher. The controller/presenter does all heavy lifting and grabs things from the view and drives services and such. 
> 
> After looking at these, I hope you picked Passive View, because in my experience, it’s the only one that makes Web Forms manageable and testable to any sufficient level J
> 
> Jeremy Miller taught me, when using Passive View, another concept known as “Presentation Model.” It goes together with Passive View very effectively to achieve highly testable, loosely coupled, highly cohesive designs – even with Web Forms! Unfortunately testing the views is still a major pain, but at least the entire rest of the system is easily decoupled and tested in isolation.
> 
> When using “Presentation Model”, you essentially define a class which is a simple, anemic DTO-style class (that is, just a bunch of getters/setters and not a lot of functionality). It will usually have a few tricks it can do in the getters and setters (i.e. if the FooName value is null, then the XYZ Panel should be hidden, etc – more on this later). Your view makes the Presenter aware that something has happened (i.e. “Hey boss, the user clicked the ‘OK’ button”). The presenter will do whatever is necessary to respond to this event and then call a method back on the view to say “Here’s what you should do.” Let’s call this “Here’s what you should do” method the UpdateYourself(presModel) method. The presModel is our Presentation Model class which has EVERYTHING the view needs present itself, including the visibility of various controls, maybe the text of labels, the enabled/disabled-ness of buttons and fields, even the HTML Title of the page if necessary. The view knows only how to raise events and, when UpdateYourself is called, redraw itself to match the state of things. In essence, the Presenter tells the view: “Here is how you should look. Now make it happen.”
> 
> Your view interface might look like: 
> 
> <div class="csharpcode-wrapper">
>   <pre><span class="kwrd">public</span> <span class="kwrd">interface</span> IUserPreferencesView
{
    <span class="rem">// first page, or maybe ever page_load, regardless of postback</span>
    <span class="kwrd">event</span> EventHandler ViewInitialized; 
    <span class="kwrd">event</span> ResetPasswordHandler ResetPasswordClicked;
    <span class="kwrd">event</span> SavePreferencesHandler SavePreferencesClicked;
    <span class="kwrd">event</span> CancelHandler CancelClicked;
    <span class="kwrd">void</span> UpdateYourself( UserPreferencesPresentationModel model );
}</pre></p>
> </div>
> 
> The event handlers would have only the information that the view gained from the user action (such as the current password, the new password, and the new-password-entered-twice-for-comparison values).
> 
> You could also make all these things properties on the IUserPreferencesView interface and just use basic EventHandlers, too. That’s OK, but it might clutter your interface a lot. Try it both ways and see how it works out for you.
> 
> Your presentation model class might look like:
> 
> <div class="csharpcode-wrapper">
>   <pre><span class="kwrd">public</span> <span class="kwrd">class</span> UserPreferencesPresentationModel
{
    <span class="rem">// maybe not all users are allowed to reset their password? These are contrived examples, bear with me</span>
    <span class="kwrd">public</span> <span class="kwrd">bool</span> ResetPasswordAllowed{ get; set; }                    

    <span class="kwrd">public</span> <span class="kwrd">string</span> Username{ get; set; }
    <span class="kwrd">public</span> <span class="kwrd">string</span> EmailAddress{ get; set; }

    <span class="rem">// Note that you can do some formatting (a form of logic) here instead of in the view</span>
    <span class="kwrd">public</span> <span class="kwrd">string</span> CurrentDateFormatted{ get; set; }

    <span class="kwrd">public</span> <span class="kwrd">bool</span> ChangeManagerAllowed{ get; set; }
    <span class="kwrd">public</span> <span class="kwrd">string</span> ManagerName{ get; set; }
    <span class="kwrd">public</span> <span class="kwrd">int</span> ManagerID{ get; set; }    

    <span class="kwrd">public</span> <span class="kwrd">bool</span> UserWantsToBeNotifiedViewEmail { get; set; }

    <span class="rem">// HTML, plain text, etc</span>
    <span class="kwrd">private</span> EmailType _emailType = EmailType.Default;

    <span class="rem">// Note that you can have some logic here</span>
    <span class="kwrd">public</span> EmailType PreferredEmailType 
    {
        get
        { 
            <span class="kwrd">return</span> UserWantsToBeNotifiedViaEmail 
                    ? _emailType
                    :  EmailType.None;
        }
        set{ _emailType = <span class="kwrd">value</span>; }
    }

    <span class="rem">// etc, etc, etc.</span>
}</pre></p>
> </div>
> 
> Now, the Controller is responsible for assembling all the data together to fill in all the properties (i.e. ManagerName which may come from the Manager table, Username which comes from the user table, etc).
> 
> Also, note that the PresentationModel can have some logic inside of itself. These are then easily testable via state-based testing, like so:
> 
> <div class="csharpcode-wrapper">
>   <pre>[TestFixture]
<span class="kwrd">public</span> <span class="kwrd">class</span> UserPreferencesPresentationModelTester
{
    [Test]
    <span class="kwrd">public</span> <span class="kwrd">void</span>  email_type_should_be_none_when_email_notify_preference_is_false()
    {
        var model = UserPreferencesPresentationModel
        {
            UserWantsToBeNotifiedViewEmail = <span class="kwrd">false</span>;
        };

        Assert.That( model.PreferredEmailType, Is.EqualTo( EmailType.None ) );
    }
}</pre></p>
> </div>
> 
> Also, using the PresentationModel object allows your View to databind directly to these properties without having a lot of “this.that.something.or.another” databind properties. Binding the view is very simple, now.
> 
> <div class="csharpcode-wrapper">
>   <pre><span class="rem">// Meanwhile, in the view…</span>
<span class="kwrd">public</span> <span class="kwrd">void</span>  UpdateYourself(UserPreferencesPresentationModel model )
{
    ResetPasswordTab.Visible = model. ResetPasswordAllowed;
    
    EmailNotifyCheckbox.Checked = model. UserWantsToBeNotifiedViewEmail;
    
    UsernameTextBox.Text = model.Username;

    <span class="rem">// etc, etc, etc</span>
}</pre></p>
> </div>
> 
> Also, testing the views can get a lot simpler now because all you have to do is pass in a PresentationModel set up the way you expect and you can use something like WatiN to verify that the HTML comes out the way you expect.
> 
> Hope this helps.