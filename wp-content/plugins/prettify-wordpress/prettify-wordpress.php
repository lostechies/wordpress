<?php
/*
 * Plugin Name: Prettify For WordPress
 * Plugin URI: http://themekitwp.com/
 * Description: Display your code on your site with Google Code Prettify and make it look good with style options powered by Themekit for WordPress 
 * Author: Josh Lyford
 * Version: 1.0.1
 * Author URI: http://joshlyford.com
 */


class PrettifyWP {
	var $themekit_version = '0.5.2';
	
	function &init() {
			static $instance = false;
			
			if ( !$instance ) {
				load_plugin_textdomain( 'prettify', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
				$instance = new PrettifyWP;
			}

			return $instance;
	}
	
	function PrettifyWP (){
		if( class_exists('ThemeKitForWP') ){
			$this->load_themekit_options();		
		}
		
		if ( apply_filters( 'prettify_load_stylesheet', true ) ){
			wp_enqueue_style('prettifycss', plugins_url('/css/prettify.css',__FILE__) );
		}
		
		wp_enqueue_script('prettify', plugins_url('/js/min/prettify_mod.js',__FILE__),array('jquery') );
		add_filter( 'the_content', array( $this , 'filter_code' ) , 9 );
	}
	
	function load_themekit_options(){
		$tk = new ThemeKitForWP();
		if( $tk->get_version() >= $this->themekit_version ){
			add_filter('prettify_load_stylesheet', array(&$this,'return_false') );
			$tk->set_option_name('prettify-wordpress');
			$tk->set_menu_type('settings');
			$tk->set_menu_title('Prettify WordPress');
			$page = $tk->get_options_page();
			add_action("load-$page", array($this, 'admin_load'));
			
			$radius = array();
			for ($i = 0; $i < 26; $i++){ 
				$radius[] = array('id'=>'radius_'.$i,'name'=>$i.'px'); 
			}
			
			
			$opts = array();
			$opts[] = array('type'=>'title','desc'=>'Preview');
			$opts[]= array(
				'type'=>'html',
				'name'=>'Current Styles:',
				'code'=> $this->filter_code($this->settings_info())
			);
			
			$opts[] = array( 
				"name" => "Code Color Settings",
				"type" => "open"
				);
			$opts[] = array(	
				"name" => "str",		
			    "id" => "str_color",
				"std" => array('color' => '#080'),
				"type" => "typography",
				"selector" => ".str",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "kwd",		
			    "id" => "kwd_color",
				"std" => array('color' => '#008'),
				"type" => "typography",
				"selector" => ".kwd",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "com",		
			    "id" => "com_color",
				"std" => array('color' => '#800'),
				"type" => "typography",
				"selector" => ".com",
				"style"=>'font'
				);
				
			$opts[] = array(	
				"name" => "typ",		
			    "id" => "typ_color",
				"std" => array('color' => '#606'),
				"type" => "typography",
				"selector" => ".typ",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "lit",		
			    "id" => "lit_color",
				"std" => array('color' => '#066'),
				"type" => "typography",
				"selector" => ".lit",
				"style"=>'font'
				);	
			
			$opts[] = array(	
				"name" => "pun",		
			    "id" => "pun_color",
				"std" => array('color' => '#660'),
				"type" => "typography",
				"selector" => ".pun",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "pln",		
			    "id" => "pln_color",
				"std" => array('color' => '#008'),
				"type" => "typography",
				"selector" => ".pln",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "tag",		
			    "id" => "tag_color",
				"std" => array('color' => '#008'),
				"type" => "typography",
				"selector" => ".tag",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "atn",		
			    "id" => "atn_color",
				"std" => array('color' => '#606'),
				"type" => "typography",
				"selector" => ".atn",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "atv",		
			    "id" => "atv_color",
				"std" => array('color' => '#080'),
				"type" => "typography",
				"selector" => ".atv",
				"style"=>'font'
				);
			$opts[] = array(	
				"name" => "dec",		
			    "id" => "dec_color",
				"std" => array('color' => '#606'),
				"type" => "typography",
				"selector" => ".dec",
				"style"=>'font'
				);
			$opts[] = array( "type" => "close"	);
			
			$opts[] = array( 
				"name" => "Pre tag styles",
				"type" => "open"
			);
			
			$opts[] = array( 	
				"name" => "Background Color",
				"desc" => "To remove background color delete everything but the #. default color is #F7F7F7",
				"id" => "pretty_pre_bg",
				"type" => "colorpicker",
				"std" => "#F7F7F7",
				"selector" => ".prettyprint, .prettyprint code",
				"style"=> "background-color"
			);
			$opts[] = array(
				"name" => "Border",
				"desc" => "Adds a border to the container. default is border: solid 1px #999999.",
				"id" => "prettify_border",
				"std" => array('width' => '1','style' => 'solid','color' => '#999999'),
				"type" => "border",
				"selector" => ".prettyprint",
				"style" => "prettify-container-border"
			);
			$opts[] = array( 
				"name" => "Border Radius",
				"subtext"=>"",
				"desc" => "Sets the border radius of the container. The default setting is 10px.",
				"id" => "pre_border_radius",
				"type" => "select",
				"options" => $radius,
				"std" => 'radius_10',
				"selector" => ".prettyprint",
				"style" => "prettify-container-border-radius"
			);
			$opts[] = array(	
				"name" => "Font",		
			    "id" => "prettify_base_font",
				"std" => array('size' => '14','face' => 'Courier','style' => 'normal','color' => '#333333'),
				"type" => "typography",
				"desc" => "Base font settings for pre tag.",
				"selector" => ".prettyprint, .prettyprint code",
				"style"=>'font'
			);
			$opts[] = array(	
				"name" => "Rel Font",		
			    "id" => "prettify_rel_text",
				"std" => array('size' => '18','face' => 'Georgia','style' => 'normal','color' => '#999999'),
				"type" => "typography",
				
				"desc" => "This is the rel text displayed in the upper right.",
				"selector" => ".prettyprint:after",
				"style"=>'font'
			);
				$opts[] = array(	
					"styles" => ' content: attr(rel); position: absolute; top: 15px; line-height: 0; right: 12px; ',
					"type" => "styleonly",
					"selector" => ".prettyprint:after",
					"style"=>'add-style'
				);
			
			//pre:after { content: attr(rel); position: absolute; font-size: 24px; top: 15px; line-height: 0; right: 12px; color: #999; font-family: Georgia;  }
			
			
			
			$opts[] = array( "type" => "close"	);
					$opts[] = array('type'=>'open','name'=>'Settings & Generated Styles');
						
					/*
					$opts[] = array( 
						"name" => "Stylesheet",
						"desc" => "You may want to add the styles directly to your stylesheet if you have caching or a cdn setup.",
						"id" => "radio_t",
						"type" => "radio",
						"std" => "true",
						"options"=> array("true" => "Have Prettify WordPress add the styles to my theme.","false" => "I will copy the generated styles to my themes stylesheet.")
						);
*/
					$opts[] = array( 
						"name" => "CSS",
						"desc" => "More options coming soon!",
						"id" => "css_dump",
						"type" => "cssdump",
						"std" => '',
						"subtext"=>"Styles generated by this plugin."
					);
					$opts[] = array( "type" => "close"	);
			$tk->register_options($opts);
		
			add_filter('themekitforwp_css_engine_prettify-wordpress',array(&$this,'css_engine'), 10, 2);
		
			
			
			
		}
	}
	
		function css_engine($reg_option, $saved){
			$styles = '';
		    switch( $reg_option['style'] ){
		    	case 'prettify-container-border-radius':
		    		$b = explode("_",$saved[ $reg_option[ "id" ] ]);
		        	$styles .= '-moz-border-radius: '.$b[1].'px;';
		        	$styles .= 'border-radius: '.$b[1].'px;';
		        break;
		        case 'prettify-container-border':
		        	$styles .= 'border: '.$saved[ $reg_option[ "id" ] ]['color'].' '.$saved[ $reg_option[ "id" ] ]['style'].' '.$saved[ $reg_option[ "id" ] ]['width'].'px;';
					$styles .= "padding: 10px; margin: 0 0 20px 0; overflow: auto; position: relative;";
				break;
		        case 'twitter-container-padding':
		        	$styles .= 'padding:'.$saved[ $reg_option[ "id" ] ]['top'].'px '.$saved[ $reg_option[ "id" ] ]['right'].'px '.$saved[ $reg_option[ "id" ] ]['bottom'].'px '.$saved[ $reg_option[ "id" ] ]['left'].'px;';
		        break;
		        case 'twitter-padding':
		        	$styles .= 'padding:'.$saved[ $reg_option[ "id" ] ]['top'].'px '.$saved[ $reg_option[ "id" ] ]['right'].'px '.$saved[ $reg_option[ "id" ] ]['bottom'].'px '.$saved[ $reg_option[ "id" ] ]['left'].'px;';
		       	break;
		        case 'twitter-header-margin':
		        	$styles .= 'margin:'.$saved[ $reg_option[ "id" ] ]['top'].'px '.$saved[ $reg_option[ "id" ] ]['right'].'px '.$saved[ $reg_option[ "id" ] ]['bottom'].'px '.$saved[ $reg_option[ "id" ] ]['left'].'px;';
		        break;
		        case 'twitter-margin':
		        	$styles .= 'margin:'.$saved[ $reg_option[ "id" ] ]['top'].'px '.$saved[ $reg_option[ "id" ] ]['right'].'px '.$saved[ $reg_option[ "id" ] ]['bottom'].'px '.$saved[ $reg_option[ "id" ] ]['left'].'px;';
		        break;
		        case 'twitter-header-text-align':
		        	$styles .= 'text-align:'.$saved[ $reg_option[ "id" ] ].';';
		        break;
		    }
		    return $styles;
		}
	
	

		
	function settings_info(){
		$output = '<div style="width:425px; float:left;"><pre rel="CSS-PHP" class="prettyprint">
<code><?php class Voila {
	public:
  	// Voila
	static const string VOILA = "Voila";
	// will not interfere with embedded tags.
	function make_widget($widget){
		return $widget;
	}
} ?>
<style> /* CSS CODE */
.str { 
	color: #080; 
	}
.kwd { 
	color: #008; 
	}
</style>
<h1>Some HTML</h1>
</code></pre></div><div style="margin-left: 450px; max-width: 300px;"><h3>Setup:</h3>To use this styling you will have to add a class of \'prettyprint\' to your pre tags. You will also need to include the code tag within your pre tag. <h3>ex:</h3>&lt;pre rel=\'demo\' class=\'prettyprint\'&gt;<br>&lt;code&gt; { Your Code Here } &lt;/code&gt;<br>&lt;/pre&gt;<h3>Note:</h3>The preview is this plugins best guess as to how it will look on your site. Results may very depending on your theme. Default code colors are the prettify defaults. Happy coding.</div><br class="clear">';
return $output;
}	
	function return_false(){
		return false;
	}
		
		
		
	function filter_code($data) {
		/*
		$mod_data = preg_replace_callback('@(<pre.*>)(.*)(<\/pre>)@isU', array( $this,'escape_html'), $data);
		*/
		$mod_data = preg_replace_callback('@(<code.*>)(.*)(<\/code>)@isU', array( $this,'escape_html'), $data);
		$mod_data = preg_replace_callback('@(<tt.*>)(.*)(<\/tt>)@isU', array( $this,'escape_html'), $mod_data);

		return $mod_data;
	}
	
	function escape_html($arr) {

		// last params (double_encode) was added in 5.2.3
		if (version_compare(PHP_VERSION, '5.2.3') >= 0) {

			$output = htmlspecialchars($arr[2], ENT_NOQUOTES, get_bloginfo('charset'), false); 
		}
		else {
			$special_chars = array(
	            '&' => '&amp;',
	            '<' => '&lt;',
	            '>' => '&gt;'
			);

			// decode already converted data
			$data = htmlspecialchars_decode($arr[2]);

			// escapse all data inside <pre>
			$output = strtr($data, $special_chars);
		}

		if (! empty($output)) {
			return  $arr[1] . $output . $arr[3];
		}
		else
		{
			return  $arr[1] . $arr[2] . $arr[3];
		}

	}
	

	
}

add_action( 'init', array( 'PrettifyWP', 'init' ) );