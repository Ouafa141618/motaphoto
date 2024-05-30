<?php
function motaphoto_child_enqueue_styles() {
    $parent_style = 'twentytwentyone-style'; // Ce style dépend du thème parent

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}

add_action('wp_enqueue_scripts', 'motaphoto_child_enqueue_styles');

?>
