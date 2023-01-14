<?php
include "Trie.php";

class SearchRoute
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'rcInsightsRegisterSearch']);
    }

    function rcInsightsRegisterSearch()
    {
        register_rest_route('insights/v1', 'search', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'rcInsightsSearchResults'],
            'permission_callback' => '__return_true'
        ]);
    }


    function rcInsightsSearchResults($data):array{
        $postsQueryArgs = [
            'post_type' => 'any',
            's' => sanitize_text_field($data['term']),
            ];
        // Match partial words
        $matching_terms = get_terms( array(
            'taxonomy' => 'settings',
            'fields' => 'slugs', // searches in the slug and returns an array of matching slugs
            'name__like' => sanitize_text_field($data['term']),

        ) );
        $taxonomyQueryArgs = [
            'tax_query' => array(
                array(
                    'taxonomy' => 'settings', // the custom vocabulary
                    'field'    => 'slug',       // type of query 'slug' | 'id' ect.
                    'terms'    => $matching_terms,      // provide the term slugs
                ),
            ),
        ];

        $postsQuery = new WP_Query( $postsQueryArgs );
        $taxonomyQuery = new WP_Query( $taxonomyQueryArgs);
        $all = new WP_Query();

        $all->posts = array_merge($postsQuery->posts,$taxonomyQuery->posts);
        $all->post_count = count($all->posts);


        $results = [

            'genInfo' => [],
            'contributors' => [],
            'subjects' => [],
            'events' => [],
            'locations' => [],
            'taxonomies' => []
        ];

        while ($all->have_posts()){
            $all->the_post();

            if (get_post_type() == 'post' || get_post_type() == 'page'){
                $isInArray = in_array(get_the_ID(), array_column($results['genInfo'], 'id'));
                $results['genInfo'][] = [
                    'title' => get_the_title(),
                    'link' => get_the_permalink(),
                    'postType' => get_post_type(),
                    'authorName' => get_the_author()
                ];
            }
            if (get_post_type() == 'location'){
                $isInArray = in_array(get_the_ID(), array_column($results['locations'], 'id'));
                if ($isInArray) break;
                $results['locations'][] = [
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'link' => get_the_permalink()
                ];
            }
            if (get_post_type() == 'subject'){
                $isInArray = in_array(get_the_ID(), array_column($results['subjects'], 'id'));

                $results['subjects'][] = [
                    'title' => get_the_title(),
                    'link' => get_the_permalink()
                ];
            }
            if (get_post_type() == 'contributor'){
                $isInArray = in_array(get_the_ID(), array_column($results['contributors'], 'id'));

                $results['contributors'][] = [
                    'title' => get_the_title(),
                    'link' => get_the_permalink()
                ];
            }
            if (get_post_type() == 'event'){
                $isInArray = in_array(get_the_ID(), array_column($results['events'], 'id'));
                $results['events'][] = [
                    'title' => get_the_title(),
                    'link' => get_the_permalink()
                ];
            }
        }


        // get all the possible matching terms (taxonomies)
        // Get the current search term as a string 'abc'

        // the scenario is this:
        // search term 'abc' | possible matches ['bar','restaurant', 'dine-in']

        $trie = new Trie();
        $trie->insert('cat');
        $trie->insert('can');
        $trie->insert('pick');
        $trie->insert('pickle');
//
        //write_log(print_r($trie->containsWord('cat')));



        return $results;
    }


}
$searchRouter = new SearchRoute();