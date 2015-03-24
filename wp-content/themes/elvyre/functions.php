<?php
/* ---------------------------------------------------
 * Theme: Elvyre - Retina Ready Wordpress Theme
 * Author: Pixel Industry
 * URL: www.pixel-industry.com
  -------------------------------------------------- */

define('TEMPLATEURL', get_template_directory_uri());
define('PI_THEME_DIR', get_template_directory() . '/');

// check if Core plugin and Content Manager is active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('elvyre-core/elvyre-core.php'))
    define('ELVYRE_CORE', true);
else
    define('ELVYRE_CORE', false);

if (is_plugin_active('content-manager/content-manager.php'))
    define('CONTENT_MANAGER', true);
else
    define('CONTENT_MANAGER', false);

// check if WooCommerce is active
$active_plugins = get_option('active_plugins');

if (in_array('woocommerce/woocommerce.php', $active_plugins)) {
    define('PI_WOOCOMMERCE', true);
} else {
    define('PI_WOOCOMMERCE', false);
}

global $pi_theme_options, $is_retina, $cma_relevanssi_post_id;

// verify that user is on device with retina display
if (isset($_COOKIE["elv_device_pixel_ratio"])) {
    $is_retina = ( $_COOKIE["elv_device_pixel_ratio"] >= 2 );
}

/* -------------------------------------------------------------------- 
 * Register and enqueue theme styles
 * -------------------------------------------------------------------- */

if (!function_exists('pi_theme_styles')) {

    function pi_theme_styles() {
        global $pi_theme_options;

        $stylesheet_uri = get_stylesheet_uri();

        wp_deregister_style('basic');
        wp_deregister_style('pixons');
        wp_deregister_style('elv_color_style');
        wp_deregister_style('style');
        wp_deregister_style('rpw-style');

        // check if Content Manager is active and load Bootstrap first
        if (CONTENT_MANAGER) {
            wp_enqueue_style('style', $stylesheet_uri, array('cma-styles-bootstrap'), '1.0', 'screen');
        } else {
            wp_enqueue_style('style', $stylesheet_uri, array(), '1.0', 'screen');
        }

        // check if Content Manager is inactive and load animate.css
        if (!CONTENT_MANAGER || (CONTENT_MANAGER && !cma_get_settings('elements-animation'))) {
            wp_enqueue_style('pi_animate_css', TEMPLATEURL . '/css/animate.css');
        }

        // registering styles
        wp_enqueue_style('grid', TEMPLATEURL . '/css/grid.css', array(), '1.0', 'screen');
        wp_enqueue_style('pixons', TEMPLATEURL . '/includes/pixons/style.css', array(), '1.0', 'screen');
        wp_enqueue_style('icons-font', TEMPLATEURL . '/includes/iconsfont/iconsfont.css', array(), '1.0', 'screen');
        wp_enqueue_style('nivoslider', TEMPLATEURL . "/css/nivo-slider.css", array(), '1.0', 'screen');
        wp_enqueue_style('prettyphoto', TEMPLATEURL . '/css/prettyPhoto.css', array(), '1.0', 'screen');
        wp_enqueue_style('retina_css', TEMPLATEURL . "/css/retina.css", array(), '1.0', 'screen');
        wp_enqueue_style('jplayer', TEMPLATEURL . '/js/jplayer/skin/pixel-industry/pixel-industry.css', array(), '1.0', 'screen');
        wp_enqueue_style('google_fonts', 'http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800,900,200,100%7COpen+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic', array(), null);

        // stylesheet for responsivness
        if ($pi_theme_options['responsive'] == '1') {
            wp_enqueue_style('responsive', TEMPLATEURL . '/css/responsive.css', array('style'), '1.0', 'screen');
        } else {
            wp_enqueue_style('non-responsive', TEMPLATEURL . '/css/non-responsive.css', array('style'), '1.0', 'screen');
        }

        // WooCommerce styles
        if (PI_WOOCOMMERCE) {
            wp_enqueue_style('pi_woocommerce', TEMPLATEURL . '/css/woocommerce-styles.css', array('style'), '1.0', 'screen');
        }
    }

}

add_action('wp_enqueue_scripts', 'pi_theme_styles', 11);

/* -------------------------------------------------------------------- 
 * Load script for custom color styles
 * -------------------------------------------------------------------- */

if (!function_exists('pi_load_color_style')) {

    function pi_load_color_style() {
        global $pi_theme_options;
        // color style
        $pre_color_style = 'darkblue';
        $color_style = $pi_theme_options['custom_color_style'];

        if (empty($color_style)) {
            wp_register_style('color_style', TEMPLATEURL . '/css/' . $pre_color_style . '.css', array('style'), '1.0', 'screen');
        } else {
            // Load Custom color style script.
            wp_register_style('color_style', TEMPLATEURL . '/includes/color-style.php', array('style'), '1.0', 'screen');
        }

        wp_enqueue_style('color_style');
    }

}

add_action('wp_enqueue_scripts', 'pi_load_color_style', 11);


/* -------------------------------------------------------------------- 
 * Load custom styles.
  -------------------------------------------------------------------- */
