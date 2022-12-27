<?php
/**
 * Must-use plugins for RC Insights.
 * Making changes to this file may require Updating Permalinks
 *  - Got to admin dashboard -> settings -> permalinks -> save changes
 *
 * @package 'rc-insights'
 */


function rc_insights_post_types(){
    // Event Post Type
    register_post_type('event',[
        'show_in_rest'=>true,
        'capability_type' => 'event',   // Add this to prevent default access to this post type
        'map_meta_cap' => true,         // needed with capability type
        'supports'=> [
            'title',
            'editor',
            'excerpt'
        ],
        'rewrite'=>[
            'slug'=> 'events'
        ],
        'public'=>true,
        'labels'=>[
            'name'=>'Events',
            'singular_name'=>'Event',
            'add_new_item'=> 'Add New Event',
            'edit_item'=> 'Edit Event',
            'all_items'=> 'All Events'
        ],
        'menu_icon'=>'dashicons-calendar',
        'has_archive'=> true
    ]);
    // Program Post Type
    register_post_type('subject',[
        'show_in_rest'=>true,
        'supports'=> [
            'title',
            'editor'
        ],
        'rewrite'=>[
            'slug'=> 'subjects'
        ],
        'public'=>true,
        'labels'=>[
            'name'=>'Subjects',
            'singular_name'=>'Subject',
            'add_new_item'=> 'Add New Subject',
            'edit_item'=> 'Edit Subject',
            'all_items'=> 'All Subject'
        ],
        'menu_icon'=>'dashicons-awards',
        'has_archive'=> true
    ]);
    //  Contributor Type
    register_post_type('contributor',[
        'show_in_rest' => true,
        'taxonomies' => ['category'],
        'rewrite'=>[
            'slug'=> 'contributors'
        ],
        'supports'=> [
            'title',
            'editor',
            'thumbnail'
        ],
        'public'=>true,
        'labels'=>[
            'name'=>'Contributors',
            'singular_name'=>'Contributor',
            'add_new_item'=> 'Add New Contributor',
            'edit_item'=> 'Edit Contributor',
            'all_items'=> 'All Contributors'
        ],
        'menu_icon'=>'dashicons-welcome-learn-more',
        'has_archive' => true

    ]);
//    // Campus Post Type
//    register_post_type('campus',[
//        'show_in_rest'=>true,
//        'capability_type' => 'campus',
//        'map_met_cap' => 'true',
//        'supports'=> [
//            'title',
//            'editor',
//            'excerpt'
//        ],
//        'rewrite'=>[
//            'slug'=> 'campuses'
//        ],
//        'public'=>true,
//        'labels'=>[
//            'name'=>'Campuses',
//            'singular_name'=>'Campus',
//            'add_new_item'=> 'Add New Campus',
//            'edit_item'=> 'Edit Campus',
//            'all_items'=> 'All Campuses'
//        ],
//        'menu_icon'=>'dashicons-location-alt',
//        'has_archive'=> true
//    ]);
//    // Note Post Type
//    register_post_type('note',[
//        'capability_type' => 'note',
//        'map_meta_cap' => true,
//        'show_in_rest' => true,
//        'supports'=> [
//            'title',
//            'editor',
//            'author'
//        ],
//        'public'=>false, // private to each user account
//        'show_ui'=> true,
//        'labels'=>[
//            'name'=>'Notes',
//            'singular_name'=>'Note',
//            'add_new_item'=> 'Add New Note',
//            'edit_item'=> 'Edit Note',
//            'all_items'=> 'All Note'
//        ],
//        'menu_icon'=>'dashicons-welcome-write-blog',
//
//    ]);

}

add_action('init','rc_insights_post_types');

// This function never got implemented. I think I was going to use it to add
// Author support to the Notes Custom Post type. But the can easily be done when
// registering the post type.  See the functions above
// Here is the stack overflow https://wordpress.stackexchange.com/questions/268900/display-post-author-for-custom-post-type-in-edit-post-screen
//
//add_action( 'init', 'add_author_support_to_posts' );
//function add_author_support_to_posts() {
//    add_post_type_support( 'note', 'author' );
//}

