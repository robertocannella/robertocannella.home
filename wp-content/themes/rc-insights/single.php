<?php

/**
 * 'Single Blog post template'
 *
 * @package 'rc-insights'
 *
 * Forwards all posts to template parts
 */

get_header();

echo get_post_format();
?>


<div id="primary" class="content-area">
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/venti-views-1900x800-bos1.jpg')?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>Replace this text later</p>
            </div>
        </div>
    </div>
    <main id="main" class="site-main" role="main">

        <?php


        if(have_posts()): while(have_posts()): the_post();
            get_template_part('template-parts/content' , get_post_format());
        endwhile; else:
            get_template_part('template-parts/content' , 'none');
        endif;
        ?>
    </main>



</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
