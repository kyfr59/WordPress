<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

global $post, $woocommerce, $product;
?>
<script type="text/javascript">
    (function($) {
        jQuery(window).load(function() {
            $('.woocommerce.single-product .images').nivoSlider({
                controlNav: true,
                manualAdvance: true,
                controlNavThumbs: true,
                effect: "fade"
            });
        });
    })(jQuery);
</script>
<div class="products-slider">
    <div class="images">

        <?php
        $attachment_ids = $product->get_gallery_attachment_ids();

        if (has_post_thumbnail()) {
            $loop = 0;
            $columns = apply_filters('woocommerce_product_thumbnails_columns', 3);

            $image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
            $image_link = wp_get_attachment_url(get_post_thumbnail_id());
            $image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                'title' => $image_title
            ));

            $attachment_count = count($product->get_gallery_attachment_ids());

            if ($attachment_count > 0) {
                $gallery = '[product-gallery]';
            } else {
                $gallery = '';
            }

            echo apply_filters('woocommerce_single_product_image_html', sprintf('<a href="%s" itemprop="image" class="woocommerce-main-image zoom" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image), $post->ID);

            foreach ($attachment_ids as $attachment_id) {
                if ($loop == 0 || $loop % $columns == 0)
                    $classes[] = 'first';

                if (( $loop + 1 ) % $columns == 0)
                    $classes[] = 'last';

                $image_link = wp_get_attachment_url($attachment_id);

                if (!$image_link)
                    continue;

                $image_thumb_link = wp_get_attachment_image_src($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'));
                $image = wp_get_attachment_image($attachment_id, 'shop_single');

                $image_class = esc_attr(implode(' ', $classes));
                $image_title = esc_attr(get_the_title($attachment_id));
                echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<img src="%s" class="%s" data-thumb="%s"/>', $image_link, $image_class, $image_thumb_link[0]), $attachment_id, $post->ID, $image_class);

                $loop++;
            }
        } else {
            echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="Placeholder" />', wc_placeholder_img_src()), $post->ID);
        }
        ?>
    </div>
</div>