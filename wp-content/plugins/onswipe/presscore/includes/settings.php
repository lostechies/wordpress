<?php

// hook stuff up.
add_action( 'init',  'onswipe_settings_page_init' );
add_action( 'admin_init', 'onswipe_options_init' );

/**
 * Hook for admin menu.
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_settings_page_init(){

	onswipe_welcome_process();

	if ( current_user_can( 'manage_options' ) ){
		// Display admin pages
		add_action( 'admin_menu', 'onswipe_add_page' );
	}

}

/**
 * Add the settings page to the menu
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_add_page(){

	if ( defined( 'SELF_HOSTED' ) && SELF_HOSTED ) {
		global $menu;
		$menu[54] = array( '', 'read', 'separator2', '', 'wp-menu-separator' );
		$icon_url = ONSWIPE_PLUGIN_URL.'/presscore/assets/images/menu-icon-2.png';
		$position = 55;
		$onswipe_settings_page = add_menu_page( 'Onswipe', 'Onswipe', 'manage_options', 'Onswipe', 'onswipe_settings_page', $icon_url, $position );
	} else {
		$onswipe_settings_page = add_theme_page( 'Onswipe', 'Onswipe', 'manage_options', 'onswipe_settings_page', 'onswipe_settings_page' );
	}

	// Add scripts and styles to the settings page
	add_action( 'admin_print_scripts-'.$onswipe_settings_page, 'onswipe_settings_scripts' );
	add_action( 'admin_print_styles-'.$onswipe_settings_page, 'onswipe_settings_styles' );
}

/**
 * Enqueues Settings' script
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_settings_scripts() {
	wp_register_script( 'onswipe-hostess', ONSWIPE_PLUGIN_URL.'/presscore/assets/js/hostess.js', array( 'farbtastic', 'jquery', 'media-upload', 'thickbox' ) );
	wp_enqueue_script( 'onswipe-hostess' );

	wp_register_script( 'onswipe-settings-scripts', ONSWIPE_PLUGIN_URL.'/presscore/assets/js/settings.js', array( 'farbtastic', 'jquery', 'media-upload', 'thickbox' ) );
	wp_enqueue_script( 'onswipe-settings-scripts' );
}

/**
 * Enques Settings' style
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_settings_styles() {
	wp_register_style( 'onswipe-settings-styles', ONSWIPE_PLUGIN_URL.'/presscore/assets/css/settings.css', array( 'farbtastic', 'thickbox' ) );
	wp_enqueue_style( 'onswipe-settings-styles' );
}

/**
 * Prints the Onswipe's Settings Page
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_settings_page(){
	?>

	<?php if( ! current_user_can( 'manage_options' ) ) wp_die( __( 'Insufficient permissions', 'onswipe' ) ); ?>

	<?php 
		if (SELF_HOSTED)
			onswipe_welcome(); 
	?>


	<div class='wrap onswipe-wrap'>

	<?php if ( ! is_writable( PBDATA_CACHE_DIR ) ): ?>

		<div class='message error'>
			<p>
				<?php _e( '<strong>Don\'t Panic</strong>, but I cannot write to the cache directory.', 'onswipe' ); ?>
				<a href='#' onclick='jQuery('.more-info').toggle(); return false;'><?php _e( 'More info' ) ?></a>
			</p>
			<p class='more-info' style='display:none'>
				You can use FTP software to log in into your server and change the permissions on this directory:
				<?php echo PBDATA_CACHE_DIR ?>
				to 0744. This way we can serve your data way faster.
			</p>
		</div>

	<?php endif ?>

	<?php onswipe_on_update(); ?>

	<div class="onswipe-title">
		<?php screen_icon( 'onswipe' ); ?>
		<h2><?php _e( 'Onswipe Settings', 'onswipe' ); ?></h2>
		<div class="social">
			<a class="facebook" href="http://facebook.com/onswipe"><?php _e( 'Like Onswipe on Facebook', 'onswipe' ) ?></a>
			 &middot;  
			<a class="twitter"  href="http://twitter.com/onswipe"><?php _e( 'Follow on Twitter', 'onswipe' ) ?></a>
		</div>
	</div>

        <form action='options.php' method='post'>

            <div id="support-button-wrap">
                <a href="#" class="et-trigger" id="support-button"><strong>Get help</strong>, send feedback, or report a bug</a>
            </div>

			<?php settings_fields( 'onswipe_options' ); ?>

			<?php do_settings_sections( 'onswipe_settings_page_top' ); ?>

			<div class='onswipe-options-settings'>
				<?php do_settings_sections( 'onswipe_settings_page' ); ?>
			</div>

			<p class='submit'><input name='Submit' type='submit' value='Save Changes' class='button-primary' /></p>
		</form>

	</div>
	<?php

	onswipe_pbdata_cache();
	
	if ( SELF_HOSTED ) {
		require_once( dirname( ONSWIPE_PLUGIN_DIR ) . '/et/et.php' );
		ET::phone_home( 'wpfeedback@onswipe.com', admin_url('admin.php?page=Onswipe') );
	}

}

/**
 * Register Onswipe settings
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_options_init(){

	register_setting( 'onswipe_options', 'onswipe_options', 'onswipe_options_sanitize' );

	// Enable Onswipe section
	add_settings_section(
	    'onswipe_enable_section', // id
	    'Enable Onswipe', // Title of section
	    'onswipe_enable_section_text', // Callback
	    'onswipe_settings_page_top' // page to display on
	);

	// Enable Toggle Button
	add_settings_field( 'onswipe_enabled', 'Onswipe', 'onswipe_enable_button', 'onswipe_settings_page_top', 'onswipe_enable_section', array( 'label_for' => 'onswipe_enabled' ) );

	// Display Options section
	add_settings_section(
	    'onswipe_basic_options', // id
	    'Design Options', // Title of section
	    'onswipe_basic_options_text', // Callback
	    'onswipe_settings_page' // page to display on
	);

	// Layouts section
	add_settings_section(
	    'onswipe_layout_options', // id
	    'Layout Options', // Title of section
	    'onswipe_basic_options_text', // Callback
	    'onswipe_settings_page' // page to display on
	);

	// Accent Color
	add_settings_field(
	    'accent_color', // ID
	    'Accent Color', // title
	    'onswipe_option_accent', // Callback
	    'onswipe_settings_page', // page to display on
	    'onswipe_basic_options', // section to display in
	    array( 'label_for' => 'accent_color' ) // This should be the same as the ID
	);


	// Loading Screen
	add_settings_field( 'loading_screen', 'Loading Screen Image URL',	'onswipe_option_file', 'onswipe_settings_page', 'onswipe_basic_options', array( 'label_for' => 'loading_screen' ) );

	// Logo
	add_settings_field( 'logo', 'Logo Image URL', 'onswipe_option_file', 'onswipe_settings_page', 'onswipe_basic_options', array( 'label_for' => 'logo' ) );

	// Icon
	add_settings_field( 'icon', 'Icon Image URL', 'onswipe_option_file', 'onswipe_settings_page', 'onswipe_basic_options', array( 'label_for' => 'icon' ) );

	// Table of Contents Layout
	add_settings_field( 'toc_layout', 'Table of Contents Layout', 'onswipe_option_radio_images', 'onswipe_settings_page', 'onswipe_layout_options', array( 'label_for' => 'toc_layout' ) );

	// Article Layout
	add_settings_field( 'article_layout', 'Article Layout', 'onswipe_option_radio_images', 'onswipe_settings_page', 'onswipe_layout_options', array( 'label_for' => 'article_layout' ) );

	// Google Analytics
	add_settings_field( 'google_analytics', 'Google Analytics ID', 'onswipe_option_text', 'onswipe_settings_page', 'onswipe_basic_options', array( 'label_for' => 'google_analytics' ) );


}

function onswipe_enable_section_text(){
	//echo '<p>Enable Onswipe</p>';
}

function onswipe_basic_options_text(){
	// Will be displayed below the section title
	// WordPress throws a warning when a callback isn't provided.
}

/**
 * Outputs Onswipe's settings enable/disable control
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_enable_button(){

	$options = get_option( 'onswipe_options' );

	$option = $options['enabled'];
	
	if ( empty( $option ) ){
		$option = 'enabled';
	}

	?>

		<div class='toggle-switch' style='display:none;'>
			<a href='#' class='enabled-label' data-value='enabled'>Enabled</a>

			<div class="switch-bg <?php echo $option; ?>">
				<div class='switch-btn'></div>
			</div>

			<a href='#' class='disabled-label' data-value='disabled'>Disabled</a>
		</div>

		<div class='hidden-radio-options'>
			<input type='radio' name='onswipe_options[enabled]' class='onswipe_enabled' value='enabled' <?php checked( $option, 'enabled' ); ?> /> <?php _e( 'Enabled', 'onswipe' ); ?><br />
			<input type='radio' name='onswipe_options[enabled]' class='onswipe_enabled' value='disabled' <?php checked( $option, 'disabled' ); ?> /> <?php _e( 'Disabled', 'onswipe' ); ?>
		</div>
	<?php
}

/**
 *	Text Field
 *
 *	Displays a simple text field. Description text is
 *  displayed based on the label_for argument passed
 *  to add_settings_field.
 *
 *	@author: Sawyer H
 */
