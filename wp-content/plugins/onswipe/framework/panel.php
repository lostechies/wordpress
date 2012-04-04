<?php 
    global $Options;
?>
<div class="wrap">

	<h2><?php _e('Onswipe Settings','padpressed') ?></h2>
	

	<?php if ($is_disabled): ?>
		<div class="padpress_enabler">

	        <div class="copy">
				<?php _e( '<strong>Onswipe</strong> displays a beautiful app-like experience to visitors browsing with an iPad.' ); ?>
	        </div>

			<form action="<?php admin_url("admin.php?page=padpressed"); ?>" method="post" id="enabler_form">			
				<?php 
				 ?>
				<input type="hidden" name="padpressed_general[enable]" value="disable">
				<label>	
					<input type="checkbox" id="enabler_checkbox" name="padpressed_general[enable]" value="enable" <?php echo ($is_disabled)?"":"checked='checked'" ?>>
					<?php _e('Display a special theme for iPad users') ?>
				</label>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'padpressed' ); ?>" />
				</p>											
				
			</form>

		</div>		
	<?php endif ?>

	<?php 
	if (!$is_disabled)
		$Options->render('padpress_warp');
	?>
</div>
