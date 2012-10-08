// let's make IE less whiny
if (typeof console == "undefined") {
  window.console = { debug : function(x){} };
};

jQuery(document).ready(function($) {


    /*	Onswipe Enabled Toggle
    **********************************************************************/
    $('.onswipe-options-settings').hide();

    if( $('input.onswipe_enabled[value="enabled"]:checked').length > 0 ){
    	$('.onswipe-options-settings').show();
    }

    $('input.onswipe_enabled').click(function(){
    	if($(this).val() == 'disabled'){
    		$('.onswipe-options-settings').slideUp();
    	} else {
    		$('.onswipe-options-settings').slideDown();
    	}
    });

    $('.toggle-switch a').click(function(){
    	if($(this).attr('data-value') == 'disabled'){
    		$('.onswipe-options-settings').slideUp();
    		$('input.onswipe_enabled[value="disabled"]').attr('checked', true);
    		$('.switch-bg').removeClass('enabled');
    	} else {
    		$('.onswipe-options-settings').slideDown();
    		$('input.onswipe_enabled[value="enabled"]').attr('checked', true);
    		$('.switch-bg').addClass('enabled');
    	}

    	return false;
    });

    $('.switch-bg').click(function(){
    	$('input.onswipe_enabled:not(:checked)').attr('checked', true);
    	$('.switch-bg').toggleClass('enabled');
    	$('.onswipe-options-settings').slideToggle();
    });

    // Toggle Switch
    $('.toggle-switch').show();
    $('.hidden-radio-options').hide();

    /*	Colorpicker for Accent Color
     **********************************************************************/
    $('#colorpicker').hide();
    $('#colorpicker').farbtastic('#accent_color');

    $('#accent_color').click(function() {
        $('#colorpicker').fadeIn();
    });

    $(document).mousedown(function() {
        $('#colorpicker').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).fadeOut();
        });
    });


    /*	Media Uploader
     **********************************************************************/

    // Clear preview button
    $('.clear-file-url').click(function(){
    	$(this).parent().slideUp();

    	var parent = $(this).parent().parent();
    	$('input[type="text"]', parent).val('');

    	return false;
    });

    // Events when an upload text field is blurred
    $('.upload-field').blur(function(){

    	var $t = $(this);
    	var inputParent = $t.parent();

    	if( $t.val() != '' ){
    		$('.onswipe-image-preview .holder', inputParent).html('<img src="'+$t.val()+'" alt="Preview" />')
    		$('.onswipe-image-preview', inputParent).fadeIn();
    	} else {
    		$('.onswipe-image-preview', inputParent).hide();
    		$('.onswipe-image-preview .holder', inputParent).html('');
    	}

    });

    // Media Uploader
	var formfield = null;
	var fieldName = null;

	$('.upload-btn').click(function() {
		$('html').addClass('Image');

		fieldName = $(this).attr('data-field');
		formfield = "onswipe_options["+fieldName+"]";

		//Change "insert into post" to "Use this Button"
		tbframe_interval = setInterval(function() {jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');}, 2000);

		tb_show('', 'media-upload.php?type=image&TB_iframe=true'); return false;
	});

	// user inserts file into post.
	// only run custom if user started process using the above process
	// window.send_to_editor(html) is how wp normally handle the received data
	window.original_send_to_editor = window.send_to_editor; window.send_to_editor = function(html){

		var fileurl;

		if (formfield != null) {
			fileurl = $('img',html).attr('src');

			$('#'+fieldName).val(fileurl);

			var inputParent = $('#'+fieldName).parent();

			$('.onswipe-image-preview .holder', inputParent).html('<img src="'+fileurl+'" alt="Preview" />');
			$('.onswipe-image-preview', inputParent).fadeIn();

			tb_remove();
			$('html').removeClass('Image');
			formfield = null;
		} else {
			window.original_send_to_editor(html);
		}
	};

	/*
	*   Assetgen
	*   =============
	*/

	$('#assetgen').each(function(){

		var url = "http://ag.wp.onswipe.com/wp/gen?url=" + this.getAttribute('data-url') + "&callback=?"
		,   callback = this.getAttribute('data-callback')
		,   _this = this
		,   p = $('p',this)
		,   tries = 5
		,	assetgen,success,fail,w3cache
		;

    console.debug(url);

		assetgen = function(){

			$.getJSON(url)
				.done(success)
				.fail(fail);

		}

		success = function(){

			$.get(callback).done(function(xhr){
				setTimeout(function(){
					p.append(" Done.");

          w3cache();

					setTimeout(function(){
						$(_this).hide('slow');
					},2000);

				},500);
			});

			console.debug("Assetgen success.");
		};

		fail = function(xhr, status, error){

			if (tries > 0) {
				tries--;
				console.debug( tries + " attempts left" );
				assetgen();
			}else{
				_this.className = "error";
				p.html("Sorry, there was an error in updating your layout. <a href='#' class='do-assetgen'>Click here to try again</a>");
				console.debug( "Assetgen error: " + xhr.status );

			}
		};

		assetgen();

		$('.do-assetgen').live('click',function(){
			console.debug("trying again");
			_this.className = "message updated";
			p.html("Generating layouts…");
			tries = 5;
			assetgen();
		});


		// experimental!!
		w3cache = function(){

			if ( typeof deal_with_w3_cache !== "undefined") {

				$('.updated .button').each(function(){
					var _func = this.getAttribute('onclick'), matches;
					if ( matches = _func.match(/document.location.href='(.+flush.+)'/)) {
						$(this).closest('.updated').hide();

						$.get(matches[1]).done(function(xhr){
							console.debug('W3Cache emptied');
						});
					};

				})

			}

		}

	});


  /*
    Welcome Stuff
  */
  $('a#hide_welcome').click(function(e){

  		e.preventDefault();
  		
  		$('#onswipe-subscribe').remove();  		
  		$('#welcome-form').submit();
  		
  	})


  /*
    Layouts Selector
  */
  var getLayouts = function(){

    var layoutsUrl = "http://ag.wp.onswipe.com/layouts"
    ,   grids = $('.onswipe-layout-grid')
    ,   processLayouts
    ,   selectLayout
    ,   layoutTemplate;
      
    if (!grids.length) return;

    processLayouts = function( results ){
              
      grids.each(function(){

          var grid = $(this), section, isdefault, layouts, current, un;

          section = grid.data('section');
          layouts = results[section];
          
          $.each(layouts,function(){
            grid.append(layoutTemplate(section,this));
          });
          
          // set default values          
          current = results.defaults[section];
          selectLayoutById(current,section);

      });

      $('input[type=radio]').bind('change',function(){  
        selectLayout(this);
      });

      if ( typeof(onswipe_default_toc) !== "undefined" ) {
        selectLayoutById(onswipe_default_toc,'toc')
      };

      if ( typeof(onswipe_default_article) !== "undefined" ) {
        selectLayoutById(onswipe_default_article,'article')
      };

      
    };
    
    selectLayout = function(el){
      $(el).closest('.onswipe-layout-grid').children('label.current').removeClass('current');
      $(el.parentNode).addClass('current');
    };
    
    selectLayoutById = function(id,section){
      $('#layout_input_' + section + id)
      .attr('checked','checked')
      .each(function(){
        selectLayout(this)
      });
    };
    
    layoutTemplate = function(key,layout){
      var template;
      template = "<label>\n<input type='radio' name=\"onswipe_options[" + key + "_layout]\" class=\"option-" + layout.id + "; ?>\" value=\"" + layout.id + "\" id=\"layout_input_" + key + layout.id + "\" />\n<img src=\"" + layout.image_horizontal + "\" alt=\"" + layout.id + "\" title=\"" + layout.description + "\" width=\"220\" height=\"165\"/>\n<p class=\"name\">" + layout.name + "</p>\n</label>";        return template;
    }

    $.getJSON(layoutsUrl).done( processLayouts );
    
  };

  
  getLayouts();


});



