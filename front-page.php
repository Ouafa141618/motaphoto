​<?php get_header(); ?>

<!--Home-->
<main class="home-page">

    <section class="hero-content-banner">
        <!-- CHARGEMENT DU HERO BANNER -->
        <?php get_template_part('banner'); ?>
        <!-- CHARGEMENT DES FILTRES -->
        <?php get_template_part('template-parts/filtre'); ?>


        <div id="primary" class="content-area">
            <section class="contain-photos">
                <?php
                // 1. On définit le tableau d'argument pour définir ce que l'on souhaite récupérer -->
                $args = array(
                    'post_type' => 'photos', // On récupère les publications de type"photos"
                    'posts_per_page' => 8, // On en affiche 8 par page
                    'paged' => 1, //On commence par la première page 
                );

                $photos_query = new WP_Query($args);
                ?>

                <?php if ($photos_query->have_posts()) : ?>
                    <div class="gallery">
                        <?php while ($photos_query->have_posts()) : $photos_query->the_post(); ?>
                            <?php get_template_part('template-parts/photo-block'); ?>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>

            </section>
            <div class="load-more">
                <button id="load-more">Charger plus</button>
            </div>
</main>

<?php get_footer(); ?>