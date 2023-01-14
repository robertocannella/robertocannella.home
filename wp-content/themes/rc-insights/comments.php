<?php

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) : ?>
        <h2 class="comments-title">

            <?php
            echo "Comments on "  . get_the_title();
            ?>
        </h2>
        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
            ) );
            ?>
            </ol><!-- .comment-list -->
     <?php endif;      ?>
        </h2><!-- .comments-title -->

</div><!-- #comments -->