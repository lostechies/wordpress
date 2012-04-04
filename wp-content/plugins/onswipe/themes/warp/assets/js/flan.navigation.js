/*
	Flan Navigation
	+++++++++++++++
	
	This class helps popping stuff in and out the screen.
	Doesn't deal with animations yet.
*/

Flan.Navigation = Class.extend({
	
	baseClass:"FlanNavigation",
	
	
	history : [],
	
	
	init:function(){

		that = this;

		this.views = {
			current:false,
			next:false,
			previous:false,
			stack:[],
		}		
		
		window.onhashchange = function(){
			that.change();
		}
		
	},
	
	change:function(){
		var hash = location.hash.substr(3);
		if (hash == this._currentHash) return;
		Flan.Router.go(hash);
	},
	
	setHash:function(hash){
		this._currentHash = hash;
		location.hash = "!/" + this._currentHash;

	},
	
	classify:function(element,c){		
		$(element).addClass(this.baseClass + c);		
		return element;
	},
	
	declassify:function(element,c){		
		$(element).removeClass(this.baseClass + c);
		return element;
	},
	
	open:function(element, hash){
		var un

		if (hash !== un) {
			this.setHash(hash)
		}
		
		if (element === false) {
			console.debug(element);
		};
		
		this.views.current = element;
		this.classify(this.views.current,'Top');
				
		return this;
	},
	
	setNext:function(element,callback){
		// alert(element.id);
		this.views.next = element;
		this.classify(this.views.next,'Next');

		return this;
	},
	
	hasNext:function(){
		return (this.views.next !== false);
	},
	
	
	next:function(){

		if (this.views.next !== false) {
						
			this.declassify(this.views.current,'Top');
			// this.setPrevious(this.views.current);

			this.declassify(this.views.next,'Next');
			this.open(this.views.next);
			this.views.next = false;		

			Flan.Eventual.fire('navigateNext',this);

		};


		return this;
	},
	
	removeNext:function(){

		if (this.views.next !== false) {
			
			var next = this.views.next;
			this.views.next = false;
			$(next).remove();
			delete next;
		};
		
		return this;
	},	
	
	setPrevious:function(element){
		this.views.stack.push(element);
		return this;
	},
	
	previous:function(element){
		

		// var element = this.views.stack.pop();	
		var old = this.declassify(this.views.current,'Top');

		this.open(element);

		$(old).remove();
		delete old;
				
		this.views.next = false;
		this.views.previous = false;		

		// Flan.Eventual.fire('navigatePrevious',this);

		return this;		
	}
	
	
});


Flan.FlipNavigation = Flan.Navigation.extend({

	flippable:false,
		
	open:function(element, flippable, hash){
				
		var old = this.declassify(this.views.current,'Top');

		this._super(element, hash);
		
		if (flippable === true){
			this.makeFlippable(element);
		}
		
		return this;
		
	},
	
	makeFlippable:function(element, responsive){

		element = element || this.views.current;

		this.flippable = new Flan.Gestures.Flippable(element, responsive);
		this.flippable.setNavigationDelegate(this);
		
	},
	
	
	unflip:function(element, callback){
		
		element = element || this.views.current;

		setTimeout(function(){
			element.style.webkitTransitionDuration = "0.5s";			
			element.style.webkitTransform = "perspective(2900) rotate3d(0,1,0,0deg)";				
		},0)
		
		if (typeof(callback) == "function"){
			callback();
		}
		
		this.flippable = false;
		
		return this;
	},
	
	/*
		This function makes the flipping effect.
	*/
	quickFlipTo:function(element,callback){

		var that = this;
		
		// first, set the next page where we are going to flip.
		this.setNext(element);
		
		
		// rotate the current element
		this.makeFlippable(null,false);

		this.views.current.style.webkitTransitionDuration = "0.3s";			
		this.views.current.style.webkitTransform = "perspective(2900) rotate3d(0,1,0,-90deg)";	

			
		setTimeout(function(){
			that.next();

			if (typeof(callback) == 'function') {
				callback();
			};
			
		},600);			
		
	},
	
	onFlipFinished:function(responsible){	
		if (this.views.next !== false) {
			this.next();			
		}
	},

	
});