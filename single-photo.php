<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Nathalie_Mota
 * @since Nathalie Mota 1.0
 */

get_header(); ?>

<?php include('template_parts/infos_photos.php'); ?>

<main class="single-container">

<?php 
// Vérifie s'il y a des posts/pages à afficher
if ( have_posts() ) :
    // Boucle à travers les pages et affiche leur contenu
    while ( have_posts() ) : the_post(); 
?>

<?php if ( 'photo' === get_post_type() ): ?>

    <article class="preview-photo">

        <section class="photoOnTop">
            <div class="single-content">            
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="reference">Référence : <?php the_field( 'reference' ); ?></div>                   
                <div class="catégorie">Catégorie : <?php echo implode(', ', $cat_names);?></div>     
                <div class="format">Format : <?php echo implode(', ', $format_names);?></div>
                <div class="post-type">Type : <?php echo esc_html( get_field('type') ); ?></div>
                <div class="publication-year">Année : <?php echo get_the_date('Y'); ?></div>
            </div>        

            <div class="preview__picture">
                <img 
                    src="<?php echo esc_url( $image_url ); ?>" 
                    alt="<?php echo esc_attr( $photographie['alt'] ); ?>"
                >
            </div>
        </section>

        <section class="contactSlider">
            <div class="btnPhotoInteress">
                <div class="btnText">
                    <p>Cette photo vous intéresse ?</p>
                    <button class="contactPhoto">Contact</button>
                </div>
            </div>      

            <div class="sliderContainer">
                <div class="changeImg noImg"> 
                    <img class="previousImg hiddenNow" src="<?php echo esc_url($previousThumbnailUrl); ?>" alt="Image précédente">
                    <img class="nextImg hiddenNow" src="<?php echo esc_url($nextThumbnailUrl); ?>" alt="Image suivante">
                </div> 
                <div class="arrows">
                    <a class="arrow-left" href="<?php echo $previousPostUrl; ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_left.svg" alt="flèche gauche">
                    </a>
                    <a class="arrow-right" href="<?php echo $nextPostUrl; ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right.svg" alt="flèche droite">
                    </a>                 
                </div>
            </div>
        </section>

    </article>

    
    
    <article class="likeToo">
        <h3>Vous aimerez aussi</h3>

 <?php if ($current_cat_id): ?>

        <article class="containerLikeToo">
              <?php 
            // Boucle pour afficher les photos de la même catégorie
            if ($related_photos->have_posts()) :
                while ($related_photos->have_posts()) : $related_photos->the_post(); 
                    $related_photo = get_field('photographie');
                    $related_photo_reference = get_field('reference'); // Référence de la photo liée
                    $related_large_url = $related_photo['sizes']['large'] ?? '';

                    // Si l'URL de la photo est vide ou si la référence est identique à la photo principale, ignorer cette photo
                    if (empty($related_large_url) || $related_photo_reference === $reference) {
                        continue;
                    }
            ?>      
            <section class="photoLikeToo">
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo esc_url($related_large_url); ?>" alt="<?php echo esc_attr($related_photo['alt']); ?>">
                </a>
            </section>
            <?php 
                endwhile;
                wp_reset_postdata(); // Réinitialiser les données de post
            endif;
            ?>
        </article>
<?php endif; ?>          
        
    </article>

<?php endif; ?>
    

<?php
    endwhile;
endif;
?>

</main>
<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
?>