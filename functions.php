<?php

// Ajoute la prise en charge des images mises en avant
add_theme_support('post-thumbnails');

// Ajoute automatiquement le titre du site dans l'en-tête du site
add_theme_support('title-tag');

// Ajout du menu dans le thème WordPress
function register_my_menus() {
    register_nav_menus(array(
        'main-menu' => __('Menu principal', 'text-domain'),
        'footer-menu' => __('Menu du pied de page', 'text-domain'),
    ));
}
add_action('after_setup_theme', 'register_my_menus');

// Enregistre les widgets du footer
function montheme_mota_widgets_init() {
    register_sidebar(array(
        'name'          => "Widget footer",
        'id'            => 'footer-widget',
        'description'   => 'Widgets pour le pied de page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'montheme_mota_widgets_init');

// Enqueue les scripts et styles
function theme_enqueue_scripts_and_styles() {
    // Enqueue style parent
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Enqueue custom script
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);

    // Enqueue Google Fonts et FontAwesome
    wp_enqueue_style('motaphoto-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Mono&family=Poppins&display=swap', false);
    wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/e6187c85ca.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts_and_styles');

// Crée le type de contenu personnalisé 'photos'
function create_photo_post_type() {
    register_post_type('photos',
        array(
            'labels' => array(
                'name' => __('Photos'),
                'singular_name' => __('Photo')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'photos'),
            'taxonomies' => array('category'),
        )
    );
}
add_action('init', 'create_photo_post_type');

// Crée les taxonomies 'categories-photos' et 'formats'
function create_photo_taxonomies() {
    register_taxonomy(
        'categories-photos',
        'photos',
        array(
            'label' => __('Catégories Photos'),
            'rewrite' => array('slug' => 'categories-photos'),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'formats',
        'photos',
        array(
            'label' => __('Formats'),
            'rewrite' => array('slug' => 'formats'),
            'hierarchical' => true,
        )
    );
}
add_action('init', 'create_photo_taxonomies');

// Enqueue les scripts pour la modale
function my_enqueue_modal_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-modal-script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_enqueue_modal_scripts');
