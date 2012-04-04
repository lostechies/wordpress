<?php
global $Options;

$set = $current_panel['name']."_opts";
$catslist = array('0'=>'-- none', '-1'=>'-- All Categories') + $this->categoryList();

/*
	Fonts list
*/
$fonts = file(dirname(__FILE__)."/fonts.txt");
foreach ($fonts as $key => $font) {
	$font = str_replace("\n","",$font);

	if ($key > 0) {
		$fonts[$font] = $font;
		unset($fonts[$key]);
	}else{
		$fonts[$key] = $font;		
	}
}

$colors = array(
    'default' => "#0ae",
    'green' => '#96cc4f',
    'orange' => '#f7930b',
    'pink' => '#de2384',
    'gray' => '#9da1a2',
    'cream' => '#cec8b2',
    'tan' => '#c69c62',
    'darkblue' => '#2b3d62',
    'red' => '#900',
);

$current_skin = $Options->get($current_panel['name'],'color_skin');



// if ('reset' == $_GET['reset']) {
// 	$Options->reset();
// }

?>


<div class="wrap">

	<form method="post" action="options.php" enctype="multipart/form-data">

		<?php settings_fields($current_panel['name']); ?>

		<?php $options = get_option($set); ?>
		
		<div class="padpress_enabler">

	        <div class="copy">
				<?php _e( '<strong>Onswipe</strong> displays a beautiful app-like experience to visitors browsing with an iPad.' ); ?>
	        </div>

				<?php 
				 ?>
				<input type="hidden" name="padpressed_general[enable]" value="disable">
				<label>	
					<input type="checkbox" id="enabler_checkbox" name="padpressed_general[enable]" value="enable" <?php echo ($is_disabled)?"":"checked='checked'" ?>>
					<?php _e('Display a special theme for iPad users') ?>
				</label>

		</div>
		

		<table class="form-table">

			<?php echo $form->input( 'show_cover', array( 'label' => __( 'Cover Display', 'padpressed' ),'type' => 'select', 'options' => array( __( 'No cover', 'padpressed' ), __( 'Show an image from a recent post', 'padpressed' ) ) ) ); ?>
			
			<tr valign="top">
				<th scope="row">
					<?php _e('Cover Logo','padpressed') ?>	
					<p class="hint">
						<?php _e( 'For best results use a 200&#215;200px transparent png', 'padpressed' ); ?>
					</p>
				</th>
				<td>
					<?php $image = $Options->get($current_panel['name'],'cover_logo');?>							
					<?php $imgclass = (!empty($image)) ? "image-widget":"image-widget image-widget-show-control";?>
					<div class="<?php echo $imgclass ?>">

						<?php if (!empty($image)): ?>
							<div class="image">
								<img src="<?php echo $image ?>" alt="No Image" class="image-preview" />
								<a href="#" class="image-switch button">
									<span class="change">
										<?php _e('change image','padpressed'); ?>
									</span>
									<span class="cancel">
										<?php _e('cancel','padpressed'); ?>
									</span>
								</a>
								<a href="#" class="delete"><?php _e('remove image','padpressed') ?></a>
							</div>
						<?php endif ?>
						

						<?php $form->input('cover_logo',array('row'=>false,'type'=>'file','label'=>0)); ?>
						<br class="clear" />								
					</div>												
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php _e('Launch Screen Image','padpressed'); ?>

					<p class="hint">
						<?php _e( 'Use an image exactly 768&#215;1004px', 'padpressed' ); ?>
					</p>
					
				</th>
				<td>
					<?php $image = $Options->get($current_panel['name'],'launch_screen');?>							
					<?php $imgclass = (!empty($image))?"image-widget":"image-widget image-widget-show-control";?>
					<div class="<?php echo $imgclass ?>">

						<?php if (!empty($image)): ?>
							<div class="image">
								<img src="<?php echo $image ?>" alt="No Image" class="image-preview" />
								<a href="#" class="image-switch button">
									<span class="change">
										<?php _e('change image','padpressed'); ?>
									</span>
									<span class="cancel">
										<?php _e('cancel','padpressed'); ?>
									</span>
								</a>
								<a href="#" class="delete"><?php _e('remove image','padpressed') ?></a>
							</div>
						<?php endif ?>

						<?php $form->input('launch_screen',array('row'=>false,'type'=>'file','label'=>0)); ?>

						<br class="clear" />								
					</div>												
				</td>
			</tr>

			
			<tr valign="top">
				<th scope="row">
					<?php _e('Display Font','padpressed') ?>							
				</th>
				<td id="display-font-select">
						<?php echo $form->input('display_font',array('label'=>false,'type'=>'select','options'=>$fonts, 'row'=>false)) ?>
        				<div id="display-font-sample">
        					<p class="hint"><?php _e('Sample Text','padpressed') ?></p>														
        					<span style="color:<?php echo $colors[$current_skin] ?>;"><?php _e('The quick brown fox jumps over the lazy dog','padpressed') ?></span>
        				</div>
						
				</td>
			</tr>					

			<tr valign="top">
				<th scope="row">
					<?php _e('Skin Color','padpressed') ?>
				</th>
				<td id="skin-color-select">
					
					<?php echo $form->input('color_skin',array('label'=>false,'type'=>'hidden','row'=>false)) ?>
					<?php foreach ($colors as $name => $color): ?>
                       <div class="swatch <?php echo ($current_skin == $name) ? "current":"" ?>" data-name="<?php echo $name ?>">
                            <span style="background-color:<?php echo $color ?>">&nbsp;</span>
                       </div>
					<?php endforeach ?>
				</td>
			</tr>


			
		</table>				
					
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'padpressed' ); ?>" />
		</p>											
		

	</form>
</div>