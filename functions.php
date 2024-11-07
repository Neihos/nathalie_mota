<?php 

// Inclure le fichier des fonctions API REST
include get_template_directory() . '/include/functions_api_rest.php';

// Enregistrement des styles CSS du thème avec filemtime pour contrôler le cache
function natmota_enqueue_styles() {
    wp_enqueue_style('natmota-theme-style', get_template_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_template_directory() . '/assets/css/theme.css'));
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
    ];

    foreach ($scripts as $handle => $file) {
        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . '/assets/js/' . $file,
            array('jquery'), // Dépendances
            filemtime(get_template_directory() . '/assets/js/' . $file), // Gestion du cache
            true // Chargement en pied de page
        );
    }

    // Localisation de l'URL AJAX et de l'URL REST après l'enregistrement des scripts
    wp_localize_script('natmota-script-main', 'natmota_js', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'rest_url' => esc_url(rest_url('wp/v2/')), // Ajout de l'URL de l'API REST de photo
        'nonce'    => wp_create_nonce('natmota-script-main')
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
