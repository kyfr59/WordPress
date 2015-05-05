<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
    <?php global $pi_theme_options ?>
    <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        
        <?php if ($pi_theme_options['responsive'] == '1'): ?>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <?php endif; ?>
            
        <meta name="author" content="pixel-industry">
        <title>
            <?php
            /*
             * Print the <title> tag based on what is being viewed.
             */
            global $page, $paged;

            wp_title('|', true, 'right');

            // Add the website name.
            bloginfo('name');

            // Add the website description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && ( is_home() || is_front_page() ))
                echo " | $site_description";

            // Add a page number if necessary:
            if ($paged >= 2 || $page >= 2)
                echo ' | ' . _('Page ', 'pi_framework') . max($paged, $page);
            ?>
        </title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />

        <?php
        global $pi_theme_options, $is_retina;

        if (isset($pi_theme_options['favicon']) && !empty($pi_theme_options['favicon']['url'])):
            ?>
            <!-- favicon -->
            <link rel="shortcut icon" type="image/x-icon" href="<?php echo $pi_theme_options['favicon']['url'] ?>" />
        <?php endif; ?>

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <?php
        /* We add some JavaScript to pages with the comment form
         * to support sites with threaded comments (when in use).
         */
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');

        /*  Important wp_head() hook */
        wp_head();
        ?>
    </head>
    <?php
    // website layout layout
    $website_layout = "layout-" . $pi_theme_options['website_layout'];
    

    // add homepage class
    $homepage = is_front_page() ? 'homepage' : '';

    // custom body classes
    $pi_body_classes = array($website_layout, $homepage);

    // get header style
    $header_style = $pi_theme_options['header_style'];

    // check if search is used
    $header_search = $pi_theme_options['header_search'] == '0' ? 'search-hidden' : '';

    // WPML language flags
    $wpml_language_flags = isset($pi_theme_options['header_wpml_flags']) ? $pi_theme_options['header_wpml_flags'] : false;
    ?>
    <body <?php body_class($pi_body_classes); ?>>

        <link href="<?php echo OMEKA_URL?>themes/studens/shared/shared.css" media="screen" rel="stylesheet" type="text/css" >
        <?php $isWordpress = true; ?>
        <?php require(OMEKA_URL."/shared/header") ?>

        <?php if ($pi_theme_options['website_layout'] == 'boxed'): ?>
            <!-- .page-wrapper start -->
            <div id="page-wrapper" class="clearfix">
            <?php endif; ?>
            <!-- #header-wrapper start -->
            <section id="header-wrapper" class="clearfix header-style-<?php echo $header_style, ' ', $header_search ?>">

                <!-- .top-bar start -->
                <section id="top-bar-wrapper">
                    <div id="top-bar" class="clearfix">
                        <?php if ($pi_theme_options['header_style'] == '1' || $pi_theme_options['header_style'] == '3') { ?>

                            <?php if (isset($pi_theme_options['header_contact']) && is_array($pi_theme_options['header_contact']) && !empty($pi_theme_options['header_contact']['icon'][0])): ?>
                                <ul class="contact-info">
                                    <?php
                                    foreach ($pi_theme_options['header_contact']['icon'] as $index => $icon) {
                                        ?>
                                        <li>
                                            <i class="<?php echo $icon ?>"></i>
                                            <span><?php echo $pi_theme_options['header_contact']['text'][$index] ?></span>
                                        </li>
                                    <?php } ?>
                                </ul><!-- .contact-info end -->
                            <?php endif; ?>                            

                            <?php if (isset($pi_theme_options['header_social_icons']) && is_array($pi_theme_options['header_social_icons']) && !empty($pi_theme_options['header_social_icons']['icon'][0]) && ($pi_theme_options['header_style'] == '1' || $pi_theme_options['header_style'] == '3')): ?>
                                <!--- .social-links start -->
                                <ul class="social-links">
                                    <?php
                                    foreach ($pi_theme_options['header_social_icons']['icon'] as $index => $icon) {
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url($pi_theme_options['header_social_icons']['text'][$index]) ?>" class="<?php echo $icon ?>"></a>
                                        </li>
                                    <?php } ?>
                                </ul><!-- .social-links end -->
                            <?php endif; ?>                                                       

                            <?php if ($wpml_language_flags == '1'): ?>
                                <!-- language selector start -->
                                <div id="wpml-header-language-selector"><?php pi_language_selector_flags(); ?></div ><!-- language selector end -->
                            <?php endif; ?>

                            <?php if (defined('PI_WOOCOMMERCE') && PI_WOOCOMMERCE && isset($pi_theme_options['woo_header_cart']) && $pi_theme_options['woo_header_cart'] == '1'): ?>
                                <?php global $woocommerce ?>
                                <div class="header-cart">
                                    <div class="cart-container icon-cart-3">
                                        <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'pi_framework'); ?>"> <span class="cart-count"><?php $woocommerce->cart->cart_contents_count ?></span> <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php } ?>
                    </div><!-- .top-bar end -->
                </section><!-- .top-bar-wrapper end -->

                <!-- header start -->
                <header id="header" class="clearfix">

                    <!-- logo start -->
                    <section id="logo">
                        <a href="<?php echo home_url(); ?>">
                            <?php
                            $logo_width = '';
                            if ($is_retina && !empty($pi_theme_options['retina_logo']['url'])) {
                                $logo = $pi_theme_options['retina_logo']['url'];
                                $logo_width = $pi_theme_options['logo']['width'];
                            } else if (!empty($pi_theme_options['logo']['url'])) {
                                $logo = $pi_theme_options['logo']['url'];
                                $logo_width = $pi_theme_options['logo']['width'];
                            } else {
                                $logo = TEMPLATEURL . "/img/logo.png";
                                $logo_width = "138";
                            }
                            ?>
                            <img src='<?php echo $logo ?>' alt='<?php bloginfo('name'); ?>' width="<?php echo $logo_width ?>"/>
                        </a>
                    </section><!-- #logo end -->

                    <?php if (isset($pi_theme_options['header_social_icons']) && is_array($pi_theme_options['header_social_icons']) && !empty($pi_theme_options['header_social_icons']['icon'][0]) && $pi_theme_options['header_style'] == '4'): ?>
                        <!--- .social-links start -->
                        <ul class="social-links">
                            <?php
                            foreach ($pi_theme_options['header_social_icons']['icon'] as $index => $icon) {
                                ?>
                                <li>
                                    <a href="<?php echo $pi_theme_options['header_social_icons']['text'][$index] ?>" class="<?php echo $icon ?>"></a>
                                </li>
                            <?php } ?>
                        </ul><!-- .social-links end -->                        

                        <?php if ($wpml_language_flags == '1'): ?>
                            <!-- language selector start -->
                            <div id="wpml-header-language-selector"><?php pi_language_selector_flags(); ?></div ><!-- language selector end -->
                        <?php endif; ?>

                        <?php if (defined('PI_WOOCOMMERCE') && PI_WOOCOMMERCE && isset($pi_theme_options['woo_header_cart']) && $pi_theme_options['woo_header_cart'] == '1'): ?>
                            <?php global $woocommerce ?>
                            <div class="header-cart">
                                <div class="cart-container icon-cart-3">
                                    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'pi_framework'); ?>"> <span class="cart-count"><?php $woocommerce->cart->cart_contents_count ?></span> <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($pi_theme_options['header_search'] == '1' && ($pi_theme_options['header_style'] == '1' || $pi_theme_options['header_style'] == '2' || $pi_theme_options['header_style'] == '3')): ?>
                        <section id="search">
                            <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                                <input id="m_search" name="s" type="text" placeholder="<?php _e('Type and hit enter...', 'pi_framework') ?>" onkeydown="if (event.keyCode == 13) {
                                            this.form.submit();
                                            return false;
                                        }"/>
                                <input class="search-submit" type="submit" />
                            </form>
                        </section>
                    <?php endif; ?>

                    <?php if ($pi_theme_options['header_style'] == '2') { ?>
                        <?php if ($wpml_language_flags == '1'): ?>
                            <!-- language selector start -->
                            <div id="wpml-header-language-selector"><?php pi_language_selector_flags(); ?></div ><!-- language selector end -->
                        <?php endif; ?>

                        <?php if (defined('PI_WOOCOMMERCE') && PI_WOOCOMMERCE && isset($pi_theme_options['woo_header_cart']) && $pi_theme_options['woo_header_cart'] == '1'): ?>
                            <?php global $woocommerce ?>
                            <div class="header-cart">
                                <div class="cart-container icon-cart-3">
                                    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'pi_framework'); ?>"> <span class="cart-count"><?php $woocommerce->cart->cart_contents_count ?></span> <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php } ?>

                    <!-- nav container start -->
                    <section id="nav-container">
                        <!-- main navigation start  -->
                        <nav id="nav">
                            <?php
                            wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'container' => false,
                                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                        'walker' => new Elvyre_Menu_Walker(),
                                        'fallback_cb' => false
                                    )
                            );
                            ?>
                        </nav><!-- main navigation end -->

                        <?php if ($pi_theme_options['header_search'] == '1' && ($pi_theme_options['header_style'] == '4' || $pi_theme_options['header_style'] == '5')): ?>
                            <section id="search">
                                <!-- search start -->
                                <form action="<?php echo esc_url(home_url('/')); ?>" method="get">    
                                    <input class="search-submit" type="submit" />
                                    <input id="m_search" name="s" type="text" placeholder="<?php _e('Type and hit enter...', 'pi_framework') ?>"  onkeydown="if (event.keyCode == 13) {
                                            this.form.submit();
                                            return false;
                                        }"/>
                                </form>
                            </section>
                        <?php endif; ?>

                        <?php if ($pi_theme_options['header_style'] == '5') { ?>
                            <?php if ($wpml_language_flags == '1'): ?>
                                <!-- language selector start -->
                                <div id="wpml-header-language-selector"><?php pi_language_selector_flags(); ?></div ><!-- language selector end -->
                            <?php endif; ?>
                            <?php if (defined('PI_WOOCOMMERCE') && PI_WOOCOMMERCE && isset($pi_theme_options['woo_header_cart']) && $pi_theme_options['woo_header_cart'] == '1'): ?>
                                <?php global $woocommerce ?>
                                <div class="header-cart">
                                    <div class="cart-container icon-cart-3">
                                        <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'pi_framework'); ?>"> <span class="cart-count"><?php $woocommerce->cart->cart_contents_count ?></span> <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php } ?>
                    </section><!-- #nav-container end -->

                    <!-- responsive navigation start -->
                    <div id="dl-menu" class='dl-menuwrapper'>
                        <button class="dl-trigger"><?php _e('Open Menu', 'pi_framework') ?></button>
                        <?php
                        wp_nav_menu(
                                array(
                                    'theme_location' => 'primary',
                                    'container' => false,
                                    'items_wrap' => '<ul id="%1$s" class="%2$s dl-menu">%3$s</ul>',
                                    'walker' => new Elvyre_Responsive_Menu_Walker(),
                                    'fallback_cb' => false
                                )
                        );
                        ?> <!-- responsive navigation end -->
                    </div>                    

                </header><!-- #header end -->
            </section><!-- #header-wrapper start end -->