<?php
/*
 * The template for displaying the footer.
 */
global $pi_theme_options;

$show_footer = $pi_theme_options['footer_show'];
$footer_animation = $pi_theme_options['widgets_animation'];
?>
<!-- footer wrapper start -->
<section class="footer-wrapper">
    <?php
    if ($show_footer == 1):
        ?>
        <footer id="footer">
            <!-- .container start -->
            <div class="container">
                <!-- .row start -->
                <div class="row">
                    <!-- animated fadeInTop -->
                    <section <?php if (!empty($footer_animation) && $footer_animation != "disabled") : ?>class="triggerAnimation animated" data-animate="<?php echo $footer_animation ?>" <?php endif; ?>>

                        <?php
                        $widget_areas = $pi_theme_options['footer_widget_areas'];

                        for ($i = 1; $i <= $widget_areas; $i++) {
                            $grid_size = 12 / $widget_areas;
                            ?>
                            <ul class="footer-widget-container grid_<?php echo $grid_size ?>">
                                <?php
                                $sidebarid = 'sidebar-' . ($i + 1);
                                if (!dynamic_sidebar($sidebarid)) :
                                    ?>
                                    <li class="widget">
                                        <h6><?php _e('Widget', 'pi_framework') ?></h6>
                                        <p><?php _e('This is widget area. Set widget here.', 'pi_framework') ?></p>
                                    </li>                                    

                                    <?php
                                endif;
                                ?>

                            </ul>
                        <?php }; ?>
                    </section>
                </div><!-- .row end -->
            </div><!-- .container end -->                
        </footer><!-- .footer-end -->
    <?php endif; ?>
    <!-- copyright container start -->
    <section class="copyright-container">
        <!-- .container start -->
        <div class="container">
            <!-- .row start -->
            <div class="row">
                <section class="grid_6">
                    <p><?php echo $pi_theme_options['copyright_text'] ?></p>
                </section>

                <section class="grid_6 omega">
                    <?php
                    wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'container' => false,
                                'items_wrap' => '<ul id="%1$s" class="%2$s footer-breadcrumbs">%3$s</ul>',
                                'depth' => 1,
                                'fallback_cb' => false,
                                'before' => '',
                                'after' => ''
                            )
                    );
                    ?>
                </section><!-- .grid_6 omega end -->        
            </div><!-- .row end -->
        </div><!-- .container end -->
    </section><!-- .copyright-container end -->

    <?php if ($pi_theme_options['scroll_to_top'] == '1'): ?>
        <a href="#" class="scroll-up"><?php _e('Scroll', 'pi_framework') ?></a>
    <?php endif; ?>
</section><!-- .footer-wrapper end -->

<?php if ($pi_theme_options['website_layout'] == 'boxed'): ?>
    <!-- .page-wrapper start -->
    <div id="page-wrapper" class="clearfix">
    <?php endif; ?>

    <div class="clear"></div>
    <?php wp_footer(); ?>

    <!-- Studen's footer integration -->
    <?php require(OMEKA_URL."shared/header") ?>
    
</body>
</html>
