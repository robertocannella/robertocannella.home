<!doctype html>
<html lang="en">
<head >
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page">

    <a href="#content" class="skip-link screen-reader-text">
        <?php esc_html_e( 'Skip to content', 'wphierarchy' ); ?>
    </a>

    <header id="masthead" class="site-header" role="banner">

        <div class="notice">

            <p>
            <?php get_sidebar('splash') ?>
            </p>
        </div>

        <div class="site-branding">
            <p class="site-title">
                <?php bloginfo( 'name' ); ?>
            </p>
            <p class="site-description" >
                <?php bloginfo( 'description' ); ?>
            </p>
        </div>

    </header>

    <div id="content" class="site-content">