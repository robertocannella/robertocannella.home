<?php

// Customize the banner for each page
function pageBanner($title = null, $subtitle = null, $photo = null) {

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
            $args['photo'] = get_theme_file_uri('/images/venti-views-1900x800-bos1.jpg');
        }
    }

    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle'] ?></p>
            </div>
        </div>
    </div>
    <?php
}

function rc_insight_features(){
    register_nav_menu('main-menu', esc_html__('Main Menu', 'rc-insights'));
    register_nav_menu('left-footer-menu', esc_html__('Footer Menu Left', 'rc-insights'));
    register_nav_menu('right-footer-menu', esc_html__('Footer Menu Right', 'rc-insights'));


    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats' , ['aside','gallery','video','link','image','quote','status','audio','chat']);
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('starter-content');

    // WP creates the following additional image sizes
    add_image_size('contributor-landscape', 400, 260,true);
    add_image_size('contributor-portrait', 480, 650,true);
    add_image_size('page-banner', 1500, 350,true);
}
add_action('after_setup_theme', 'rc_insight_features');

function rc_insights_style_loader(){
    //wp_enqueue_style('rc-insights-main-css',get_stylesheet_directory_uri() . '/style.css', null,time(),'all');
   // wp_enqueue_script('rc-fu-google-map-js', '//maps.googleapis.com/maps/api/js?key=' . GOOGLE_API_KEY ,null,1.0, true);
    wp_enqueue_script('rc-insights-main-js', get_theme_file_uri('/build/index.js'),null,1.0, true);
    wp_enqueue_style('google-custom-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('rc-insights-main-styles', get_theme_file_uri('/build/style-index.css') ,[],time(),'all');
    wp_enqueue_style('rc-insights-additional-styles', get_theme_file_uri('/build/index.css') ,[] , time(), 'all');

//    wp_localize_script('rc-fu-main-js','globalSiteData', [
//        'siteUrl' => get_site_url(),
//        'nonceX' => wp_create_nonce('wp_rest')
//    ]);

}

add_action('wp_enqueue_scripts', 'rc_insights_style_loader');

function rc_insights_widgets_init(){
    // Widget for the sidebar
    register_sidebar([
        'name'          => esc_html__('Main Sidebar', 'rc-insights'),
        'id'            => 'main-sidebar',
        'description'   => esc_html__('Add widgets for main sidebar here', 'rc-insights'),
        'before_widget' => '<section id="%1$s" class="widget widget-wrapper %2$s" >',
        'after_widget' => '</section>',
        'before-title'  => '<h2 class="widget-title">',
        'after-title'   => '</h2>'
    ]);
    // Widget area for the splash
    register_sidebar([
        'name'          => esc_html__('Splash Widget', 'rc-insights'),
        'id'            => 'splash-widget',
        'description'   => esc_html__('Add widgets for Splash Header here', 'rc-insights'),
        'before_widget' => '<section id="%1$s" class="widget widget-wrapper %2$s" >',
        'after_widget' => '</section>',
        'before-title'  => '<h2 class="widget-title">',
        'after-title'   => '</h2>'
    ]);

    // Widget for the footer

}
add_action('widgets_init','rc_insights_widgets_init');

/**
 * Manipulates the Query Object For the Events post type sorting
 *
 * @param $query
 * @return void
 */
function rc_insights_adjust_queries($query){
    // Get all campuses (regardless of size)
    if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()){
        $query->set('posts_per_page', -1);
    }
    if (!is_admin() && is_post_type_archive('subject') && $query->is_main_query()){
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }


    $today = date('Ymd');
    // Checks:
    // Is NOT on admin site
    // Is the Event archive post type
    // Is NOT a custom query
    if (!is_admin() &&
        is_post_type_archive('event') &&
        $query->is_main_query()){
        $query->set('meta_key','event_date');
        $query->set('orderby','meta_value_num');
        $query->set('order','ASC');
        $query->set('meta_query', [
                [
                    'key'=>'event_date',
                    'compare'=>'>=',
                    'value'=>$today,
                    'type'=>'DATE'
                ]
            ]
        );
    }
}
add_action('pre_get_posts','rc_insights_adjust_queries');

// Nav Menu Highlight links
function rc_insights_nav_highlights($items, $args){

    if (get_post_type() == 'event' || is_page('past-events')) {
        $items =  str_replace("menu-item-116", "current-menu-item menu-item-116",$items);
       // <li id="menu-item-116" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-116"><a href="https://www.robertocannella.com/events/" aria-current="page">Events</a></li>
    }

    return $items;
}

add_filter( 'wp_nav_menu_items', 'rc_insights_nav_highlights', 10 ,2);



//$debug_tags = array();
//add_action( 'all', function ( $tag ) {
//    global $debug_tags;
//    if ( in_array( $tag, $debug_tags ) ) {
//        return;
//    }
//    echo "<pre>" . $tag . "</pre>";
//    $debug_tags[] = $tag;
//} );