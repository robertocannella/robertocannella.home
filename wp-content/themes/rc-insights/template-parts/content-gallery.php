<?php
/**
* 'Single Blog post Gallery template-part'
*
* @package 'rc-insights'
*/

?>

<article id="post-<?php the_ID(); ?>"  <?php post_class(); ?>>

    <header class="entry-header">


<!--        <span>--><?php //esc_html_e('Enjoy this Gallery!','rc-insights') ?><!--</span>-->



    </header>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <?php
                if (!empty($post->ID)) { ?>
                    <span class="dashicons dashicons-format-<?php echo get_post_format( $post->ID ); ?>"></span>
                <?php  } ?>
                <a class="metabox__blog-home-link" href="<?php echo site_url('/blog')?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a>
                <span class="metabox__main">Posted by <?php the_author_posts_link();?> <?php the_time('n.j.y');?> in <?php echo get_the_category_list(',')?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content();?>
        </div>

    </div>
    <?php
        if (comments_open()):
             comments_template();
        endif;
    ?>
</article>
