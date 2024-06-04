<?php get_header(); ?>

<main class="home-page">
    <section class="hero-content-banner">
        <?php get_template_part('banner'); ?>
        <?php get_template_part('template-parts/filtre'); ?>
    </section>

    <div id="primary" class="content-area">
        <section class="contain-photos">
            <?php
            $args = array(
                'post_type' => 'photos',
                'posts_per_page' => 8,
                'paged' => 1,
            );
            $photos_query = new WP_Query($args);
            ?>

            <?php if ($photos_query->have_posts()) : ?>
                <div class="gallery">
                    <?php while ($photos_query->have_posts()) : $photos_query->the_post(); ?>
                        <?php get_template_part('template-parts/photo-block'); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        </section>
        <div class="load-more">
            <button id="load-more">Charger plus</button>
        </div>
    </div>
</main>

<?php get_footer(); ?>
