<section class="photoCard">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye.svg" alt="eye">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/square.svg" alt="carré">
    <span><?php echo get_the_terms(get_the_ID(), 'categorie') ?></span>
    <span><?php echo get_field('reference') ?></span>
</section>