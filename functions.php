<?php 

// Enregistrement des styles CSS du thème avec filemtime pour contrôler le cache
function natmota_enqueue_styles() {
    wp_enqueue_style('natmota-theme-style', get_template_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_template_directory() . '/assets/css/theme.css'));
}

// Enregistrement des fichiers JS avec filemtime et chargement en pied de page
function natmota_enqueue_scripts() {
    wp_enqueue_script('natmota-script', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/scripts.js'), true);
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