function onswipe_option_text( $args ){

	if ( isset( $args['label_for'] ) ){
		$id = $args['label_for'];

		$options = get_option( 'onswipe_options' );
		$option  = $options[$id];

		if ( $id == 'google_analytics' ){
			$desc = 'Ex. UA-12345678-9';
		}
	?>
		<input type='text' name="onswipe_options[<?php echo $id; ?>]" id="<?php echo $id; ?>" value="<?php echo $option; ?>" />
		<?php if ( $desc ){ ?><br /><span class='description'><?php echo $desc; ?></span><br /><?php } ?>
	<?php
	}
}

/**
 *	File Uploader
 *
 *	Displays a text field for a file URL, with an
 * 	upload button next to it. Description text is
 *  displayed based on the label_for argument passed
 *  to add_settings_field.
 *
 *	@author: Sawyer H
 */
function onswipe_option_file( $args ){

	if( isset( $args['label_for'] ) ):

	$id = $args['label_for'];

	$options = get_option( 'onswipe_options' );
	$file    = $options[$id];

	$desc = '';

	if ( $id == 'loading_screen' ){
		$desc = __( 'recommended: PNG image with transparency at 768&#215;1004px', 'onswipe' );
	} elseif ( $id == 'icon' ){
		$desc = __( 'recommended: PNG image at 129&#215;129px', 'onswipe' );
	} elseif ( $id == 'logo' ){
		$desc = __( 'recommended: use a 200&#215;200px transparent PNG', 'onswipe' );
	}

	?>

	<div class='file-upload-wrap'>
		<input type='text' name="onswipe_options[<?php echo $id; ?>]" value="<?php echo $file; ?>" id="<?php echo $id; ?>" class="upload-field" />
		<a href="#" class="upload-btn button-secondary" data-field="<?php echo $id; ?>"><?php _e( 'Upload', 'onswipe' ); ?></a>
		<?php if ( $desc ){ ?><br /><span class="description"><?php echo $desc; ?></span><br /><?php } ?>
		<div class="onswipe-image-preview"<?php if ( $file && $file != '' ){ echo 'style="display:block;"'; } ?>>
			<div class="holder">
				<?php if ( $file && $file != '' ){
					echo '<img src="'.$file.'" alt="Preview" />';
				} ?>
			</div>
			<a href="#" class="clear-file-url"><img src="<?php echo ONSWIPE_PLUGIN_URL; ?>/presscore/assets/images/delete-ico.png" alt='Remove' /></a>
		</div>
	</div>

	<?php
	endif;
}

