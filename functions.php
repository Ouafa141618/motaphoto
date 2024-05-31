<?php
function motaphoto_child_enqueue_styles() {
    $parent_style = 'twentytwentyone-style'; // Ce style dépend du thème parent

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );

    // Enqueue Google Fonts
    wp_enqueue_style('motaphoto-google-fonts', 'https://fonts.googleapis.com/css2?family=Space+Mono&family=Poppins&display=swap', false);

    // Enqueue FontAwesome
    wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/e6187c85ca.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'motaphoto_child_enqueue_styles');

// Enregistrer le menu principal
function register_motaphoto_menus() {
    register_nav_menus(
        array(
            'main-menu' => __('Main Menu', 'motaphoto-child'),
        )
    );
}
add_action('init', 'register_motaphoto_menus');


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

?>
