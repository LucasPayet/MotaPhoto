<?php


function enqueue_custom_styles() {
    wp_enqueue_style( 'motaphototheme-style', get_template_directory_uri() . '/style.css', array());
    wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js');
    wp_enqueue_script("jquery");
    wp_enqueue_script('scripts', get_template_directory_uri() . '/js/load-more.js', array('jquery'), null, true);
    wp_localize_script('scripts', 'loadmore_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX URL
        'post_type' => 'album',
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function add_defer_attribute($tag, $handle) {
    if ('scripts' === $handle) {
        $tag = str_replace(' src', ' defer="defer" src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);

//ajax loadmore
function loadmore_ajax_handler(){
    $args = array(
        'post_type' => $_POST['post_type'],
        'post_status' => 'publish',
        'paged' => $_POST['page'],
        'posts_per_page' => 8,
    );

    set_query_var('newquery', $args);
    set_query_var('uri', $theme_uri);
    get_template_part('./templates-part/post_query');

    wp_die();
}

add_action('wp_ajax_loadmore', 'loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler');

//ajax filter
function filterAlbum_ajax_handler(){
    if ($_POST['cat'] == "all" && $_POST['format'] == "all" && $_POST['year'] == 'all') {
        $args = array(
            'post_type'   => $_POST['post_type'],
            'post_status' => 'publish',
            'paged'       => -1,
            'posts_per_page' => -1,
        );
    } 
    else {
        $args = array(
        'post_type' => $_POST['post_type'],
        'post_status' => 'publish',
        'paged' => -1,
        'tax_query' => array(
            $_POST['cat'] != "all" ?
            array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $_POST['cat'],
            ):'',
            $_POST['format'] != "all" ?
            array(
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $_POST['format'],
            ):'',
        ),
        'date_query' => $_POST['year'] != 'all' ? array(
            array(
                'year' => $_POST['year'],
            ),
        ):'',
    );
    }
    

    set_query_var('newquery', $args);
    set_query_var('uri', $theme_uri);
    get_template_part('./templates-part/post_query');

    wp_die();
}

add_action('wp_ajax_filterAlbum', 'filterAlbum_ajax_handler');
add_action('wp_ajax_nopriv_filterAlbum', 'filterAlbum_ajax_handler');

//ajax lightbox navigation
function get_lightboxJson_ajax_handler(){
    $args = array( 
        'post_type' => 'album',
        'numberposts' => '1', 
    );
    $post_id = $_POST['postID'];
    global $post;
    $post = get_post($post_id);

    $oldargs = array(
        'post_type' =>'album',
        'numberposts' => -1,
        'posts_per_page' => 1,
        'order' => 'ASC' );
    
    $oldest_posts = get_posts($oldargs);
    $oldest_posts_id = $oldest_posts[0]->ID;

    $lastargs = array(
        'post_type' =>'album',
        'numberposts' => 0,
        'posts_per_page' => 1,
        'order' => 'ASC' );
    
    $lastest_posts = get_posts($lastargs);
    $lastest_posts_id = $lastest_posts[0]->ID;


    if (get_next_post()){
        $prevlink = get_next_post()->ID;
    }else{
        $prevlink = $oldest_posts_id;
    }
    if (get_previous_post()){
        $nextlink = get_previous_post()->ID;
    }else{
        $nextlink = $lastest_posts_id;
    }

    $img = get_the_post_thumbnail_url($post);
    $categories = get_the_terms( $post_id, 'categorie' );
    $ref=get_field('référence', $post_id);
    $data = array(
        'image' => $img,
        'ref' => $ref,
        'cat' => $categories[0]->name,
        'prevlink' => $prevlink,
        'nextlink' => $nextlink
    );

    wp_send_json($data);
}

add_action('wp_ajax_getlightbox', 'get_lightboxJson_ajax_handler');
add_action('wp_ajax_nopriv_getlightbox', 'get_lightboxJson_ajax_handler');

//ajax


function custom_theme_setup() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'text-domain'),
        'secondary-menu' => __('Secondary Menu', 'text-domain'),
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