<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */
if (!class_exists("Redux_Framework_sample_config")) {

    class Redux_Framework_sample_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            // This is needed. Bah WordPress bugs.  ;)
            if (defined('TEMPLATEPATH') && strpos(Redux_Helpers::cleanFilePath(__FILE__), Redux_Helpers::cleanFilePath(TEMPLATEPATH)) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }

        public function initSettings() {

            if (!class_exists("ReduxFramework")) {
                return;
            }

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            if (CONTENT_MANAGER)
                add_filter("redux/options/pi_theme_options/sections", 'cma_settings_fields');

            // get active plugins and check if WooCommerce is active
            $active_plugins = get_option('active_plugins');

            if (in_array('woocommerce/woocommerce.php', $active_plugins)) {
                add_filter("redux/options/pi_theme_options/sections", array($this, 'pi_woocommerce_options'));
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function pi_get_icon_fonts_section() {
            ob_start();
            wp_nonce_field();
            ?>
            <form action="" method="post">
                <p>Text</p>
                <input name="save" type="submit" value="Save a file" />
            </form>
            <?php
            $html = ob_get_clean();
            return $html;
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;


            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
                'title' => __('Home page', 'pi_framework'),
                'icon' => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(
                    array(
                        'id' => 'home_slider',
                        'type' => 'checkbox',
                        'title' => __('Show Slider On Homepage', 'pi_framework'),
                        'subtitle' => __('Note that Homepage must be set in Setttings->Reading.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'home_slider_id',
                        'type' => 'text',
                        'title' => __('Revolution Slider Alias', 'pi_framework'),
                        'subtitle' => __('Enter Revolution slider Alias.', 'pi_framework'),
                        'validate' => 'no_html'
                    )
                ),
            );



            $this->sections[] = array(
                'type' => 'divide',
            );


            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => __('General Settings', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'page_comments',
                        'type' => 'checkbox',
                        'title' => __('Page comments', 'pi_framework'),
                        'subtitle' => __('Disable comments on all pages.', 'pi_framework'),
                        'default' => '0'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'pagination',
                        'type' => 'text',
                        'title' => __('Pagination format', 'pi_framework'),
                        'subtitle' => __('Enter Blog and Portfolio pagination format. %current% - current page, %total% - total pages.', 'pi_framework'),
                        'default' => 'Page %current% of %total%',
                    ),
                    array(
                        'id' => 'tracking_code',
                        'type' => 'textarea',
                        'title' => __('Tracking Code', 'pi_framework'),
                        'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'pi_framework'),
                        'default' => ''
                    )
                )
            );



            $this->sections[] = array(
                'icon' => 'el-icon-tint',
                'title' => __('Appearance', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'website_layout',
                        'type' => 'select',
                        'title' => __('Layout', 'pi_framework'),
                        'subtitle' => __('Boxed or stretched layout.', 'pi_framework'),
                        'options' => array('boxed' => 'Boxed', 'stretched' => 'Stretched'),
                        'default' => 'stretched',
                    ),
                    array(
                        'id' => 'body-background',
                        'type' => 'background',
                        'required' => array('website_layout', '=', 'boxed'),
                        'output' => array('body'),
                        'title' => __('Body Background', 'pi_framework'),
                        'subtitle' => __('Body background with image, color, etc.', 'pi_framework'),
                        'default' => array('background-image' => TEMPLATEURL . "/img/pattern-2.png"),
                    ),
                    array(
                        'id' => 'container_border',
                        'type' => 'border',
                        'required' => array('website_layout', '=', 'boxed'),
                        'title' => __('Container border', 'pi_framework'),
                        'subtitle' => __('Set content container border style.', 'pi_framework'),
                        'output' => array('#page-wrapper'), // An array of CSS selectors to apply this font style to
                        'default' => array('border-color' => '#444', 'border-style' => 'solid', 'border-top' => '0', 'border-right' => '1px', 'border-bottom' => '1px', 'border-left' => '1px')
                    ),
                    array(
                        'id' => 'custom_color_style',
                        'type' => 'color',
                        'output' => array('.site-title'),
                        'title' => __('Custom Color Style', 'pi_framework'),
                        'subtitle' => __('Set custom color that will be applied to all elements..', 'pi_framework'),
                        'default' => '',
                        'validate' => 'color',
                    ),
                    array(
                        'id' => 'favicon',
                        'type' => 'media',
                        'title' => __('Favicon', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Upload favicon for your website.', 'pi_framework'),
                    ),
                    array(
                        'id' => 'scroll_to_top',
                        'type' => 'checkbox',
                        'title' => __('Scroll to Top', 'pi_framework'),
                        'subtitle' => __('Show Scroll to Top button for easier navigation.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'responsive',
                        'type' => 'checkbox',
                        'title' => __('Responsive', 'pi_framework'),
                        'subtitle' => __('Unheck to disable responsivness.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'parallax',
                        'type' => 'checkbox',
                        'title' => __('Parallax', 'pi_framework'),
                        'subtitle' => __('Enable parallax effect (page title and portfolio single).', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'retina',
                        'type' => 'checkbox',
                        'title' => __('HiDPI images', 'pi_framework'),
                        'subtitle' => __('Enable HiDPI images feature (Retina).', 'pi_framework'),
                        'default' => '0'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'custom_css',
                        'type' => 'textarea',
                        'title' => __('Custom CSS', 'pi_framework'),
                        'subtitle' => __('Quickly add some CSS to your theme by adding it to this block.', 'pi_framework'),
                        'validate' => 'css',
                        'output' => 'body'
                    )
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => __('Header', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'header_style',
                        'type' => 'select_image',
                        'title' => __('Style', 'pi_framework'),
                        'subtitle' => __('Select header style.', 'pi_framework'),
                        'options' => array(
                            '1' => array('alt' => 'Header 1 (default)', 'img' => TEMPLATEURL . '/img/theme-options/header-1.jpg'),
                            '2' => array('alt' => 'Header 2', 'img' => TEMPLATEURL . '/img/theme-options/header-2.jpg'),
                            '3' => array('alt' => 'Header 3', 'img' => TEMPLATEURL . '/img/theme-options/header-3.jpg'),
                            '4' => array('alt' => 'Header 4', 'img' => TEMPLATEURL . '/img/theme-options/header-4.jpg'),
                            '5' => array('alt' => 'Header 5', 'img' => TEMPLATEURL . '/img/theme-options/header-5.jpg')
                        ), //Must provide key => value(array:title|img) pairs for radio options
                        'default' => '1'
                    ),
                    array(
                        'id' => 'static_header',
                        'type' => 'checkbox',
                        'title' => __('Static', 'pi_framework'),
                        'subtitle' => __('Make header static.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'header_search',
                        'type' => 'checkbox',
                        'title' => __('Search', 'pi_framework'),
                        'subtitle' => __('Show search button.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'header_wpml_flags',
                        'type' => 'checkbox',
                        'title' => __('WPML Flags', 'pi_framework'),
                        'subtitle' => __('Show WPML language flags in header.', 'pi_framework'),
                        'default' => '0'
                    ),
                    array(
                        'id' => 'logo',
                        'type' => 'media',
                        'title' => __('Logo', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Upload logo for your website.', 'pi_framework')
                    ),
                    array(
                        'id' => 'retina_logo',
                        'type' => 'media',
                        'title' => __('HiDPI Logo', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Upload HiDPI (Retina) logo for your website.', 'pi_framework'),
                        'required' => array('retina', 'equals', '1'),
                    ),
                    array(
                        'id' => 'header_social_icons',
                        'type' => 'select_text',
                        'title' => __('Social Icons', 'pi_framework'),
                        'subtitle' => __('Add social icons to header.', 'pi_framework'),
                        'icons' => pi_get_pixons_names()
                    ),
                    array(
                        'id' => 'menu_icons',
                        'type' => 'select_label',
                        'title' => __('Menu Icons', 'pi_framework'),
                        'subtitle' => __('Add icons to menu items.', 'pi_framework'),
                        'icons' => pi_icons_font_names(),
                        'options' => pi_get_top_level_menu_items('primary'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'header_contact',
                        'type' => 'select_text',
                        'title' => __('Header Contact Text', 'pi_framework'),
                        'subtitle' => __('Icon and text will be rendered above menu.', 'pi_framework'),
                        'icons' => pi_icons_font_names()
                    )
            ));

            $this->sections[] = array(
                'icon' => 'el-icon-tint',
                'title' => __('Page title', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'title_text_color',
                        'type' => 'color',
                        'title' => __('Text color', 'pi_framework'),
                        'subtitle' => __('Set custom text color for page title.', 'pi_framework'),
                        'default' => '#39414b',
                        'validate' => 'color',
                        'output' => array('.pt-title h1'),
                        'mode' => 'color'
                    ),
                    array(
                        'id' => 'title_text_background_color',
                        'type' => 'color',
                        'title' => __('Text background color', 'pi_framework'),
                        'subtitle' => __('Set custom text background color for page title.', 'pi_framework'),
                        'default' => '',
                        'validate' => 'color',
                        'output' => array('.pt-title h1'),
                        'mode' => 'background-color'
                    ),
                    array(
                        'id' => 'title_animation',
                        'type' => 'select',
                        'title' => __('Title Animation', 'pi_framework'),
                        'subtitle' => __('Set title animation.', 'pi_framework'),
                        'options' => pi_animate_css_animations(),
                        'default' => 'disabled',
                    ),
                    array(
                        'id' => 'animated_image_animation',
                        'type' => 'select',
                        'title' => __('Animated image animation', 'pi_framework'),
                        'subtitle' => __('Set animation for animated image.', 'pi_framework'),
                        'options' => pi_animate_css_animations(),
                        'default' => 'disabled',
                    ),
                    array(
                        'id' => '21',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'show_breadcrumbs',
                        'type' => 'switch',
                        'title' => __('Breadcrumbs', 'pi_framework'),
                        'subtitle' => __('Set breadcrumbs visibility.', 'pi_framework'),
                        "default" => 1,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),
                    array(
                        'id' => 'breadcrumbs_navigation_label',
                        'type' => 'checkbox',
                        'required' => array('show_breadcrumbs', '=', '1'),
                        'title' => __('Breadcrumbs Text', 'pi_framework'),
                        'subtitle' => __('Show navigation label instead page/post title.', 'pi_framework'),
                        'default' => '0'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'breadcrumbs_length',
                        'type' => 'text',
                        'required' => array('show_breadcrumbs', '=', '1'),
                        'title' => __('Breadcrumbs Length', 'pi_framework'),
                        'desc' => __('Breadcrumbs will be cut by number of characters entered here.', 'pi_framework'),
                        'validate' => 'numeric',
                        'default' => 25
                    ),
                    array(
                        'id' => 'breadcrumbs_prefix',
                        'type' => 'text',
                        'required' => array('show_breadcrumbs', '=', '1'),
                        'title' => __('Breadcrumbs Prefix', 'pi_framework'),
                        'desc' => __('Text that will be added before breadcrumbs.', 'pi_framework'),
                        'default' => 'You are here: '
                    ),
                    array(
                        'id' => 'breadcrumbs_animation',
                        'type' => 'select',
                        'required' => array('show_breadcrumbs', '=', '1'),
                        'title' => __('Breadcrumbs Animation', 'pi_framework'),
                        'subtitle' => __('Set breadcrumbs animation.', 'pi_framework'),
                        'options' => pi_animate_css_animations(),
                        'default' => 'disabled',
                    ),
                    array(
                        'id' => 'section-title-portfolio-single',
                        'type' => 'section',
                        'title' => __('Portfolio single and category', 'pi_framework'),
                        'subtitle' => __('Title on Portfolio single and category page.', 'pi_framework'),
                        'indent' => false // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id' => 'portfolio_single_show_title',
                        'type' => 'switch',
                        'title' => __('Show title', 'pi_framework'),
                        'subtitle' => __('Check to show title.', 'pi_framework'),
                        "default" => 1,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),
                    array(
                        'id' => 'portfolio_single_title_style',
                        'type' => 'select',
                        'title' => __('Title style', 'pi_framework'),
                        'subtitle' => __('Choose title style.', 'pi_framework'),
                        'options' => array('1' => 'Large (Title + Breadcrumbs + Image)', '2' => 'Medium (Title + Breadcrumbs)', '3' => 'Small (Breadcrumbs)'),
                        'default' => 1,
                        'required' => array('portfolio_single_show_title', '=', '1')
                    ),
                    array(
                        'id' => 'portfolio_single_title_color',
                        'type' => 'color',
                        'title' => __('Background Color', 'pi_framework'),
                        'subtitle' => __('Set custom color for page title background.', 'pi_framework'),
                        'default' => '#ededed',
                        'validate' => 'color',
                    ),
                    array(
                        'id' => 'portfolio_single_title_image',
                        'type' => 'media',
                        'title' => __('Background Image', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Upload image that will be use as page title background.', 'pi_framework')
                    ),
                    array(
                        'id' => 'portfolio_single_title_additional_image',
                        'type' => 'media',
                        'title' => __('Additional image', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Image that will appear on the right side of the title.', 'pi_framework'),
                        'required' => array('portfolio_single_show_title', '=', '1')
                    ),
            ));

            $this->sections[] = array(
                'icon' => 'el-icon-font',
                'title' => __('Typography', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'body_font2',
                        'type' => 'typography',
                        'title' => __('Body Font', 'pi_framework'),
                        'subtitle' => __('Specify the body font properties.', 'pi_framework'),
                        'google' => true,
                        'default' => array(
                            'color' => '#333333',
                            'font-size' => '13px',
                            'font-family' => 'Open Sans',
                            'font-weight' => 'Normal'
                        ),
                        'output' => array('body')
                    ),
                    array(
                        'id' => 'paragraphs',
                        'type' => 'typography',
                        'title' => __('Paragraph Font', 'pi_framework'),
                        'subtitle' => __('Specify the paragraph font properties.', 'pi_framework'),
                        'google' => true,
                        'default' => array(
                            'color' => '#666',
                            'font-size' => '13px',
                            'font-family' => 'Open Sans',
                            'font-weight' => 'Normal',
                            'line-height' => '22px'
                        ),
                        'output' => array('p')
                    ),
                    array(
                        'id' => 'heading_h1',
                        'type' => 'typography',
                        'title' => __('H1 Heading', 'pi_framework'),
                        'subtitle' => __('Specify the body font properties.', 'pi_framework'),
                        'google' => true,
                        'output' => array('h1'),
                        'default' => array(
                            'color' => '#39414b',
                            'font-size' => '36px',
                            'font-family' => 'Raleway',
                            'font-weight' => 'Normal',
                            'line-height' => '38px'
                        ),
                    ),
                    array(
                        'id' => 'heading_h2',
                        'type' => 'typography',
                        'title' => __('H2 Heading', 'pi_framework'),
                        'subtitle' => __('Specify the properties for H2.', 'pi_framework'),
                        'google' => true,
                        'output' => array('h2'),
                        'default' => array(
                            'color' => '#39414b',
                            'font-size' => '32px',
                            'font-family' => 'Raleway',
                            'font-weight' => 'Normal',
                            'line-height' => '24px'
                        ),
                    ),
                    array(
                        'id' => 'heading_h3',
                        'type' => 'typography',
                        'title' => __('H3 Heading', 'pi_framework'),
                        'subtitle' => __('Specify the properties for H3.', 'pi_framework'),
                        'google' => true,
                        'output' => array('h3'),
                        'default' => array(
                            'color' => '#39414b',
                            'font-size' => '26px',
                            'font-family' => 'Raleway',
                            'font-weight' => 'Normal',
                            'line-height' => '28px'
                        ),
                    ),
                    array(
                        'id' => 'heading_h4',
                        'type' => 'typography',
                        'title' => __('H4 Heading', 'pi_framework'),
                        'subtitle' => __('Specify the properties for H4.', 'pi_framework'),
                        'google' => true,
                        'output' => array('h4'),
                        'default' => array(
                            'color' => '#39414b',
                            'font-size' => '22px',
                            'font-family' => 'Raleway',
                            'font-weight' => 'Normal',
                            'line-height' => '24px'
                        ),
                    ),
                    array(
                        'id' => 'heading_h5',
                        'type' => 'typography',
                        'title' => __('H5 Heading', 'pi_framework'),
                        'subtitle' => __('Specify the properties for H5.', 'pi_framework'),
                        'google' => true,
                        'output' => array('h5'),
                        'default' => array(
                            'color' => '#39414b',
                            'font-size' => '18px',
                            'font-family' => 'Raleway',
                            'font-weight' => 'Normal',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                        'id' => 'heading_h6',
                        'type' => 'typography',
                        'title' => __('H6 Heading', 'pi_framework'),
                        'subtitle' => __('Specify the properties for H6.', 'pi_framework'),
                        'google' => true,
                        'output' => array('h6'),
                        'default' => array(
                            'color' => '#39414b',
                            'font-size' => '16px',
                            'font-family' => 'Raleway',
                            'font-weight' => 'Normal',
                            'line-height' => '20px'
                        ),
                    ),
            ));

            $this->sections[] = array(
                'icon' => 'el-icon-book',
                'title' => __('Blog', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'blog_style',
                        'type' => 'select_image',
                        'title' => __('Blog Layout', 'pi_framework'),
                        'subtitle' => __('Choose blog layout.', 'pi_framework'),
                        'options' => array(
                            'blog-post-large-image' => array('alt' => 'Large Images', 'img' => TEMPLATEURL . '/img/theme-options/blog-big-images.jpg'),
                            'blog-post-small-image' => array('alt' => 'Small Images', 'img' => TEMPLATEURL . '/img/theme-options/blog-small-images.jpg'),
                            'blog-post-full' => array('alt' => 'Full Width', 'img' => TEMPLATEURL . '/img/theme-options/blog-full.jpg'),
                            'blog-post-masonry' => array('alt' => 'Masonry', 'img' => TEMPLATEURL . '/img/theme-options/blog-masonry.jpg'),
                            'blog-post-masonry-full' => array('alt' => 'Masonry Full Width', 'img' => TEMPLATEURL . '/img/theme-options/blog-masonry-full.jpg')
                        ), //Must provide key => value(array:title|img) pairs for radio options
                        'default' => 'blog-post-small-image'
                    ),
                    array(
                        'id' => 'blog_sidebar_position',
                        'type' => 'image_select',
                        'title' => __('Sidebar Position', 'pi_framework'),
                        'subtitle' => __('Sidebar on the left or on the right side.', 'pi_framework'),
                        'options' => array(
                            'left' => array('alt' => 'Left side', 'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            'right' => array('alt' => 'Right side', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png')
                        ), //Must provide key => value(array:title|img) pairs for radio options
                        'default' => 'right'
                    ),
                    array(
                        'id' => 'blog_image_crop',
                        'type' => 'checkbox',
                        'title' => __('Image Cropping', 'pi_framework'),
                        'subtitle' => __('Set image cropping for all images in main blog page.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'blog_hide_readmore',
                        'type' => 'checkbox',
                        'title' => __('Read More button', 'pi_framework'),
                        'subtitle' => __('Show Read More button.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'blog_readmore_text',
                        'type' => 'text',
                        'required' => array('blog_hide_readmore', '=', '1'),
                        'title' => __('Read More text', 'pi_framework'),
                        'subtitle' => __('Read More button text.', 'pi_framework'),
                        'default' => 'Read more',
                        'validate' => 'no_html'
                    ),
                    array(
                        'id' => 'blog_animation',
                        'type' => 'select',
                        'title' => __('Posts Animation', 'pi_framework'),
                        'subtitle' => __('Set blog animation.', 'pi_framework'),
                        'options' => pi_animate_css_animations(),
                        'default' => 'disabled',
                    ),
                    array(
                        'id' => 'blog_sidebar_animation',
                        'type' => 'select',
                        'title' => __('Sidebar Animation', 'pi_framework'),
                        'subtitle' => __('Set blog sidebar animation.', 'pi_framework'),
                        'options' => pi_animate_css_animations(),
                        'default' => 'disabled',
                    ),
                    array(
                        'id' => 'section-gallery',
                        'type' => 'section',
                        'title' => __('Gallery post format', 'pi_framework'),
                        'subtitle' => __('Gallery post format options', 'pi_framework'),
                        'indent' => false // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id' => 'blog_gallery_slider_autoslide',
                        'type' => 'checkbox',
                        'title' => __('Slider auto sliding', 'pi_framework'),
                        'subtitle' => __('Check to enable slider auto sliding', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'blog_gallery_slider_delay',
                        'type' => 'text',
                        'required' => array('blog_gallery_slider_autoslide', '=', '1'),
                        'title' => __('Slider delay', 'pi_framework'),
                        'subtitle' => __('Enter time delay [ms].', 'pi_framework'),
                        'validate' => 'numeric',
                        'default' => 3000
                    ),
                    array(
                        'id' => 'section-single',
                        'type' => 'section',
                        'title' => __('Single post options', 'pi_framework'),
                        'subtitle' => __('Edit single post options.', 'pi_framework'),
                        'indent' => false // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id' => 'blog_single_sidebar',
                        'type' => 'image_select',
                        'title' => __('Style', 'pi_framework'),
                        'subtitle' => __('Show or hide sidebar on blog single page.', 'pi_framework'),
                        'options' => array(
                            'blog-post-full' => array('alt' => 'No sidebar', 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            'blog-post-large-image' => array('alt' => 'Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png')
                        ), //Must provide key => value(array:title|img) pairs for radio options
                        'default' => 'blog-post-large-image'
                    ),
                    array(
                        'id' => 'blog_single_meta',
                        'type' => 'checkbox',
                        'title' => __('Post meta', 'pi_framework'),
                        'subtitle' => __('Show/Hide post date and format.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'blog_single_show_author',
                        'type' => 'checkbox',
                        'title' => __('Post Author', 'pi_framework'),
                        'subtitle' => __('Show post author below post.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'blog_single_author_section_title',
                        'type' => 'text',
                        'title' => __('Author Section Title', 'pi_framework'),
                        'subtitle' => __('Change default title for Author section.', 'pi_framework'),
                        'default' => __('About the Author', 'pi_framework'),
                        'validate' => 'no_html'
                    ),
                    array(
                        'id' => 'blog_single_image_crop',
                        'type' => 'checkbox',
                        'title' => __('Image Cropping', 'pi_framework'),
                        'subtitle' => __('Set image cropping for all images in single post.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    )
            ));

            $this->sections[] = array(
                'icon' => 'el-icon-picture',
                'title' => __('Portfolio', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'portfolio_page',
                        'type' => 'select',
                        'title' => __('Portfolio page', 'pi_framework'),
                        'subtitle' => __('Select portfolio page. Page will be used for Breadcrumbs.', 'pi_framework'),
                        'data' => 'pages'
                    ),
                    array(
                        'id' => 'portfolio_pagination',
                        'type' => 'slider',
                        'title' => __('Pagination', 'pi_framework'),
                        'subtitle' => __('Number of items per page.', 'pi_framework'),
                        "default" => "10",
                        "min" => "0",
                        "step" => "1",
                        "max" => "100",
                    ),
                    array(
                        'id' => 'portfolio_order',
                        'type' => 'select',
                        'title' => __('Order', 'pi_framework'),
                        'subtitle' => __('Ascending or descending order.', 'pi_framework'),
                        'options' => array('ASC' => 'Ascending', 'DESC' => 'Descending'),
                        'default' => 'ASC'
                    ),
                    array(
                        'id' => 'portfolio_order_by',
                        'type' => 'select',
                        'title' => __('Order by', 'pi_framework'),
                        'subtitle' => __('Order items by one of available parameters.', 'pi_framework'),
                        'options' => array('id' => 'ID', 'title' => 'Title', 'date' => 'Date', 'rand' => 'Random'),
                        'default' => 'date'
                    ),
                    array(
                        'id' => 'portfolio_item_custom',
                        'type' => 'checkbox',
                        'title' => __('Item Customization', 'pi_framework'),
                        'subtitle' => __('Customize appearance of portfolio item.', 'pi_framework'),
                        'options' => array('zoom' => 'Show Zoom Icon', 'link' => 'Show Link Icon', 'image_lightbox' => 'Use Image as Link', 'lightbox_current_project' => 'Lightbox show images from current project'), //Must provide key => value pairs for multi checkbox options
                        'default' => array('zoom' => '1', 'link' => '1', 'image_lightbox' => '0', 'lightbox_current_project' => '0')//See how std has changed? you also don't need to specify opts that are 0.
                    ),
                    array(
                        'id' => 'portfolio_ssba',
                        'type' => 'checkbox',
                        'title' => __('Simple Share Buttons', 'pi_framework'),
                        'subtitle' => __('Show share buttons.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'section-portfolio-single',
                        'type' => 'section',
                        'title' => __('Portfolio single options', 'pi_framework'),
                        'subtitle' => __('Edit portfolio single options.', 'pi_framework'),
                        'indent' => false // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id' => 'portfolio_slider_size',
                        'type' => 'select',
                        'title' => __('Slider size', 'pi_framework'),
                        'subtitle' => __('Size of portfolio slider.', 'pi_framework'),
                        'options' => array('4' => 'Grid 4 (33%)', '6' => 'Grid 6 (50%)', '7' => 'Grid 7 (58%)', '8' => 'Grid 8 (66%)', '9' => 'Grid 9 (75%)', '12' => 'Grid 12 (100%)'),
                        'default' => 7,
                    ),
                    array(
                        'id' => 'portfolio_auto_slide',
                        'type' => 'checkbox',
                        'title' => __('Slider auto slide', 'pi_framework'),
                        'subtitle' => __('Enable auto sliding.', 'pi_framework'),
                        'default' => '0'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'portfolio_slider_delay',
                        'type' => 'text',
                        'title' => __('Slider delay', 'pi_framework'),
                        'desc' => __('Delay between two slides.', 'pi_framework'),
                        'validate' => 'numeric',
                        'default' => 3000,
                        'required' => array('portfolio_auto_slide', '=', '1'),
                    ),
                    array(
                        'id' => 'portfolio_slider_arrows',
                        'type' => 'checkbox',
                        'title' => __('Slider arrows', 'pi_framework'),
                        'subtitle' => __('Show/Hide slider arrows.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'portfolio_single_cropping',
                        'type' => 'checkbox',
                        'title' => __('Image Cropping', 'pi_framework'),
                        'subtitle' => __('Crop images on portfolio single page.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'portfolio_slider_height',
                        'type' => 'text',
                        'title' => __('Slider height', 'pi_framework'),
                        'desc' => __('Set slider height.', 'pi_framework'),
                        'validate' => 'numeric',
                        'default' => 530,
                        'required' => array('portfolio_single_cropping', '=', '1'),
                    ),
                    array(
                        'id' => 'section-related-posts',
                        'type' => 'section',
                        'title' => __('Related Posts Section', 'pi_framework'),
                        'subtitle' => __('Edit related posts section in portfolio single page.', 'pi_framework'),
                        'indent' => false // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id' => 'portfolio_related_posts',
                        'type' => 'switch',
                        'title' => __('Show section', 'pi_framework'),
                        'subtitle' => __('Show related posts section.', 'pi_framework'),
                        'default' => '1',
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),
                    array(
                        'id' => 'portfolio_related_posts_title',
                        'type' => 'text',
                        'title' => __('Section title', 'pi_framework'),
                        'desc' => __('Enter section title.', 'pi_framework'),
                        'default' => 'Related Projects',
                        'required' => array('portfolio_related_posts', '=', '1'),
                        'validate' => 'html'
                    ),
                    array(
                        'id' => 'portfolio_related_posts_subtitle',
                        'type' => 'text',
                        'title' => __('Section subtitle', 'pi_framework'),
                        'desc' => __('Enter section subtitle', 'pi_framework'),
                        'default' => 'Check our latest portfolio projects. Sure you\'ll find something interesting.',
                        'required' => array('portfolio_related_posts', '=', '1'),
                        'validate' => 'html'
                    ),
                    array(
                        'id' => 'portfolio_related_posts_count',
                        'type' => 'slider',
                        'title' => __('Number of items', 'pi_framework'),
                        'subtitle' => __('Number of items in Related posts section.', 'pi_framework'),
                        "default" => "8",
                        "min" => "3",
                        "step" => "1",
                        "max" => "50",
                        'required' => array('portfolio_related_posts', '=', '1')
                    ),
                    array(
                        'id' => 'portfolio_related_posts_customization',
                        'type' => 'checkbox',
                        'title' => __('Item Customization', 'pi_framework'),
                        'subtitle' => __('Customize appearance of portfolio item.', 'pi_framework'),
                        'options' => array('zoom' => 'Show Zoom Icon', 'link' => 'Show Link Icon', 'image_lightbox' => 'Use Image as Link', 'lightbox_current_project' => 'Lightbox show images from current project'), //Must provide key => value pairs for multi checkbox options
                        'default' => array('zoom' => '1', 'link' => '1', 'image_lightbox' => '0', 'lightbox_current_project' => '0'), //See how std has changed? you also don't need to specify opts that are 0.
                        'required' => array('portfolio_related_posts', '=', '1')
                    ),
                    array(
                        'id' => 'portfolio_related_posts_filter',
                        'type' => 'select',
                        'title' => __('Items filter', 'pi_framework'),
                        'subtitle' => __('Select which posts should be generated.', 'pi_framework'),
                        'options' => array('latest' => 'Latest', 'category' => 'Same category', 'random' => 'Random'),
                        'default' => 'latest',
                        'required' => array('portfolio_related_posts', '=', '1'),
                    ),
                    array(
                        'id' => 'portfolio_related_posts_color',
                        'type' => 'color',
                        'title' => __('Background color', 'pi_framework'),
                        'subtitle' => __('Set custom background color.', 'pi_framework'),
                        'validate' => 'color',
                        'mode' => 'color'
                    ),
                    array(
                        'id' => 'portfolio_related_posts_image',
                        'type' => 'media',
                        'title' => __('Background Image', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Upload image that will be use as page title background.', 'pi_framework')
                    ),
                    array(
                        'id' => 'portfolio_related_ssba',
                        'type' => 'checkbox',
                        'title' => __('Simple Share Buttons', 'pi_framework'),
                        'subtitle' => __('Show share buttons on Related posts section.', 'pi_framework'),
                        'default' => '1'// 1 = on | 0 = off
                    ),
                    array(
                        'id' => 'section-portfolio-category',
                        'type' => 'section',
                        'title' => __('Portfolio category page', 'pi_framework'),
                        'subtitle' => __('Edit portfolio category page options.', 'pi_framework'),
                        'indent' => false // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id' => 'portfolio_category_style',
                        'type' => 'select',
                        'title' => __('Category page style', 'pi_framework'),
                        'subtitle' => __('Select category page style.', 'pi_framework'),
                        'options' => array('2-col' => '2 Columns', '3-col' => '3 Columns', '4-col' => '4 Columns', 'full' => 'Full width'),
                        'default' => '3-col',
                    ),
            ));

            $this->sections[] = array(
                'icon' => 'el-icon-adjust-alt',
                'title' => __('Footer', 'pi_framework'),
                'fields' => array(
                    array(
                        'id' => 'footer_show',
                        'type' => 'switch',
                        'title' => __('Show Footer', 'pi_framework'),
                        'subtitle' => __('Show Footer section.', 'pi_framework'),
                        "default" => 1,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),
                    array(
                        'id' => 'footer_widget_areas',
                        'type' => 'slider',
                        'required' => array('footer_show', '=', '1'),
                        'title' => __('Widget areas', 'pi_framework'),
                        'subtitle' => __('Number of widget areas.', 'pi_framework'),
                        "default" => "4",
                        "min" => "1",
                        "step" => "1",
                        "max" => "4",
                    ),
                    array(
                        'id' => 'copyright_text',
                        'type' => 'textarea',
                        'title' => __('Copyright Text', 'pi_framework'),
                        'subtitle' => __('Enter copyright text.', 'pi_framework'),
                        'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                        'default' => 'COPYRIGHT ELVYRE 2014. ALL RIGHTS RESERVED.'
                    ),
                    array(
                        'id' => 'widgets_animation',
                        'type' => 'select',
                        'title' => __('Widgets animation', 'pi_framework'),
                        'subtitle' => __('Set animation for widgets.', 'pi_framework'),
                        'options' => pi_animate_css_animations(),
                        'default' => 'disabled',
                    ),
            ));

            $this->sections[] = array(
                'type' => 'divide',
            );

//            $this->sections[] = array(
//                'icon' => 'el-icon-info-sign',
//                'title' => __('Icon Fonts', 'redux-framework-demo'),
//                'desc' => __('<p class="description">This section allows you updating/reloading icon fonts.</p>', 'redux-framework-demo'),
//                'fields' => array(
//                    array(
//                        'id' => 'opt-raw-info',
//                        'type' => 'raw',
//                        'content' => $this->pi_get_icon_fonts_section(),
//                    )
//                ),
//            );
        }

        function pi_woocommerce_options($sections) {
            $sections[] = array(
                'title' => __('WooCommerce', 'pi-cma'),
                'desc' => __('Settings for WooCommerce plugin.', 'pi-cma'),
                'icon' => 'el-icon-shopping-cart',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array(
                    array(
                        'id' => 'woo_custom_shop_page',
                        'type' => 'checkbox',
                        'title' => __('Hide Products Loop', 'pi-cma'),
                        'subtitle' => __('Check this to hide main Products loop (default list of products will be hidden).', 'pi-cma'),
                        'default' => '0'
                    ),
                    array(
                        'id' => 'woo_shop_page_products_count',
                        'type' => 'slider',
                        'title' => __('Products Count', 'pi-cma'),
                        'subtitle' => __('Number of products to show on Shop page.', 'pi-cma'),
                        'default' => 10,
                        'min' => '1',
                        'step' => '1',
                        'max' => '100'
                    ),
                    array(
                        'id' => 'woo_custom_shop_slider',
                        'type' => 'checkbox',
                        'title' => __('Slider/Page title', 'pi-cma'),
                        'subtitle' => __('Check this if you want to show slider instead classic Page title.', 'pi-cma'),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'woo_slider_id',
                        'type' => 'text',
                        'title' => __('Slider ID', 'pi-cma'),
                        'subtitle' => __('Enter Slider ID.', 'pi-cma')
                    ),
                    array(
                        'id' => 'woo_header_cart',
                        'type' => 'checkbox',
                        'title' => __('Header Cart', 'pi-cma'),
                        'subtitle' => __('Show cart in header.', 'pi-cma'),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'woo_product_hover',
                        'type' => 'checkbox',
                        'title' => __('Product Hover', 'pi-cma'),
                        'subtitle' => __('Show Product hover with rating and Wishlist.', 'pi-cma'),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'section-woo',
                        'type' => 'section',
                        'title' => __('Products single', 'pi_framework'),
                        'subtitle' => __('Options for product single page', 'pi_framework'),
                        'indent' => false // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id' => 'woo_single_product_slider',
                        'type' => 'checkbox',
                        'title' => __('Slider', 'pi-cma'),
                        'subtitle' => __('Show Slider on Products single (category and tags page).', 'pi-cma'),
                        'default' => '0'
                    ),
                    array(
                        'id' => 'woo_single_product_sidebar',
                        'type' => 'select',
                        'title' => __('Sidebar', 'pi-cma'),
                        'subtitle' => __('Show sidebar on single products page.', 'pi-cma'),
                        'default' => 'fullwidth',
                        'options' => array('fullwidth' => 'Fullwidth', 'left' => 'Left', 'right' => 'Right')
                    ),
                    array(
                        'id' => 'products_single_title_style',
                        'type' => 'select',
                        'title' => __('Title style', 'pi_framework'),
                        'subtitle' => __('Choose title style.', 'pi_framework'),
                        'options' => array('1' => 'Large (Title + Breadcrumbs + Image)', '2' => 'Medium (Title + Breadcrumbs)', '3' => 'Small (Breadcrumbs)'),
                        'default' => 1,
                        'required' => array('portfolio_single_show_title', '=', '1')
                    ),
                    array(
                        'id' => 'products_single_title_color',
                        'type' => 'color',
                        'title' => __('Background Color', 'pi_framework'),
                        'subtitle' => __('Set custom color for page title background.', 'pi_framework'),
                        'default' => '#ededed',
                        'validate' => 'color',
                    ),
                    array(
                        'id' => 'products_single_title_image',
                        'type' => 'media',
                        'title' => __('Background Image', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Upload image that will be use as page title background.', 'pi_framework')
                    ),
                    array(
                        'id' => 'products_single_title_additional_image',
                        'type' => 'media',
                        'title' => __('Additional image', 'pi_framework'),
                        'compiler' => 'true',
                        'subtitle' => __('Image that will appear on the right side of the title.', 'pi_framework'),
                        'required' => array('portfolio_single_show_title', '=', '1')
                    ),
                )
            );

            return $sections;
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'pi_theme_options', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Elvyre Options', 'pi_framework'),
                'page_title' => __('Elvyre Options', 'pi_framework'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyBsN1cG-NVXTUyefbmSlbv5NxMWyDzD8Nw', // Must be defined to add google fonts to the typography module
                'async_typography' => false, // Use a asynchronous font on the front end or font string
                //'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => '', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => '', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '', // __( '', $this->args['domain'] );            
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
            $this->args['share_icons'][] = array(
                'url' => 'https://github.com/pixel-industry/',
                'title' => 'Visit us on GitHub',
                'icon' => 'el-icon-github'
                    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/pixel.industry.themes',
                'title' => 'Like us on Facebook',
                'icon' => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://twitter.com/pixel_industry',
                'title' => 'Follow us on Twitter',
                'icon' => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon' => 'el-icon-linkedin'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://dribbble.com/pixel_industry',
                'title' => 'Our Work on Dribbble',
                'icon' => 'el-icon-dribbble'
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.behance.net/pixel-industry',
                'title' => 'Our Portfolio on Behance',
                'icon' => 'el-icon-behance'
            );
        }

    }

    new Redux_Framework_sample_config();
}

