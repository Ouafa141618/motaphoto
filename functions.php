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

// Enqueue les scripts JavaScript
function theme_enqueue_scripts() {
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);

    // Localisation des scripts pour les requêtes AJAX
    wp_localize_script('custom-script', 'frontendajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('filter_photos_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Enqueue le fichier style.css
function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Enqueue Google Fonts et FontAwesome
function enqueue_custom_styles_and_scripts() {
    wp_enqueue_style('motaphoto-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Mono&family=Poppins&display=swap', false);
    wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/e6187c85ca.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles_and_scripts');

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

// Traitement des requêtes Ajax pour les filtres
function filter_photos() {
    // Vérifiez le nonce pour la sécurité
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'filter_photos_nonce')) {
        wp_die('La sécurité de la requête n\'a pas pu être vérifiée.');
    }

    // Récupération des valeurs
    $category = $_POST['categories_photos'];
    $format = $_POST['formats'];
    $tri = $_POST['tri'];
    $page = $_POST['page'];

    // Configuration de la requête
    $args = array(
        'post_type' => 'photos',
        'paged' => $page,
        'posts_per_page' => 10,
        'order' => 'DESC',
    );

    // Ajoutez les termes de la taxonomie 'categories-photos' si nécessaire
    if (!empty($category) && $category != 'default-category') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categories-photos',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    // Ajoutez les termes de la taxonomie 'formats' si nécessaire
    if (!empty($format) && $format != 'default-format') {
        $args['tax_query'][] = array(
            'taxonomy' => 'formats',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    // Ajouter la logique de tri par date si nécessaire
    if (!empty($tri) && in_array($tri, array('2019', '2020', '2021', '2022'))) {
        $args['date_query'] = array(
            array(
                'year' => $tri,
            ),
        );
    }

    // La requête WP_Query
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo-block');
        }
    } else {
        echo 'Aucune photo trouvée.';
    }

    wp_reset_postdata(); // Toujours réinitialiser après une requête personnalisée
    wp_die(); // Cela arrête l'exécution de PHP et retourne la réponse
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

// Load more photos
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
        echo 0;
    endif;

    wp_die(); // Cela arrête l'exécution de PHP et retourne la réponse
}
add_action('wp_ajax_load_more', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more', 'load_more_photos');

// Enqueue les scripts pour la modale
function my_enqueue_modal_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-modal-script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
    wp_localize_script('custom-modal-script', 'modalData', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'my_enqueue_modal_scripts');

?>
