<?php
/**
 * The template for displaying Comments.
 *
 */
?>
<?php if (post_password_required()) : ?>
    <p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'pi_framework'); ?></p>
    </div><!-- #comments -->
    <?php
    /* Stop the rest of comments.php from being processed,
     * but don't kill the script entirely -- we still have
     * to fully load the template.
     */
    return;
endif;
?>
<?php if (have_comments()) : ?>
    <!-- post comments start -->
    <article class="post-comments">
        <h4><?php _e('Comments', 'pi_framework') ?> (<?php echo get_comments_number(); ?>)</h4>

        <!-- post comments list items start -->
        <ul class="comments-li">
            <?php
            /* Loop through and list the comments. Tell wp_list_comments()
             * to use twentyeleven_comment() to format the comments.
             */
            wp_list_comments(array('callback' => 'pi_render_comment'));
            ?>
            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
                <li class="comments-pagination">
                    <?php paginate_comments_links(); ?>
                </li>
            <?php endif; ?>
        </ul><!-- post comments list items end -->

    </article><!-- post comments end -->

    <?php
elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :
    ?>
    <p class="nocomments"><?php _e('Comments are closed.', 'pi_framework'); ?></p>
    <?php
endif;
if (comments_open()) :
    ?>
    <section class="comment-form">
        <?php comment_form(); ?>        
    </section>
<?php endif; ?>
<div class="clearfix"></div>
