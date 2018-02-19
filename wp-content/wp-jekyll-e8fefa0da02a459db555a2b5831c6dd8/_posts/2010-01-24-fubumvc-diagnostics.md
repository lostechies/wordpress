---
id: 159
title: FubuMVC Diagnostics
date: 2010-01-24T22:07:36+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2010/01/24/fubumvc-diagnostics.aspx
permalink: /2010/01/24/fubumvc-diagnostics/
dsq_thread_id:
  - "262114489"
categories:
  - FubuMVC
---
_This post is about the_ [_FubuMVC_](http://fubumvc.com/) _framework. For more info on getting started, click the previous link, or view the_ [_Getting started wiki page_](http://wiki.fubumvc.com/Getting_started)_._

FubuMVC’s configuration model is a _[semantic model](http://martinfowler.com/dslwip/SemanticModel.html)_ that is built up by an API.&#160; This allows great flexibility in how FubuMVC is configured as it could have several different ways of configuring it.&#160; Originally, we envisioned a conventional mode where routes are discovered and configured conventionally as well as another mode (thanks to input from [Aaron Jensen](http://codebetter.com/blogs/aaron.jensen/)) where routes would be explicitly defined up front and then matched to controllers and actions according to strict rules.&#160; There are several other modes/scenarios we thought of, but those two appear to be the most compelling.

As of this moment, in the source tree we have only completed one API/mode for configuring FubuMVC: the conventional one.&#160; For our application at Dovetail, we have a lot of actions that are very similar and conventional, so the conventional configuration of FubuMVC made sense for us to start with at first.

Having well-defined conventions is very nice in that it makes configuration a breeze and gets us away from reams and reams of XML or code for configuring our web framework.&#160; The down side is that because there is so much happening automatically to configure our routes, it gets hard to troubleshoot why something went wrong if we make a mistake.

We’ve tried to combat this problem by having lots of logging and diagnostics within the framework itself so you can see what actually got configured and even get some clues as to “Why” the conventional configuration mode did what it did.

## Diagnostics Portal

**NOTE**: if you don’t already have a FubuMVC-based application up and running, you check out Tim Tyrrell’s [super quick guide to getting started on FubuMVC](http://blog.timtyrrell.net/2010/01/hello-world-with-fubumvc-super-quick.html).

Once you have your FubuMVC-based application up and running and you can successfully browse to your routes/actions, you should try hitting the FubuMVC diagnostics portal.&#160; First, make sure that you have enabled diagnostics in your Global.asax (if you’re using the FubuStructureMapApplication) by setting EnableDiagnostics = true, or (if you have your own FubuRegistry-derived class), passing true to IncludeDiagnostics(bool).&#160; Next, navigate your browser to http://<yourserver>/<yourapp>/_fubu.&#160; You should see the portal home screen, like this:

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="fubu_diags_home" src="http://lostechies.com/chadmyers/files/2011/03/fubu_diags_home_thumb_17C2A247.png" width="674" height="207" />](http://lostechies.com/chadmyers/files/2011/03/fubu_diags_home_0BC0B213.png) 

### Chains

“Chains” means “Behavior Chains”.&#160; FubuMVC executes routes by using a sort of chain-of-command pattern (not exactly chain-of-command, but it’s similar).&#160; Many “behavior nodes” or “behaviors” are chained together and each get an opportunity to service part or all of the request.&#160; Some examples of behaviors are “Invoke the action”, “Render a WebForm view”, “Log the request”, “Render output model as JSON”, etc.&#160; Behaviors get associated with chains conventionally through your configuration.&#160; To view all the chains that are available, click on the “Chains” link. At which point you’ll see a screen something like this (from the FubuMVC HelloWorld sample application):

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="fubu_diags_chains" src="http://lostechies.com/chadmyers/files/2011/03/fubu_diags_chains_thumb_0E49E3D1.png" width="906" height="281" />](http://lostechies.com/chadmyers/files/2011/03/fubu_diags_chains_343F9427.png) 

&#160;

In this screen, you can see that there are four routes/chains/actions (actually, there are more, I cut out some others for the sake of keeping the image as small as possible).

You should also note (as an aside), that there is a special “(default)” route and two methods that are HTTP method-constrained.&#160; Joshua Flanagan detailed the HTTP method constraining capabilities of FubuMVC in his recent post “[Define your actions your way](http://www.lostechies.com/blogs/joshuaflanagan/archive/2010/01/18/fubumvc-define-your-actions-your-way.aspx).”

When you click on a chain (I clicked on “(default)”) you’ll see a screen with more detail including the behaviors (“Nodes”) and a short log (I’ll explain this in a second):

[<img style="border-bottom: 0px;border-left: 0px;border-top: 0px;border-right: 0px" border="0" alt="fubu_diags_chain_nodes" src="http://lostechies.com/chadmyers/files/2011/03/fubu_diags_chain_nodes_thumb_3BAB79A1.png" width="902" height="731" />](http://lostechies.com/chadmyers/files/2011/03/fubu_diags_chain_nodes_08030D43.png) 

#### Chain – Nodes

This table represents all the behavior “nodes” in the behavior chain for this route.&#160; Here we can see five behaviors.&#160; Three of them are diagnostic behaviors (behaviors that enable the FubuDebug tracing feature described in an upcoming post). So let’s ignore them for now.&#160; If you had diagnostics disabled, there would only be two behaviors in this chain:&#160; The “Call” behavior and the “Output” behavior. The “Call” behavior is the one that will actually call your controller action method. The “Output” behavior is, as you can probably guess, responsible for actually binding the output of the action method to the view and rendering it.&#160; This is a very simplistic example. Real-world apps would likely have several more behaviors attached for example one to log the request, one to start a database transaction, etc.

#### Chain &#8211; Log

The log output gives you a window into how all the conventions in your FubuRegistry contributed towards the configuration of this route/chain.&#160; If the right behavior didn’t get wired up or the wrong one did, this log may reveal the answer “Why”.&#160; This is helpful for troubleshooting in large applications where conventions are complex and may even collide in some circumstances.&#160; Using the log can help you make your conventions more explicit so as to avoid collisions or misses.

### Routes

This screen is very similar to the “Chains” view, except it shows the Route, the Action that will be executed, what the Output will be, and then has a link to the chain view for this route.&#160; The “Routes” view is helpful if you want a quick view of which routes map to which actions or output views.

### Actions

This screen is similar to the others, but is organized by Action, alphabetically. This screen is useful if you’re investigating why a particular action is behaving the way it’s behaving.

### Inputs

This screen lists all the input model types and their associated actions.&#160; In FubuMVC, action routes are usually (but not only) identified by their input model types (since FubuMVC prefers the one-model-in, one-model-out style of action methods).&#160; You can request the route/URL for a given input model type in FubuMVC.&#160; If you’re not getting back the expected URL for the specified input type, use this “Inputs” view to help track down why it’s not working right.

## Summary

In this post I showed you how to enable and view the FubuMVC diagnostics portal and what the various screens in the portal mean. I hope that this portal assists you in learning about FubuMVC and to troubleshoot any problems that may come up when setting up your application.