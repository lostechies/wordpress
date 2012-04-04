/*!
 *	
 *  @author: Armando Sosa	
 *	
 */

Flan.PopOver = function(wrapper){			
	
	var PopOver = {

		create:function(wrapper){
			this.wrapper = wrapper;	
			$(this.wrapper).addClass('PopOver');
			return this;			
		},

		attachTo:function(trigger){
			this.trigger = trigger;	
			var that = this;
			this.wrapper.style.display = "none";

			trigger[ontap] = function(e){
				e.preventDefault();
				e.stopPropagation();
				that.open();
			}	
				
		},
		
		open:function(){
			var that = this;
			
			var isChild = function(child, parent) {
			     var node = child.parentNode;
			     while (node != null) {
			         if (node == parent) {
			             return true;
			         }
			         node = node.parentNode;
			     }
			     return false;
			}
			
			var closeHandler = function(e){

				$(document.body).unbind('click touchstart',closeHandler);
				
				// we ignore this if the target is inside the popover.
				if (isChild(e.target,that.wrapper)) {
					return;
				};				
				
				e.stopPropagation();
				
				that.open();
			}
			
			
			if ($(that.wrapper).hasClass('open')) {					

				$(that.wrapper).removeClass('open');						

				setTimeout(function(){
					that.wrapper.style.display = 'none';
				},500);

			}else{
				
				that.wrapper.style.display = 'block';
				setTimeout(function(){
					$(that.wrapper).addClass('open');						
				},0);						

				setTimeout(function(){
					$(document.body).bind('click touchstart',closeHandler);
				},500);
				
			}					
		},
		
		close:function(){
			PopOver.open();
		},


	}
	
	return PopOver.create(wrapper);
	
}

String.prototype.times = function( count ){
  return count < 1 ? '' : new Array(count + 1).join(this);
}

var $;
$ = jQuery;
$.fn.drilldown = function(o) {
  o = $.fn.extend(o, {
    width: 300
  });
  return this.each(function() {
    var back, current, level, move, submenus, wrapper, selector;
    wrapper = $('ul:first', this);
    back = $('.goback', this).hide();
    level = 0;
    submenus = $('ul ul', this);
    current = null;
    move = function(n, next) {
      var direction, left;
      if (n < 0) {
        return;
      }
      direction = n < level ? 'back' : 'forward';
      level = n;
      left = level * o.width;
      return setTimeout(function() {
        wrapper.css({
          webkitTransform: "translate3d(-" + left + "px,0,0)"
        });
        if (direction === "back") {
	selector = 'ul' + ' li>ul'.times(level+1);
	$(selector).hide();
        }
        if (level > 0) {
          return back.show();
        } else {
          return back.hide();
        }
      }, 0);
    };
    submenus.each(function() {
      return $(this.parentNode).addClass('has-children').prepend('<span class="drill">&rarr;</span>').children('.drill').bind('click touchstart', function(e) {
        var next;
        e.preventDefault();
        next = $(">ul:first", this.parentNode);
        next.show();
        return move(level + 1);
      });
    });
    return back.bind('click touchstart', function(e) {
      e.preventDefault();
      e.stopPropagation();
      return move(level - 1);
    });
  });
};

