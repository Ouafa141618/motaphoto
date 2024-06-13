<!-- GALERIE PHOTOS -->
<figure class="photo1 brightness" data-photo-id="<?php the_ID(); ?>">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail(); ?>
    <?php endif; ?>
    <div>
        <h2 class="info-title"><?php the_title(); ?></h2>
        <h3 class="info-tax gallery-category"><?php echo get_the_term_list(get_the_ID(), 'categories-photos', '', ', '); ?></h3>
        <a href="<?php the_permalink(); ?>" aria-label="Voir le détail de la photo" class="detail photos"></a>
        <!-- Affichage de la lightbox -->
        <a href="#" class="openLightbox gallery-fullscreen" 
            aria-label="Afficher en plein écran" 
            data-src="<?php the_post_thumbnail_url(); ?>" 
            data-reference="<?php the_field('reference'); ?>"
            data-page="accueil">
        </a>
    </div>
</figure>
