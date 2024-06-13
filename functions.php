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
            'rewrite' => array('slug' => 'photo'), // Utilisez 'photo' comme slug
            'supports' => array('title', 'editor', 'thumbnail'),
            'taxonomies' => array('categories-photos', 'formats'),
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

// Fonction Ajax pour charger plus de photos
function load_more_photos() {
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

    $photos_query = new WP_Query($args);

    if ($photos_query->have_posts()) :
        while ($photos_query->have_posts()) : $photos_query->the_post();
            get_template_part('template-parts/photo-block');
        endwhile;
        wp_reset_postdata();
    else:
        wp_send_json(false);
    endif;

    wp_die();
}
add_action('wp_ajax_load_more', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more', 'load_more_photos');

// Fonction Ajax pour filtrer les photos
function filter_photos() {
    $category = $_POST['category'];
    $format = $_POST['format'];
    $sort = $_POST['sort'];

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => 1,
        'tax_query' => array(
            'relation' => 'AND',
        ),
        'orderby' => 'date',
        'order' => $sort === 'date_asc' ? 'ASC' : 'DESC',
    );

    if ($category !== 'default-category') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categories-photos',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format !== 'default-format') {
        $args['tax_query'][] = array(
            'taxonomy' => 'formats',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    $photos_query = new WP_Query($args);

    if ($photos_query->have_posts()) :
        while ($photos_query->have_posts()) : $photos_query->the_post();
            get_template_part('template-parts/photo-block');
        endwhile;
        wp_reset_postdata();
    else:
        wp_send_json(false);
    endif;

    wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