if (!function_exists('pi_load_custom_styles')) {

    function pi_load_custom_styles() {
        global $pi_theme_options;

        // custom CSS styles
        $custom_styles = isset($pi_theme_options['custom_css']) ? $pi_theme_options['custom_css'] : '';
        if (!empty($custom_styles)) {
            $custom_styles = html_entity_decode($custom_styles);
            wp_enqueue_style('pi_custom_css', TEMPLATEURL . '/includes/custom-styles.php', array('style', 'color_style'), '1.0', 'screen');
        }
    }

}

add_action('wp_enqueue_scripts', 'pi_load_custom_styles', 12);

/* -------------------------------------------------------------------- 
 * Register and enqueue admin syles
 * -------------------------------------------------------------------- */

if (!function_exists('pi_load_admin_styles')) {

    function pi_load_admin_styles() {
        wp_register_style('icons-font', TEMPLATEURL . '/includes/iconsfont/iconsfont.css', array(), '1.0', 'screen');
        wp_register_style('pixons', TEMPLATEURL . '/includes/pixons/style.css', array(), '1.0', 'screen');
        wp_enqueue_style('icons-font');
        wp_enqueue_style('pixons');
    }

}

add_action('admin_enqueue_scripts', 'pi_load_admin_styles');

/* -------------------------------------------------------------------- 
 * Register all scripts which are needed for theme  
 * -------------------------------------------------------------------- */

if (!function_exists('pi_register_scripts')) {

    function pi_register_scripts() {
        if (!is_admin()) {
            global $pi_theme_options;

            /* jQuery Modernizr plugin */
            wp_register_script('modernizr', TEMPLATEURL . '/js/modernizr.custom.js', array('jquery'), '1.0', TRUE);
            /* CarouFredSel carousel plugin */
            wp_register_script('caroufredsel', TEMPLATEURL . '/js/jquery.carouFredSel-6.2.1-packed.js', 'jquery', '1.0', TRUE);
            /* Nivo slider - Image slider */
            wp_register_script('nivoslider', TEMPLATEURL . '/js/jquery.nivo.slider.js', 'jquery', '1.0', TRUE);
            /* jQuery Placeholder plugin */
            wp_register_script('placeholder', TEMPLATEURL . '/js/jquery.placeholder.min.js', 'jquery', '1.0', TRUE);
            /* jPlayer - video player */
            wp_register_script('jplayer', TEMPLATEURL . '/js/jplayer/jquery.jplayer.min.js', array('jquery'), '1.0', TRUE);
            /* Touch Swipe plugin for mobile devices */
            wp_register_script('touchswipe', TEMPLATEURL . '/js/jquery.touchSwipe.min.js', array('jquery'), '1.0', TRUE);
            /* HTML5Shiv plugin for IE6-IE8 */
            wp_register_script('html5shiv', TEMPLATEURL . '/js/html5shiv.js', array('jquery'), '1.0');
            /* jQuery Selectivizr plugin for IE6+ */
            wp_register_script('selectivizr', TEMPLATEURL . '/js/selectivizr-min.js', array('jquery'), '1.0', TRUE);
            /* jQuery Responsive menu plugin */
            wp_register_script('dl-menu', TEMPLATEURL . '/js/jquery.dlmenu.js', array('jquery'), '1.0', TRUE);
            /* jQuery custom scripts and plugins init */
            wp_register_script('isotope', TEMPLATEURL . '/js/jquery.isotope.min.js', array('jquery'), '1.0', TRUE);
            /* jQuery custom scripts and plugins init */
            wp_register_script('images_loaded', TEMPLATEURL . '/js/imagesloaded.pkgd.min.js', array('jquery'), '1.0', TRUE);
            /* jQuery custom scripts and plugins init */
            wp_register_script('pi_include', TEMPLATEURL . '/js/include.js', array('jquery', 'placeholder', 'dl-menu'), '1.0', TRUE);
            /* jQuery custom scripts and plugins init */
            wp_register_script('pi_framework_functions', TEMPLATEURL . '/js/pi-framework.functions.js', array('jquery'), '1.0', FALSE);


            /* Enqueue scripts */
            wp_enqueue_script('jquery');
            wp_enqueue_script('modernizr');
            wp_enqueue_script('touchswipe');
            wp_enqueue_script('dl-menu');
            wp_enqueue_script('pi_include');
            wp_enqueue_script('pi_framework_functions');

            // verify current browser visitor is using
            $IE_version = pi_detect_ie();
            if (isset($IE_version['ie6']) || isset($IE_version['ie7']) || isset($IE_version['ie8'])) {
                wp_enqueue_script('html5shiv');
                wp_enqueue_script('placeholder');
                wp_enqueue_script('selectivizr');
            }

            if (is_home() || is_singular('post') || is_archive() || is_search() || is_singular('product')) {
                wp_enqueue_script('jplayer');
                wp_enqueue_script('nivoslider');
                wp_enqueue_script('isotope');
            }

            // check if Content Manager is inactive and load stellar.js script
            if (!CONTENT_MANAGER || (CONTENT_MANAGER && !cma_get_settings('section-parallax'))) {
                wp_enqueue_script('pi_stellar', TEMPLATEURL . '/js/jquery.stellar.min.js', array('jquery', 'pi_include'), '1.0', TRUE);
            }

            // check if Content Manager is inactive and load waypoints.js script
            if (!CONTENT_MANAGER || (CONTENT_MANAGER && !cma_get_settings('elements-animation'))) {
                wp_enqueue_script('pi_waypoints', TEMPLATEURL . '/js/waypoints.min.js', array('jquery', 'pi_include'), '1.0', TRUE);
            }

            // WooCommerce scripts
            if (PI_WOOCOMMERCE) {
                wp_enqueue_script('pi_woocommerce', TEMPLATEURL . '/js/woocommerce.js', array('jquery'), '1.0', TRUE);
            }

            // pass settings to include.js file
            $parallax = $pi_theme_options['parallax'];
            $static_header = $pi_theme_options['static_header'];
            $retina = $pi_theme_options['retina'];

            wp_localize_script('pi_include', 'PiElvyre', array(
                'parallax' => $parallax,
                'staticHeader' => $static_header,
                'retina' => $retina
            ));
        }
    }

}

