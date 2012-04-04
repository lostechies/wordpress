/*!
 *
 *  PADPRESSED - App.js
 *
 *	Version  1.0
 *
 *	Author: Armando Sosa
 *
 *  Copyright (C) 2010 Padpressed
 *
 *
 */

// we like conflict;
window.$ = jQuery;

var tap = (window.Touch)?'touchstart':'click';
var ontap = (window.Touch)?'ontouchstart':'onclick';

var App = {

	isSingle : false,

	paged : 0,

	sectionsGridCreated : false,
	
	temp: {},
	
	currentTermType : false,
	currentTermSlug : 'all',
	currentTermTitle : 'All posts',
	currentTermId : -1,


	/**
	 * This one init's everything
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */
	init:function(){

		App.wrapper = document.getElementById('wrapper');
		App.spinner =$('#spinner');

		$(document.body).orientation('portrait');	

		Flan.hasher.init();
		App.Nav = new Flan.FlipNavigation();


		if (!App.isSingle) {
			App.initCover();
		}else{
			App.initSingleSingle();			
		}

	},


	/**
	 * Describe what this method does
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	initCover : function(){
		var cover  =  document.getElementById('cover');
		var entries = document.getElementById('entries');

		App.updatePaginationIndicator();
		

		if (!cover || location.hash.substr(3) === 'all') {

			App.initEntries();
			
		}else{
			
			App.Nav.open(cover,true,'cover');

			setTimeout(function(){
				App.Nav.setNext(entries);
				Flan.Eventual.bind(this,'navigateNext', App.initEntries, true);				
			},0);
			
			
		}
	},

	/**
	 * Sets the title for the entries page.
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	setEntriesTitle: function(title,element){

		// default values
		element = element || App.currentPageElement;
		if (title) {
			App.currentTermTitle = title;			
		}
		element.getElementsByClassName('entries-section-title')[0].innerHTML = App.currentTermTitle;
	},

	/**
	 * Describe what this method does
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	setEntriesClass : function(articlesCount){
		var classes = ['none','one','two','three','four','five','six'];
		$(document.getElementById('entries')).addClass(classes[articlesCount]);
	},

	/**
	 * Describe what this method does
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	getEntriesPage : function(paged){
		
		if (!App.MainMenu) {
			App.MainMenu = new Flan.PopOver(document.getElementById('menu'));
		};

		var paged = paged || 0,
			id = (paged>0)?'entries'+paged:'entries',
			section  = document.getElementById(id),
			menuTitle = document.getElementById('menu-title').innerHTML;

		if (section !== null) return section;

		var template =
		'	<header class="title-bar">'+
		'		<h1 class="site-title"><a href="'+App.baseUrl+'">'+App.blogName+'</a></h1>'+
		'		<h2 class="entries-section-title"></h2>'+
		'		<a class="menu-trigger button" href="#">' + menuTitle + '</a>'+
		'		<span class="shadow"></span>'+
		'	</header>'+
		'	<div class="archive-entries-container">'+
		'	</div>';

		var section = document.createElement('SECTION');

		section.id = id;
		section.className = 'entries-archive';
		section.innerHTML = template;
		
		App.wrapper.appendChild(section);

		var btn = section.getElementsByClassName('menu-trigger')[0];
		if (btn) {
			App.MainMenu.attachTo(btn);
		};

		return section;
	},

	/**
	 * Gets (and creats if necessary) the next entries page according to the App.paged property.
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	nextEntriesPage : function(){
		var next = App.paged + 1;
		return App.getEntriesPage(next);
	},



	updatePaginationIndicator : function(current, total){

		var un;

		if (!App.paginationElement || typeof App.paginationElement == un) {
			App.paginationElement = document.getElementById('pagination');
		};
		
		
		App.paginationElement.innerHTML = '';

		if (current){
			App.paginationElement.innerHTML = "showing page <strong>"+current+"</strong> of <em>"+total+"</em>";
		}
		
	},
	
	getEntriesSlug : function(id){
		var un;
		id = (id == un) ? 1 : id + 1;

		return "page/" + id;

	},

	/**
	 * This method prepares the entries archive page and propagate it with posts.
	 *
	 * @private
	 * @param Number paged The page number to retrieve
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	initEntries: function(){
		
		// only on the first page
		if (App.paged == 0){
			App.currentPageElement = App.getEntriesPage();	
		} 
		

		App.Nav.open(App.currentPageElement, false, App.getEntriesSlug(App.paged));

		App.setEntriesTitle();


		// get the container, based on the current page
		App.archiveContainer = App.currentPageElement.getElementsByClassName('archive-entries-container')[0];

		App.archiveContainer.innerHTML = '';
		App.spinner.show();

		$.get(App.getEntriesUrl(App.paged),function(response){


			if (response !== false && (typeof(response.posts) !== "undefined")) {

				App.setEntriesClass(response.posts.length);

				$.each(response.posts,function(){
					App.createArchiveItem(this);
				})

				// update pagination indicator
				App.updatePaginationIndicator(response.meta.current_page, response.meta.max_pages);

				// +++++
				// Ok, So this nonsense bellow handles pagination going forward.
				if (response.meta.max_pages >= response.meta.current_page) {

					App.Nav.makeFlippable();

					// ++
					// This block handles the advancement of the page.

					var nextPage = App.nextEntriesPage();
					App.setEntriesTitle(App.currentTermTitle,nextPage);
					App.Nav.setNext(nextPage);

					if (response.meta.max_pages <= response.meta.current_page) {
						App.Nav.flippable.setFlipDirection( false, true );
					};
					
					Flan.Eventual.bind(App,'navigateNext',function(){
						// we should advance the page count
						setTimeout(function(){
							App.paged++;
							App.currentPageElement = nextPage;
							App.Nav.declassify(nextPage,'Next');
							// App.Nav.open(nextPage);
							App.initEntries();							
						},0);
					}, true, true);
					//++

					// ++
					// This block handles the paging back;
					// te language here says 'prev' because it's going to be prev in the next iteration.
					var prevHash = App.getEntriesSlug(App.paged);
					var prevPage = App.currentPageElement;
					Flan.Eventual.bind(App,'on'+prevHash,function(){
						App.paged--;
						App.currentPageElement = prevPage;
						App.Nav.open(prevPage,App.getEntriesSlug(App.paged)).unflip();
						App.initEntries();
					},true,true);

					// this allows going back by virtue of swipping left to right
					Flan.Eventual.bind(App,'swippedLeftToRight',function(){
						if (App.paged > 0) {
							history.back();							
						};
					},true,true);
					//++

				};
				// +++++

			};

			App.spinner.hide();
			
		});


	},

	/**
	 * Get's the correct url for Ajax retrival
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	getEntriesUrl : function(paged){

		// set default page
		paged = paged || 0;

		url = App.baseUrl + "wp-admin/admin-ajax.php?action=get_archive";
		if (App.currentTermType) {
			url +="&" + App.currentTermType + "=" + App.currentTermId;
		}else{
			url +="&all=all";
		}


		if (paged > 0) {
			url += "&paged="+paged;
		};
				
		return url;

	},

	/**
	 * Creates an archive entry
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	createArchiveItem : function(row){

		var post = document.createElement('ARTICLE');
		post.className = 'entry';
		row.excerpt = Flan.truncate(row.excerpt,120,'&hellip;');
		
		var html = "<div class='inner'><h1>"+row.title+"</h1>";				

		if (row.excerpt.length) {
			html += "<div class='entry-excerpt'>"+row.excerpt+"</div>";				
		};

		html += "</div>";

		if (row.image) {
			var imgsrc = unescape(row.image.replace(/\&amp;/g,'&'));
			post.style.backgroundImage = "url("+imgsrc+")"; 
			post.style.backgroundAttachment = "no-repeat";
			post.style.backgroundPosition = "center";
			
			// html += "<div class='entry-image'><img src='"+imgsrc+"'></div>";
			post.className+=' with-image';
		}else{
			post.className+=' no-image';
		}
		
		post.innerHTML = html;
		App.archiveContainer.appendChild(post);
		
		// "background-attachment:no-repeat; background-position:center'";
		

		$(post).bind('click',function(){
			row.category = App.currentTermTitle;
			setTimeout(function(){
				App.createSinglePostSection(row);
			},0);
		});

	},

	/**
	 * Describe what this method does
	 * @private
	 * @param {String|Object|Array|Boolean|Number} paramName Describe this parameter
	 * @returns Describe what it returns
	 * @type String|Object|Array|Boolean|Number
	 */

	createSinglePostSection : function(data){
		
		var commentsbtn = (data.comments_count || data.comments_open) ? '<a href="#comments" class="comments-btn" id="comments-btn">'+data.comment_count+'</a>' : '';
		var section = document.getElementById('entry');

		var successCallback = function(template){
			// section.innerHTML = template;

			var sharemenu = document.getElementById('share-menu');
			var sharebtn = document.getElementById('share-btn');
			var popover = new Flan.PopOver(sharemenu,false);
			popover.attachTo(sharebtn);



			//let's prepare the scrollableElement
			var scrollableElement = document.getElementById('entry-scroller');
			App.entryScrollable = new TouchScroll(scrollableElement, {elastic:true});

			//
			scrollableElement.onorientationchange = function(){
				App.entryScrollable.setupScroller();
			}

			setTimeout(scrollableElement.onorientationchange,1500);
			setTimeout(scrollableElement.onorientationchange,3000);


			var imgs = scrollableElement.getElementsByTagName('img');

			// this should fix the craploadofimages issue.
			$(imgs).each(function(){
				this.onload = function(){
					App.entryScrollable.setupScroller();
				}
			});

		   /*
			*   Here we are going to create a modal window.
			*/

			var closebtn = document.getElementById('close-btn');
			var oldhashhandler = window.onhashchange;
			var entryhash;
			var oldhash = location.hash;

			$(section).addClass('FlanModal');

			setTimeout(function(){
				$(section).addClass('opened');
			},0);

			videoIFrame(section);

			location.hash = entryhash = "!/entry/" + data.id;

			window.onhashchange = function(x){
				if (location.hash.substr(1) !== entryhash) {
					window.onhashchange = oldhashhandler;
					closebtn.onclick(false);
				};
			}

			closebtn.onclick = function(e){

				if (e) {
					e.preventDefault();
				};

				$(section).removeClass('opened');

				setTimeout(function(){
					$(section).removeClass('FlanModal');
				},1000);

				if (e !== false) {
					window.history.back()
				};

			}

			// bind comments btn
			App.initComments(data.id);
			// bind comments btn
			$("#comments-btn").bind('touchstart click',function(e){
				e.preventDefault();
				App.showComments();			
			});



			//
			return section;			
		};

		$(section).load(data.permalink,successCallback);

	},
	
	initSingleSingle:function(){
		
		App.spinner.show();
		var entryElement = document.getElementById('entry');

		App.Nav.open(document.getElementById('entry'));
		
		var scrollableElement = document.getElementById('entry-scroller');
		App.entryScrollable = new TouchScroll(scrollableElement, {elastic:true});

		var sharemenu = document.getElementById('share-menu');
		var sharebtn = document.getElementById('share-btn');
		var popover = new Flan.PopOver(sharemenu,false);
		popover.attachTo(sharebtn);


		if (!App.MainMenu) {
			App.MainMenu = new Flan.PopOver(document.getElementById('menu'));
		};

		// set the categories menu button
		var	menuTitle = document.getElementById('menu-title').innerHTML;
		var menuBtn = document.getElementById('single-menu-button');
		menuBtn.innerHTML = menuTitle;
		App.MainMenu.attachTo(menuBtn);


		//
		scrollableElement.onorientationchange = function(){
			App.entryScrollable.setupScroller();
		}
		
		videoIFrame(scrollableElement);		

		// this should fix the craploadofimages issue.
		var imgs = scrollableElement.getElementsByTagName('img');
		$(imgs).each(function(){
			this.onload = function(){
				App.entryScrollable.setupScroller();
			}
		});

		App.initComments(App.currentPostId);
		
		$('#comments-btn').bind('touchstart click',function(e){
			e.preventDefault();
			App.showComments();			
		});


		setTimeout(function(){
			$(entryElement).addClass('opened');
			App.spinner.hide();			
		},200);

	},

	getComments:function(postId, container, title, highlight_id){
		var un;
		var url = App.baseUrl + "wp-admin/admin-ajax.php?action=get_comments&post_id=" + postId;
		container = container || document.getElementById('comments');
		title = title || container.getElementsByClassName('comments-title')[0];

		var inner = container.getElementsByClassName('comments-inner')[0];

		$.get(url,function(response){
			// response = xhr.responseText;
			if (isNaN(response)) {

				if (inner === un) {
					// wrapper element for comments
					inner = document.createElement('DIV');
					inner.className = "comments-inner scroller";
					container.appendChild(inner);
				}else{
					inner.innerHTML = "";
				}

				inner.innerHTML = response;
				App.CommentsScrollable = new TouchScroll(inner, {elastic:true});

				var replylinks = inner.querySelectorAll('a.comment-reply-link');
				$(replylinks).each(function(){

					var title = document.getElementById('respond-title');

					if ((title) && !App.temp['commentDialogTitle']) {
						App.temp['commentDialogTitle']  = title.innerHTML;						
					};

					$(this).bind('click',function(e){
						e.preventDefault();
						e.stopPropagation();

						// set hidden parentid on form
						window.commentform.comment_parent.value = this.getAttribute("data-parentid");

						// change the form title
						if (title) title.innerHTML = App.temp['replyDialogTitle'] = "Reply to " + this.getAttribute("data-replyto");

						$('#respond').toggleClass('show');

					},false);
				});

				// if a comment id has been passed. We are going to scroll to that comment.
				if (highlight_id) {
					setTimeout(function(){
						highlight_id = "comment_" + highlight_id;
						var highlighted = document.getElementById(highlight_id);
						if (highlighted) {
							var y = highlighted.offsetTop;
							App.CommentsScrollable.scrollTo(0,y);
							App.CommentsScrollable.setupScroller();
						};						
					},100);
					
				};

			};


		});

	},

	getCommentForm : function(postId,container){
		var un;
		var url = App.baseUrl + "wp-admin/admin-ajax.php?action=get_comments_form&post_id=" + postId;
		container = container || document.getElementById('comments');

		$.get(url,function(data){

			if (data){

				respond = document.createElement('DIV');
				respond.id = "respond";
				container.appendChild(respond);

				respond.innerHTML = data;

				var btn = $('#post-comment-btn');
				btn.bind('touchstart click',function(e){
					
					// this whole callback should probably be on it's own method.
					// will seperate it later.

					e.preventDefault();

					var action = this.parentNode.parentNode.action + "&post_id=" + postId;
					var oldLabel = this.innerHTML;
					var btn = this;

					btn.innerHTML = "Sending Comment…";

					// fill postData
					var inputs = this.parentNode.parentNode.getElementsByTagName('input');
					var postData = '';
					$(inputs).each(function(){
						if ( ( this.type == "checkbox" || this.type == "radio" ) ) {
							if ( this.checked )
								postData+= "&" + encodeURIComponent(this.name) + "=" + encodeURIComponent(this.value);
						} else {
							postData+= "&" + encodeURIComponent(this.name) + "=" + encodeURIComponent(this.value);
						} 
						
					});
					var commentArea = this.parentNode.parentNode.getElementsByTagName('textarea')[0];
					// trim comment area
					commentArea.value = $.trim(commentArea.value);

					// invalidation
					// now this only tests for empty comments, but
					// can be extended to allow for other validation rules
					if (commentArea.value == '') {
						alert('Please type a comment');
						btn.innerHTML = oldLabel;
						return;						
					}
					
					
					postData+= "&" + encodeURIComponent(commentArea.name) + "=" + encodeURIComponent(commentArea.value);


					App.spinner.show();
					$.post(action,postData,function(data){

						App.spinner.hide();						

						if (typeof data == "object") {
							App.getComments(postId,container, null, data.comment_ID);
							commentArea.value = "";
						}else if(typeof data == "string"){
							App.getComments(postId,container);							
						}

						// clean after
						btn.innerHTML = oldLabel;
						App.toggleCommentForm();						

					});

				});

				var closeTriggers = respond.getElementsByClassName('close-comments-form');
				$(closeTriggers).bind('touchstart click',function(e){
					e.preventDefault();
					App.toggleCommentForm();
				});

			}
		});


	},

	initComments:function(postId){

		var entry = document.querySelector('#entry>.inner');
		var container = document.createElement('DIV');
		var title = document.createElement('H3');

		title.className = "comments-title";
		container.appendChild(title);
		entry.appendChild(container);
		container.id = "comments";
		title.innerHTML = "Comments";

		// get and display comments
		App.getComments(postId,container,title);

		//create the close btn
		var closebtn = document.createElement('A');
		container.appendChild(closebtn);
		closebtn.className = "button";
		closebtn.id = "back-to-post";
		closebtn.innerHTML = "<img src='"+App.assetsUrl+"images/eject-button.png'>";
		closebtn.innerHTML += "Back To Article";
		closebtn.href = "#";
		closebtn.onclick = function(e){
			e.preventDefault();
			$(document.getElementById('entry')).removeClass('show-comments');
		}

		//create the open form btn
		var formbtn = document.createElement('A');
		container.appendChild(formbtn);
		formbtn.className = "button";
		formbtn.innerHTML = "New Comment";
		formbtn.href = "#";

		formbtn.onclick = function(e){

			e.preventDefault();

			var title = document.getElementById('respond-title');
			if (App.temp['commentDialogTitle']) {
				title.innerHTML = App.temp['commentDialogTitle'];
			};
			
			App.toggleCommentForm();
			window.commentform.comment_parent.value = 0;			
		}
		
		// create the form
		App.getCommentForm(postId,container);

	},

	toggleCommentForm : function(e){

		if (e) e.preventDefault();

		var el = $(document.getElementById('respond'));
		if (el.hasClass('show')) {
			document.getElementById('comment').blur();
			el.removeClass('show');
		}else{
			el.addClass('show');
		}
	},

	showComments : function(){
		var entry = document.getElementById('entry');
		$(entry).addClass('show-comments');
		if (App.CommentsScrollable) App.CommentsScrollable.setupScroller();			
	},



};

/*
	Find the base url
*/

(function() {
	var scripts = document.getElementsByTagName('script');
	for (var i = scripts.length - 1; i >= 0; i--){
		var matches = scripts[i].src.match(/(.+)(wp\-content.+assets)\/js\/app\.js.*/i);
		if (matches) {
			App.baseUrl = matches[1];
			App.assetsUrl = App.baseUrl + matches[2];
			break;
		};
	};
})();


/*!
	Start the whole thing

*/
document.addEventListener("DOMContentLoaded", App.init, false);