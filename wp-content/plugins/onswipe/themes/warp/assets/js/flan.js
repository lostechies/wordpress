/*!*
 * 
 *  Flan.js
 *  +++++++++
 *  A little framework for iPad HTML5 applications.
 * 
 */

var Flan = Flan || {}


var $ = jQuery;	
$.fn.orientation = function(initial){

	var _orientation = initial || 'portrait' // starting 
		, that = this;

	if (('standalone' in window.navigator) && window.navigator.standalone) {
		$(this).addClass('standalone');
	}else{
		$(this).addClass('inbrowser');			
	}
	
	//attach it to the onchange event
	$("#wrapper").bind('orientationchange',function(){
		
		// faster than a switch, albeit a little unreadable. I hope I'm not being to clever.
		var orientation = ("orientation" in window) ? 
							(Math.abs(parseInt(window.orientation)) == 90) ? 
								'landscape' 
								: 'portrait' 
							: _orientation;

		$(that).removeClass( orientation == 'landscape' ? 'portrait' : 'landscape' );
		$(that).addClass(orientation);
		_orientation = orientation;		
	}).trigger('orientationchange');

};




/*

	Flan.Events
	++++++++++++
	
	Allow for custom events
*/

Flan.Eventual = {
	
	_listeners:{},
	
	bind:function(obj,type,callback,exclusive,autodestroy){
		
		autodestroy = (typeof(autodestroy) == "undefined")?false:autodestroy;
		
        if (typeof this._listeners[type] == "undefined"){
            this._listeners[type] = [];
        }

		var evt = {bindto:obj,callback:callback,exclusive:exclusive,autodestroy:autodestroy};

		if (!exclusive) {
	        this._listeners[type].push(evt);
		}else{
			this._listeners[type] = [evt];
		}
		
	},
	
	fire:function(type,args){
		if( this._listeners[type] instanceof Array){
			$.each(this._listeners[type],function(){
				if (typeof(this.callback) == "function") {
					this.callback.call(this.bindto,args);
					if (this.exclusive && this.autodestroy) {
						delete Flan.Eventual._listeners[type];
					};
				};
			});			
		}
	},
	
	remove:function(obj,type,callback){
		$.each(this._listeners[type],function(){
			if (this.bindto == obj && this.callback == callback) {
				this.callback = false;
				delete this;
			};
		});
	}
	
	
}

Flan.Router = {
	
	set : function(obj,route,callback){
		route = 'on'+route;
		Flan.Eventual.bind(obj, route ,callback);		
	},
	
	go : function(hash){
		Flan.Eventual.fire('on'+hash);		
	}
	
};


/*
	
	Flan.Hasher
	+++++++++++++++++
	fixes the lack of onhashchange on iPad
	
*/

Flan.hasher = {
	
	init:function(){		
		if (!("onhashchange" in window)) {
			this.oldhash = location.hash;
			this.observer = setTimeout(this.listen,250);
		};
	},
	
	listen:function(){

		if (Flan.hasher.oldhash !== location.hash) {
			
			if ("onhashchange" in window && typeof(window.onhashchange) == 'function') {
				Flan.hasher.oldhash = location.hash;				
				window.onhashchange();
			};
			
		};

		Flan.hasher.observer = setTimeout(Flan.hasher.listen,250);		
	},
	
}




Flan.truncate = function(str,len, ellipsis){
	if (str.length > len) {
		str = str.substring(0, len).replace(/\w+$/, '');
		if (typeof(ellipsis) == "string") {
			str += ellipsis; 
		};		
	};
	
	return str;
}

