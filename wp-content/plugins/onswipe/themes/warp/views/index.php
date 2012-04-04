<?php 
global $t,$Options; 
$singleOrPage = (is_single() || is_page());
?>

<?php 
	
	if (!$singleOrPage) {

        if ($Options->get('padpress_warp','show_cover') && is_home()){
            $this->partial('cover');
        }
        ?>
            <section id="entry"></section>            
        <?php

	}else{
	    $this->partial('single');        
	}
?>