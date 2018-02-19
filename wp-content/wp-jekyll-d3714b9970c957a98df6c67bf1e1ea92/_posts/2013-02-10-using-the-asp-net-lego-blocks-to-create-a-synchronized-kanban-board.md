---
id: 401
title: using the asp.net lego blocks to create a synchronized Kanban board.
date: 2013-02-10T10:43:00+00:00
author: Eric Hexter
layout: post
guid: http://lostechies.com/erichexter/?p=401
permalink: /2013/02/10/using-the-asp-net-lego-blocks-to-create-a-synchronized-kanban-board/
dsq_thread_id:
  - "1075910585"
categories:
  - Asp.Net
  - Asp.Net MVC
  - jQuery
  - jquery mobile
  - knockoutJs
  - Open Source Software
  - signalR
---
Over the last 1-2 years the capabilities of the web lego blocks (libraries) have really come together to allow us, the web development community. to start putting together some really interesting applications. The best part is all of the plumbing code is in the libraries. You can know write a rich user experience without having to write a lot of code. The example app uses [ASP.Net MVC](http://www.asp.net/mvc), [ASP.Net WebAPI](http://www.asp.net/web-api), [SignalR](http://signalr.net/), [KnockoutJS](http://knockoutjs.com/),  [jQuery](http://jquery.com/), [jQuery UI](http://jqueryui.com/), and [Twtitter Bootstrap](http://twitter.github.com/bootstrap/).

If you are really interested in this project, fork it on github [https://github.com/erichexter/SyncKanbanSample](https://github.com/erichexter/SyncKanbanSample "https://github.com/erichexter/SyncKanbanSample")

## A Synchronized Kanban board

A kanban board is pretty simple, it has a collection of vertical swim lanes and items that move from one lane to the next, from left to right.  Below is a screen shot of the application I put together in a few hours. The interesting features are you can click and drag a post it note from one column to another, this is then saved on the server behind the scenes. Then if two people are looking at the same board, the changes will be synchronized on each others web browser in real time.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb.png" alt="image" width="703" height="786" border="0" />](http://lostechies.com/erichexter/files/2013/02/image.png)

To allow the drag and drop, I used the jQuery UI <a href="http://jqueryui.com/sortable/" target="_blank">Sortable</a> interaction.  To enable the mulit browser syncronization I used a combination of <a href="http://knockoutjs.com/" target="_blank">KnockoutJS</a> and <a href="http://signalr.net/" target="_blank">SignalR</a>.

Here is an example of the synchronization.



To view this on youtube go here <http://www.youtube.com/watch?v=MXQwhfHzRls&feature=youtu.be>

The Code:

To create the initial screen us use the following code:

ASP.Net MVC Action -

The code in this action will retrieve a board including the collection of lists and tasks and pass that model to the mvc View.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb1.png" alt="image" width="721" height="282" border="0" />](http://lostechies.com/erichexter/files/2013/02/image1.png)

Below is the Board Viewmodel

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb2.png" alt="image" width="480" height="175" border="0" />](http://lostechies.com/erichexter/files/2013/02/image2.png)

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb3.png" alt="image" width="576" height="183" border="0" />](http://lostechies.com/erichexter/files/2013/02/image3.png)

Here is the MVC view.  A majority of the code is the client side templating. All of the data-binding is the KnockoutJS client side binding syntax.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb4.png" alt="image" width="718" height="465" border="0" />](http://lostechies.com/erichexter/files/2013/02/image4.png)

The script on the page wires up the knockout bindings, a jQuery Sortable knockout plugin, and the signalR initialization code.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb5.png" alt="image" width="721" height="820" border="0" />](http://lostechies.com/erichexter/files/2013/02/image5.png)

The code below shows the SignalR server side code “Hub”. The two main server side code snippets is the getAllLists, which will send down all the lists and tasks when the board initializes. The second method is the movedTask method which is executed when a card is dropped in a column.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb6.png" alt="image" width="718" height="765" border="0" />](http://lostechies.com/erichexter/files/2013/02/image6.png)

The last piece of code which ties this together is some more client side code which is the client side viewmodel.

This is where the client side code wires up the Sortable Drop with the signalR code to call the server side hub.

[<img style="background-image: none; padding-left: 0px; padding-right: 0px; display: inline; padding-top: 0px; border-width: 0px;" title="image" src="http://lostechies.com/erichexter/files/2013/02/image_thumb7.png" alt="image" width="708" height="744" border="0" />](http://lostechies.com/erichexter/files/2013/02/image7.png)