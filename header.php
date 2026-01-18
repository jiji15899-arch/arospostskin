<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php if (get_theme_mod('adsense_blocker_url')): ?>
    <script>
        window.redirectTarget = "<?php echo esc_js(get_theme_mod('adsense_blocker_url', 'https://aros100.com')); ?>";
    </script>
    <script src='https://cdn.jsdelivr.net/gh/abaeksite/aros_adsense_blocker@main/aros_adsense_blocker_v7-1.js'></script>
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- 헤더 -->
<header class='header'>
    <div class='container'>
        <span class='logo'>
            <?php if (get_theme_mod('header_logo')): ?>
                <img alt='로고 이미지' class='logo' src='<?php echo esc_url(get_theme_mod('header_logo')); ?>'/>
            <?php endif; ?>
        </span>
        <h1 class='logo-text'><?php echo esc_html(get_theme_mod('site_title', get_bloginfo('name'))); ?></h1>
    </div>
</header>
