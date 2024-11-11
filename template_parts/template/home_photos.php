<?php
// =================================================================================================================
//                                                    Page home 
// =================================================================================================================

// ----->  Donne une image aléatoire au hero header  <-----

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

// ----->  Fonction pour gérer les photos de la page d'accueil  <-----

function photoDisplay_event() {

    $home_photo_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'order' => 'DESC',
        'orderby' => 'date',
    ));

    $photos_html = ''; // Variable pour stocker le code HTML des images
    $displayed_images = []; // Tableau pour stocker les URLs des images déjà affichées
    $item_post_url = ""; // Variable pour stocker les URLs des posts 

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

                // Vérifie si l'image a déjà été affichée
                if ($home_image_url && !in_array($home_image_url, $displayed_images)) {
                    // Ajoute l'URL de l'image au tableau des images affichées
                    $displayed_images[] = $home_image_url;

                    // Crée le code HTML pour chaque image
                    $photos_html .= '<div class="homePhoto-item">';
                    $photos_html .= '<a href=" ' . get_permalink(get_the_ID()) . '" target="">'; // Récupère l'URL du post
                    $photos_html .= '<img src="' . esc_url($home_image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                    $photos_html .= '</a>';
                    $photos_html .= '</div>';
                }
            }
        }
        wp_reset_postdata(); // On réinitialise les données
    }

    return $photos_html; // Retourne le code HTML des images
}

?>