add_action('wp_enqueue_scripts', 'pi_register_scripts');


/* -------------------------------------------------------------------- 
 * Set the content width based on the theme's design and stylesheet.
 * -------------------------------------------------------------------- */

if (!isset($content_width))
    $content_width = 600;

/* --------------------------------------------------
 * Load necesarry scripts for proper theme work.
 * -------------------------------------------------- */

if (!function_exists('pi_theme_setup')) {

    function pi_theme_setup() {

        // Add default posts and comments RSS feed links to <head>.
        add_theme_support('automatic-feed-links');

        // Registering Main menu
        register_nav_menu('primary', 'Primary Menu');

        // Registering footer menu
        register_nav_menu('footer', 'Footer Menu');

        // Add support for a variety of post formats
        add_theme_support('post-formats', array('video', 'quote', 'audio', 'gallery', 'link'));

        // Add support for Shortcodes in Widgets
        add_filter('widget_text', 'do_shortcode');

        // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
        add_theme_support('post-thumbnails', array('post', 'product'));

        // adds support for WooCommerce plugin
        add_theme_support('woocommerce');

        // Make theme available for translation
        load_theme_textdomain('pi_framework', PI_THEME_DIR . 'languages');
        $locale = get_locale();
        $locale_file = PI_THEME_DIR . "languages/$locale.php";
        if (is_readable($locale_file))
            require_once( $locale_file );
    }

}

add_action('after_setup_theme', 'pi_theme_setup');

/* -------------------------------------------------------------------- 
 * Load necesarry scripts.
  -------------------------------------------------------------------- */

if (!function_exists('pi_include_scripts')) {

    function pi_include_scripts() {
        // including all scripts required for theme proper work
        require_once(get_template_directory() . '/includes/includes.php');
    }

}
add_action('after_setup_theme', 'pi_include_scripts', 11);

/* ------------------------------------------------------------------
 * Add menu icon to first level menu items.
  ------------------------------------------------------------------- */
if (!function_exists('pi_add_menu_icon')) {

    function pi_add_menu_icon($item) {
        global $pi_theme_options;

        // find selected icons from Theme options and set for each menu item
        if ($item->post_type == 'nav_menu_item' && $item->menu_item_parent == 0) {

            // get icons from theme options
            $menu_icons = isset($pi_theme_options['menu_icons']) ? $pi_theme_options['menu_icons'] : '';

            // if icons is set, add span element before menu item text
            if (!empty($menu_icons[$item->ID]))
                $menu_icon = "<span class='nav-icon {$menu_icons[$item->ID]}'></span>";
            else
                $menu_icon = '';

            return $menu_icon;
        }
    }

}

add_filter('elvyre_menu_icon', 'pi_add_menu_icon');

/* ---------------------------------------------------------
 * Menu Walker
 *
 * Custom Menu Walker with addition of icons.
  ---------------------------------------------------------- */
