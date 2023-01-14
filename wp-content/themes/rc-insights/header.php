<!doctype html>
<html lang="en">
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CRW9GN5P5G"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-CRW9GN5P5G');
    </script>
    <?php wp_head() ?>
</head>
<body <?php body_class(); ?>>
    <div class="page">
        <a href="#content" class="skip-link screen-reader-text">
            <?php esc_html_e('Skip to content', 'rc-insights'); ?>
        </a>
        <header class="site-header">
            <div class="container">
                <h1 class="school-logo-text float-left">
                    <a href="<?php echo site_url() ?>"><strong>Roberto</strong> Cannella</a>
                </h1>
                <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
                <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
                <div class="site-header__menu group">
                    <nav class="main-navigation">

                    <?php
                    // This implementation for dynamic menu through customizer
                    wp_nav_menu([
                        'theme_location'=>'main-menu'
                    ]); ?>

<!--                        <ul>-->
<!--                            <li><a href="--><?php //echo site_url('about')?><!--">About Me</a></li>-->
<!--                            <li><a href="#">Projects</a></li>-->
<!--                            <li><a href="#">Events</a></li>-->
<!--                            <li><a href="#">Campuses</a></li>-->
<!--                            <li><a href="#">Blog</a></li>-->
<!--                        </ul>-->

                    </nav>
                    <div class="site-header__util">
                        <?php
                        if (is_user_logged_in()){?>
                            <a href="<?php echo esc_url(site_url('/my-notes')); ?>" class="btn btn--small btn--orange float-left push-right">My Notes</a>

                            <a href="<?php echo wp_logout_url() ?>" class="btn btn--small btn--dark-orange float-left btn--with-photo">
                         <span class="site-header__avatar">
                             <?php echo get_avatar(get_current_user_id(),60) ?>
                         </span>
                                <span class="btn__text">Log Out</span>
                            </a>
                        <?php }else { ?>
                            <a href="<?php echo wp_login_url() ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                            <a href="<?php echo wp_registration_url() ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>

                        <?php } ?>
                        <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </header>
<!--        <header id="masthead" class="site-header" role="banner">-->
<!---->
<!--            <div class="site-branding">-->
<!--                <p class="site-title">-->
<!--                    <a href="--><?php //echo esc_url(home_url('/')) ?><!--">-->
<!--                        --><?php //bloginfo('name'); ?>
<!--                    </a>-->
<!--                </p>-->
<!--                <p class="site-description">-->
<!--                        --><?php //bloginfo('description'); ?>
<!--                </p>-->
<!--            </div>-->
<!--            <nav class="main-navigation" id="site-navigation" role="navigation">-->
<!---->
<!--                --><?php
//                $args = [
//                    'theme-location' => 'main-menu'
//                ];
//                wp_nav_menu($args)
//                ?>
<!--            </nav>-->
<!--        </header>-->
        <div class="site-content" id="content">


