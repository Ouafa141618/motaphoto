​<?php

// Ajoute la prise en charge des images mises en avant
add_theme_support('post-thumbnails');

// Ajoute automatiquement le titre du site dans l'en-tête du site
add_theme_support('title-tag');

// Ajout du menu dans le thème WordPress
function register_my_menus()
{
    register_nav_menu('main-menu', __('Menu principal', 'text-domain'));
    register_nav_menu('footer-menu', __('Menu du pied de page', 'text-domain'));
}
add_action('after_setup_theme', 'register_my_menus');

function montheme_mota_widgets_init()
{
    register_sidebar(
        array(
            'name'          => "Widget footer",
            'id'            => 'footer-widget',
            'description'   => 'Widgets pour le pied de page',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'montheme_mota_widgets_init');


// Déclare les scripts JavaScript
function theme_enqueue_scripts()
{
    wp_enqueue_script('custom-script-1', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
    wp_enqueue_script('custom-script-2', get_stylesheet_directory_uri() . '/js/filtre.js', array('jquery'), '1.0', true);
    wp_enqueue_script('custom-script-3', get_stylesheet_directory_uri() . '/js/lightbox.js', array('jquery'), '1.0', true);

    // Localisation des scripts pour les requêtes AJAX
    wp_localize_script('custom-script-2', 'frontendajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('filter_photos_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Déclare le fichier style.css
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Traitement des requêtes Ajax pour les filtres
function filter_photos()
{
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
        'posts_per_page' => 10, // Vous pouvez ajuster cela si nécessaire
        'order' => 'DESC', // Ou 'ASC'
        // Ajoutez ici d'autres arguments selon vos besoins
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

    if (!empty($date) && $format != 'default-format') {
        $args['tax_query'][] = array(
            'taxonomy' => 'date',
            'field' => 'slug',
            'terms' => $date,
        );
    }


    // Ajouter la logique de tri par date si nécessaire
    if (!empty($tri) && in_array($tri, array('2019', '2020', '2021', '2022'))) {
        $args['date_query'] = array(
            array(
                'year'  => $tri,
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
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos')

    // Enqueue Google Fonts
    wp_enqueue_style('motaphoto-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Mono&family=Poppins&display=swap', false);

    // Enqueue FontAwesome
    wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/e6187c85ca.js', array(), null, true);

add_action('wp_enqueue_scripts', 'motaphoto_child_enqueue_styles');

