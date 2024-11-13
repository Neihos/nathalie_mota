<?php 

// Inclure le fichier des fonctions API REST
include get_template_directory() . '/include/functions_api_rest.php';

// Enregistrement des styles CSS du thème avec filemtime pour contrôler le cache
function natmota_enqueue_styles() {
    wp_enqueue_style('natmota-theme-style', get_template_directory_uri() . '/css/theme.css', array(), filemtime(get_template_directory() . '/css/theme.css'));
    wp_enqueue_style(
        'select2-css', // Un identifiant unique pour ce style
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', // Lien vers le CSS de Select2
        array(), // Pas de dépendance pour le CSS
        '4.1.0-rc.0' // Version du style
    );
}

// Enregistrement des fichiers JS avec filemtime et chargement en pied de page
function natmota_enqueue_scripts() {
    // Liste des fichiers JS à charger
    $scripts = [
        'natmota-script-main' => 'scripts.js',
        'natmota-script-menu' => 'menu.js',
        'natmota-script-modale' => 'modale.js',
        'natmota-script-home' => 'home.js',
        'natmota-script-single-photo' => 'single-photo.js',
        'natmota-script-lightbox' => 'lightbox.js',
    ];

    foreach ($scripts as $handle => $file) {
        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . './js/' . $file,
            array('jquery'), // Dépendances
            filemtime(get_template_directory() . './js/' . $file), // Gestion du cache
            true // Chargement en pied de page
        );
    }

    // Ajout de Select2 séparément avec sa dépendance jQuery
    wp_enqueue_script(
        'select2-js', // Un identifiant unique pour ce script
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', // Lien vers la bibliothèque Select2
        array('jquery'), // Dépendance à jQuery
        '4.1.0-rc.0', // Version du script
        true // Chargement en pied de page
    );

    // Localisation de l'URL AJAX et de l'URL REST après l'enregistrement des scripts
    wp_localize_script('natmota-script-main', 'natmota_js', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'rest_url' => esc_url(rest_url('wp/v2/')), // Ajout de l'URL de l'API REST de photo
        'nonce'    => wp_create_nonce('natmota-script-main'),
        // Ajout des URLs des icônes
        'eye_icon' => get_template_directory_uri() . '/assets/images/eye.svg',
        'square_icon' => get_template_directory_uri() . '/assets/images/square.svg'
    ));
}

// Enregistrement des emplacements de menus du thème
function natmota_register_menus() {
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}

// Actions pour charger les styles, scripts et menus
add_action('wp_enqueue_scripts', 'natmota_enqueue_styles');
add_action('wp_enqueue_scripts', 'natmota_enqueue_scripts');
add_action('after_setup_theme', 'natmota_register_menus');

?>
