<?php
/* Template Name: Photos */
get_header();
?>

<div class="filters-container">
    <?php get_template_part('filters'); ?>
</div>

<div class="photos-list">
    <?php
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
    );
    $photos_query = new WP_Query($args);

    if ($photos_query->have_posts()) :
        while ($photos_query->have_posts()) : $photos_query->the_post();
            get_template_part('template-parts/photo-block');
        endwhile;
        wp_reset_postdata();
    else:
        echo 'Aucune photo trouvée.';
    endif;
    ?>
</div>
<button id="load-more">Charger plus</button>

<?php get_footer(); ?>
