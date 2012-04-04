var LuxBox = {
	
	Video : function(context){
		
		var getVideoIdFromUrl = function(url){
			var match = url.match('youtube.com.+v\/([^\?]+)');
			if (match) {
				return match[1];
			};
			
			return false;
		}

		// get the video objects
		var tubes = context.getElementsByTagName('object');

		if (!tubes.length) return;

		// check that they are indeed youtube 
		Flan.each(tubes,function(){
			var movieParam = this.querySelector('param[name=movie]');
		
			var tube = this;
			
			if (movieParam) {
				
				tube.style.display = 'none';
				var id = getVideoIdFromUrl(movieParam.value);

				if (id) {
					var placeHolder = document.createElement('DIV');
					var img = "<img src='http://img.youtube.com/vi/"+id+"/0.jpg'/>";
					
					// placeHolder.href = "#";
					placeHolder.className = "luxbox-video-placeholder";
					placeHolder.innerHTML = img + "<span>Play Video</span>";

					placeHolder.onclick = function(){
						tube.style.display = 'block';
					}

					Flan.Elemental(this).insertAfter(placeHolder);					
					
				};



			};
		});
		

	}
	
}