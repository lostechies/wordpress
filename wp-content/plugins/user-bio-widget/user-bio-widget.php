<?php
/*
Plugin Name: User Bio Widget
Description: Easily display the Biographical Info of your user profile in your blog's sidebar. Allows you to choose from multiple authors/users on your blog and also gives you the ability to display the author's Gravatar, with some size and alignment options. Compatible with the multi-site feature available in WordPress 3.0.
Version: 0.2
Author: Anthony Bubel
Author URI: http://anthonybubel.com/
*/

class User_Bio_Widget extends WP_Widget {

	function User_Bio_Widget() {
		$widget_ops = array('classname' => 'widget_user_bio', 'description' => "Display your User Profile's Biographical Info with the option to also display your Gravatar." );
		$this->WP_Widget('user_bio', 'User Bio', $widget_ops);
	}
	
	function widget($args, $instance) {
		extract( $args );		

		echo $before_widget;
		echo $before_title . esc_attr($instance['title']) . $after_title;
		
		global $wpdb;
		$bio = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'description' AND wp_usermeta.user_id = " . $instance['author'] . ";"));
		$email = $wpdb->get_var($wpdb->prepare("SELECT user_email FROM wp_users WHERE ID = " . $instance['author'] . ";"));
		$no_bio_msg = "One of these days I will add something to my user profile! For now, I shall remain mysterious.";
		
		if ( 'display' == $instance['gravatar'] ) {
			if ( function_exists('get_avatar') ) {
				$grav_image = get_avatar( $email, $size = $instance['grav_size'] );
			}
			if ( 'center' == $instance['grav_align'] ) {
				$output = '<div class="ub-grav" style="margin:5px 5px 0px 5px;text-align:center;">' . $grav_image . '</div>';
			} else {
				$output = '<div class="ub-grav" style="margin:5px 5px 0px 5px;float: ' . $instance['grav_align'] . ';">' . $grav_image . '</div>';
			}
			if ( 'yes' == $instance['only_gravatar'] ) {
				if ( 'left' == $instance['grav_align'] || 'right' == $instance['grav_align'] ) {
				$output = '<div class="ub-grav" style="margin:5px 5px 0px 5px;text-align: ' . $instance['grav_align'] . ';">' . $grav_image . '</div>';
				}
				else {
				$output = $output;
				}
			}
			elseif ( 'yes' != $instance['only_gravatar'] ) {
				if ( !empty($bio) ) {
					$output .= $bio;
				}
				if ( empty($bio) ) {
					$output .= $no_bio_msg;
				}
			}
		} elseif ( 'display' != $instance['gravatar'] ) {
			if ( !empty($bio) ) {
			$output = $bio;
			}
			else {
			$output = $no_bio_msg;
			}
		}
		
		echo $output;

		echo "\n" . $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['author'] = $new_instance['author'];
		$instance['gravatar'] = $new_instance['gravatar'];
		$instance['grav_size'] = $new_instance['grav_size'];
		$instance['grav_align'] = $new_instance['grav_align'];
		$instance['only_gravatar'] = $new_instance['only_gravatar'];
		
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array('title'=>'', 'author'=>'', 'gravatar'=>'', 'grav_size'=>'96', 'grav_align'=>'none') );
		
		$title = esc_attr($instance['title']);
		$author = $instance['author'];
		$gravatar = $instance['gravatar'];
		$grav_size = $instance['grav_size'];
		$grav_align = $instance['grav_align'];
		$only_gravatar = $instance['only_gravatar'];
			
			echo '<p><label for="<' . $this->get_field_id('title') . '">' . __('Title:') . '
			<input class="widefat" id="<' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
			</label></p>
			<p><label for="<' . $this->get_field_id('author') . '">' . __('Author:') . '
			<select id="<' . $this->get_field_id('author') . '" name="' . $this->get_field_name('author') . '" class="widefat">';

			global $wpdb;
			//This is the query to use if the blog ID is 1 or if the multi-site function is not enabled or available.
			$simple_authors_query = $wpdb->get_results($wpdb->prepare("SELECT distinct ID,display_name FROM wp_users,wp_usermeta WHERE wp_users.ID=wp_usermeta.user_id AND wp_usermeta.meta_key='wp_user_level' AND wp_usermeta.meta_value != 0;"));
			
