<?php

// Include helper functions
require_once ( get_template_directory() . '/includes/libs/helper.php' );

// Load file with Icon Font functions
require_once( get_template_directory() . "/includes/libs/icon-fonts.php" );

// Include Custom field Select Text
function pi_redux_select_text_field($field) {
    return get_template_directory() . '/core/theme-options/custom-fields/select_text/field_select_text.php';
}

add_filter("redux/pi_theme_options/field/class/select_text", "pi_redux_select_text_field");

// Include custom field Select Label
function pi_redux_select_label_field($field) {
    return get_template_directory() . '/core/theme-options/custom-fields/select_label/field_select_label.php';
}

add_filter("redux/pi_theme_options/field/class/select_label", "pi_redux_select_label_field");

// Include modified field Select Image
function pi_redux_select_image_field($field) {
    return get_template_directory() . '/core/theme-options/custom-fields/select_image/field_select_image.php';
}

add_filter("redux/pi_theme_options/field/class/select_image", "pi_redux_select_image_field");

// Include Redux Framework files
if (!class_exists('ReduxFramework') && file_exists(get_template_directory() . '/core/theme-options/redux-framework/ReduxCore/framework.php')) {
    require_once( get_template_directory() . '/core/theme-options/redux-framework/ReduxCore/framework.php' );
}

if (!isset($redux_demo) && file_exists(get_template_directory() . '/core/theme-options/theme-options.php')) {
    require_once( get_template_directory() . '/core/theme-options/theme-options.php' );
}

// Remove Demo mode in Redux Framework
function pi_redux_remove_demo_mode() { // Be sure to rename this function to something more unique
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
    }
}

add_action('init', 'pi_redux_remove_demo_mode');

// Include the meta box script
require_once ( get_template_directory() . '/core/meta-box/meta-box/meta-box.php' );

// Include the script for plugin version checking
include_once ( get_template_directory() . '/core/plugin-activation/plugin-list.php' );

// Include the TGM Plugin Activation script
include_once ( get_template_directory() . '/core/plugin-activation/plugin-list.php' );

// Include the Mobile Detect script
include_once ( get_template_directory() . '/includes/libs/Mobile_Detect.php' );

// Include the Aqua Resizer script
include_once ( get_template_directory() . '/includes/libs/BFI_Thumb.php' );

// include Contact info widget
require ( get_template_directory() . '/includes/widgets/widget-contact-info.php' );

// Include Plugin for Responsive Menu
if (!function_exists('dropdown_menu'))
    include_once( get_template_directory() . '/includes/dropdown-menus.php' );

if (PI_WOOCOMMERCE) {
    require_once(get_template_directory() . '/woocommerce/woocommerce.php');
}
?>
