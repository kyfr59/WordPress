<?php
/**
 * The template for displaying all pages.
 */
get_header();

global $page_style, $mts_website_layout, $page_title, $is_retina, $pi_theme_options;

$page_id = get_the_ID();

// hide page title
$hide_page_title = get_post_meta($page_id, 'pg_hide_title', true);
$hide_page_title = empty($hide_page_title) ? '0' : $hide_page_title;

// check if nice title is set
$page_title = get_post_meta($page_id, 'pg_page_description', true);
$page_title = empty($page_title) ? get_the_title() : $page_title;

// page comments
$disable_page_comments = $pi_theme_options['page_comments'];

if (have_posts()) : the_post();
    if (!is_front_page()) {
        if ($hide_page_title == '0') {
            get_template_part('section', 'title');
        }
    }

    if (is_front_page() && $pi_theme_options['home_slider'] == "1") {
        echo '<div class="top-shadow"></div>';
        get_template_part('content', 'slider');
    }

    // page with sidebar or fullwidth
    $page_style = get_post_meta($post->ID, 'pg_sidebar', true);
    $page_style = empty($page_style) ? 'fullwidth' : $page_style;

    // check if Content Manager is active on this page
    $cma_active = get_post_meta($post->ID, 'content_manager_active', true);

    if ($page_style == 'left' || $page_style == 'right') {
        ?>
        <!-- .page-content start -->
        <section class="page-content">
            <!-- container start -->
            <div class="container">
                <!-- .row start -->
                <div class="row">
                    <?php if ($page_style == 'left') get_sidebar(); ?>
                    <article class="grid_9">
                        <?php
                        the_content();
                        if ($disable_page_comments != '1')
                          // comments_template('', true);
                        ?>
                    </article>
                    <?php if ($page_style == 'right') get_sidebar(); ?>
                </div><!-- .row end -->
            </div><!-- .container end -->
        </section><!-- .page-content end -->
        <?php
    } else {
        if (CONTENT_MANAGER && $cma_active == '1') {
            the_content();
            
            $comments = get_comments();

            if ($disable_page_comments != '1' && get_comments_number()) {
                ?>
                <!--.page-content start -->
                <section class = "page-content">
                    <!--container start -->
                    <div class = "container">
                        <!--.row start -->
                        <div class = "row">
                            <article class = "grid_12">
                                <?php
                                //comments_template('', true);
                                ?>
                            </article>
                        </div><!-- .row end -->
                    </div><!-- .container end -->
                </section><!-- .page-content end -->
                <?php
            }
        } else {
            ?>
            <!-- .page-content start -->
            <section class="page-content">
                <!-- container start -->
                <div class="container">
                    <!-- .row start -->
                    <div class="row">
                        <article class="grid_12">
                            <?php
                            the_content();
                            //if ($disable_page_comments != '1')
                            //    comments_template('', true);
                            ?>
                        </article>
                    </div><!-- .row end -->
                </div><!-- .container end -->
            </section><!-- .page-content end -->
            <?php
        }
    } // end of the loop.
endif; // end of the loop.
get_footer();
?>