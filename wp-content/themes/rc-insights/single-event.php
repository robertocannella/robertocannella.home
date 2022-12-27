<?php
/**
 * Single Event template.
 *
 * @package 'rc-insights'
 */


get_header();
pageBanner();
while (have_posts()){
    the_post();
    ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event');?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Events Home
                </a>
                <span class="metabox__main"><?php the_title();?></span>

            </p>
        </div>
        <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
                                <span class="event-summary__month">
                                    <?php
                                    $eventDate = new DateTime(get_field('event_date'));
                                    echo $eventDate->format('M');
                                    ?>
                                </span>
                <span class="event-summary__day"><?php echo $eventDate->format('d');?></span>
            </a>
        </div>
        <div class="generic-content">
            <?php the_content();?>
        </div>

        <?php $relatedSubjects = get_field('related_subjects');
        if ($relatedSubjects) :
            echo '<hr class="section-break">';
            echo ' <ul class="link-list min-list">';
            echo '<h2 class="headline headline--medium">Related Subjects(s)</h2>';
            foreach ($relatedSubjects as $relatedSubject):?>
                <li><a href="<?php echo get_the_permalink($relatedSubject) ?>"><?php echo get_the_title($relatedSubject) ?></a></li>
            <?php   endforeach; endif;?>
        </ul>
    </div>

    <?php
} get_footer();

?>
