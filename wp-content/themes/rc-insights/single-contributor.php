<?php
/**
 * Single contributor template.
 *
 * @package 'rc-insights'
 */



get_header();

while (have_posts()){
    the_post();

    pageBanner();
    ?>

    <div class="container container--narrow page-section">

        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php the_post_thumbnail('contributor-portrait'); ?>
                </div>
                <div class="two-thirds">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <?php
        $today = date('Ymd');
        $relateContributors = new WP_Query([
            'posts_per_page'=>-1,
            'post_type'=>'event',
            'orderby'=> 'title',
            'order'=>'ASC',
            'meta_key'=>'contributor',
            'meta_query'=>[
                [
                    'key'=>'related_subjects',
                    'compare'=>'LIKE',
                    'value'=> ' "'. get_the_ID() .'"' // must be in double quotes here
                ]
            ]
        ]);


        if ($relateContributors->have_posts()){


            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium"> ' . get_the_title() . ' Contributors</h2>';
            while ($relateContributors->have_posts()): $relateContributors->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"></a><?php the_title();?></li>

            <?php endwhile; wp_reset_postdata(); } ?>


        <?php $relatedSubjects = get_field('related_subjects');
        if ($relatedSubjects) :
            echo '<hr class="section-break">';
            echo ' <ul class="link-list min-list">';
            echo '<h2 class="headline headline--medium">Academic areas</h2>';
            foreach ($relatedSubjects as $relatedSubject):?>
                <li><a href="<?php echo get_the_permalink($relatedSubject) ?>"><?php echo get_the_title($relatedSubject) ?></a></li>
            <?php   endforeach; endif;?>
        </ul>
    </div>

    <?php
} get_footer();

?>
