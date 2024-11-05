<?php 

// Récupérer les catégories associées
$categories = get_the_terms( get_the_ID(), 'categorie' );
$current_cat_id = !empty($categories) ? $categories[0]->term_id : null; 
    if ( !empty($categories) && !is_wp_error($categories) ) {
        $cat_names = wp_list_pluck( $categories, 'name' );
    }

// Récupérer les formats associés
$formats = get_the_terms( get_the_ID(), 'format' ); 
    if ( !empty($formats) && !is_wp_error($formats) ) {
        $format_names = wp_list_pluck( $formats, 'name' );
    }
                
// Récupérer le tableau complet de l'image depuis le champ ACF 'photographie'
$photographie = get_field( 'photographie' );

// Récupérer la référence de la photo principale dans preview__picture
$reference = get_field( 'reference');
        
   
// Priorité à la taille "full", sinon on utilise 'large', puis 'medium'
$image_url = null;
if (!empty($photographie)) {
    if (!empty($photographie['sizes'])) {
        $image_url = $photographie['sizes']['full'] ?? $photographie['sizes']['large'] ?? $photographie['sizes']['medium'] ?? $photographie['sizes']['thumbnail'];
    } else {
        $image_url = $photographie['url'] ?? null;
    }
}


// Obtenir les articles de type "photo" triés par date de publication

$photo_posts = get_posts(array(
    'post_type' => 'photo',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC'
 ));

// URLs des posts premier, précédent, suivant, final et actuelle
$first_post = $photo_posts[0] ?? null;
$previous_post = get_previous_post();
$next_post = get_next_post();
$last_post = end($photo_posts) ?: null;        
$current_photo_id = get_the_ID();

// URLs des premiers et derniers posts
$firstPostUrl = $first_post ? esc_url(get_permalink($first_post->ID)) : '#';
$lastPostUrl = $last_post ? esc_url(get_permalink($last_post->ID)) : '#';

// URLs par défaut des posts suivant et précédent
$nextPostUrl = $next_post ? esc_url(get_permalink($next_post->ID)) : $firstPostUrl;
$previousPostUrl = $previous_post ? esc_url(get_permalink($previous_post->ID)) : $lastPostUrl;

// Créations des variables pour les URLs des miniatures des posts premier, suivant, précédent et final
$previousThumbnailUrl = '';
$nextThumbnailUrl = '';
$firstThumbnailUrl = '';
$lastThumbnailUrl = '';

// Miniature du post précédent
if ($previous_post) {
    $previous_photographie = get_field('photographie', $previous_post->ID);
    $previousThumbnailUrl = $previous_photographie['sizes']['thumbnail'] ?? '';
} elseif ($last_post) {
    $last_photographie = get_field('photographie', $last_post->ID);
    $previousThumbnailUrl = $last_photographie['sizes']['thumbnail'] ?? '';
}

// Miniature du post suivant
if ($next_post) {
    $next_photographie = get_field('photographie', $next_post->ID);
    $nextThumbnailUrl = $next_photographie['sizes']['thumbnail'] ?? '';
} elseif ($first_post) {
    $first_photographie = get_field('photographie', $first_post->ID);
    $nextThumbnailUrl = $first_photographie['sizes']['thumbnail'] ?? '';
}

// afficher les photos de la même catégorie en dessous

// Requête pour afficher des photos de la même catégorie
if ($current_cat_id) {
    $related_photos = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 2,
        'orderby' => 'rand',
        'post__not_in' => array($current_photo_id),
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'term_id',
                'terms'    => $current_cat_id,
            ),
        ),
    ));
}

// Fonction pour récupérer une photographie aléatoire
function get_random_photo() {
    $random_photo_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'rand', // Trier aléatoirement
    ));
    
    if ($random_photo_query->have_posts()) {
        while ($random_photo_query->have_posts()) {
            $random_photo_query->the_post();
            $random_photographie = get_field('photographie');
            if (!empty($random_photographie)) {
                $random_image_url = $random_photographie['sizes']['full'] ?? $random_photographie['sizes']['large'] ?? $random_photographie['sizes']['medium'] ?? $random_photographie['sizes']['thumbnail'] ?? $random_photographie['url'];
                return esc_url($random_image_url); // Retourner l'URL de l'image
            }
        }
    }
    wp_reset_postdata();
}