<?php

if (!class_exists('csml')) {
	require_once(PADPRESS_FRAMEWORK_DIR.'/csml.php');
}

/**
 * OnswipeOptions
 * 
 * This Class makes easier to make save and retrieve options ad option panels
 * 
 *  
 * @package default
 * @author Armando Sosa
 */
class OnswipeOptions{

	var $panels = array();
	
	var $values = array();
	
	function __construct(){
		add_action('admin_init',array($this,'registerSettings'));
		add_action('admin_menu',array($this,'registerPanels'));
		add_action('admin_head',array($this,'customAdminHead'));
	}

	function addPanel($options = array(),$defaults = array()){
		
		$options =  wp_parse_args( $options, array(
			'name' => 'options',
			'page_title'=>'options',
			'menu_title'=>'options',
			'access_level'=>'manage_options',
			'custom_css'=>false,
			'custom_js'=>false,
			'top_level'=>'themes.php',
			'auto_register'=>true,
		));		
				
		$options['function'] = array($this,'render_'.$options['name']);
		$this->panels[$options['name']] = $options;
		
		// set values from database or default
		$values = get_option($options['name']."_opts",true);


		if (empty($values)) {
			$values = array();
		}	
			
		$this->values[$options['name']] = wp_parse_args($values,$defaults);		
				
	}
	
	function customAdminHead(){
		echo "<!-- #dupie-options -->";			
		foreach ($this->panels as $panel) {
			if ($panel['custom_css']) {
				echo '<link rel="stylesheet" type="text/css" href="'.$panel['custom_css'].'"/>'."\n";		
			}
		}
		foreach ($this->panels as $panel) {
			if ($panel['custom_js']) {
				echo '<script src="'.$panel['custom_js'].'" type="text/javascript" charset="utf-8"></script>';
			}
		}
	}
	
	function hasPanel($panel){
		return isset($this->panels[$panel]);
	}
	
	function registerSettings(){
		foreach ($this->panels as $panel) {
			register_setting( $panel['name'],$panel['name']."_opts", array($this,'validate_'.$panel['name']) );
		}
		
	}
	
	function registerPanels(){
		foreach ($this->panels as &$panel) {
			extract($panel);
			if ($auto_register == true) {
				$panel['callback'] = add_submenu_page($top_level, $page_title, $menu_title, $access_level, $name, $function);
			}
			
		}				
	}
	
	function render($name){
		global $current_panel;
		$current_panel = $this->panels[$name];

		$themePath = dirname(dirname(__FILE__));

		if (isset($current_panel['file_path'])) {
			$path = $current_panel['file_path'];
		}else{
			$path = $themePath . '/views/'.$name.'_panel.php';			
		}
		
		if (file_exists($path)) {
			$form = new OnswipeOptionsHelper($current_panel, $this->values[$name]);
			include($path);
		}else{
			echo "missing file: ".$name;
		}
	}
	
	function validate($name, $data){
		
		$files = array();
		
		if ( isset( $_FILES[$name . '_opts'] ) ) {
			define( 'ONSWIPE_SETTINGS', true );
			$files = array_insideout( $_FILES[$name . '_opts'] );
		}

		foreach ($files as $key => $file) {
			
			$key = str_replace('__file','',$key);
			if (empty($file['tmp_name'])) {
				continue;
			}
			
			$override = array(
				'test_form'=>false,
			);
		
			$uploaded_file = wp_handle_upload($file,$override);
		
			if(!empty($uploaded_file['error'])) {
				return  new WP_Error('broke', __("Upload Error : ",'nube')." ".$uploaded_file['error']);
			}
			$data[$key]  = $uploaded_file['url'];
		}
		
		if ( isset( $_POST['padpressed_general']['enable'] ) ) {
			if ( $_POST['padpressed_general']['enable'] === 'enable' ) {
				update_option( 'padpressed_is_disabled', 0 );
				if ( function_exists( 'bump_stats_extras' ) )
					bump_stats_extras( 'onswipe', 'enabled' );
			} else {
				update_option( 'padpressed_is_disabled', 1 );
				if ( function_exists( 'bump_stats_extras' ) )
					bump_stats_extras( 'onswipe', 'disabled' );
			}
		} elseif ( false === get_option( 'padpressed_is_disabled' ) ) {
			// Set the option so a user won't be confused if they
			// change mobile and onswipe ends up changing as well
			if ( 1 == get_option( 'wp_mobile_disable' ) )
				update_option( 'padpressed_is_disabled', 1 );
			else
				update_option( 'padpressed_is_disabled', 0 );
		}		
		
		return $data;
	}
	
	
	function __call($method,$args = array()){
		if (strpos($method,'render_') === 0) {
			$panel = str_replace('render_','',$method);
			return $this->render($panel);
		}elseif (strpos($method,'validate_') === 0){
			$panel = str_replace('validate_','',$method);
			return $this->validate($panel, $args[0]);			
		}else{
			return false;
		}
	}
	
	function get($group,$name = ''){

		if (empty($name)) {	
			if (isset($this->values[$group])) {
				return $this->values[$group];
			}			
		}

		if (isset($this->values[$group][$name])) {
			return $this->values[$group][$name];
		}else{
			return null;
		}
	}
	