if (!class_exists('Elvyre_Menu_Walker')) {


    class Elvyre_Menu_Walker extends Walker_Nav_Menu {

        /**
         * Start the element output.
         *
         * @see Walker::start_el()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item   Menu item data object.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         * @param int    $id     Current item ID.
         */
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            global $wp_query;
            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
            //$hide_icons = of_get_option('menu_hide_icons', 0);
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            //$attributes .= $hide_icons ? ' class="no-icons"' : '';

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('elvyre_menu_icon', $item) . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= ($depth == 0) ? '<span>' . $item->description . '</span>' : "";
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

}

/* ---------------------------------------------------------
 * Responsive Menu Walker
 *
 * Custom Responsive Menu Walker.
  ---------------------------------------------------------- */
if (!class_exists('Elvyre_Responsive_Menu_Walker')) {

    class Elvyre_Responsive_Menu_Walker extends Walker_Nav_Menu {

        /**
         * Starts the list before the elements are added.
         *
         * @see Walker::start_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         */
        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"dl-submenu\">\n";
        }

        /**
         * Start the element output.
         *
         * @see Walker::start_el()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item   Menu item data object.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         * @param int    $id     Current item ID.
         */
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            global $wp_query;
            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
            //$hide_icons = of_get_option('menu_hide_icons', 0);
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            //$attributes .= $hide_icons ? ' class="no-icons"' : '';

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('elvyre_menu_icon', $item) . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= ($depth == 0) ? '<span>' . $item->description . '</span>' : "";
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

}

/* -------------------------------------------------------------------------------
 * Breadcrumbs on pages
 *
 * Generates breadcrumbs for all pages except home page.
  ------------------------------------------------------------------------------- */
if (!function_exists('pi_breadcrumbs')) {

    function pi_breadcrumbs() {
        global $pi_theme_options;

        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter = '/'; // delimiter between crumbs
        $home = __('Home', 'pi_framework'); // text for the 'Home' link
        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $before = '<span class="active">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb
        $pre_breadcrumbs = $pi_theme_options['breadcrumbs_prefix'];
        $breadcrumbs_length = $pi_theme_options['breadcrumbs_length'];

        global $post;
        $homeLink = home_url();
        $blog_id = get_option('page_for_posts', true);
        if (get_option('page_for_posts', true)) {
            $blog_page_title = get_the_title(get_option('page_for_posts', true));
            $blog_page_url = get_permalink($blog_id);
            $blog_page_link = "<li><a href='{$blog_page_url}'>{$blog_page_title}</a> {$delimiter}</li>";
        } else {
            $blog_page_link = '';
        }

        if (is_front_page()) {
            if ($showOnHome == 1)
                echo '<div class="breadcrumbs"><ul><li>' . $pre_breadcrumbs . '</li><li><a href="' . $homeLink . '" class="home">Home</a></li><li class="home-icon"><a href="' . $homeLink . '" title="' . $home . '"></a></li></ul></div>';
        } elseif (is_home()) {
            $blog_page_title = get_the_title(get_option('page_for_posts', true));
            echo '<div class="breadcrumbs"><ul><li>' . $pre_breadcrumbs . '</li><li><a href="' . $homeLink . '" class="home">Home</a></li><li class="home-icon"><a href="' . $homeLink . '" title="' . $home . '"></a> /</li><li>' . $before . $blog_page_title . $after . '</li></ul></div>';
        } else {

            echo '<div class="breadcrumbs"><ul><li>' . $pre_breadcrumbs . '</li><li><a href="' . $homeLink . '" class="home">Home</a></li><li class="home-icon"><a href="' . $homeLink . '" title="' . $home . '"></a> ' . $delimiter . '</li> ';

            if (is_category()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0)
                    echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
                echo $blog_page_link;
                echo '<li>' . $before . 'Category: "' . single_cat_title('', false) . '"' . $after . '</li>';
            } elseif (is_search()) {
                echo '<li>' . $before . 'Search results: "' . get_search_query() . '"' . $after . '</li>';
            } elseif (is_day()) {
                echo $blog_page_link;
                echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
                echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . '</li> ';
                echo '<li>' . $before . get_the_time('d') . $after . '</li>';
            } elseif (is_month()) {
                echo $blog_page_link;
                echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
                echo '<li>' . $before . get_the_time('F') . $after . '</li>';
            } elseif (is_year()) {
                echo $blog_page_link;
                echo '<li>' . $before . get_the_time('Y') . $after . '</li>';
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    if ($post_type->name == 'pi_portfolio') {
                        // Get Product page ID from Theme options
                        $portfolio_page_id = isset($pi_theme_options['portfolio_page']) ? $pi_theme_options['portfolio_page'] : '';
                        if (!empty($portfolio_page_id)) {
                            $page_name = get_the_title($portfolio_page_id);
                            $page_url = get_permalink($portfolio_page_id);
                            $page_name = _substr($page_name, $breadcrumbs_length, 3);
                            echo "<li><a href='{$page_url}'>{$page_name}</a> {$delimiter} </li>";
                        }

                        if ($showCurrent == 1)
                            echo ' <li>' . $before . get_the_title() . $after . '</li>';
                    } else {
                        $post_type = get_post_type_object(get_post_type());
                        $title = _substr($post_type->labels->singular_name, $breadcrumbs_length, 3);
                        echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/" title="' . $home . '">' . $title . '</a></li>';
                        if ($showCurrent == 1) {
                            $title = _substr(get_the_title(), $breadcrumbs_length, 3);
                            echo ' <li>' . $delimiter . ' ' . $before . $title . $after . '</li>';
                        }
                    }
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                    if ($showCurrent == 0)
                        $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                    echo $blog_page_link;
                    echo '<li>' . $cats . '</li>';
                    if ($showCurrent == 1) {
                        $title = _substr(get_the_title(), $breadcrumbs_length, 3);
                        echo '<li>' . $before . $title . $after . '</li>';
                    }
                }
            } elseif (is_tax()) {
                $taxonomy = get_taxonomy(get_query_var('taxonomy'));
                $post_type = $taxonomy->object_type[0];
                $post_type_object = get_post_type_object($post_type);
                $post_type_title = $post_type_object->label;
                $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                $page_url = "";

                if ($post_type == 'pi_portfolio') {
                    // Get Product page ID from Theme options
                    $portfolio_page_id = $pi_theme_options['portfolio_page'];
                    if (!empty($portfolio_page_id)) {
                        $page_name = get_the_title($portfolio_page_id);
                        $page_name = _substr($page_name, $breadcrumbs_length, 3);
                        $page_url = get_permalink($portfolio_page_id);
                        echo "<li><a href='{$page_url}'>{$page_name}</a> {$delimiter} </li>";
                    }
                }
                echo "<li>{$before}{$term->name}{$after}</li>";
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                $title = _substr($post_type->labels->singular_name, $breadcrumbs_length, 3);
                echo '<li>' . $before . $title . $after . '</li>';
            } elseif (is_attachment()) {

                $parent = get_post($post->post_parent);

                if (!empty($parent)) {
                    $parent_title = _substr($parent->post_title, $breadcrumbs_length, 3);
                    echo '<li><a href="' . get_permalink($parent) . '">' . $parent_title . '</a></li>';
                    if ($showCurrent == 1) {
                        $att_title = substr(get_the_title(), 0, $breadcrumbs_length);
                        echo ' <li>' . $delimiter . ' ' . $before . $att_title . $after . '</li>';
                    }
                }
            } elseif (is_page() && !$post->post_parent) {
                if ($pi_theme_options['breadcrumbs_navigation_label'] == '1') {
                    $menu_id = get_nav_menu_locations();
                    $menu = wp_get_nav_menu_items($menu_id['primary'], array(
                        'posts_per_page' => -1,
                        'meta_key' => '_menu_item_object_id',
                        'meta_value' => $post->ID // the currently displayed post
                    ));

                    if (!empty($menu[0]->title)) {
                        $page_title = $menu[0]->title;
                    } else {
                        $page_title = get_the_title();
                    }
                } else {
                    $page_title = get_the_title();
                }
                $page_title = _substr($page_title, $breadcrumbs_length, 3);

                if ($showCurrent == 1)
                    echo '<li>' . $before . $page_title . $after . '</li>';
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                $navigation_label = $pi_theme_options['breadcrumbs_navigation_label'];
                $menu_id = get_nav_menu_locations();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($navigation_label == '1') {
                        $menu = wp_get_nav_menu_items($menu_id['primary'], array(
                            'posts_per_page' => -1,
                            'meta_key' => '_menu_item_object_id',
                            'meta_value' => $page->ID // the currently displayed page
                        ));

                        if (!empty($menu)) {
                            $title = _substr($menu[0]->title, $breadcrumbs_length, 3);
                            $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . $title . '</a></li>';
                        } else {
                            $title = _substr(get_the_title($page->ID), $breadcrumbs_length, 3);
                            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . $title . '</a>';
                        }
                    } else {
                        $title = _substr(get_the_title($page->ID), $breadcrumbs_length, 3);
                        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . $title . '</a>';
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    if ($i != count($breadcrumbs) - 1) {
                        echo '<li>' . $breadcrumbs[$i] . $delimiter . '</li>';
                    } else {
                        echo '<li>' . $breadcrumbs[$i] . '</li>';
                    }
                }
                if ($navigation_label == '1') {
                    $menu = wp_get_nav_menu_items($menu_id['primary'], array(
                        'posts_per_page' => -1,
                        'meta_key' => '_menu_item_object_id',
                        'meta_value' => $post->ID // the currently displayed post
                    ));
                    if ($showCurrent == 1) {
                        if (!empty($menu)) {
                            $title = _substr($menu[0]->title, $breadcrumbs_length, 3);
                            echo ' <li>' . $delimiter . ' ' . $before . $title . $after . '</li>';
                        } else {
                            $title = _substr(get_the_title(), $breadcrumbs_length, 3);
                            echo ' <li>' . $delimiter . ' ' . $before . $title . $after . '</li>';
                        }
                    }
                } else {
                    if ($showCurrent == 1) {
                        $title = _substr(get_the_title(), $breadcrumbs_length, 3);
                        echo ' <li>' . $delimiter . ' ' . $before . $title . $after . '</li>';
                    }
                }
            } elseif (is_tag()) {
                echo '<li>' . $before . __('Tag:', 'pi_framework') . ' "' . single_tag_title('', false) . '"' . $after . '</li>';
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo $blog_page_link;
                echo '<li>' . $before . __('Author: ', 'pi_framework') . $userdata->display_name . $after . '</li>';
            } elseif (is_404()) {
                echo '<li>' . $before . __('Error 404', 'pi_framework') . $after . '</li>';
            }

            if (get_query_var('paged')) {
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo ' (';
                echo '<li> - ' . __('Page', 'pi_framework') . ' ' . get_query_var('paged') . '</li>';
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo ')';
            }

            echo '</ul></div>';
        }
    }

}

