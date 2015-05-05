<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

global $product, $woocommerce_loop, $pi_theme_options;

// Store loop count we're currently on
if (empty($woocommerce_loop['loop']))
    $woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns']))
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);

// Ensure visibility
if (!$product || !$product->is_visible())
    return;

// Increase loop count
$woocommerce_loop['loop'] ++;

// Extra post classes
$classes = array();
if (0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'])
    $classes[] = 'first';
if (0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'])
    $classes[] = 'last';
?>
<li <?php post_class($classes); ?>>

    <?php
    do_action('woocommerce_before_shop_loop_item');
    ?>

    <div class='img-container'>

        <a href="<?php the_permalink(); ?>">
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>
        </a>
        <?php if (isset($pi_theme_options['woo_product_hover']) && $pi_theme_options['woo_product_hover'] == '1'): ?>
            <div class="hover-container">
                <?php
                /**
                 * woocommerce_shop_loop_item_hover hook
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked pi_woocoomerce_shop_loop_item_hover - 10
                 */
                do_action('woocommerce_shop_loop_item_hover');
                ?>
                <?php
                // check is Wishlist plugin active
                $active_plugins = get_option('active_plugins');
                if (in_array('yith-woocommerce-wishlist/init.php', $active_plugins)) {
                    ?>
                    <div class="meta-links">
                        <span class="wishlist"><?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?></span>           
                    </div>
                <?php } ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="product-meta">
        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

        <?php
        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title');
        ?>
    </div>


    <?php do_action('woocommerce_after_shop_loop_item'); ?>

</li>