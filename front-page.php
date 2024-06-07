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

<script>
jQuery(document).ready(function($) {
    var page = 2;
    $('#load-more').on('click', function() {
        var data = {
            'action': 'load_more',
            'page': page,
        };

        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response) {
                    $('.gallery').append(response);
                    page++;
                } else {
                    $('#load-more').text('Plus de photos');
                    $('#load-more').prop('disabled', true);
                }
            }
        });
    });
});
</script>
