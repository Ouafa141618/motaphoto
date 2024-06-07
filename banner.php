<?php
/**
 * HERO DU HEADER
 *
 * @package WordPress
 * @subpackage Montheme-mota
 */
?>

<?php
$args = array(
    'post_type' => 'photos',
    'posts_per_page' => 1, // 1 seul élément à récupérer
    'orderby' => 'rand', // Aléatoirement
);

// Création de l'objet WP_Query
$loop = new WP_Query($args);

// Démarrage de la boucle
if ($loop->have_posts()) :
    while ($loop->have_posts()) : $loop->the_post();
        $background_image = get_the_post_thumbnail_url();
    endwhile;
endif;

// Réinitialisation des données post
wp_reset_postdata();
?>

<div class="photoHero" style="background-image: url('<?php echo esc_url($background_image); ?>');">
    <div class="hero-thumbnail">
        <img class="Titre_header" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/Titre-header.png" alt="logo">
    </div>
</div>
