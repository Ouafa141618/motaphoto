<?php
get_header();

/* Start the Loop */
while (have_posts()) : the_post();
    get_template_part('template-parts/content/content-single');

    if (is_attachment()) {
        the_post_navigation(array(
            'prev_text' => sprintf(__('<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone'), '%title'),
        ));
    }

    if (comments_open() || get_comments_number()) {
        comments_template();
    }

    the_post_navigation(array(
        'next_text' => '<p class="meta-nav">' . __('Next post', 'twentytwentyone') . '</p><p class="post-title">%title</p>',
        'prev_text' => '<p class="meta-nav">' . __('Previous post', 'twentytwentyone') . '</p><p class="post-title">%title</p>',
    ));
endwhile;

get_footer();
?>