/**
 *	Colorpicker
 *
 *	Displays a small text field that turns into
 * 	a colorpicker upon focus. Uses WordPress' default
 *  colorpicker, Farbtastic.
 *
 *	@author: Sawyer H
 */
function onswipe_option_accent(){
	$options = get_option( 'onswipe_options' );
	$accent_color = esc_attr( $options['accent_color'] );

	if ( ! $accent_color || $accent_color == '' ){
		$accent_color = '#';
	}
	?>
	<div class='color-picker' style='position: relative;'>
        <input type='text' name='onswipe_options[accent_color]' id='accent_color' value="<?php echo $accent_color; ?>" size='7' autocomplete='off'/>
        <div style='position: absolute;' id='colorpicker'></div>
    </div>

	<?php
}



/**
 *	Layout Selector
 *
 *	A customized collection of radio options that pulls
 *  from the $onswipe_layouts array and displays an image
 *  for each layout.
 *
 *	@author: Sawyer H
 */
function onswipe_option_radio_images( $args ){

	if( isset( $args['label_for'] ) ):

	$key = $args['label_for'];

	$options  = get_option( 'onswipe_options' );
	$selected = $options[$key];

	$onswipe_layouts = onswipe_get_layouts();
	
	$key = str_replace('_layout','',$key )
	?>

	<div class='onswipe-radio-images onswipe-layout-grid' data-section='<?php echo $key ?>'></div>
	<?php if ( ! empty( $selected ) ): ?>
		<script type="text/javascript" charset="utf-8">
			window.onswipe_default_<?php echo $key ?> = <?php echo $selected ?>;      
		</script>		
	<?php endif ?>
	<?php
	endif;
}


/**
 * Sanitizes Options
 *
 * @param string $inputs
 * @return void
 * @author Armando Sosa
 */
function onswipe_options_sanitize( $inputs ){
	
	foreach ( $inputs as $key => &$input ){
		// Trim whitespace
		$input = trim( $input );

		switch ( $key ) {
			case 'loading_screen':
			case 'icon':
				$input = esc_url( $input );
				break;

			case 'accent_color':
				if ( ! str_starts_with( '#', $field ) ) {
					$field = '#'.$field;
				}

			default:
				$input = esc_attr( $input );
				break;
		}
	}
	
	return $inputs;
}

