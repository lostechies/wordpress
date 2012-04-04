Flan.Gestures = {};

Flan.Gestures.Flippable = function(el,responsive){
	
	var un;
	
	var rad2deg = function(rad){
		return (180 * rad) / Math.PI;
	};	


	// this variable controls wether this will respond to touch flickering
	responsive = responsive == un ? true : responsive;
	
	if (el === false) {
		console.debug(this);
	};

	el.style["-webkit-transition-property"] = "-webkit-transform";
	el.style['-webkit-transition-duration'] = "0.5s";
	el.style['-webkit-transform-style'] = "preserve-3d";
	el.style['-webkit-transform-origin'] = "left center";
	
	var self = this;

	// intialize the delegate to an empty object
	self.navigationDelegate = {};
	
	var isfunc = function(v){
		return (typeof(v) == "function");
	};
	
	// this is the core object
	var Flippable = {
		
		maxRotation : 45,
		maxSwipe : 100,
		perspective:2950,
		active:true,
		hint:false,
				
		flipForward : true,
		flipBack : true,
				
		
		rotate:function(rotation,speed){

			Flippable.rotation = rotation;
			
			if (speed) {
				el.style['-webkit-transition-duration'] = speed;
			}else{
				el.style['-webkit-transition-duration'] = "0.5s";
			}
			el.style.webkitTransform = "perspective(2900) rotate3d(0,1,0,"+rotation+"deg)";
		},
		
		unflip:function(){
			var rotation = Flippable.getRotation();
			if (rotation == "-90") {
				setTimeout(function(){
					Flippable.rotate(0);					
				},0);
			};
		},
		
	}	

	Flippable.actions = {

		active:function(){
			return Flippable.active;
		},

		start:function(flick){
			if (Flippable.hint && isfunc(self.navigationDelegate.hasNext) && self.navigationDelegate.hasNext()) {
				Flippable.rotate(-30);
				
			};			
		},

		move:function(flick){
			
			// console.profile('move gesture');
			
			var delta = Math.round(((el.offsetWidth - flick.touch.pageX) / el.offsetWidth)*100) / 100;
			var theta = Math.round(Math.asin(delta) * 100) / 100;
			var rotation = Math.floor(rad2deg(theta));
						
			if (flick.direction == "left") {
				
				if (Flippable.flipForward) {
					rotation = 1-rotation;
					Flippable.rotate(rotation);									
				}else{
					Flan.Eventual.fire('swippedPastBorder',rotation);
				}
			}
			
		},

		cancel:function(){
			Flippable.rotate(0);
		},

		end:function(flick){

			if (isfunc(self.navigationDelegate.hasNext)) {
				
				if (!self.navigationDelegate.hasNext()) {
					Flippable.actions.cancel();
					return;					
				};
			};
			
			if (flick.direction == "left") {
								
				if (Flippable.flipForward){
					Flippable.rotate(-90);

					if (isfunc(self.navigationDelegate.onFlipFinished)) {
						setTimeout(function(){
							self.navigationDelegate.onFlipFinished();
						},500);

					};					
				}
				
			}else{
				if (Flippable.flipBack) Flan.Eventual.fire('swippedLeftToRight',Flippable);
			}


		}

	}

	if (responsive) {
		swippable(el,Flippable.maxSwipe,Flippable.actions);
	};


	return {
		
		setNavigationDelegate:function(object){
			self.navigationDelegate = object;
		},
		
		rotate:Flippable.rotate,
		
		unflip:Flippable.unflip,
		
		next:function(){
			Flippable.actions.end({direction:"left"});
		},
		
		disable:function(){
			Flippable.active = false;
		},
		
		enable:function(){
			Flippable.active = true;
		},
		
		is:function(_el){
			return _el == el;
		},
		
		hint : function(dohint){
			Flippable.hint = true;
		},
		
		setFlipDirection : function(forward,back){
			Flippable.flipForward = forward;
			Flippable.flipBack = back;
			console.debug(Flippable)
		}
		
	}

}