<?php
function motaphoto_child_enqueue_styles() {
    $parent_style = 'twentytwentyone-style'; // Ceci est le handle du style parent

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'motaphoto_child_enqueue_styles');
?>
<?php
function motaphoto_enqueue_scripts() {
    wp_enqueue_script('motaphoto-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_scripts');
