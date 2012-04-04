<?php

if (!defined('DUP_VIEWS_DIR')) define('DUP_VIEWS_DIR',dirname(dirname(__FILE__))."/views");

class OnswipeView{
	
	var $layout = 'default';
	var $contentForPage;

	function __construct(){
		
	}
	
	function render($view){
		
		$viewFile = DUP_VIEWS_DIR."/".$view.".php";

		if (file_exists($viewFile)) {

			if (!empty($this->layout) && !is_ajax_request()) {

				ob_start();
				include($viewFile);
				$content_for_page = ob_get_contents();
				ob_end_clean();		

				$layoutFile = DUP_VIEWS_DIR."/layouts/".$this->layout.".php";
				include($layoutFile);
				
			}else{
				include($viewFile);
			}

		}
				
		
	}
	
	
	function partial($view, $vars = array()){
		
		$viewFile = DUP_VIEWS_DIR."/_".$view.".php";

		if (file_exists($viewFile)) {
			extract($vars);
			include($viewFile);
		}else{
			echo "File $viewFile is missing";
		}
		
	}
	
}

?>