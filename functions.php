<?php 

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
        'natmota-script-info_photo' => 'info_photo.js',
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