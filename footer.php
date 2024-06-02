<footer class="footer">
    <?php get_template_part('template-parts/contact'); ?>
    <?php get_template_part('template-parts/lightbox'); ?>

    <nav class="footer-nav">
        <?php
        wp_nav_menu([
            'theme_location' => 'footer-menu', // Assurez-vous que l'identifiant correspond
            'container' => false, // On retire le conteneur généré par WP
        ]);
        ?>
    </nav>

    <aside id="widget-area">
        <?php dynamic_sidebar('footer-widget'); ?>
    </aside>
    
    <div class="footer-text">
        <p>TOUS DROITS RÉSERVÉS</p>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
