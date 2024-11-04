<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nathalie Mota</title>
    <?php wp_head(); ?>
</head>
    
<header>

  <nav class="navBar">
    <div class="logoSite">
      <a href="<?php echo home_url( '/' ); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-mota.svg" alt="logo">
      </a>
    </div>

    <div class="navDesktop">
      <?php
      // menu main déclaré dans functions.php
			wp_nav_menu(array('theme_location' => 'main')); 
		  ?>
    </div>

    <div class="burgerMenu">
      <img class="burgerIcon" src="<?php echo get_template_directory_uri(); ?>/assets/images/burgerIcone.svg" alt="icone burger menu">
      <img class="crossIcon hiddenNow" src="<?php echo get_template_directory_uri(); ?>/assets/images/crossIcone.svg" alt="Icone croix">
    </div>
  </nav>

  <div class="burger-menu">
    <?php
			wp_nav_menu(array('theme_location' => 'main')); 
		  ?>
  </div>

</header>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>