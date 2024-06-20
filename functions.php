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

    // Localiser le script avec les variables PHP nécessaires
    wp_localize_script('custom-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
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
            'rewrite' => array('slug' => 'photos', 'with_front' => false), // Assurez-vous que le slug est 'photos'
        )
    );
}
add_action('init', 'create_photo_post_type');
// Ajouter une règle de réécriture personnalisée pour inclure la référence dans les permaliens
function add_custom_rewrite_rules() {
    add_rewrite_rule(
        'photos/([^/]+)/?$',
        'index.php?post_type=photos&reference=$matches[1]',
        'top'
    );
}
add_action('init', 'add_custom_rewrite_rules');

// Ajouter un paramètre de requête pour gérer la référence
function add_custom_query_var($vars) {
    $vars[] = 'reference';
    return $vars;
}
add_filter('query_vars', 'add_custom_query_var');

// Modifier la requête principale pour rechercher par référence
function modify_main_query($query) {
    if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'photos' && $query->get('reference')) {
        $query->set('meta_query', array(
            array(
                'key' => 'reference',
                'value' => $query->get('reference'),
                'compare' => '='
            )
        ));
    }
}
add_action('pre_get_posts', 'modify_main_query');

// Générer les permaliens en utilisant la référence
function custom_photo_permalink($permalink, $post) {
    if ($post->post_type === 'photos') {
        $reference = get_post_meta($post->ID, 'reference', true);
        if ($reference) {
            $permalink = home_url('photos/' . $reference . '/');
        }
    }
    return $permalink;
}
add_filter('post_type_link', 'custom_photo_permalink', 10, 2);

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

// Handler AJAX pour filtrer les photos
function filter_photos() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : '';

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
    );

    if ($category && $category != 'default-category') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categories-photos',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if ($format && $format != 'default-format') {
        $args['tax_query'][] = array(
            'taxonomy' => 'formats',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    if ($sort == 'date_desc') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ($sort == 'date_asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }

    $photos_query = new WP_Query($args);

    if ($photos_query->have_posts()) :
        while ($photos_query->have_posts()) : $photos_query->the_post();
            get_template_part('template-parts/photo-block');
        endwhile;
    else :
        echo '<p>No photos found</p>';
    endif;

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

// Handler AJAX pour charger plus de photos
function load_more_photos() {
    $paged = isset($_POST['page']) ? sanitize_text_field($_POST['page']) : 1;
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
    else :
        echo '';
    endif;

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_load_more', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more', 'load_more_photos');
?>
