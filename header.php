<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bienvenue sur le site de Nathalie Mota, photographe professionnelle spécialisée dans la photographie artistique et de portrait.
     Explorez une galerie unique où l'émotion et l'esthétique se rencontrent à travers des clichés captivants.
      Que vous soyez à la recherche de portraits, de photos de mariage, ou d'images pour des événements spéciaux, ce site vous invite à découvrir un travail photographique de haute qualité.
       Nathalie Mota, votre photographe passionnée, vous offre des souvenirs immortalisés à travers son objectif.">
    <meta name="keywords" content="photographe professionnelle, Nathalie Mota, photographie de portrait, photographie de mariage, photos artistiques, photographie événementielle, photographie de qualité, portrait,
     photographie créative, photographie numérique, photographie argentique">
    <meta name="author" content="Nathalie Mota">
    <meta name="title" content="Nathalie Mota - Photographe Professionnelle | Portraits, Mariages et Événements">
    <meta name="robots" content="index, follow">
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