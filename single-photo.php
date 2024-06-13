<?php
get_header();
?>

<section class="photo details">
    <div class="post-content">
        <!-- Colonne gauche/Description -->
        <div class="post-description">
            <h2 class="title">
                <?php the_title(); ?>
            </h2>
            <div class="description">
                <p>REFERENCE: <?php echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
                <p>CATEGORIE: <?php echo get_the_terms(get_the_ID(), 'categories-photos', false); ?></p>
                <p>TYPE: <?php echo get_post_meta(get_the_ID(), 'type', true); ?></p>
                <p>FORMAT: <?php echo get_the_terms(get_the_ID(), 'formats', false); ?></p>
                <p>ANNEE: <?php echo get_the_date(); ?></p>
            </div>
        </div>
        <!-- Colonne droite/Photos -->
        <div class="post-image">
            <?php if (has_post_thumbnail()) : ?>
                <figure class="photo1 brightness">
                    <?php the_post_thumbnail(); ?>
                </figure>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
