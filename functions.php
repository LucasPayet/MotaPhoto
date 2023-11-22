<?php
function enqueue_custom_styles() {
    wp_enqueue_style( 'motaphototheme-style', get_template_directory_uri() . '/style.css', array());
    wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function add_defer_attribute($tag, $handle) {
    if ('scripts' === $handle) {
        $tag = str_replace(' src', ' defer="defer" src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);




function custom_theme_setup() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'text-domain'), // You can define multiple menu locations like this
        'secondary-menu' => __('Secondary Menu', 'text-domain'), // Example of another menu location
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

function montheme_customize_register($wp_customize)
{
    // Ajout d'une section pour le logo personnalisé
    $wp_customize->add_section('montheme_logo_section', array(
        'title'      => __('Logo', 'montheme'),
        'priority'   => 30,
    ));

    // Ajout de la fonctionnalité de logo personnalisé
    $wp_customize->add_setting('montheme_logo');

    // Ajout du contrôle pour téléverser le logo personnalisé
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'montheme_logo', array(
        'label'    => __('Téléverser votre logo', 'montheme'),
        'section'  => 'montheme_logo_section',
        'settings' => 'montheme_logo',
    )));
}
add_action('customize_register', 'montheme_customize_register');

function add_custom_menu_item( $items, $args ) {
    if ( $args->theme_location == 'primary-menu') {
        $new_items = '<li id="menu-item-100" class="contact_btn"><span>CONTACT</span></li>';
        $items = $items . $new_items;
    }
    return $items;
}

add_filter( 'wp_nav_menu_items', 'add_custom_menu_item', 10, 2 );