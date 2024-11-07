<?php
// Ajoute la fonction Ajax pour la pagination infinie
function load_more_photos_ajax() {
    // Vérifie la page de la requête Ajax
    $paged = (isset($_POST['page'])) ? $_POST['page'] : 2;
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';

    $home_photo_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'DESC',
    ));

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => array($format),
        );
    }

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
                    // Génère le code HTML pour chaque image
                    echo '<div class="homePhoto-item">';
                    echo '<img src="' . esc_url($home_image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                    echo '</div>';
                }
            }
        }
        wp_reset_postdata();
    } else {
        echo 0; // Indique qu'il n'y a plus de photos à charger
    }

    wp_die(); // Terminer la requête
}

add_action('wp_ajax_load_more_photos', 'load_more_photos_ajax');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos_ajax'); // Permet l'accès aux utilisateurs non connectés


?>