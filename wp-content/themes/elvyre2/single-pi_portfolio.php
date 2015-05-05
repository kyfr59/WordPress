<?php
/**
 * Singe portfolio item template.
 */
get_header();

if (have_posts()) : the_post();

    global $pi_theme_options, $page_title, $is_retina;

    $page_id = get_the_ID();
    $page_title = get_the_title();

    $images = rwmb_meta('pf_image', 'type=image&size=full', get_the_ID());

    // slider and content size
    $slider_size = $pi_theme_options['portfolio_slider_size'];
    $content_size = ($slider_size == '12') ? 12 : 12 - intval($slider_size);

    // hide slider arrows
    $slider_arrows = $pi_theme_options['portfolio_slider_arrows'];
    $show_slider_arrows = $slider_arrows == '0' || empty($slider_arrows) || (count($images) <= 1) ? 'false' : 'true';

    // auto sliding
    $auto_sliding = $pi_theme_options['portfolio_auto_slide'];
    $disable_auto_sliding = $auto_sliding == '0' || empty($auto_sliding) ? 'true' : 'false';
    $slider_pause_time = empty($pi_theme_options['portfolio_slider_delay']) ? '3000' : $pi_theme_options['portfolio_slider_delay'];

    // show/hide page title
    $hide_page_title = get_post_meta($page_id, 'pg_hide_title', true);
    $hide_page_title = empty($hide_page_title) ? '0' : $hide_page_title;

    // image size in slider depends on selected option in Theme options
    if ($slider_size == '4') {
        $slider_image_width = 370;
    } else if ($slider_size == '6') {
        $slider_image_width = 570;
    } else if ($slider_size == '7') {
        $slider_image_width = 670;
    } else if ($slider_size == '8') {
        $slider_image_width = 770;
    } else if ($slider_size == '9') {
        $slider_image_width = 870;
    } else if ($slider_size == '12') {
        $slider_image_width = 1170;
    }

    $slider_image_height = $pi_theme_options['portfolio_slider_height'];

    // if user is on retina device, double the size of image
    if ($is_retina) {
        $slider_image_width = 2 * $slider_image_width;
        $slider_image_height = 2 * intval($slider_image_height);
    }

    // check if cropping images is disabled
    $image_croppping = $pi_theme_options['portfolio_single_cropping'];

    // item customization like display zoom/single icons etc.
    $item_customization = $pi_theme_options['portfolio_item_custom'];
    $lightbox_current_item = isset($item_customization['lightbox_current_project']) ? $item_customization['lightbox_current_project'] : false;

    // title and subtitle for related posts section 
    $section_title = $pi_theme_options['portfolio_related_posts_title'];
    $section_subtitle = $pi_theme_options['portfolio_related_posts_subtitle'];

    // get title section
    if ($hide_page_title == '0') {
        get_template_part('section', 'title');
    }

    // Simple Share Buttons Adder
    $portfolio_ssba = $pi_theme_options['portfolio_related_ssba'];
    ?>

    <!-- .page-content start -->
    <section class="page-content">

        <!-- .container start -->
        <div class="container">

            <!-- .row start -->
            <div class="row">

                <!-- .grid_NN start -->
                <article class="grid_<?php echo $slider_size ?> triggerAnimation animated" data-animate="fadeInLeft">
                    <section id="post-slider" class="nivoSlider">
                        <?php
                        if (isset($images)):
                            foreach ($images as $index => $image) {

                                $image_url = $image['url'];

                                if ($image_croppping == '0') {
                                    $params = array('width' => $slider_image_width);
                                    $featured_image = bfi_thumb($image_url, $params);
                                } else {
                                    $params = array('width' => $slider_image_width, 'height' => $slider_image_height);
                                    $featured_image = bfi_thumb($image_url, $params);
                                }

                                echo "<img src='{$featured_image}' alt='{$image['title']}'/>";
                            }
                        else:
                            ?> 
                            <img data-src="<?php echo TEMPLATEURL ?>/js/holder.js/<?php echo $slider_image_width ?>x530/auto/text:Image Placeholder" 
                                 width="$slider_image_width" alt="<?php __('Image', 'pi_framework') ?>"/>
                             <?php endif; ?>
                    </section><!-- .nivoSlider end -->
                </article><!-- .grid_7 end -->

                <?php if ($content_size < 12): ?>
                    <article class="grid_<?php echo $content_size ?>">
                        <?php the_content(); ?>
                    </article>
                <?php endif; ?>

            </div><!-- .row end -->            
        </div>
    </section><!-- .page-content end -->

    <?php if ($content_size == 12): ?>
        <?php the_content(); ?>
    <?php endif; ?>

    <?php
    if ($pi_theme_options['portfolio_related_posts'] == '1'):
        $class = '';
        $style = '';

        $bkg_color = isset($pi_theme_options['portfolio_related_posts_color']) ? $pi_theme_options['portfolio_related_posts_color'] : false;
        $bkg_image = isset($pi_theme_options['portfolio_related_posts_image']) ? $pi_theme_options['portfolio_related_posts_image'] : false;

        if (isset($bkg_image['url']) && !empty($bkg_image['url'])) {
            $style = "style='background: url({$bkg_image['url']});'";
        } else if (!empty($bkg_color)) {
            $style = "style='background: {$bkg_color};'";
        } else {
            $class = 'pattern';
        }

        // check if parallax is enabled
        $parallax = $pi_theme_options['parallax'];
        if (!empty($parallax)) {
            // get parallax background ratio
            if (CONTENT_MANAGER) {
                $data_stellar_background_ratio = "data-stellar-background-ratio='" . cma_get_settings('data-stellar-background-ratio') . "'";
            } else {
                $data_stellar_background_ratio = 'data-stellar-background-ratio="0.4"';
            }
        }
        ?>
        <!-- .page-content.parallax pattern -->
        <section class="page-content parallax <?php echo $class ?>" <?php echo $data_stellar_background_ratio ?> <?php echo $style ?>>
            <!-- .container start -->
            <div class="container">
                <!-- .row start -->
                <div class="row">
                    <article class="grid_12">
                        <section class="heading-centered triggerAnimation animated" data-animate="bounceIn">
                            <?php if (!empty($section_title)): ?><h2><?php echo $section_title ?></h2><?php endif; ?>
                            <?php if (!empty($section_subtitle)): ?><p><?php echo $section_subtitle ?></p><?php endif; ?>
                        </section>
                    </article><!-- .grid_12 end -->

                </div><!-- .roe end -->            

                <!-- .row start -->
                <div class='row'> 
                    <article class="grid_12">
                        <article class="portfolio-carousel triggerAnimation animated" data-animate="fadeInUp">
                            <ul id="portfolio-related-carousel" class="carousel-li">

                                <?php
                                $id_counter = 1;
                                $index = 1;
                                $post_content = '';

                                // parameters for query
                                $carousel_items = $pi_theme_options['portfolio_related_posts_count'];
                                $filter = $pi_theme_options['portfolio_related_posts_filter'];

                                if ($filter == 'latest') {
                                    $args = array(
                                        'post_type' => 'pi_portfolio',
                                        'posts_per_page' => $carousel_items
                                    );
                                } else if ($filter == 'category') {
                                    $args = array('taxonomy' => 'portfolio-category', 'order' => 'ASC');
                                    $current_category = get_the_terms(get_the_ID(), 'portfolio-category');
                                    foreach ($current_category as $category) {
                                        $categories_list[] = $category->term_id;
                                    }

                                    $args = array(
                                        'post_type' => 'pi_portfolio',
                                        'posts_per_page' => $carousel_items,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'portfolio-category',
                                                'field' => 'id',
                                                'terms' => $categories_list
                                            )
                                        )
                                    );
                                } else if ($filter == 'random') {
                                    $args = array(
                                        'post_type' => 'pi_portfolio',
                                        'posts_per_page' => $carousel_items,
                                        'orderby' => 'rand'
                                    );
                                }

                                $item_customization = $pi_theme_options['portfolio_related_posts_customization'];
                                $lightbox_current_item = isset($item_customization['lightbox_current_item']) ? $item_customization['lightbox_current_item'] : false;

                                // The Query
                                $wp_query = new WP_Query($args);

                                // The Loop
                                while ($wp_query->have_posts()) : $wp_query->the_post();

                                    $post_id = get_the_ID();
                                    $i = 0;
                                    $terms_string = "";
                                    $post_url = get_permalink();
                                    // Get Portfolio categories
                                    $terms = get_the_terms($post_id, 'portfolio-category');
                                    $terms_count = count($terms);

                                    foreach ($terms as $term) {
                                        $terms_string .= $term->name . ( ++$i != $terms_count ? ' ' : "");
                                    }

                                    // get all uploaded image IDs for this portfolio item
                                    $images = rwmb_meta('pf_image', 'type=image&size=full', $post_id);
                                    $image_url = reset($images);
                                    $first_item_id = $image_url['ID'];
                                    $image_url = $image_url['url'];

                                    // if user is on retina device, double the size of image
                                    if ($is_retina) {
                                        $params = array('width' => 776, 'height' => 614);
                                    } else {
                                        $params = array('width' => 388, 'height' => 307);
                                    }

                                    $featured_image = bfi_thumb($image_url, $params);

                                    if (empty($featured_image)) {
                                        $featured_image = TEMPLATEURL . "/js/holder.js/388x307/auto/text:Image Placeholder";
                                    }
                                    ?>
                                    <li data-id="id-<?php echo $id_counter ?>" class="isotope-item">
                                        <!--portfolio figure with animation start-->
                                        <figure class="portfolio-img-container">                        
                                            <div class="portfolio-img">
                                                <?php if (isset($item_customization['image_lightbox']) && $item_customization['image_lightbox'] == '1' && !$item_customization['zoom'] && !$item_customization['link']) { ?>
                                                    <a href="<?php echo $image_url; ?>" data-gal="prettyPhoto[pp_gallery<?php echo $lightbox_current_item == '1' ? "_" . $id_counter : '' ?>]">

                                                    <?php } else { ?>
                                                        <a href="<?php echo $post_url; ?>">
                                                        <?php } ?>
                                                        <img src="<?php echo $featured_image ?>" 
                                                             alt="<?php _e('Portfolio Image', 'pi_framework') ?>" 
                                                             width="388"                                                 
                                                             />
                                                    </a>
                                                    <?php
                                                    if ($item_customization['zoom'] == '1' && $item_customization['link'] == '1') {
                                                        ?>
                                                        <div class="portfolio-img-hover">
                                                            <div class="mask"></div>

                                                            <ul>
                                                                <?php if ($item_customization['zoom'] == '1'): ?>
                                                                    <li class="portfolio-zoom <?php if (!$item_customization['link'] == '1') echo "single"; ?>">
                                                                        <a href="<?php echo $image_url; ?>" 
                                                                           data-gal="prettyPhoto[pp_gallery<?php echo $lightbox_current_item == '1' ? "_" . $id_counter : '' ?>]" class="icon-expand-2"></a>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if ($item_customization['link'] == '1'): ?>
                                                                    <li class="portfolio-single <?php if (!$item_customization['zoom'] == '1') echo "single"; ?>">
                                                                        <a href="<?php echo $post_url; ?>" class="icon-redo"></a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div><!-- .portfolio-img-hover end -->
                                                        <?php
                                                    }

                                                    if ($lightbox_current_item == '1') {
                                                        foreach ($images as $id => $val) {

                                                            // prevent first item duplicate
                                                            if ($id == $first_item_id)
                                                                continue;
                                                            ?>
                                                            <a class="hidden-portfolio-image" href="<?php echo $val['url'] ?>" data-gal="prettyPhoto[pp_gallery_<?php echo $id_counter ?>]">
                                                                <img src="<?php echo $val['url'] ?>" 
                                                                     alt="<?php __('Portfolio Image', 'pi_framework'); ?>"                                                     
                                                                     />
                                                            </a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                            </div>                                             
                                            <figcaption>
                                                <a class="title" href="<?php echo get_permalink() ?>"><?php the_title(); ?></a>
                                                <?php
                                                if (shortcode_exists('ssba') && $portfolio_ssba == '1') {
                                                    $shortcode = "[ssba url='{$post_url}']";
                                                    ?>
                                                    <div class="portfolio-item-like"><?php echo do_shortcode($shortcode) ?></div>
                                                <?php } ?>
                                            </figcaption>                        
                                        </figure>
                                    </li>
                                    <?php
                                    $id_counter++;

                                endwhile;
                                ?>
                            </ul>
                            <div class="clearfix"></div>
                            <ul class="carousel-nav">
                                <li>
                                    <a class="c_prev" href="#"></a> 
                                </li>
                                <li>
                                    <a class="c_next" href="#"></a>
                                </li>
                            </ul>
                        </article><!-- .portfolio-carousel end -->
                    </article><!-- .grid_12 end -->
                </div><!-- .row end -->
            </div><!-- .container end -->
        </section><!-- .page-content.parallax.pattern end -->

    <?php endif; ?>

    <script>
        jQuery(document).ready(function ($) {

            // init slider
            jQuery('#post-slider').nivoSlider({
                controlNav: false,
                directionNav: <?php echo $show_slider_arrows ?>,
                manualAdvance: <?php echo $disable_auto_sliding ?>,
                pauseTime: <?php echo $slider_pause_time ?>
            });

            //  Responsive layout, resizing the items
            jQuery('#portfolio-related-carousel').carouFredSel({
                responsive: true,
                width: '100%',
                height: '100%',
                auto: false,
                scroll: 1,
                prev: '.c_prev',
                next: '.c_next',
                items: {
                    width: 400,
                    height: '100%',
                    visible: {
                        min: 1,
                        max: 4
                    }
                }
            });
        });

    </script>
    <?php
endif; // end of the loop.
get_footer();
?>