/* -------------------------------------------------------------------------------
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
  ------------------------------------------------------------------------------- */
if (!function_exists('pi_excerpt_length')) {

    function pi_excerpt_length($length) {
        return 40;
    }

}
add_filter('excerpt_length', 'pi_excerpt_length');

/* -------------------------------------------------------------------
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
  ------------------------------------------------------------------- */
if (!function_exists('pi_page_menu_args')) {

    function pi_page_menu_args($args) {
        $args['show_home'] = true;
        return $args;
    }

}
add_filter('wp_page_menu_args', 'pi_page_menu_args');

/* ----------------------------------------
 * Adds Google Analytics code in footer 
  ---------------------------------------- */
if (!function_exists('pi_google_analytics')) {

    function pi_google_analytics() {
        global $pi_theme_options;

        $analytics = isset($pi_theme_options['tracking_code']) ? $pi_theme_options['tracking_code'] : false;
        if (!empty($analytics))
            echo $analytics;
    }

}
add_action('wp_footer', 'pi_google_analytics');

/* ----------------------------------------
 * Tags widget customizations
  ---------------------------------------- */
if (!function_exists('pi_tag_cloud_args')) {

    function pi_tag_cloud_args($args) {
        $args['smallest'] = 11;
        $args['largest'] = 11;
        $args['unit'] = "px";
        return $args;
    }

}
add_filter('widget_tag_cloud_args', 'pi_tag_cloud_args');

