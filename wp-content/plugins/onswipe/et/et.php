<?php

if ( ! function_exists( 'get_plugins' ) ) require_once ( ABSPATH.'wp-admin/includes/plugin.php' );

class ET{

	private $info = array();

	public static function instance(){

		static $instance = null;
		if ( $instance == null ) {
			$instance = new ET();
		}

		return $instance;

	}

	private function __construct(){

		$this->get_info();

	}

	private function get_info(){

		global $Onswipe;

		$this->info = array(
			'version'     => $Onswipe->version,
			'name'        => get_bloginfo( 'name' ),
			'url'         => get_bloginfo( 'url' ),
			'OS'          => php_uname(),
			'php_version' => phpversion(),
			'wp_version'  => get_bloginfo( 'version' ),
		);

		$gdinfo = false;
		if ( function_exists( 'gd_info' ) ) {
			$gdinfo = gd_info();
			$gdinfo = $gdinfo['GD Version'];
		}

		$this->info['gd_version'] = $gdinfo;

		$this->get_plugins();
		$this->get_muplugins();
		$this->get_theme();
		$this->get_permissions();

	}

	private function get_plugins(){

		$active_plugins = array();
		$active_plugins_keys = (array) get_option( 'active_plugins', array() );

		$all_plugins = get_plugins();
		foreach ( $active_plugins_keys as $key ) {
			$active_plugins[] = array(
				'name'     => $all_plugins[$key]['Name'],
				'version'  => $all_plugins[$key]['Version'],
				'url'      => $all_plugins[$key]['PluginURI'],
				'path'     => $key,
			);
		}

		$this->info['plugins'] = $active_plugins;

	}

	private function get_muplugins(){
		$muplugins = (array) get_mu_plugins();

		foreach ( $muplugins as $path => $plugin ) {
			$this->info['plugins'][] = array(
				'name'      => $plugin['Name'],
				'version'   => $plugin['Version'],
				'url'       => $plugin['PluginURI'],
				'path'      => $path,
				'mu-plugin' => true,
			);
		}

	}

	private function get_theme(){
		$theme_name = get_current_theme();
		$theme = get_theme( $theme_name );

		$this->info['theme'] = array(
			'name'           => $theme['Name'],
			'version'        => $theme['Version'],
			'author'         => $theme['Author URI'],
			'template_dir'   => $theme['Template Dir'],
			'stylesheet_dir' => $theme['Stylesheet Dir'],
			'parent'         => $theme['Parent Theme'],
		);

	}

	private function get_permissions(){

		$this->info['cache'] = array(
			'dir'     => PBDATA_CACHE_DIR,
			'access'  => is_writable( PBDATA_CACHE_DIR ),
		);

	}

	public static function phone_home( $mail, $action = null ){

		$instance = self::instance();

		$subject = "Feedback from : {$instance->info['name']} [{$instance->info['url']}]";

		if ( isset( $_POST['ET'] ) ) {
			
			$headers = "From: {$instance->info['name']} <{$_POST['ET']['email']}> \r\n" .
			    "Reply-To: {$_POST['ET']['email']} \r\n" .
			    'X-Mailer: ET';
			
			$body = $_POST['ET']['body'];

			if ( isset( $_POST['ET']['email'] ) ) {
				$body = "From: {$_POST['ET']['email']}\n\n***\n\n" . $body;
			}

			if ( isset( $_POST['ET']['info'] ) ) {
				$body .= '\n\n***\n\nSYSTEM DETAILS\n\n' . print_r( $instance->info, true );
			}

			wp_mail( $mail, $subject, $body, $headers );
			

        ?>
		<div class='message updated fade'>
			<p>Thank you for sending your feedback. We'll reply to your request shortly.</p>
        </div>
        <?php
		}

?>
    <style type="text/css">
    #et-call-home {
        -moz-border-radius-topleft: 3px;
        -moz-border-radius-topright: 3px;
        -moz-border-radius-bottomright: 0px;
        -moz-border-radius-bottomleft: 0px;
        -webkit-border-radius: 3px 3px 0px 0px;
        border-radius: 3px 3px 0px 0px;
    }
    </style>

	<div id="et-call-home" style="background:#000; background:rgba(0,0,0,.85); border:1px solid #666; color:#ccc; position:fixed;bottom:0;right:10px;z-index:1000">
		<div id="et-handle" style="padding:10px;">
			<a href="#" id="et-trigger" class="et-trigger" style="color:#ffffff; text-decoration:none;">
				Send Feedback <span style="color: #bbbbbb;">or</span> Report a Bug
			</a>
			<a href="#" id="et-close" class="et-trigger" style="color:#fff; text-decoration:none;position:absolute;right:0;top:0;padding:10px;display:none;">
				&#215;
			</a>
		</div>
		<div id="et-form" style="width:400px; padding:10px; display:none">
			<form method="post" accept-charset="utf-8" <?php if ( !empty( $action ) ) echo "action='{$action}'"?>>
				<label for="ET[email]">Your Email</label><br>
				<input type="email" name="ET[email]" value="" placeholder="yourname@example.com">
				<br>
				<label for="ET[body]" style="margin-top:7px">Feedback</label>
				<br>
				<textarea name="ET[body]" rows="8" cols="40" style="width:400px" placeholder="Thanks for your feedback. Please include your contact data."></textarea>
				<p>
					<label>
						<input type="checkbox" class="checkbox" value="include_info" name="ET[info]" checked="checked"/>
						Include data about your installation
					</label>
				</p>
				<input type="submit" value="Send to Onswipe" class="button">

			</form>
		</div>
	</div>

	<script type="text/javascript" charset="utf-8">
		( function( $ ){
			var $trigger = $( '.et-trigger' );
			var $form = $( '#et-form' );
			$trigger.live( 'click', function( e ){
				e.preventDefault();
				$form.toggle();
				$('#et-close').toggle();
			} );
		} )( jQuery );
	</script>

<?php

	}

}
