<?php
function load_more_photos_ajax() {
    // Vérifie la page de la requête Ajax
    $paged = (isset($_POST['page'])) ? $_POST['page'] : 2;
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => array($format),
        );
    }

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => array($category),
        );
    }

    if ($sort == '1') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ($sort == '2') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }

    // Exécute la requête
    $home_photo_query = new WP_Query($args);

    if ($home_photo_query->have_posts()) {
        while ($home_photo_query->have_posts()) {
            $home_photo_query->the_post();
            $home_photographie = get_field('photographie');
            $reference = get_field('reference'); // Récupère la référence via ACF
            $categories = get_the_terms(get_the_ID(), 'categorie'); // Récupère la catégorie
            $post_link = get_permalink(get_the_ID());; // Récupère le lien de la page

            // Convertit les catégories en une liste séparée par des virgules
            $category_names = [];
            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $cat) {
                    $category_names[] = $cat->name;
                }
            }
            $category_list = implode(', ', $category_names);

            if (!empty($home_photographie['sizes'])) {
                // Sélectionne la meilleure qualité disponible
                $home_image_url = $home_photographie['sizes']['full'] ?? 
                                  $home_photographie['sizes']['large'] ?? 
                                  $home_photographie['sizes']['medium'] ?? 
                                  $home_photographie['sizes']['thumbnail'] ?? 
                                  $home_photographie['url'];

                if ($home_image_url) {
                    // Génère le code HTML pour chaque image avec les attributs data
                    echo '<div class="homePhoto-item">';
                    echo '<img class="lightbox-target" src="' . esc_url($home_image_url) . '"
                                                       alt="' . esc_attr(get_the_title()) . '"
                                                       data-fullsize="' . esc_url($home_photographie['url']) . '"
                                                       data-category="' . esc_attr($category_list) . '"
                                                       data-reference="' . esc_attr($reference) . '"
                                                       data-link="' . esc_url($post_link) . '">';
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