/* -------------------------------------------------
 * Register our sidebars and widgetized areas. 
 * Also register the default Epherma widget.
  ------------------------------------------------- */
if (!function_exists('pi_widgets_init')) {

    function pi_widgets_init() {
        global $wpdb;

        register_sidebar(array(
            'name' => __('Main Sidebar', 'pi_framework'),
            'id' => 'sidebar-1',
            'description' => __('Blog page widget area', 'pi_framework'),
            'before_widget' => '<li id="%1$s" class="widget %2$s clearfix">',
            'after_widget' => "</li>",
            'before_title' => '<div class="title"><h6>',
            'after_title' => '</h6></div>',
        ));

        register_sidebar(array(
            'name' => __('Footer Area One', 'pi_framework'),
            'id' => 'sidebar-2',
            'description' => __('An optional widget area for your site footer', 'pi_framework'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => "</li>",
            'before_title' => '<div class="title"><h6>',
            'after_title' => '</h6></div>'
        ));

        register_sidebar(array(
            'name' => __('Footer Area Two', 'pi_framework'),
            'id' => 'sidebar-3',
            'description' => __('An optional widget area for your site footer', 'pi_framework'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => "</li>",
            'before_title' => '<div class="title"><h6>',
            'after_title' => '</h6></div>'
        ));

        register_sidebar(array(
            'name' => __('Footer Area Three', 'pi_framework'),
            'id' => 'sidebar-4',
            'description' => __('An optional widget area for your site footer', 'pi_framework'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => "</li>",
            'before_title' => '<div class="title"><h6>',
            'after_title' => '</h6></div>'
        ));

        register_sidebar(array(
            'name' => __('Footer Area Four', 'pi_framework'),
            'id' => 'sidebar-5',
            'description' => __('An optional widget area for your site footer', 'pi_framework'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => "</li>",
            'before_title' => '<div class="title"><h6>',
            'after_title' => '</h6></div>'
        ));

        // create sidebar for pages with left or right sidebar
        $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts AS posts, $wpdb->postmeta AS meta WHERE meta.post_id = posts.ID AND meta.meta_key = 'pg_sidebar' AND meta.meta_value IN ('left', 'right')");
        foreach ($post_ids as $id) {
            $post = get_post(intval($id));

            $sidebar_title = $post->post_title;
            $sidebar_id = "pixel-industry-sidebar-" . $post->ID;
            register_sidebar(array(
                'name' => $sidebar_title,
                'id' => $sidebar_id,
                'description' => __('An optional widget area for page ', 'pi_framework') . $sidebar_title,
                'before_widget' => '<li id="%1$s" class="widget %2$s clearfix">',
                'after_widget' => "</li>",
                'before_title' => '<div class="title"><h5>',
                'after_title' => '</h5></div>'
            ));
        }
    }

}
add_action('widgets_init', 'pi_widgets_init');

/* -----------------------------------------
 * Template for comments and pingbacks.
  ----------------------------------------- */

if (!function_exists('pi_render_comment')) {

    function pi_render_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) {
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p>
                        <?php _e('Pingback', 'pi_framework'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'pi_framework'), '<span class="edit-link">', '</span>'); ?>
                    </p>
                    <?php
                    break;
                default :
                    ?>
                <li id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment">
                        <div class="avatar">                            
                            <?php
                            $avatar_size = 87;
                            echo get_avatar($comment, $avatar_size);
                            ?>                            
                        </div>
                        <ul class="comment-meta">
                            <li>
                                <a href="<?php get_comment_author_link(); ?>" class="author"><?php comment_author(); ?></a>
                            </li>
                            <li class="comment-timestamp">
                                <?php
                                echo get_comment_date() . " at ";
                                comment_time();
                                ?>  
                            </li>                            
                        </ul>

                        <div class="comment-body">
                            <?php
                            comment_text();
                            comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'pi_framework'), 'depth' => $depth, 'max_depth' => $args['max_depth'])));
                            ?>
                        </div> 
                    </article><!-- #comment-## -->
                    <?php
                    break;
            }
        }

    }

    /* -----------------------------------------
     * Comment Form styling
      ----------------------------------------- */

    if (!function_exists('pi_get_comment_form')) {

        function pi_get_comment_form($fields) {

            // get current commenter data
            $commenter = wp_get_current_commenter();

            // check if field is required
            $req = get_option('require_name_email');
            $aria_req = ( $req ? " aria-required='true' required" : '' );

            // change fields style
            $fields['fields']['author'] = '<fieldset class="name-container"><label for="comment-name">' . __('Name:', 'pi_framework') . ($req ? ' <span class="text-color">*</span>' : '') . '</label>' .
                    '<input type="text" name="author" class="name" id="comment-name" value="' . esc_attr($commenter['comment_author']) . '" size="22" tabindex="1"' . $aria_req . '/></fieldset>';

            $fields['fields']['email'] = '<fieldset class="email-container"><label for="comment-email">' . __('E-Mail:', 'pi_framework') . ($req ? ' <span class="text-color">*</span>' : '') . '</label>' .
                    '<input type="email" name="email" class="email" id="comment-email" value="' . esc_attr($commenter['comment_author_email']) . '" size="22" tabindex="2" ' . $aria_req . '/></fieldset>';

            $fields['fields']['url'] = '';

            $fields['comment_field'] = '<fieldset class="message"><label for="comment-message">' . __('Message:', 'pi_framework') . ($req ? ' <span class="text-color">*</span>' : '') . '</label><textarea name="comment" class="comment-text" id="comment-message" rows="8" tabindex="4" aria-required="true" required></textarea></fieldset>';

            $fields['comment_notes_before'] = '';
            $fields['comment_notes_after'] = '<p class="reguired-fields">' . __('Required fields are marked ', 'pi_framework') . '<span class="text-color">*</span></p>';
            $fields['cancel_reply_link'] = ' - ' . __('Cancel reply', 'pi_framework');
            $fields['title_reply'] = __('Leave a comment', 'pi_framework');
            $fields['id_submit'] = 'comment-reply';
            $fields['label_submit'] = __('Submit', 'pi_framework');

            return $fields;
        }

    }

    add_filter('comment_form_defaults', 'pi_get_comment_form');

    /* -----------------------------------------
     * Paginate function for Blog and Portfolio
      ----------------------------------------- */
    if (!function_exists('pi_pagination')) {

        function pi_pagination($location) {
            global $wp_query, $pi_theme_options, $wp_rewrite;

            $pages = '';
            $pagination = '';
            $max = $wp_query->max_num_pages;

            // if variable paged isn't set
            if (!$current = get_query_var('paged'))
                $current = 1;

            // set parameters
            $args = array(
                'base' => str_replace(999999999, '%#%', get_pagenum_link(999999999)),
                'format' => '',
                'total' => $max,
                'current' => $current,
                'show_all' => true,
                'type' => 'array',
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
                'prev_next' => false,
                'mid_size' => 3,
                'end_size' => 1
            );

            if ($location == 'portfolio') {
                $args['base'] = @add_query_arg('page', '%#%');

                // check if permalinks are used
                if ($wp_rewrite->using_permalinks())
                    $args['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
                if (!empty($wp_query->query_vars['s']))
                    $args['add_args'] = array('s' => get_query_var('s'));
            }

            $previous_label = __('&#60; Previous', 'pi_framework');
            $next_label = __('Next &#62;', 'pi_framework');

            // previous and next links html
            $prev_page_link = $current == 1 ? "" : "<li><a class='icon-double-angle-left' href='" . get_pagenum_link($current - 1) . "'></a></li>";
            $next_page_link = $current == $max ? "" : "<li><a class='icon-double-angle-right' href='" . get_pagenum_link($current + 1) . "'></a></li>";

            // get page link
            $pagination_links = paginate_links($args);

            // get page indicator format from theme options
            $page_indicator = $pi_theme_options['pagination'];
            $page_indicator = str_replace('%current%', '%1$d', $page_indicator);
            $page_indicator = str_replace('%total%', '%2$d', $page_indicator);
            $page_indicator = sprintf($page_indicator, $current, $max);

            // loop through pages
            if (!empty($pagination_links)) {
                foreach ($pagination_links as $index => $link) {
                    $link = str_replace('</span>', '</a>', $link);
                    $link = str_replace('<span', '<a', $link);

                    $pagination .= "<li " . (($index + 1) == $current ? "class='active'>" : ">") . $link . "</li>";
                }
            }

            // if there is more then one page send html to browser
            if ($max > 1) {
                if ($location == 'portfolio') {
                    $container = 'div';
                } else {
                    $container = 'li';
                }

                echo "<{$container} class='pagination'>
                        <ul>                        
                        <li class='current-page'>
                            <span>{$page_indicator}</span>
                        </li>
                        {$prev_page_link}
                        {$pagination}
                        {$next_page_link}
                        </ul>
                      </{$container}>";
            }
        }

    }

    /* --------------------------------------------------------------
     * Portfolio taxonomy archive.
     * Set posts_per_page variable based on value from Theme options.
     * -------------------------------------------------------------- */

    if (!function_exists('pi_portfolio_set_posts_per_page')) {

        function pi_portfolio_set_posts_per_page($query) {
            if (!is_admin() && $query->is_tax() && ( $query->is_archive() )) {
                $taxonomy_vars = $query->query_vars;
                if (isset($taxonomy_vars['portfolio-category']))
                    $tax = 'portfolio';

                if (!empty($tax)) {
                    $posts_per_page = $pi_theme_options['portfolio_pagination'];
                    $query->set('posts_per_page', $posts_per_page);
                    $query->set('post_type', "pi_" . $tax);
                }
            }

            return $query;
        }

    }

    add_action('pre_get_posts', 'pi_portfolio_set_posts_per_page');

    /* -----------------------------------------
     * Verify audio file type
      ----------------------------------------- */
    if (!function_exists('pi_verify_audio_post_format_files')) {

        function pi_verify_audio_post_format_files($audio_string) {
            $audio_urls = preg_split('/\r\n|[\r\n]/', $audio_string[0]);
            $allowed_formats = array('m4a', 'webma', 'oga', 'fla', 'wav', 'ogg');
            $valid_urls = array();
            foreach ($audio_urls as $url) {
                $audio_format = substr($url, strrpos($url, '.') + 1);
                if (in_array($audio_format, $allowed_formats)) {
                    if ($audio_format == 'ogg')
                        $audio_format = 'oga';
                    $valid_urls[$audio_format] = $url;
                }
            }
            return $valid_urls;
        }

    }
    add_filter('pi_verify_post_audio', 'pi_verify_audio_post_format_files');

    /**
     *
     * Intercept Simple Share Buttons Adder output.
     *
     */
    if (!function_exists('pi_remove_ssba_from_content')) {

        function pi_remove_ssba_from_content($content, $using_shortcode) {
            global $pi_theme_options;

            $slider_size = $pi_theme_options['portfolio_slider_size'];

            if (!$using_shortcode && (is_page() || (is_singular('pi_portfolio') && $slider_size == 12))) {
                $content = "<section class='page-content'>"
                        . "<section class='container'>"
                        . "<div class='row'>"
                        . "<div class='grid_12'>"
                        . $content
                        . "</div></seection></section>";
            }

            return $content;
        }

    }
    if (shortcode_exists('ssba')) {
        add_filter('ssba_html_output', 'pi_remove_ssba_from_content', 10, 2);
    }

    /**
     * Filter that adds slashes to layout data before it's imported.
     */
    if (!function_exists('pi_import_post_meta')) {

        function pi_import_post_meta($post_meta) {
            foreach ($post_meta as $index => $meta) {
                if ($meta['key'] == 'cma_layout_data') {
                    $post_meta = wp_slash($post_meta);
                }
            }
            return $post_meta;
        }

    }
    if (!CONTENT_MANAGER)
        add_filter('wp_import_post_meta', 'pi_import_post_meta');

    /*

     * Content Manager settings from Theme Options
     *              
     */
    if (!function_exists('pi_content_manager_settings')) {

        function pi_content_manager_settings($settings) {
            global $pi_theme_options;

            $settings['post-types'] = $pi_theme_options['cma_post_types'];
            $settings['elements-animation'] = $pi_theme_options['cma_elements_animations'] == "1";
            $settings['elements-animation-offset'] = $pi_theme_options['cma_elements_animation_offset'];
            $settings['section-parallax'] = $pi_theme_options['cma_parallax'] == "1";
            $settings['data-stellar-background-ratio'] = $pi_theme_options['cma_parallax_background_ratio'];
            $settings['prebuilt_post_types'] = $pi_theme_options['cma_prebuilt_post_types'];
            $settings['show_settings'] = false;
            $settings['dev-mode'] = false;

            return $settings;
        }

    }
    if (CONTENT_MANAGER) {
        add_filter('cma_global_settings', 'pi_content_manager_settings');
    }

    /*

     * Echoes WPML flags in header.
     *              
     */
    if (!function_exists('pi_language_selector_flags')) {

        function pi_language_selector_flags() {
            // check if WPML is active
            if (function_exists('icl_get_languages')) {
                $languages = icl_get_languages('skip_missing=0&orderby=code');
                if (!empty($languages)) {
                    foreach ($languages as $l) {
                        if (!$l['active'])
                            echo '<a href="' . $l['url'] . '">';
                        echo '<img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18" />';
                        if (!$l['active'])
                            echo '</a>';
                    }
                }
            }
        }

    }

    /**
     * Compatibility with Relevanssi - A Better Search plugin
     * 
     * @global int $cma_relevanssi_post_id
     * @param string $content
     * @param object $post
     * @return string
     */
    if (!function_exists('pi_relevanssi_compatibility_fix')) {

        function pi_relevanssi_compatibility_fix($content, $post) {
            global $cma_relevanssi_post_id;

            $cma_relevanssi_post_id = $post->ID;

            return $content;
        }

    }

    add_filter('relevanssi_post_content', 'pi_relevanssi_compatibility_fix', 10, 2);

    /* ----------------------------------------------------------------------------- */
    /*  Change default image sizes for products
     * 
     * @return void
     * ----------------------------------------------------------------------------- */
    global $pagenow;

    if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
        add_action('init', 'pi_woocommerce_change_default_image_sizes', 1);
    }

    if (!function_exists('pi_woocommerce_change_default_image_sizes')) {

        function pi_woocommerce_change_default_image_sizes() {

            $catalog = array(
                'width' => '269',
                'height' => '329',
                'crop' => 1
            );

            $single = array(
                'width' => '562',
                'height' => '687',
                'crop' => 1
            );

            $thumbnail = array(
                'width' => '173',
                'height' => '173',
                'crop' => 1
            );

            // Product category thumbs
            update_option('shop_catalog_image_size', $catalog);
            // Single product image
            update_option('shop_single_image_size', $single);
            // Image gallery thumbs
            update_option('shop_thumbnail_image_size', $thumbnail);
        }

    }

    add_filter('widget_text', 'php_text', 99);
    function php_text($text) {
    if (strpos($text, '<' . '?') !== false) {
    ob_start();
    eval('?' . '>' . $text);
    $text = ob_get_contents();
    ob_end_clean();
    }
    return $text;
}

    ?>