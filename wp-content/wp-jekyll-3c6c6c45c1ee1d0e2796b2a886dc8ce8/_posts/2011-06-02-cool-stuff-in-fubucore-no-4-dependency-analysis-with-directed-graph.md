---
id: 194
title: 'Cool stuff in FubuCore No. 4: Dependency Analysis with Directed Graph'
date: 2011-06-02T13:41:00+00:00
author: Chad Myers
layout: post
guid: http://lostechies.com/chadmyers/?p=194
permalink: /2011/06/02/cool-stuff-in-fubucore-no-4-dependency-analysis-with-directed-graph/
dsq_thread_id:
  - "320607788"
categories:
  - .NET
  - cool-stuff-in-fubu
  - fubucore
  - FubuMVC
---
This is the fourth post of the FubuCore series mentioned in the [Introduction post](http://lostechies.com/chadmyers/2011/05/30/cool-stuff-in-fubucore-and-fubumvc-series/).

There are several places in the Fubu-related projects (FubuMVC, Bottles packaging/deployment, etc) that we need to work out a dependency tree.&nbsp; This means, for a given node, we need to find out all the dependencies that node has and if there are any cycles in the dependency graph.&nbsp; I’m being vague. Let me be more concrete. 

FubuMVC has [script management](https://github.com/DarthFubuMVC/fubumvc/tree/master/src/FubuMVC.Core/UI/Scripts) functionality. Actually, it has resource management because it can handle more than just scripts (like CSS), but the main problem has to do with script dependencies.&nbsp; We do a \*lot\* of stuff with JavaScript and jQuery. We use a lot of jQuery plugins and we have a lot of internal plugins we’ve written for our app.&nbsp; The dependency graph gets kinda complicated: ScriptX depends on ScriptY which depends on jQuery.Validate and jQuery.UI and all these four scripts depend on jQuery proper.&nbsp; So if a view requests that ScriptX be added to the HTML output, our script manager has to also ensure that <script> tags are rendered to include jQuery, jQuery.UI, jQuery.Validate, ScriptY and then ScriptX (in that order – though jQuery.UI and jQuery.Validate can be in either order). 

Later, if another view requests, say, ScriptY, the script manager knows that ScriptY and all its dependencies have already been rendered, so it does nothing.&nbsp; So the script manager ensures once-and-only-once and dependency graph resolution (among other things).

<p align="left">
  We ran into a similar situation in our deployment story when figuring out what dependencies application X has when being deployed.&nbsp; Rather than re-writing dependency graph resolution logic again, <a href="http://codebetter.com/drusellers/">Dru</a> and <a href="http://codebetter.com/jeremymiller/">Jeremy</a> decided to figure out if there was common algorithm for doing this sort of thing.&nbsp; They found some and then implemented them in FubuCore.&nbsp; We’re currently using it for Bottles Deployment and will soon retro-fit it back into Script Manager.&nbsp;
</p>

<h2 align="left">
  First, the math!
</h2>

<p align="left">
  Here’s where they started:
</p>

<p align="left">
  <a href="http://en.wikipedia.org/wiki/Directed_graph">Directed Graph</a>
</p>

<p align="left">
  <a href="http://en.wikipedia.org/wiki/Tarjan%27s_strongly_connected_components_algorithm">Tarjan’s strongly connected components algorithm</a>&nbsp;
</p>

<p align="left">
  Some <a href="http://algowiki.net/wiki/index.php?title=Tarjan%27s_algorithm">pseudo code</a> for Tarjan’s algorithm
</p>

<p align="left">
  Some S.O. Q/A on the subject of detecting cycles in a graph:
</p>

<p align="left">
  <a href="http://stackoverflow.com/questions/261573/best-algorithm-for-detecting-cycles-in-a-directed-graph">Best algorithm for detecting cycles in a directed graph</a>
</p>

<p align="left">
  <a href="http://stackoverflow.com/questions/546655/finding-all-cycles-in-graph">Finding all cycles in a graph</a>
</p>

<h2 align="left">
  Second, the implementation
</h2>

<p align="left">
  They wrote the implementation to be use-case agnostic. They made it generic to apply to any dependency-resolution situation so that we could reuse it for numerous things like deployment and script management.
</p>

<p align="left">
  It all starts with DependencyGraph.&nbsp; You tell DependencyGraph about your main graph model object (think ‘script’ for the script manager or ‘component’ for deployment).&nbsp; Another good example is a build tool (say, rake).&nbsp; Rake, like every other build tool, has targets (i.e. ‘compile’ or ‘test’). Targets have dependencies (‘test’ may require ‘compile’ and ‘deploy_config’).&nbsp; A rakefile (like a makefile or NAnt build file or MSBuild file) has a flat list of all the targets.&nbsp; You would feed this list to DependencyGraph and then tell it how to find the dependencies for each task.
</p>

<p align="left">
  For this post, let’s talk about Bottles (since that’s what DependencyGraph was originally written for and is currently the best example of its use). In Bottles, a deployable unit (or component) is called a “<a href="https://github.com/DarthFubuMVC/bottles/blob/master/src/Bottles.Deployment/Recipe.cs">Recipe</a>.” The Recipe object has a [Name : string] property and a [Dependencies : IEnumerable<string>]&nbsp; property.&nbsp;
</p>

<p align="left">
  In Bottles, we need to feed a flattened list of all the recipes and their dependencies (which we get from a config file) and want DependencyGraph to tell us the order of how all the recipes need to be installed. Consider this code snippet:
</p>

<pre class="brush:csharp">// Teach D.G. how get a unique key/name and list of deps for each recipe
var graph = new DependencyGraph&lt;Recipe&gt;(r =&gt; r.Name, r =&gt; r.Dependencies);

// Register each recipe with the graph
recipes.Each(graph.RegisterItem);

// Ask the graph to give us the final, properly-ordered list
return graph.Ordered();</pre>

<p align="left">
  Our script management works similarly (the list of scripts and their dependencies are in a <a href="https://github.com/DarthFubuMVC/fubumvc/blob/master/src/FubuMVC.Diagnostics/diagnostics.script.config">config file</a>).&nbsp; We have a <a href="https://github.com/DarthFubuMVC/fubumvc/blob/master/src/FubuMVC.Core/UI/Scripts/IScriptObject.cs">model object</a> that represents a configured script and its related dependencies.&nbsp; We’d be able to reuse that DependencyGraph code above fairly easily to take advantage of the algorithm implementations and remove a bunch of code from FubuMVC’s script management. We just haven’t done it yet :)
</p>

<h2 align="left">
  Summary
</h2>

<p align="left">
  If you’re working with a list of things that have dependencies and you need to know the order that those things should be processed to honor the dependency chain, consider using the DependencyGraph in FubuCore!
</p>