<?php
global $pi_theme_options;

/* ----------------------------------------------------------------------------- */
/*  Remove hooks on Shop page
 * ----------------------------------------------------------------------------- */
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_shop_loop', 'woocommerce_output_content_wrapper_end', 10);

// remove breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
// remove price hook
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
// remove rating hook
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

/* ----------------------------------------------------------------------------- */
/*  Remove hooks on product single page
 * ----------------------------------------------------------------------------- */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/* ----------------------------------------------------------------------------- */
/*  Show WooCommerce breadcrumbs on page title instead default one
 * ----------------------------------------------------------------------------- */

// Add breadcrumbs to page title hook pi_woocommerce_breadcrumb
add_action('pi_woocommerce_breadcrumb', 'woocommerce_breadcrumb', 20, 0);

// Add text before breadcumbs
if (!function_exists('pi_woocommerce_breadcrumb_defaults')) {

    function pi_woocommerce_breadcrumb_defaults($args) {
        $before_text = __('You are here: ', 'pi_framework');
        $args['wrap_before'] = __("<nav class='woocommerce-breadcrumb' ><span class='before-text'>{$before_text} </span>", 'pi_framework');
        $args['before'] = "<span class='item'>";
        $args['after'] = "</span>";
        return $args;
    }

}
add_filter('woocommerce_breadcrumb_defaults', 'pi_woocommerce_breadcrumb_defaults');

/* ----------------------------------------------------------------------------- */
/*  If user want to use custom Shop page hide Orderby and Results fields
 * ----------------------------------------------------------------------------- */

// check if user wants to build custom shop page
$custom_shop_page = isset($pi_theme_options['woo_custom_shop_page']) ? $pi_theme_options['woo_custom_shop_page'] : false;

if ($custom_shop_page == '1') {
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
}

/* ----------------------------------------------------------------------------- */
/*  Wrap content in Bootstrap grid
 * ----------------------------------------------------------------------------- */
if (!function_exists('pi_woocommerce_before_shop_loop')) {

    function pi_woocommerce_before_shop_loop() {
        global $pi_theme_options;
        $current_hook = current_filter();

        if (is_shop()) {
            // Page with sidebar or fullwidth
            $page_sidebar_id = get_option('woocommerce_shop_page_id');
            $page_style = get_post_meta($page_sidebar_id, 'pg_sidebar', true);
        } else if (is_singular('product')) {
            $page_style = isset($pi_theme_options['woo_single_product_sidebar']) ? $pi_theme_options['woo_single_product_sidebar'] : 'fullwidth';
        }

        if ($page_style == 'fullwidth' || empty($page_style)) {
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
            $article_size = "12";

            // if it's woocommerce_before_shop_loop hook, content needs to be wrapped
            if ($current_hook == 'woocommerce_before_main_content')
                return;
        } else {
            // if it's not full and it's woocommerce_before_shop_loop hook, 
            // dont' wrap the content
            if ($current_hook == 'woocommerce_before_shop_loop' || $current_hook == 'woocommerce_before_single_product')
                return;

            $article_size = "9";
        }
        ?>
        <!-- .page-content start -->
        <section class="page-content">
            <!-- container start -->
            <div class="container">
                <!-- .row start -->
                <div class="row">
                    <?php
                    if ($page_style == 'left') {
                        /**
                         * woocommerce_sidebar hook
                         *
                         * @hooked woocommerce_get_sidebar - 10
                         */
                        do_action('woocommerce_sidebar');
                    }
                    ?>

                    <article class="grid_<?php echo $article_size ?>">                    

                        <?php
                    }

                }
                add_action('woocommerce_before_main_content', 'pi_woocommerce_before_shop_loop');
                add_action('woocommerce_before_shop_loop', 'pi_woocommerce_before_shop_loop');
                add_action('woocommerce_before_single_product', 'pi_woocommerce_before_shop_loop');

                if (!function_exists('pi_woocommerce_after_shop_loop')) {

                    function pi_woocommerce_after_shop_loop() {
                        global $pi_theme_options;
                        $current_hook = current_filter();

                        if (is_shop()) {
                            // Page with sidebar or fullwidth
                            $page_sidebar_id = get_option('woocommerce_shop_page_id');
                            $page_style = get_post_meta($page_sidebar_id, 'pg_sidebar', true);
                        } else if (is_singular('product')) {
                            $page_style = isset($pi_theme_options['woo_single_product_sidebar']) ? $pi_theme_options['woo_single_product_sidebar'] : 'fullwidth';
                        }

                        // Page with sidebar or fullwidth
                        $page_sidebar_id = get_option('woocommerce_shop_page_id');

                        if ($page_style == 'fullwidth' || empty($page_style)) {

                            // if it's woocommerce_after_shop_loop hook, content needs to be wrapped
                            if ($current_hook == 'woocommerce_after_main_content')
                                return;
                        }else {
                            // if it's not full and it's woocommerce_before_shop_loop hook, 
                            // dont' wrap the content
                            if ($current_hook == 'woocommerce_after_shop_loop' || $current_hook == 'woocommerce_after_single_product')
                                return;
                        }
                        ?>

                    </article>
                    <?php
                    if ($page_style == 'right') {
                        /**
                         * woocommerce_sidebar hook
                         *
                         * @hooked woocommerce_get_sidebar - 10
                         */
                        do_action('woocommerce_sidebar');
                    }
                    ?>
                </div><!-- .row end -->
            </div><!-- .container end -->
        </section><!-- .page-content end -->

        <?php
    }

}
add_action('woocommerce_after_main_content', 'pi_woocommerce_after_shop_loop');
add_action('woocommerce_after_shop_loop', 'pi_woocommerce_after_shop_loop');
add_action('woocommerce_after_single_product', 'pi_woocommerce_after_shop_loop');

