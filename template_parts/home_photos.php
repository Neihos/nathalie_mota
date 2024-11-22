<?php
// =================================================================================================================
//                                                    Parts for home page
// =================================================================================================================

// ----->  Donne une image aléatoire au hero header  <-----

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
                $random_image_url = $random_photographie['sizes']['full'] ?? 
                                    $random_photographie['sizes']['large'] ?? 
                                    $random_photographie['sizes']['medium'] ?? 
                                    $random_photographie['sizes']['thumbnail'] ?? 
                                    $random_photographie['url'];
                return esc_url($random_image_url); // Retourner l'URL de l'image
            }
        }
    }
    wp_reset_postdata();
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

    if ($home_photo_query->have_posts()) {
        while ($home_photo_query->have_posts()) {
            $home_photo_query->the_post();
            $home_photographie = get_field('photographie');
            $reference = get_field('reference'); // Récupère la référence via ACF
            $categories = get_the_terms(get_the_ID(), 'categorie'); // Récupère la catégorie
            $post_link = get_permalink(get_the_ID()); // Récupère le lien vers la page du post associé à l'image


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

                // Vérifie si l'image a déjà été affichée
                if ($home_image_url && !in_array($home_image_url, $displayed_images)) {
                    // Ajoute l'URL de l'image au tableau des images affichées
                    $displayed_images[] = $home_image_url;

                    // Crée le code HTML pour chaque image avec les attributs data
                    $photos_html .= '<section class="homePhoto-item">';
                    $photos_html .= '<img class="lightbox-target"  src="' . esc_url($home_image_url) . '"
                                                                   alt="' . esc_attr(get_the_title()) . '" 
                                                                   data-fullsize="' . esc_url($home_photographie['url']) . '" 
                                                                   data-category="' . esc_attr($category_list) . '" 
                                                                   data-reference="' . esc_attr($reference) . '" 
                                                                   data-link="' . esc_url($post_link) . '">';
                    $photos_html .= '</section>';
                }
            }
        }
        wp_reset_postdata(); // On réinitialise les données
    }

    return $photos_html; // Retourne le code HTML des images
}

?>