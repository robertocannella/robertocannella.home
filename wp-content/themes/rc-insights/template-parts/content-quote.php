<?php
/**
* 'Single Blog post Quote template-part'
*
* @package 'rc-insights'
*/

?>

<article id="post-<?php the_ID(); ?>"  <?php post_class(); ?>>

    <header class="entry-header">

        <?php
        if (!empty($post->ID)) { ?>
            <span class="dashicons dashicons-format-<?php echo get_post_format( $post->ID ); ?>"></span>
        <?php  } ?>
        <span>Enjoy this Quote!</span>
        <?php the_title('<h1>','</h1>') ?>


        <div class="byline">
            <?php esc_html_e('Author'); ?> <?php the_author();?>
        </div>
    </header>

    <div class="entry-content">
        <?php  the_content(); ?>
    </div>
    <?php
        if (comments_open()):
             comments_template();
        endif;
    ?>
</article>
