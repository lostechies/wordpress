(function($){
	$(function(){

		/*
			Image Widget
		*/
		$('.image-widget').each(function(){
			var that = $(this);
			$('a.image-switch',this).click(function(e){
				e.preventDefault();
				that.toggleClass('image-widget-show-control');
			});
						
			$('a.delete',this).click(function(e){
				e.preventDefault();
				var input = $('input[type=hidden]',that);
				var img = $('.image',that);
				img.fadeOut().remove();
				that.addClass('image-widget-show-control');
				input.val('');
			});
			
		});
		
		/*
			Font Sample
		*/
		var $fontSample = $('#display-font-sample span');
		$('#display_font').bind('change',function(){
			$fontSample.css({fontFamily:this.value});
		}).change();

		/*
			Color skin selector
		*/
		var $swatches = $('.swatch');
		var $skin_input = $('#color_skin');
		$swatches.click(function(e){
			$swatches.removeClass('current');
			$(this).addClass('current');
			$skin_input.val(this.getAttribute('data-name'));
			$fontSample.css('color',$(this).children('span:first').css('backgroundColor'));
		});
		
	});
})(jQuery);