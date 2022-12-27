<?php
/**
* 'Single Blog post content template-part'
*
* @package 'rc-insights'
*/

?>

<article id="post-<?php the_ID(); ?>"  <?php post_class(); ?>>

    <header class="entry-header">
        <div class="post-item">
        <?php
        if (!empty($post->ID)) { ?>
            <span class="dashicons dashicons-format-<?php echo get_post_format( $post->ID ); ?>">

            </span>
        <?php  } ?>

            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
            <div class="metabox">
                <p><?php the_author_posts_link();?> <?php the_time('n.j.y');?> in <?php echo get_the_category_list(',')?></p>
            </div>
            <div class="generic-content">
                <?php
                the_excerpt();
                ?>
                <p><a class="btn btn--blue" href="<?php the_permalink();?>">Continue reading...</a></p>
            </div>
        </div>
    </header>

</article>
