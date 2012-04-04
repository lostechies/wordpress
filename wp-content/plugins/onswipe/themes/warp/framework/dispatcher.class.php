<?php

require_once("view.class.php");

class OnswipeDispatcher{

	function __construct(){

		global $View;

		$View = new OnswipeView();

		$pages = $this->getCurrentPageTypes();
								
		foreach ($pages as $page) {
			$viewFile = DUP_VIEWS_DIR."/".$page.".php";
			if (file_exists($viewFile)) {
				$View->render($page);
				break;
			}
		}
		
	}
	
	/**
	 * undocumented function
	 *
	 * @param string $default 
	 * @param string $returnFirstCoincidence 
	 * @param string $availablePages 
	 * @return void
	 * @author Armando Sosa
	 */
	function getCurrentPageType($default='home',$returnFirstCoincidence = true,$availablePages = null){
		if (!$availablePages) { //make this available as a parameter, just in case dev want to change priority order
			$availablePages=array(
					'home',
					'attachment',					
					'single',
					'paged',					
					'page',
					'year',
					'month',
					'day',
					'date',					
					'time',
					'author',
					'category',
					'tag',
					'tax',
					'archive',										
					'search',
					'feed',
					'comment_feed',
					'trackback',
					'404',
					'admin',
					'singular',
					'robots',
					'posts_page',
				);
		}
		$pageNames=array();
		foreach ($availablePages as $key => $pageName) {
			$functionName="is_".$pageName;			
			if (function_exists($functionName) && $functionName()) {
				if ($returnFirstCoincidence) {
					return $pageName;
				}
				$pageNames[] = $pageName;
			}
		}
		
		$pageNames[] = 'index';
		
		
		if (!empty($pageNames)) {
			return $pageNames;
		}
		
		return $default;
	}	
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function getCurrentPageTypes(){
		return (Array) $this->getCurrentPageType(null,false);
	}	
	
}


?>