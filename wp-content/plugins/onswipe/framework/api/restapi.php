<?php
class RESTAPI{
	
	private $__request;
	private $__action;
	private $__method;
	private $__callback;
	private $__params;
	private $__named = false;
	private $routes;
	
	/**
	 * Constructor
	 *
	 * @author Armando Sosa
	 */
	function __construct(){		
		$hook = "rest_api_request";
		add_action("wp_ajax_nopriv_$hook",array($this,'handle_request'));
		add_action("wp_ajax_$hook",array($this,'handle_request'));				
	}

	function get($route,$callback){
		$this->route('get',$route,$callback);
	}
	
	function post($route,$callback){
		$this->route('post',$route,$callback);
	}
	
	function put($route,$callback){
		$this->route('put',$route,$callback);
	}
	
	function delete($route,$callback){
		$this->route('delete',$route,$callback);
	}
	
	
	function route($method,$route,$callback){
		$method = strtoupper($method);
		$this->routes[$method][$route] = $callback;
	}
	
	
	function handle_request(){		
		$this->__parse_request();
		if (is_callable($this->__callback)) {
			
			if ($this->__named) {
				call_user_func($this->__callback,$this->__params);
			}else{
				call_user_func_array($this->__callback,$this->__params);				
			}
		}else{
			echo "404";
		}
		die;
	}
	
	private function __parse_request(){
		$raw_request = $_REQUEST;
		$this->__query = array_splice($raw_request,2);
		$this->__method = $_SERVER['REQUEST_METHOD'];
		$this->__request = preg_replace("#\/$#",'',$raw_request['api_request']); // I'm trimming the trailing slash
		$this->__params = explode('/',$this->__request);
		$this->__action = array_shift($this->__params);

		$this->__router($this->__request);
		
	
	}
	
	/**
	 * Very simple router
	 *
	 * @param string $uri 
	 * @return void
	 * @author Armando Sosa
	 */
	private function __router($uri){

		if (!isset($this->routes[$this->__method])) return;

	    foreach ($this->routes[$this->__method] as $route => $callback) {

			// first, check for catch-all asterisks
			$reRule = preg_replace('/\*/', '(.+)$', $route,-1,$asterisks);

			// then, for named parameters
			$reRule = preg_replace('/:([a-z]+)/', '(?P<\1>[^/]+)', $reRule, -1, $named);
			$reRule = str_replace('/', '\/', $reRule);

			//execute the regexp
			preg_match('/' . $reRule .'/', $uri, $matches);

			if ($matches) {
				$this->__callback = $callback;
				if ($asterisks) {
					$this->__params = explode('/',$matches[1]);
				}else{
					$this->__named = true;
					$this->__params = array();
					foreach ($matches as $k => &$v) {
						if (!is_int($k)) {
							$this->__params[$k] = $v;
						};
					}
				}
				break;
			}

		}
	}
	
	/**
	 * Converts an object or array to JSON and outputs it
	 *
	 * @param string $object 
	 * @return void
	 * @author Armando Sosa
	 */
	function jsonize($object){
        header( 'Cache-Control: no-cache, must-revalidate' );
        header( 'Content-type: application/json' );
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Headers: X_REQUESTED_WITH' );
		echo json_encode($object);
		die;		
	}
	
	
}

if (!function_exists('pr')) {
	/**
	 * Helper function for development.
	 *
	 * @param string $v 
	 * @return void
	 * @author Armando Sosa
	 */
	function pr($v){
		echo "<pre>";
		print_r($v);
		echo "</pre>";
	}    
}
