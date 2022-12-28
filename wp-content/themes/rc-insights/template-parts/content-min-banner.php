<?php

// Customize the banner for each page
function pageMinBanner($title = null, $subtitle = null, $photo = null) {

    $args = [
        'title'=>$title,
        'subtitle'=>$subtitle,
        'photo'=>$photo
    ];
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }

    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']) {
        if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['page-banner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }

    ?>
    <div class="page-banner-min">
        <div class="page-banner-min__bg-image" style="background-image: url(<?php echo $args['photo'] ?>);"></div>
        <div class="page-banner-min__content container container--narrow">
            <h1 class="page-banner-min__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner-min__intro">
                <p><?php echo $args['subtitle'] ?></p>
            </div>
        </div>
    </div>
    <?php
}
pageMinBanner();