<?php
/**
 * Blog page template.
 *
 * @package 'rc-insights'
 */

 get_header(); ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/venti-views-1900x800-bos1.jpg')?>)"></div>
            <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title">Welcome to the blog.</h1>
                <div class="page-banner__intro">
                    <p>Replace this text later</p>
                </div>
            </div>
        </div>

<div class="container container--narrow page-section">

    <main id="main" class="site-main" role="main">
<!--        <h1>--><?php //wp_title( '' ) ?><!--</h1>-->
        <?php
        if(have_posts()): while(have_posts()): the_post();
            get_template_part('template-parts/content', 'posts');
        endwhile; else:
            get_template_part('template-parts/content' , 'none');
        endif;
        echo paginate_links();
        ?>

    </main>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
