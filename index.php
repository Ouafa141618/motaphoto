<?php get_header(); ?>

<main>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <header>
                <h1><?php the_title(); ?></h1>
            </header>
            <?php the_content(); ?>
        </article>
    <?php endwhile; else : ?>
        <article>
            <h2>No posts found</h2>
        </article>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