	function filter($group,$filter){
				
		if (isset($this->values[$group])) {
			$filtered = array();
			
			foreach ($this->values[$group] as $key => $value) {
				if (str_starts_with($filter,$key)) {
					$key = str_replace($filter,'',$key);
					$filtered[$key] = $value;
				}
			}
			
			return $filtered;
		}
		
		return false;
	}
	
	function reset($name = null){
		if (!$name) {
			global $current_panel;
			$name = $current_panel['name'];
		}		
		delete_option("{$name}_opts");
	}
		
	function categoryList(){
		$cats = get_categories(array( 'get' => 'all'));
		$list = array();
		foreach ($cats as $cat) {
			$list[$cat->term_id] = $cat->name;
		}
		return $list;
	}
	
	
}

class OnswipeOptionsHelper{

	var $panel;
	var $values;
	
	function __construct($panel, $values){
		$this->panel = $panel;
		$this->values = $values;
	}
	
	function input($name, $options = array()){
		
		$fieldName = $this->panel['name']."_opts"."[$name]";
		$fieldAdjacentFileName = $this->panel['name']."_opts"."[{$name}__file]";
		
		$options =  set_merge( array(
			'label' => $name,
			'hint'=>'',
			'type'=>'text',
			'options'=>false,
			'attributes'=>array(
					'id'=>$name,
					'name'=>$fieldName,	
					'class'=>false,
				),
			'row'=>true,	
			'preview'=>false,
			'enclosing_tag'=>"div.input"
		),$options);	

		if (isset($this->values[$name])) {
			$options['attributes']['value'] = $this->values[$name];
		}else{
			$options['attributes']['value'] = '';
		}
		$options['attributes']['type'] = $options['type'];
				
		switch ($options['type']) {
			case 'text':
			case 'input':
			case 'hidden':
				$input = csml::tag("input/",$options['attributes']); 
				break;
			case 'file':				
				$input = csml::tag("input/",array('type'=>'hidden','value'=>$options['attributes']['value'], 'name'=>$options['attributes']['name']))."<br/>"; 				
				$input .= csml::tag("input/",array('type'=>'file','name'=>$fieldAdjacentFileName)); 
				break;				
			case 'textarea':
				$value = $options['attributes']['value'];
				$options['attributes']['value'] = false;
				$input = csml::entag($value,'textarea',$options['attributes']);
				break;
			case 'select':
				$value = $options['attributes']['value'];
				$options['attributes']['value'] = false;
				$input = csml::tag('select',$options['attributes']);
				$options['options'] = (array) $options['options'];
				foreach ($options['options'] as $v => $l) {
					$opattr = array('value'=>$v);
					if ($value == $v) {
						$opattr['selected'] = 'selected';						
					}
					$input.= csml::entag($l,'option',$opattr);
					
				}
				$input.= csml::tag('/select');
				break;
			case 'checkbox':
				
				$options['attributes']['checked'] = ($options['attributes']['value'] === "on")?'checked':false;
				$options['attributes']['value'] = false;


				$options['legend'] = (isset($options['legend'])) ? $options['legend']: $options['label'];
				$input = csml::tag("input/",$options['attributes']); 			
				if ($options['legend']) {
					$input = csml::entag($input." ".$options['legend'],'label');
				}
				break;				
			default:
				$input = csml::tag("input/",$options['attributes']); 
				break;
		}	
		
		// image preview
		if ($options['type'] == 'file') {
			if ($options['preview'] && !empty($options['attributes']['value'])) {
				$img = csml::tag('img/',array('src'=>$options['attributes']['value'],'max-height'=>'120'));
				$input .= csml::entag($img,'p.image_preview');
			}
			
			$options['hint'].="<br/>".$options['attributes']['value'];
		}
		
		
		if ($options['row']) {
			$input = $this->row($options,$input, $options['hint']);
		}else{
			if ($options['label']) {
				$input = "<label>{$options['label']} $input </label>";
			}
			if (is_string($options['enclosing_tag'])) {
				$input = csml::entag($input,$options['enclosing_tag']);
			}			
		}	
		
		
		echo $input;
	}
	
	function row($options,$input,$hint=''){
		if (!empty($hint)) {
			$hint = csml::entag($hint,'p.hint');
			
		}
		$th = csml::entag($options['label'],'th',array('scope'=>'row'));
		$td = csml::entag($input.$hint,'td');
		return csml::entag($th.$td,'tr[valign="top"]');
	}
	
	function section($title){
		$h = csml::entag($title,'h3')."<hr/>";
		$th = csml::entag($h,'th',array('colspan'=>'2'));
		return csml::entag($th,'tr[valign="top"]');		
	}
	
}

function array_insideout($array1){
	$array2 = array();
	foreach ($array1 as $key => $inner) {
		foreach ($inner as $innerKey => $value) {
			$array2[$innerKey][$key] = $value;
		}
	}
	return $array2;
}


global $Options;
$Options = new OnswipeOptions;
