<?php
/**
 * Content for portfolio page
 */
global $wp_query, $pi_theme_options, $is_retina;

// get portfolio style from pages options
$style = ELVYRE_CORE ? rwmb_meta('pg_portfolio_style', '', get_the_ID()) : false;

if (is_tax()) {
    $style = $pi_theme_options['portfolio_category_style'];
}

$style = !empty($style) ? $style : '2-col';

// if user set 0, all posts will be fetched
$posts_per_page = $pi_theme_options['portfolio_pagination'] == 0 ? "-1" : $pi_theme_options['portfolio_pagination'];

if ($style == '2-col') {
    $columns_class = 'grid_6';
    $image_width = 584;
    $image_height = 462;
} else if ($style == '3-col') {
    $columns_class = 'grid_4';
    $image_width = 388;
    $image_height = 307;
} else if ($style == '4-col') {
    $columns_class = 'grid_3';
    $image_width = 291;
    $image_height = 230;
} else if ($style == 'full') {
    $columns_class = 'grid_4';
    $image_width = 584;
    $image_height = 462;
}

// if user is on retina device, double the size of image
if ($is_retina) {
    $image_width = 2 * $img_width;
    $image_height = 2 * $img_height;
}

// check if page needs to be paged
$paged = 1;
if (get_query_var('paged'))
    $paged = get_query_var('paged');
if (get_query_var('page'))
    $paged = get_query_var('page');

$id_counter = 1;

$item_defaults = array(
    'zoom' => '1',
    'link' => '1',
    'image_lightbox' => '0',
    'lightbox_current_project' => '0'
);
$item_customization = array_merge($item_defaults, $pi_theme_options['portfolio_item_custom']);
$lightbox_current_item = $item_customization['lightbox_current_project'];

// items order
$order = $pi_theme_options['portfolio_order'];
$order_by = $pi_theme_options['portfolio_order_by'];

// Simple Share Buttons Adder
$portfolio_ssba = $pi_theme_options['portfolio_ssba'];

