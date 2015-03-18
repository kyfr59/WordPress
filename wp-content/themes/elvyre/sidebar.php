<?php
/**
 * The Sidebar containing the main widget area.
 *
 */
?>
<!-- sidebar start -->
<?php
global $page_title, $pi_theme_options;
$aside_classes = array('grid_3');

if (is_home()) {
    $page_style = $pi_theme_options['blog_sidebar_position'];
} else if (PI_WOOCOMMERCE && is_shop()) {
    $shop_page_id = get_option('woocommerce_shop_page_id');
    $page_style = get_post_meta($shop_page_id, 'pg_sidebar', true);
} else if (PI_WOOCOMMERCE && (is_product() || is_product_tag() || is_product_category())) {
    $page_style = isset($pi_theme_options['woo_single_product_sidebar']) ? $pi_theme_options['woo_single_product_sidebar'] : 'fullwidth';
} else {
    global $page_style;
}

if ($page_style == 'left') {
    $aside_classes[] = 'aside-left';
} else {
    $aside_classes[] = 'aside-right';
}

// get animation classes
$animation = $pi_theme_options['blog_sidebar_animation'];
if ($animation != "disabled") {
    $aside_classes[] = 'triggerAnimation';
    $aside_classes[] = 'animated';
    $aside_classes[] = $animation;
}
?>
<aside class="<?php echo join(' ', $aside_classes); ?>">
    <ul class="aside_widgets">
        <?php
        wp_reset_query();

        if (is_page()) {
            $page_sidebar_id = "pixel-industry-sidebar-" . get_the_id();
        } else if (PI_WOOCOMMERCE && is_shop()) {
            $page_sidebar_id = "pixel-industry-sidebar-" . get_option('woocommerce_shop_page_id');
        } else if (PI_WOOCOMMERCE && (is_product() || is_product_tag() || is_product_category())) {
            $page_sidebar_id = 'sidebar-1';
        } else {
            $page_sidebar_id = 'sidebar-1';
        }

        if (!dynamic_sidebar($page_sidebar_id)) :
            // Widget args
            $args = array(
                'before_widget' => '<li class="widget widget_search">',
                'after_widget' => "</li>",
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5>'
            );

            // Call Search Widget
            the_widget('WP_Widget_Search', '', $args);
        endif;
        ?>
    </ul>
</aside><!-- sidebar end -->
