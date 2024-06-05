<?php
get_header();
?>

<section class="photo_detail">
    <!-- Section 1 -->
    <div class="post-content">
        <!-- Colonne gauche/Description -->
        <div class="post-description">
            <h2 class="title"><?php the_title(); ?></h2>
            <div class="description">
                <p>REFERENCE: <?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?></p>
                <p>CATEGORIE: 
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'categories-photos');
                    if ($categories && !is_wp_error($categories)) {
                        $category_names = wp_list_pluck($categories, 'name');
                        echo esc_html(implode(', ', $category_names));
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </p>
                <p>TYPE: <?php echo esc_html(get_post_meta(get_the_ID(), 'type', true)); ?></p>
                <p>FORMAT: 
                    <?php
                    $formats = get_the_terms(get_the_ID(), 'formats');
                    if ($formats && !is_wp_error($formats)) {
                        $format_names = wp_list_pluck($formats, 'name');
                        echo esc_html(implode(', ', $format_names));
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </p>
                <p>ANNEE: <?php echo get_the_date('Y'); ?></p>
            </div>
        </div>

        <!-- Colonne droite/Photos -->
        <div class="post-image">
            <?php if (has_post_thumbnail()) : ?>
                <figure class="photo1 brightness">
                    <?php the_post_thumbnail(); ?>
                    <div>
                        <a href="#" class="openLightbox gallery-fullscreen" aria-label="Afficher en plein écran" 
                           data-src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" 
                           data-reference="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">
                        </a>
                    </div>
                </figure>
            <?php endif; ?>
        </div>
    </div>

    <!-- SECTION DU MILIEU -->
    <div class="photo__contact">
        <p>Cette photo vous intéresse-t-elle?</p>
        <button class="btn" type="button" id="contact_btn" data-reference="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">Contact</button>

        <!-- PHOTOS APPARENTES -->
        <div class="photo_choix">
            <div class="photo_avant">
                <?php
                $prev_post = get_previous_post();
                if (!empty($prev_post)) {
                    $prev_image = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail');
                    echo '<span class="left">';
                    echo '<img src="' . esc_url($prev_image) . '" alt="' . esc_attr($prev_post->post_title) . '" width="75" height="75"/>';
                    previous_post_link('%link', '<img src="' . get_template_directory_uri() . '/images/fleche-gauche.png">', false);
                    echo '</span>';
                }
                ?>
            </div>
            <div class="photo_apres">
                <?php
                $next_post = get_next_post();
                if (!empty($next_post)) {
                    $next_image = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
                    echo '<span class="right">';
                    echo '<img src="' . esc_url($next_image) . '" alt="' . esc_attr($next_post->post_title) . '" width="75" height="75"/>';
                    next_post_link('%link', '<img src="' . get_template_directory_uri() . '/images/fleche-droite.png">', false);
                    echo '</span>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- AFFICHAGE DE DEUX PHOTOS DE LA MEME CATEGORIE -->
<section class="photo_detail">
    <div class="affichage2photos">
        <h3>VOUS AIMEREZ AUSSI</h3>
        <?php
        $categories = get_the_terms(get_the_ID(), 'categories-photos');
        if ($categories && !is_wp_error($categories)) {
            $category = array_shift($categories);
            $args = array(
                'post_type' => 'photos',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()), // Exclure la photo actuelle
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
            <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Page d'accueil de Nathalie Mota">Toutes les photos</a>
        </button>
    </div>
</section>

<?php get_footer(); ?>
