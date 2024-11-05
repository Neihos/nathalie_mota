<?php
/**
 * The template for home page
 *
 * This is the template that displays home by default.
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 * @since nathalie-mota 1.0
 */

get_header(); 

// Inclure le fichier avec les données photo
include('template_parts/template/infos_photos.php');
?>

<div class="main-container">
    <?php
    // Récupérer l'URL de la photo aléatoire
    $random_photo_url = get_random_photo();
    // Récupérer les photos pour faire la galerie d'images
    $home_photos_display = photoDisplay_event();
    ?>
    <section class="hero_header" style="background-image: url('<?php echo $random_photo_url; ?>');">
        <h1>Photograph Event</h1>
    </section>

    <section class="homePhotos">
        <div class="photoContainer">        
            <?php echo $home_photos_display; ?>
        </div>
    </section>
    
</div>

<?php get_footer(); ?>