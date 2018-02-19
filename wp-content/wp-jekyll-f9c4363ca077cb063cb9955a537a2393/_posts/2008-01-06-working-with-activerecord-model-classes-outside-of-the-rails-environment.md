---
id: 8
title: Working with ActiveRecord model classes outside of the Rails environment
date: 2008-01-06T13:27:50+00:00
author: Chad Myers
layout: post
guid: /blogs/chad_myers/archive/2008/01/06/working-with-activerecord-model-classes-outside-of-the-rails-environment.aspx
permalink: /2008/01/06/working-with-activerecord-model-classes-outside-of-the-rails-environment/
dsq_thread_id:
  - "262113565"
categories:
  - Rails
  - Ruby
---
I had a task yesterday that involved me wanting to dump some information about a Rails ActiveRecord class I had (don&#8217;t ask, it&#8217;s a long story).

I wanted to access my AR class from outside the Rails web environment (i.e. I wanted to type &#8216;ruby something&#8217; from the command line).

I put a file in the scripts folder and put the following code at the top:

> ENV['RAILS\_ENV'] = ARGV.first || ENV['RAILS\_ENV'] || &#8216;development&#8217;  
> RAILS\_ROOT = &#8220;#{File.dirname(\\_\_FILE\_\_)}/..&#8221; unless defined?(RAILS_ROOT)  
> require &#8216;rubygems&#8217;  
> require &#8216;active_record&#8217; 
> 
> ActiveRecord::Base.establish\_connection(YAML::load(File.open(&#8216;config/database.yml&#8217;))[ENV['RAILS\_ENV']])</blockquote> 
> 
> From here on out, you have the basics of the rails environment and can execute ActiveRecord functionality.