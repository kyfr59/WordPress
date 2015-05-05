<?php
/**
 * Template for video post format.
 */
global $blog_style, $pi_theme_options, $is_retina, $post;

// post video
$post_video_url = get_post_meta(get_the_ID(), 'pt_video_url', true);

//get post meta
$post_title = get_the_title();
$post_permalink = get_permalink();
$post_author_name = get_the_author_meta('display_name');
$post_author_url = get_author_posts_url(get_the_author_meta('ID'));

// if Core plugin isn't activated or user didn't fill neccesarry data 
// for this post format, load default post format
if (!ELVYRE_CORE || empty($post_video_url)) {
    get_template_part('content');
    return true;
}

// list item array of classes
$list_classes = array('blog-post');

if ($blog_style == 'blog-post-masonry-full' || $blog_style == 'blog-post-masonry')
    $list_classes[] = 'isotope-item';

// read more button
$read_more = $pi_theme_options['blog_hide_readmore'];
$read_more_text = $pi_theme_options['blog_readmore_text'];

// show/hide post meta
$single_post_meta = $pi_theme_options['blog_single_meta'];
?>
<li id="post-<?php the_ID(); ?>" <?php post_class($list_classes); ?>>
    <div class="post-media-container">
        <?php echo $post_video_url; ?>
    </div><!-- .post-media-container -->

    <?php if (!is_single() && $blog_style != 'blog-post-small-image' || (is_single() && $single_post_meta == '1')): ?>
        <ul class="post-info">
            <li class="post-date">
                <span class="day"><?php the_time('d') ?></span>
                <span class="month"><?php mb_strtoupper(the_time('M')); ?></span>
            </li>

            <li class="post-category">
                <i class="icon-play-2"></i>
            </li>
        </ul>

    <?php endif; ?>

    <!-- .post-body start -->
    <article class="post-body <?php if(is_single() && $single_post_meta == '0') echo "meta-hidden"; ?>">
        <?php if ($blog_style == 'blog-post-small-image'): ?>
            <!-- .post-info start -->
            <div class="post-info-container">

                <ul class="date-category">
                    <li class="post-date">
                        <span class="day"><?php the_time('d') ?></span>
                        <span class="month"><?php mb_strtoupper(the_time('M')); ?></span>
                    </li>

                    <li class="post-category">
                        <i class="icon-play-2"></i>
                    </li>
                </ul>

                <div class="post-info">
                <?php endif; ?>

                <a href="<?php echo $post_permalink ?>">
                    <h3><?php the_title(); ?></h3>
                </a>

                <ul class="post-meta">
                    <li class="icon-clock">
                        <span><?php the_time('M d, Y') ?></span>
                    </li>
                    <li class="icon-user">
                        <a href="<?php echo $post_author_url; ?>"><?php echo $post_author_name; ?></a>
                    </li>

                    <li class="icon-comments">
                        <a href="<?php comments_link() ?>"><?php echo get_comments_number(); ?></a>
                    </li>

                    <li class="post-tags icon-tags">
                        <?php the_tags('', ', ') ?>
                    </li><!-- .post-tags end -->
                </ul><!-- .post-meta end -->

                <?php if ($blog_style == 'blog-post-small-image'): ?>
                </div><!-- .post-info end -->

            </div><!-- .post-info-container end -->
        <?php endif; ?>

        <?php
        if (is_single()) {
            the_content();
            wp_link_pages(array('before' => '<p class="wp-link-pages">Pages: ', 'after' => '</p>'));
        } else {
            // if user inserts more tag get regular content instead excerpt
            if ( preg_match('/<!--more(.*?)?-->/', $post->post_content) ) {
                the_content();                
            }else{
                the_excerpt();
            }
        }
        ?>
        <?php if (!is_single() && $read_more == '1'): ?>
            <a class="read-more" href="<?php echo $post_permalink ?>">
                <?php echo !empty($read_more_text) ? $read_more_text : __('Read More', 'pi_framework') ?>
                <span class="icon-arrow-right-3"></span>
            </a>
        <?php endif; ?>
        <?php if (!is_single()): ?>
        </article><!-- .post-body end -->
    </li><!-- blog post end -->
<?php endif; ?>