function onswipe_on_update(){
	
	if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ){ 
		// cache plugins installed? let's clean 'em up
		if ( function_exists( 'w3tc_pgcache_flush' ) )
			w3tc_pgcache_flush();

		if ( function_exists( 'wp_cache_clear_cache' ) )
			wp_cache_clear_cache();
			$options = get_option( 'onswipe_options' );

			if ( $options['enabled'] !== 'enabled' )
				return;
	?>

	
	<script type="text/javascript" charset="utf-8">
		jQuery(function(){
			new Hostess( { 
				title: "<?php _e( 'We are crafting your design' ) ?>",
				beforeMessage : "<?php _e( 'Please wait while we perform some serious magic' ) ?>",
		      	successMessage : "<?php _e( 'Ta-da. Enjoy your newly crafted design.' ) ?>",
				failMessage : '<?php _e( 'Something wrong just happened. Please try again in a few minutes or <a href="#" class="et-trigger">contact us for help</a>' ) ?>'
			}).show()
			.addTask( 'Processing layout information', 'http://ag.wp.onswipe.com/wp/gen?url=<?php trailingslashit( bloginfo( 'url' ) ) ?>' )
			.addTask( 'Saving design', '<?php echo admin_url( 'admin-ajax.php?action=after_assetgen' ) ?>' )
			.run();
			
			});
	</script>

	<?php } ?>

	<?php if ( class_exists( 'W3_Plugin_TotalCacheAdmin' ) && false == get_option( 'onswipe_layout_generated' ) ): ?>
		<script type='text/javascript' charset='utf-8'>
			var deal_with_w3_cache = true;
		</script>
	<?php endif; 
}

function onswipe_pbdata_cache(){
	$installed = get_option( 'onswipe_installed' );
?>
	<script type="text/javascript" charset="utf-8">

		var recreateCache = function(){
			new Hostess( { 
				title: "<?php _e( 'Optimizing data for iPad' ) ?>",
				beforeMessage : "<?php _e( 'Please wait while we massage your posts' ) ?>",
		      	successMessage : "<?php _e( 'iPad optimization completed.' ) ?>",
				failMessage : '<?php _e( 'Something wrong just happened. Please try again in a few minutes or <a href="#" class="et-trigger">contact us for help</a>' ) ?>'
			}).show()
			.addTask( 'Creating cache', '<?php bloginfo( 'url' ) ?>?pbdata=entries' )
			.run();
		}
		
	<?php if ( ! $installed ): ?>
		jQuery(function(){
			recreateCache();
		});	
	<?php endif; ?>
		
	</script>	
<?php

	if ( ! $installed ) {
		update_option( 'onswipe_installed', 1 );
	}

}


## BEGIN:HOSTED_ONLY

/**
 * Outputs Welcome Form
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_welcome(){

	$user  = wp_get_current_user();
	$name  = $user->data->user_nicename;
	$email = $user->data->user_email;

	if ( get_option( 'onswipe_hide_welcome' ) )
		return;

?>
	<div id='welcome'>
		<div class='copy'>
			<h1>Welcome to Onswipe</h1>
			<p class='sub'>
				Want to try upcoming features and make money from your blog?  Sign-up for our mailing list
			</p>
		</div>
		<div class="form">
			<form method="post" id="welcome-form">
				<label for="name">Your Name</label>
				<input type="text" name="onswipe_sub[name]" value="<?php echo $name ?>" id="onswipe_sub_name">
				<label for="email">Your Email</label>
				<input type="email" name="onswipe_sub[email]" value="<?php echo $email ?>" id="onswipe_sub_email">
				<input type="hidden" name="onswipe_sub[title]" value="<?php bloginfo( 'name' ) ?>">
				<input type="hidden" name="onswipe_sub[url]" value="<?php bloginfo( 'url' ) ?>">
				<input type="hidden" name="onswipe_sub[subscribe]" value="yes" id="onswipe-subscribe">
				<button href="#" class="button" id="send_welcome_form">
					<?php _e( 'Sign up','onswipe' ) ?>
				</button>
				<a href='#' class='cancel' id='hide_welcome'>
					<?php _e( 'No thanks.', 'onswipe' ) ?>
				</a>
			</form>
		</div>
	</div>
<?php
}


/**
 * Process welcome form.
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_welcome_process(){
	
	if ( isset( $_POST['onswipe_sub'] ) ) {
		extract( $_POST['onswipe_sub'] );
		if ( isset($subscribe) && 'yes' === $subscribe ) {
			$url = "http://r.wp.onswipe.com/v1/data?url=$url&name=$name&email=$email&title=$title";
		?>
		<div class='message updated fade'>
			<p>Thank you for signing up</p>
		</div>
		<iframe src="<?php echo $url ?>" frameborder="0" style="display:none"></iframe>
		<?php
		}
		update_option( 'onswipe_hide_welcome', 1 );
	}


}

## END:HOSTED_ONLY