			//If the multi-site function is enabled.
			if (function_exists('is_multisite') && is_multisite()) {
			
				//Get the current blog's ID.
				$this_blog = $wpdb->blogid;
				
				if (1 == $this_blog) {
					$authors = $simple_authors_query;
				}
				//If the blog's ID is not 1, we need a more customized query which uses the blog's ID in obtaining the authors to use for the drop-down.
				else {
					$authors = $wpdb->get_results($wpdb->prepare("SELECT distinct ID,display_name FROM wp_users,wp_usermeta WHERE wp_users.ID=wp_usermeta.user_id AND wp_usermeta.meta_key='wp_" . $this_blog . "_user_level' AND wp_usermeta.meta_value != 0;"));
				}
			}
			// If the multi-site function is not enabled or available, there is no need to do that extra stuff above; just run the simple query.
			else {
				$authors = $simple_authors_query;
			}
					foreach ( $authors as $author ){
						echo '<option value="'. $author->ID .'"';
						if($author->ID == $instance['author']){
							echo ' selected ';
						}
						echo '>'. $author->display_name . '</option>'."\n";
					}
			echo '</select></label></p>';
?>
			<p><label for="<?php echo $this->get_field_id('gravatar'); ?>"><?php echo __('Display this author\'s <a href="http://gravatar.com/" title="Gravatar">Gravatar</a>'); ?>
			<input id="<?php echo $this->get_field_id('gravatar'); ?>" name="<?php echo $this->get_field_name('gravatar'); ?>" type="checkbox" value="display" <?php if($gravatar == "display") echo 'CHECKED'; ?> onchange="if ( this.checked == false ) jQuery( 'p#extra-options' ).slideUp(); else jQuery( 'p#extra-options' ).slideDown();" />
			</label></p>
<?php
			echo '<style type="text/css">#extra-options {background:#eee;border:1px solid #ddd;padding:5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;}</style>';

			echo '<p id="extra-options"';
				if ( 'display' != $gravatar ) echo ' style="display: none;">';
			echo '<strong>' . __('Gravatar Settings:') . '</strong><br /><br />';
?>
			<label for="<?php echo $this->get_field_id('only_gravatar'); ?>"><?php echo __('Display only the Gravatar'); ?>
			<input id="<?php echo $this->get_field_id('only_gravatar'); ?>" name="<?php echo $this->get_field_name('only_gravatar'); ?>" type="checkbox" value="yes" <?php if($only_gravatar == "yes") echo 'CHECKED'; ?> />
			<br /><br />
<?php
			$sizes = array('64' => 'Small - 64px', '96' => 'Medium - 96px', '128' => 'Large - 128px', '256' => 'Extra Large - 256px');
			echo '<label for="' . $this->get_field_id('grav_size') . '">' .  __('Size:') . '
				<select id="' . $this->get_field_id('grav_size') . '" name="' . $this->get_field_name('grav_size') . '">';
			foreach ( $sizes as $size => $size_display ) {
				echo  '<option value="' . $size . '" ';
				if ( $size == $grav_size ) echo 'selected ';
				echo '>' . __($size_display) . '</option>' . "\n";
			}
			echo '</select></label><br /><br />';

			$alignments = array('None', 'Left', 'Center', 'Right');
			echo '<label for="' . $this->get_field_id('grav_align') . '">' .  __('Alignment:') . '
				<select id="' . $this->get_field_id('grav_align') . '" name="' . $this->get_field_name('grav_align') . '">';
			foreach ( $alignments as $alignment ) {
				echo  '<option value="' . strtolower($alignment) . '" ';
				if ( strtolower($alignment) == $grav_align ) echo 'selected ';
				echo '>' . __($alignment) . '</option>' . "\n";
			}
			echo '</select></label></p>';
	}
	
} //END User_Bio_Widget class

	function UserBioInit() {
		register_widget('User_Bio_Widget');
	}

	add_action('widgets_init', 'UserBioInit');
?>