<?php
// =================================================================================================================
//                                              Template for modal
// =================================================================================================================
?>

<section class="popup-overlay hiddenPopup">
	<div class="popup-contact">
		<header class="popup-title">
			<img class="popup-img" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/contact-header.svg'?>" alt="Page contact">
		</header>
		<div class="popup-informations">			
            <div id="contact-form-container">
                <?php echo do_shortcode('[contact-form-7 id="ecb6116" title="Contact"]'); ?>
            </div>		
	</div>
</section>