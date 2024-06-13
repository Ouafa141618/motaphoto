<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e6187c85ca.js" crossorigin="anonymous"></script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header>
        <div class="container-header">
            <a href="<?php echo home_url('/'); ?>" aria-label="Page d'accueil de Nathalie Mota">
                <img src="<?php echo get_template_directory_uri(); ?>/images/Logo.png" alt="Logo <?php echo bloginfo('name'); ?>">
            </a>

            <nav role="navigation" aria-label="<?php _e('Menu principal', 'text-domain'); ?>" id="nav" class="active open">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'container' => false, // On retire le conteneur généré par WP
                ]);
                ?>
            </nav>
        </div>
        <?php include_once 'template-parts/contact.php'; ?>
    </header>

    <?php wp_footer(); ?>
</body>
</html>
