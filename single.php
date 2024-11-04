<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Nathalie_Mota
 * @since Nathalie Mota 1.0
 */

get_header(); ?>

<main class="single-container">

    <?php 
    // Boucle unique pour afficher le contenu du post
    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    ?>

        <article class="single_content site-content" role="main">

            <div id="content">
                <?php
                // Charge le modèle de contenu pour l'article en cours
                get_template_part( 'content', get_post_format() );
                ?>
            </div><!-- #content -->

        </article>

        <?php
        // Navigation article précédent/suivant.
        the_post_navigation();

        // Chargement du template de commentaires si activés.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

    endwhile; endif; // Fin de la boucle
    ?>

</main>

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
?>
