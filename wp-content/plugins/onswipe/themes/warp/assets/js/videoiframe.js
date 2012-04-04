var videoIFrame =  function(context, width, height){
					
		var getVideoIdFromUrl = function(url, provider){

			if (provider == "youtube.com") {
				var match = url.match('youtube.com.+v\/([^\?]+)');
				if (match) {
					return match[1];
				};				
			};

			if (provider == "vimeo.com") {
				var match = url.match('vimeo.com.+clip_id\=([^\&]+)');
				if (match) {
					return match[1];
				};				
			};

			
			return false;
		}
		
		var getProviderFromUrl = function(url){
			var match = url.match('(youtube\.com|vimeo\.com)');
			if (match){
				return match[1];
			}
		}

		// get the video objects
		var tubes = context.getElementsByTagName('object');
		if (!tubes.length) return;

		// check that they are indeed youtube or vimeo
		$(tubes).each(function(){

			var movieParam = this.querySelector('param[name=movie]');
			if (!movieParam) {
				movieParam = this.querySelector('param[name=src]');
			};

			var tube = this;

			if (movieParam) {

				tube.style.display = 'none';
				var provider = getProviderFromUrl(movieParam.value);		
				var id = getVideoIdFromUrl(movieParam.value,provider);

				if (id) {

					var iframe = document.createElement('IFRAME');
					iframe.width = (width) ? width : tube.width;
					iframe.height = (height) ? height : tube.height;

					if (provider == "youtube.com") {
						iframe.title = "YouTube video player";						
						iframe.src = "http://www.youtube.com/embed/" + id;						
					}else if (provider == "vimeo.com"){
						iframe.src = "http://player.vimeo.com/video/" + id;						
					}

					iframe.setAttribute('frameborder',0);
					iframe.setAttribute('allowfullscreen','allowfullscreen');

					$(this).insertAfter(iframe);					
					
				};
				

			};
		});
		

	}
	
