<?php

/*
*  Plugin Name: D3.js Support
*  Version: 0.0.1
*  Author: Roberto Cannella
*  Author URI: https://www.robertocannella.com
*/



function rc_d3_js_script_loader(){
    //wp_enqueue_style('rc-insights-main-css',get_stylesheet_directory_uri() . '/style.css', null,time(),'all');
    wp_enqueue_script('rc-insights-d3-js',"//cdnjs.cloudflare.com/ajax/libs/d3/7.6.1/d3.js",null,1.0, true);
//    wp_enqueue_script('rc-fu-google-map-js', '//maps.googleapis.com/maps/api/js?key=' . GOOGLE_API_KEY ,null,1.0, true);
//    wp_enqueue_script('rc-insights-main-js', get_theme_file_uri('/build/index.js'),null,1.0, true);
//    wp_enqueue_style('google-custom-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
//    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
//    wp_enqueue_style('rc-insights-main-styles', get_theme_file_uri('/build/style-index.css') ,[],time(),'all');
//    wp_enqueue_style('rc-insights-additional-styles', get_theme_file_uri('/build/index.css') ,[] , time(), 'all');
//
//    wp_localize_script('rc-insights-main-js','globalSiteData', [
//        'siteUrl' => get_site_url(),
//        'nonceX' => wp_create_nonce('wp_rest')
//    ]);

}

add_action('wp_enqueue_scripts', 'rc_d3_js_script_loader');