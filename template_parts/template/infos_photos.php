<?php 

// Récupérer les catégories associées
$categories = get_the_terms(get_the_ID(), 'categorie');
$current_cat_id = (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->term_id : null; 
$cat_names = $current_cat_id ? wp_list_pluck($categories, 'name') : [];

// Récupérer les formats associés
$formats = get_the_terms(get_the_ID(), 'format');
$format_names = (!empty($formats) && !is_wp_error($formats)) ? wp_list_pluck($formats, 'name') : [];

// Récupérer le champ personnalisé 'photographie' avec les vérifications
$photographie = get_field('photographie');
$image_url = null;

if (!empty($photographie)) {
    $sizes = $photographie['sizes'];
    $image_url = $sizes['full'] ?? $sizes['large'] ?? $sizes['medium'] ?? $sizes['thumbnail'] ?? $photographie['url'];
}

// Récupérer la référence de la photo principale
$reference = get_field('reference');

// Obtenir les articles de type "photo" triés par date de publication
$photo_posts = get_posts(array(
    'post_type' => 'photo',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC'
));

$first_post = $photo_posts[0] ?? null;
$previous_post = get_previous_post();
$next_post = get_next_post();
$last_post = end($photo_posts) ?: null;        
$current_photo_id = get_the_ID();

$firstPostUrl = $first_post ? esc_url(get_permalink($first_post->ID)) : '#';
$lastPostUrl = $last_post ? esc_url(get_permalink($last_post->ID)) : '#';
$nextPostUrl = $next_post ? esc_url(get_permalink($next_post->ID)) : $firstPostUrl;
$previousPostUrl = $previous_post ? esc_url(get_permalink($previous_post->ID)) : $lastPostUrl;

// Récupérer les URLs de miniatures pour les posts premier, suivant, précédent et final
$previousThumbnailUrl = $nextThumbnailUrl = $firstThumbnailUrl = $lastThumbnailUrl = '';

if ($previous_post) {
    $previous_photographie = get_field('photographie', $previous_post->ID);
    $previousThumbnailUrl = !empty($previous_photographie['sizes']['thumbnail']) ? $previous_photographie['sizes']['thumbnail'] : '';
} elseif ($last_post) {
    $last_photographie = get_field('photographie', $last_post->ID);
    $previousThumbnailUrl = !empty($last_photographie['sizes']['thumbnail']) ? $last_photographie['sizes']['thumbnail'] : '';
}

if ($next_post) {
    $next_photographie = get_field('photographie', $next_post->ID);
    $nextThumbnailUrl = !empty($next_photographie['sizes']['thumbnail']) ? $next_photographie['sizes']['thumbnail'] : '';
} elseif ($first_post) {
    $first_photographie = get_field('photographie', $first_post->ID);
    $nextThumbnailUrl = !empty($first_photographie['sizes']['thumbnail']) ? $first_photographie['sizes']['thumbnail'] : '';
}

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
        'orderby' => 'rand',
    ));
    
    if ($random_photo_query->have_posts()) {
        while ($random_photo_query->have_posts()) {
            $random_photo_query->the_post();
            $random_photographie = get_field('photographie');
            if (!empty($random_photographie['sizes'])) {
                $random_image_url = $random_photographie['sizes']['full'] ?? $random_photographie['sizes']['large'] ?? $random_photographie['sizes']['medium'] ?? $random_photographie['sizes']['thumbnail'] ?? $random_photographie['url'];
                wp_reset_postdata();
                return esc_url($random_image_url);
            }
        }
    }
    wp_reset_postdata();
    return null;
}

// Fonction pour gérer les photo de la page d'accueil
 function photoDisplay_event() {
    $home_photo_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'ASC',
    ));

    $photos_html = ''; // Variable pour stocker le code HTML des images

    if ($home_photo_query->have_posts()) {
        while ($home_photo_query->have_posts()) {
            $home_photo_query->the_post();
            $home_photographie = get_field('photographie');

            if (!empty($home_photographie['sizes'])) {
                // Sélectionne la meilleure qualité disponible
                $home_image_url = $home_photographie['sizes']['full'] ?? 
                                  $home_photographie['sizes']['large'] ?? 
                                  $home_photographie['sizes']['medium'] ?? 
                                  $home_photographie['sizes']['thumbnail'] ?? 
                                  $home_photographie['url'];

                if ($home_image_url) {
                    // Crée le code HTML pour chaque image
                    $photos_html .= '<div class="homePhoto-item">';
                    $photos_html .= '<img src="' . esc_url($home_image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                    $photos_html .= '</div>';
                }
            }
        }
        wp_reset_postdata(); // Appelé une fois seulement, après la boucle
    }

    return $photos_html; // Retourne le code HTML des images
}

?>