<?php
/**
 * The default template for displaying single post
 */
get_header();

global $blog_style, $page_title;

$page_title = get_the_title();

// hide page title
$hide_page_title = get_post_meta($page_id, 'pg_hide_title', true);
$hide_page_title = empty($hide_page_title) ? '0' : $hide_page_title;

// style
$blog_style = $pi_theme_options['blog_single_sidebar'];

if ($hide_page_title == '0') {
    get_template_part('section', 'title');
}

// ul classes
$ul_classes = array('blog-posts');

if($blog_style == 'blog-post-large-image'){
    $ul_classes[] = 'grid_9';
}else{
    $ul_classes[] = 'grid_12';
}

// get animation classes
$animation = $pi_theme_options['blog_animation'];
if ($animation != "disabled") {
    $ul_classes[] = 'triggerAnimation';
    $ul_classes[] = 'animated';
    $ul_classes[] = $animation;
}
?>

<!-- .page-content start -->
<section class="page-content <?php if ($hide_page_title == '1') echo 'no-page-title'; ?>">

    <!-- .container start -->
    <div class="container">

        <!-- .row start -->
        <div class="row">

            <!-- blog posts container start -->
            <ul class="<?php echo join(' ', $ul_classes) ?>">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('content', 'single');
                endwhile;
                ?>
            </ul><!-- blog posts container end -->
            <?php if ($blog_style == 'blog-post-large-image') get_sidebar(); ?>
        </div><!-- .row end -->
    </div><!-- .container end -->
</section><!-- .page-content end -->
<?php get_footer(); ?>