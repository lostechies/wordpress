
/*!
 * @autor: Armando Sosa, based on the work of Dave Dunkin
 * 
 */

function swippable(el,threshold,listeners){
	var startX;
	var dx;
	var direction;
	var startX,startY;
	// var threshold = 200;
	var verticalThreshold = 100;
	
	var tappy = (function(){
			if("createTouch" in document){ // True on the iPhone
				return true;
			}
			try{
				var event = document.createEvent("TouchEvent"); // Should throw an error if not supported
				return !!event.initTouchEvent; // Check for existance of initialization method
			}catch(error){
				return false;
			}
	}());	
	
	var tap = {
		start:(tappy)?'touchstart':'mousedown',
		move:(tappy)?'touchmove':'mousemove',
		end:(tappy)?'touchend':'mouseup',
		cancel:'touchcancel'
	}


	function cancelTouch(say){		
		el.removeEventListener(tap.move, onTouchMove);
		el.removeEventListener(tap.end, onTouchEnd);
		startX = null;
		startY = null;
		direction = null;
		dx = null;
		
	}

	function onTouchMove(e){
		if (e.touches && e.touches.length > 1){
		}else{

			e.preventDefault();
			
			if(e.touches && e.touches.length){
				e = e.touches[0];
			}
			
			dx = e.pageX - startX;
			// var dy = e.pageY - startY;
			var delta = Math.abs(dx);

			if (direction == null){
				direction = dx;
			}else if ((direction < 0 && dx > 0) || (direction > 0 && dx < 0)){
				cancelTouch();
			}			
			
			if (delta < threshold) {
				if (typeof(listeners.move) == 'function') {
					var move = listeners.move({
						target: el, 
						direction: dx > 0 ? 'right' : 'left',
						velocity:Math.abs(dx),
						touch:e,
					});					
				};				
			}else{
				onTouchEnd();
			}

		}
	}

	function onTouchEnd(e){
		if (Math.abs(dx) > threshold){
			if (typeof(listeners.end) == "function") listeners.end({ target: el, direction: dx > 0 ? 'right' : 'left' });			
		}else{
			if (typeof(listeners.cancel) == "function") listeners.cancel(el);
			dx = null;
		}
		cancelTouch();				
		
	}

	function onTouchStart(e){
		
		if (typeof(listeners.active) == "function"){
			if (!listeners.active()) {return false};
		} 
		
		
		cancelTouch();
		
		if (e.touches && e.touches.length > 1) {
			return;
		};
		if(e.touches && e.touches.length){
			e = e.touches[0];
		}
		startX = e.pageX;
		startY = e.pageY;
		dx = null;
		el.addEventListener(tap.move, onTouchMove, false);
		el.addEventListener(tap.end, onTouchEnd, false);

		if (typeof(listeners.start) == "function") listeners.start({touch:e,el:el});
	}
	
	el.addEventListener(tap.start, onTouchStart, false);
}
