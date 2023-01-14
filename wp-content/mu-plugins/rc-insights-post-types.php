<?php
/**
 * Must-use plugins for RC Insights.
 * Making changes to this file may require Updating Permalinks
 *  - Got to admin dashboard -> settings -> permalinks -> save changes
 *
 * @package 'rc-insights'
 */

require get_theme_file_path('inc/search-route.php');

function rc_insights_post_types(){
    /*
     *  Recipe Post Type
     */
    register_post_type('recipe',[
        'show_in_rest' => true,
        'capability_type' => 'recipe',   // Add this to prevent default access to this post type
        'map_meta_cap' => true,         // needed with capability type
        'supports'=> [
            'title',
            'editor',
            'excerpt',
            'author',
            'category'
        ],
        'rewrite'=>[
            'slug'=> 'recipes'
        ],
        'public'=>true,
        'labels'=>[
            'name'=>'Recipes',
            'singular_name'=>'Recipe',
            'add_new_item'=> 'Add New Recipe',
            'edit_item'=> 'Edit Recipe',
            'all_items'=> 'All Recipes'
        ],
        'menu_icon'=>'dashicons-index-card',
        'show_in_nav_menus' => true,
        'has_archive'=> true
    ]);
    /*
     * Note Post Type
     */

    register_post_type('note',[
        'capability_type' => 'note',    // Add this to prevent default access to this post type
        'map_meta_cap' => true,         // needed with capability type
        'show_in_rest' => true,
        'supports'=> [
            'title',
            'editor',
            'author'
        ],
        'public'=>false, // private to each user account
        'show_ui'=> true,
        'labels'=>[
            'name'=>'Notes',
            'singular_name'=>'Note',
            'add_new_item'=> 'Add New Note',
            'edit_item'=> 'Edit Note',
            'all_items'=> 'All Note'
        ],
        'menu_icon'=>'dashicons-welcome-write-blog',

    ]);
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
        'show_in_nav_menus' => true,
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

    register_post_type('location',[
        'taxonomies'=> ['settings'],
        'capability_type' => 'location',   // Add this to prevent default access to this post type
        'map_meta_cap' => true,             // needed with capability type
        'supports'=> [
            'title',
            'editor',
            'excerpt'
        ],
        'rewrite'=>[
            'slug'=> 'locations'
        ],
        'public'=>true,
        'labels'=>[
            'name'=>'Locations',
            'singular_name'=>'Location',
            'add_new_item'=> 'Add New Location',
            'edit_item'=> 'Edit Location',
            'all_items'=> 'All Locations'
        ],
        'menu_icon'=>'dashicons-location-alt',
        'has_archive'=> true,
        'show_in_rest'=>true,
    ]);


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

//hook into the init action and call create_book_taxonomies when it fires

add_action( 'init', 'create_subjects_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it types for your posts

function create_subjects_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

    $labels = array(
        'name' => _x( 'Setting', 'taxonomy general name' ),
        'singular_name' => _x( 'Setting', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Setting' ),
        'all_items' => __( 'All Settings' ),
        'parent_item' => __( 'Parent Settings' ),
        'parent_item_colon' => __( 'Parent Setting:' ),
        'edit_item' => __( 'Edit Setting' ),
        'update_item' => __( 'Update Setting' ),
        'add_new_item' => __( 'Add New Setting' ),
        'new_item_name' => __( 'New Setting Name' ),
        'menu_name' => __( 'Settings' ),
    );

// Now register the taxonomy
    register_taxonomy('settings',['location'] /*Show in location*/, array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite' => array( 'slug' => 'setting', 'with_front' => false )
    ));

}

/**
 *
 * Utility Functions
 */


/**
 * Log utility
 *
 */

if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}

/**
 * Log REST API errors
 *
 * @param WP_REST_Response $result  Result that will be sent to the client.
 * @param WP_REST_Server   $server  The API server instance.
 * @param WP_REST_Request  $request The request used to generate the response.
 */
if (!function_exists('log_rest_api_errors')){
    function log_rest_api_errors( $result, $server, $request ) {
        if ( $result->is_error() ) {
            error_log( sprintf(
                "REST request: %s: %s",
                $request->get_route(),
                print_r( $request->get_params(), true )
            ) );

            error_log( sprintf(
                "REST result: %s: %s",
                $result->get_matched_route(),
                print_r( $result->get_data(), true )
            ) );
        }

        return $result;
    }


    add_filter( 'rest_post_dispatch', 'log_rest_api_errors', 10, 3 );
}
/**
 *
 * Class autoloader
 */
if (!function_exists('spl_autoload_register')){
    function autoloader($classname) {
        include_once 'path/to/class.files/' . $classname . '.php';
    }
    spl_autoload_register('autoloader');
}