// include specific taxonomies
$specific_taxonomies = rwmb_meta('pg_portfolio_taxonomies', '', get_the_ID());
if (!empty($specific_taxonomies)) {
    // clean taxonomies
    $specific_taxonomies = trim($specific_taxonomies, ',');
    $specific_taxonomies = explode(',', $specific_taxonomies);
}
?>
<!-- .page-content start -->
<section class="page-content">

    <!-- .container start -->
    <div class="container">
        <?php if (ELVYRE_CORE) : ?>
            <!-- .row start -->
            <div class="row portfolio-filters triggerAnimation animated" data-animate="fadeInDown">
                <section class="grid_12">
                    <ul id="filters">                        
                        <?php
                        $category_html = '';
                        $categories_count = 0;
                        if (is_tax()) {
                            $category_id = "";
                            $query_category = $wp_query->get_queried_object();
                            $category_id = $query_category->term_id;
                            $args = array(
                                'order' => 'ASC',
                                'include' => $category_id
                            );
                        } else if (!empty($specific_taxonomies)) {
                            $args = array(
                                'include' => $specific_taxonomies,
                                'order' => 'ASC'
                            );
                        } else {
                            $args = array('order' => 'ASC');
                        }

                        $categories = get_terms('portfolio-category', $args);

                        $index = 1;
                        foreach ($categories as $cat) {
                            $category_html .= '<li><a data-filter=".' . $cat->slug . '" href="#">' . $cat->name . '<span class="item-number">' . $cat->count . '</span></a></li>';
                            $categories_count += $cat->count;
                            $index++;
                        }
                        
                        if (count($categories) > 1):
                            ?>
                            <li class="active"><a href="#" data-filter="*"><?php _e('All', 'pi_framework') ?> <span class="item-number"><?php echo $categories_count ?></span></a></li>
                        <?php endif; ?>
                        <?php echo $category_html ?>
                    </ul>
                </section><!-- .grid_12 end -->                    
            </div><!-- .row.portfolio-filters end  end -->
            <?php if ($style == 'full') { ?>
            </div>
        </section>
        <section class="page-content full">
            <div class="container full">
                <!-- .row.portfolio-items-holder start -->
            <?php } ?>
            <!-- .row.portfolio-items-holder start -->
            <div class="row portfolio-items-holder triggerAnimation animated" data-animate="fadeInUp">
                <!-- #portfolioitems.isotope start -->
                <ul id="portfolioitems" class="isotope">
                    <?php
                    //query args
                    if (is_tax()) {
                        global $wp_query;
                        $query_category = $wp_query->get_queried_object();
                        $category_id = $query_category->term_id;
                        $args = array('post_type' => 'pi_portfolio',
                            'posts_per_page' => $posts_per_page,
                            'paged' => $paged,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'portfolio-category',
                                    'field' => 'id',
                                    'terms' => $category_id
                                )
                            ),
                            'order' => $order,
                            'orderby' => $order_by
                        );
                    } else if (!empty($specific_taxonomies)) {

                        $args = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'portfolio-category',
                                    'field' => 'id',
                                    'terms' => $specific_taxonomies
                                )
                            ),
                            'post_type' => 'pi_portfolio',
                            'posts_per_page' => $posts_per_page,
                            'paged' => $paged,
                            'order' => $order,
                            'orderby' => $order_by
                        );
                    } else {
                        $args = array('post_type' => 'pi_portfolio', 'posts_per_page' => $posts_per_page, 'paged' => $paged, 'order' => $order, 'orderby' => $order_by);
                    }

                    // The Query
                    $wp_query = new WP_Query($args);

                    // The Loop
                    while ($wp_query->have_posts()) : $wp_query->the_post();
                        /* Show portfolio columns based on style selected in custom options */
                        $terms_slugs = "";
                        $post_count = $wp_query->post_count;

                        // Get Portfolio categories
                        $terms = get_the_terms(get_the_ID(), 'portfolio-category');
                        $terms_count = count($terms);
                        $i = 0;
                        foreach ($terms as $term) {
                            $current_term = ++$i;
                            $terms_slugs .= $term->slug . ($current_term != $terms_count ? ' ' : "");
                        }
                        $terms_title = get_the_term_list(get_the_ID(), 'portfolio-category', '<span>', ', ', '</span>');

                        $post_url = get_permalink();

                        // get all uploaded image IDs for this portfolio item
                        $images = rwmb_meta('pf_image', 'type=image&size=full', get_the_ID());
                        $image_url = reset($images);
                        $first_item_id = $image_url['ID'];
                        $image_url = $image_url['url'];

                        $params = array('width' => $image_width, 'height' => $image_height);

                        $featured_image = bfi_thumb($image_url, $params);
                        // post date
                        $date_format = get_option('date_format');
                        $post_date = get_the_time($date_format);

                        if (empty($featured_image)) {
                            continue;
                        }
                        ?>
                        <li class="isotope-item <?php echo $columns_class, " ", $terms_slugs; ?>">

                            <figure class="portfolio-img-container">
                                <div class="portfolio-img">
                                    <?php if ($item_customization['image_lightbox'] == '1' && !$item_customization['zoom'] && !$item_customization['link']) { ?>
                                        <a href="<?php echo $image_url; ?>" data-gal="prettyPhoto[pp_gallery<?php echo $lightbox_current_item == '1' ? "_" . $id_counter : '' ?>]">

                                        <?php } else { ?>
                                            <a href="<?php echo $post_url; ?>">
                                            <?php } ?>
                                            <img src="<?php echo $featured_image ?>" 
                                                 alt="<?php _e('Portfolio Image', 'pi_framework') ?>" 
                                                 width="<?php echo $image_width ?>"                                                 
                                                 />
                                        </a>
                                        <?php
                                        if ($item_customization['zoom'] == '1' || $item_customization['link'] == '1') {
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
                                                        <li class="portfolio-single <?php if ($item_customization['zoom'] != '1') echo "single"; ?>">
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
                                    <a class="title" href="<?php echo $post_url; ?>"><?php the_title() ?></a>
                                    <?php
                                    if (shortcode_exists('ssba') && $portfolio_ssba == '1') {
                                        $shortcode = "[ssba url='{$post_url}']";
                                        ?>
                                        <div class="portfolio-item-like"><?php echo do_shortcode($shortcode) ?></div>
                                    <?php } ?>
                                </figcaption>
                            </figure>
                        </li><!-- .grid_6.isotope-item.design end -->
                        <?php
                        $id_counter++;
                    endwhile;
                    ?>
                </ul>
            </div>
            <?php pi_pagination('portfolio'); ?>
        <?php else: ?>
            <div class="container_12">
                <div class="grid_12">
                    <?php _e('Please activate Core plugin to show Portfolio items!', 'pi_framework'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div><!-- .container end -->
</section><!-- .page-content end -->