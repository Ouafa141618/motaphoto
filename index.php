<?php


get_header();

?>

<section class="photo_detail">
    <!-------------------------------- Section 1 ----------------------------------------->
    <div class="post-content">
        <!-------------------------------- Colonne gauche/Description ----------------------------------------->
        <div class="post-description">

            <h2 class="title">
                <?php the_title(); ?>
            </h2>

            <div class="description">
                <p>
                    REFERENCE: <?php echo get_post_meta(get_the_ID(), 'reference', true); ?>
                    <!-- ACF  -->
                </p>
                <p>

                    CATEGORIE: <?php echo the_terms(get_the_ID(), 'categories-photos', false); ?>
                    <!-- CPT UI -->
                </p>
                <p>
                    TYPE: <?php echo get_post_meta(get_the_ID(), 'type', true); ?>
                </p>
                <p>

                    FORMAT: <?php echo the_terms(get_the_ID(), 'formats', false); ?>
                </p>

                <p>

                    ANNEE: <?php echo get_the_date(); ?>
                </p>
            </div>
        </div>

        <!-------------------------------- Colonne droite/Photos ----------------------------------------->
    
        <div class="post-image ">
            <?php if (has_post_thumbnail()) : ?>
                <figure class="photo1 brightness">
                    <?php the_post_thumbnail(); ?>
                    <div>
                        <a href="#" class="openLightbox gallery-fullscreen" 
                        aria-label="Afficher en plein écran" 
                        data-src="<?php the_post_thumbnail_url(); ?>" 
                        data-reference="<?php the_field('reference'); ?>">
                        </a>
                    </div>
                </figure>
            <?php endif; ?>
        </div>
    </div>

    <!-------------------- SECTION DU MILIEU ------------------->
    <div class="photo__contact">
        <p>Cette photo vous intéresse-t-elle?</p>
        <button class="btn" type="button" id="single_contact_btn" data-reference="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">Contact</button>



        <!-------------------- PHOTOS APPARENTES ------------------->

        <div class="photo_choix">
    <div class="photo_avant">
        <?php
        $prev_post = get_previous_post();
        if (!empty($prev_post)) {
            $prev_image = get_the_post_thumbnail_url($prev_post->ID);
            echo '<span class="left"><a href="' . get_permalink($prev_post) . '" rel="prev"><img src="' . get_stylesheet_directory_uri() . '/images/fleche-gauche.png" class="nav-arrow" data-image="' . $prev_image . '" data-title="' . esc_attr($prev_post->post_title) . '"></a></span>';
        }
        ?>
        <div class="prev-thumbnail" style="display: none;">
            <img src="" alt="" width="75" height="75"/>
        </div>
    </div>
    <div class="photo_apres">
        <?php
        $next_post = get_next_post();
        if (!empty($next_post)) {
            $next_image = get_the_post_thumbnail_url($next_post->ID);
            echo '<span class="right"><a href="' . get_permalink($next_post) . '" rel="next"><img src="' . get_stylesheet_directory_uri() . '/images/fleche-droite.png" class="nav-arrow" data-image="' . $next_image . '" data-title="' . esc_attr($next_post->post_title) . '"></a></span>';
        }
        ?>
        <div class="next-thumbnail" style="display: none;">
            <img src="" alt="" width="75" height="75"/>
           </div>
          </div>
     </div>

    </div>

</section>

<!-- AFFICHAGE DE DEUX PHOTOS DE LA MEME CATEGORIES -->
<section class="photo_detail">
    <div class="affichage2photos">
        <h3>VOUS AIMEREZ AUSSI</h3>
        <?php
        // Récupérez les catégories de la photo courante
        $categories = get_the_terms(get_the_ID(), 'categories-photos');
        if ($categories && !is_wp_error($categories)) {
            // Prenez juste le premier terme
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
            <a href="http://localhost/mota/" aria-label="Page d'accueil de Nathalie Mota">Toutes les photos</a>
        </button>
    </div>
</section>

<?php get_footer(); ?>

</div>
<?php get_footer(); ?>