/* ----------------------------------------------------------------------------- */
/*  Hide page title
 * ----------------------------------------------------------------------------- */
if (!function_exists('pi_woocommerce_show_page_title')) {

    function pi_woocommerce_show_page_title($title) {
        global $pi_theme_options;

        if (is_shop()) {
            if ($pi_theme_options['woo_custom_shop_slider'] == "0")
                return true;
            else
                return false;
        } else if (is_product() || is_product_tag() || is_product_category()) {
            if ($pi_theme_options['woo_single_product_slider'] == "1") {
                return false;
            } else {
                return true;
            }
        }
    }

}
add_filter('woocommerce_show_page_title', 'pi_woocommerce_show_page_title');

/* ----------------------------------------------------------------------------- */
/*  Show slider on main Shop page
 * ----------------------------------------------------------------------------- */
if (!function_exists('pi_slider_woocommerce_before_main_content')) {

    function pi_slider_woocommerce_before_main_content() {
        global $pi_theme_options;

        if (is_shop()) {
            if ($pi_theme_options['woo_custom_shop_slider'] == "1") {
                echo '<div class="top-shadow"></div>';
                get_template_part('content', 'slider');
            }
        } else if (is_product() || is_product_tag() || is_product_category()) {
            if (isset($pi_theme_options['woo_single_product_slider']) && $pi_theme_options['woo_single_product_slider'] == "1") {
                echo '<div class="top-shadow"></div>';
                get_template_part('content', 'slider');
            }
        }
    }

}
add_action('woocommerce_before_main_content', 'pi_slider_woocommerce_before_main_content');

/* ----------------------------------------------------------------------------- */
/*  Shop item hover
 * ----------------------------------------------------------------------------- */

// add rating before title
add_action('woocommerce_shop_loop_item_hover', 'woocommerce_template_loop_rating', 5);

/* ----------------------------------------------------------------------------- */
/*  Shop item category
 * ----------------------------------------------------------------------------- */
if (!function_exists('pi_woocommerce_add_product_category')) {

    function pi_woocommerce_add_product_category() {
        global $post;
        $terms = get_the_terms($post->ID, 'product_cat');
        foreach ($terms as $term) {
            $product_cat_id = $term->term_id;
            $product_cat_name = $term->name;
            echo "<span class='category'>{$product_cat_name}</span>";
            break;
        }
    }

}
add_action('woocommerce_after_shop_loop_item_title', 'pi_woocommerce_add_product_category');
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');



/* ----------------------------------------------------------------------------- */
/*  Handle adding to cart with AJAX
 * ----------------------------------------------------------------------------- */
if (!function_exists('pi_woocommerce_header_add_to_cart_fragment')) {

    function pi_woocommerce_header_add_to_cart_fragment($fragments) {

        global $woocommerce;
        ob_start();
        ?>

        <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
            <span class="cart-count triggerAnimation animated pulse"><?php echo $woocommerce->cart->cart_contents_count ?></span> <?php echo $woocommerce->cart->get_cart_total(); ?>
        </a>

        <?php
        $fragments['a.cart-contents'] = ob_get_clean();
        return $fragments;
    }

}
add_filter('add_to_cart_fragments', 'pi_woocommerce_header_add_to_cart_fragment');

/* ----------------------------------------------------------------------------- */
/*  Change Shop page default products count
 * ----------------------------------------------------------------------------- */
if (!function_exists('pi_shop_page_products_count')) {

    function pi_shop_page_products_count() {
        global $pi_theme_options;

        $count = isset($pi_theme_options['woo_shop_page_products_count']) ? $pi_theme_options['woo_shop_page_products_count'] : 10;

        return $count;
    }

}
add_filter('loop_shop_per_page', 'pi_shop_page_products_count', 20);

/* ----------------------------------------------------------------------------- */
/*  Change number of related products on product page
 * ----------------------------------------------------------------------------- */

function pi_related_products_args($args) {
    $args['posts_per_page'] = 4; // 4 related products
    $args['columns'] = 4; // arranged in 2 columns

    return $args;
}

add_filter('woocommerce_output_related_products_args', 'pi_related_products_args');

/* ----------------------------------------------------------------------------- */
/*  Change number of upsells output
 * ----------------------------------------------------------------------------- */

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);

if (!function_exists('woocommerce_output_upsells')) {

    function woocommerce_output_upsells() {
        woocommerce_upsell_display(4, 4); // Display 3 products in rows of 3
    }

}

add_action('woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15);

/* ----------------------------------------------------------------------------- */
/*  Change number of cros-sell output
 * ----------------------------------------------------------------------------- */

// three columns
if (!function_exists('pi_woocommerce_cross_sells_columns')) {

    function pi_woocommerce_cross_sells_columns($columns) {
        return 4;
    }

}
add_filter('woocommerce_cross_sells_columns', 'pi_woocommerce_cross_sells_columns');


// three products total
if (!function_exists('pi_woocommerce_cross_sells_total')) {

    function pi_woocommerce_cross_sells_total($total) {
        return 4;
    }

}
add_filter('woocommerce_cross_sells_total', 'pi_woocommerce_cross_sells_total');
?>
