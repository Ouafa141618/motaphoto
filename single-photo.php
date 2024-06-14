<?php
get_header();
?>

<section class="detail-photo">
    <div class="post-content">
        <div class="post-description">
            <h2 class="title"><?php the_title(); ?></h2>
            <div class="description">
                <p>REFERENCE: <?php echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
                <p>CATEGORIE: <?php echo get_the_term_list(get_the_ID(), 'categories-photos', '', ', '); ?></p>
                <p>TYPE: <?php echo get_post_meta(get_the_ID(), 'type', true); ?></p>
                <p>FORMAT: <?php echo get_the_term_list(get_the_ID(), 'formats', '', ', '); ?></p>
                <p>ANNEE: <?php echo get_the_date(); ?></p>
            </div>
        </div>
        <div class="post-image">
            <?php if (has_post_thumbnail()) : ?>
                <figure class="photo1 brightness">
                    <?php the_post_thumbnail(); ?>
                    <div>
                        <a href="#" class="openLightbox gallery-fullscreen" 
                           aria-label="Afficher en plein écran" 
                           data-src="<?php the_post_thumbnail_url(); ?>" 
                           data-reference="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>">
                        </a>
                    </div>
                </figure>
            <?php endif; ?>
        </div>
    </div>
    <div class="photo__contact">
        <p>Cette photo vous intéresse-t-elle?</p>
        <button class="btn" type="button" id="contact_btn" data-reference="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">Contact</button>
        <div class="photo_choix">
            <div class="photo_avant">
                <?php
                $prev_post = get_previous_post();
                if (!empty($prev_post)) {
                    $prev_image = get_the_post_thumbnail_url($prev_post->ID);
                    previous_post_link(
                        '<span class="left"><img src="' . esc_url($prev_image) . '" alt="' . esc_attr($prev_post->post_title) . '" width="75" height="75"/> <a href="' . esc_url(get_permalink($prev_post)) . '" rel="prev"><img src="' . esc_url(get_stylesheet_directory_uri()) . '/assets/images/fleche-gauche.png"></a></span>',
                        '%title',
                        false
                    );
                }
                ?>
            </div>
            <div class="photo_apres">
                <?php
                $next_post = get_next_post();
                if (!empty($next_post)) {
                    $next_image = get_the_post_thumbnail_url($next_post->ID);
                    next_post_link(
                        '<span class="right"><img src="' . esc_url($next_image) . '" alt="' . esc_attr($next_post->post_title) . '" width="75" height="75"/> <a href="' . esc_url(get_permalink($next_post)) . '" rel="next"><img src="' . esc_url(get_stylesheet_directory_uri()) . '/assets/images/fleche-droite.png"></a></span>',
                        '%title',
                        false
                    );
                }
                ?>
            </div>
        </div>
    </div>
</section>
<section class="detail-photo">
    <div class="affichage2photos">
        <h3>VOUS AIMEREZ AUSSI</h3>
        <?php
        $categories = get_the_terms(get_the_ID(), 'categories-photos');
        if ($categories && !is_wp_error($categories)) {
            $category = array_shift($categories);
            $args = array(
                'post_type' => 'photos',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categories-photos',
                        'field'    => 'term_id',
                        'terms'    => $category->term_id,
                    ),
                ),
            );

            $related_photos = new WP_Query($args);

            if ($related_photos->have_posts()) {
                echo '<div class="gallery-related">';
                while ($related_photos->have_posts()) : $related_photos->the_post();
                    get_template_part('template-parts/photo-block');
                endwhile;
                echo '</div>';
                wp_reset_postdata();
            }
        }
        ?>
    </div>
    <div class="btn-all-photos">
        <button id="all-photos" type="button">
            <a href="<?php echo home_url('/'); ?>" aria-label="Page d'accueil de Nathalie Mota">Toutes les photos</a>
        </button>
    </div>
</section>

<?php get_footer(); ?>
