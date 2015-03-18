<?php

/* * ***************************
 * Theme helper functions
 * 
 * *************************** */

/* -----------------------------------------
 * Substring text
  ----------------------------------------- */
if (!function_exists('_substr')) {

    function _substr($str, $length, $minword = 3) {
        $sub = '';
        $len = 0;

        foreach (explode(' ', $str) as $word) {
            $part = (($sub != '') ? ' ' : '') . $word;
            $sub .= $part;
            $len += strlen($part);

            if (strlen($word) > $minword && strlen($sub) >= $length) {
                break;
            }
        }

        return $sub . (($len < strlen($str)) ? '...' : '');
    }

}
/* --------------------------------------------
 * Verify if visitor is using Internet Explorer
  --------------------------------------------- */
if (!function_exists('pi_detect_ie')) {

    function pi_detect_ie() {
        $browsers = array();
        $ie6 = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0');
        $ie7 = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0');
        $ie8 = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0');
        if ($ie6 !== false) {
            $browsers['ie6'] = 'true';
        } else if ($ie7 !== false) {
            $browsers['ie7'] = 'true';
        } else if ($ie8 !== false) {
            $browsers['ie8'] = 'true';
        }

        return $browsers;
    }

}
/* ------------------------------------------------------------------
 * Check the current post for the existence of a short code
  ------------------------------------------------------------------ */
if (!function_exists('pi_has_shortcode')) {

    function pi_has_shortcode($shortcode = '') {

        $post_to_check = get_post(get_the_ID());

        // false because we have to search through the post content first
        $found = false;

        // if no short code was provided, return false
        if (!$shortcode) {
            return $found;
        }
        // check the post content for the short code
        if (stripos($post_to_check->post_content, '[' . $shortcode) !== false) {
            // we have found the short code
            $found = true;
        }

        // return our final results
        return $found;
    }

}

/* --------------------------------------------
 * Adjust brightness by changing Hex value
  --------------------------------------------- */
if (!function_exists('pi_adjust_color_brightness')) {

    function pi_adjust_color_brightness($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Format the hex color string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }

        // Get decimal values
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Adjust number of steps and keep it inside 0 to 255
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));

        $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
        $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
        $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

        return '#' . $r_hex . $g_hex . $b_hex;
    }

}

/* --------------------------------------------
 * Convert HEX color to RGB
 * http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
  --------------------------------------------- */

if (!function_exists('pi_hex2rgb')) {

    function pi_hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

}

/* --------------------------------------------
 * Convert RGB color to HEX
 * http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
  --------------------------------------------- */
if (!function_exists('pi_rgb2hex')) {

    function pi_rgb2hex($rgb) {
        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

        return $hex; // returns the hex value including the number sign (#)
    }

}

/* --------------------------------------------
 * Get top level menu items
  --------------------------------------------- */

if (!function_exists('pi_get_top_level_menu_items')) {

    function pi_get_top_level_menu_items($location_id = 'primary') {
        $top_level_nav = array();
        $locations = get_registered_nav_menus();
        $menus = wp_get_nav_menus();
        $menu_locations = get_nav_menu_locations();

        if (isset($menu_locations[$location_id])) {
            foreach ($menus as $menu) {
                // If the ID of this menu is the ID associated with the location we're searching for
                if ($menu->term_id == $menu_locations[$location_id]) {
                    // This is the correct menu
                    // Get the items for this menu 
                    $menu_items = wp_get_nav_menu_items($menu);
                    break;
                }
            }

            if (isset($menu_items)) {
                foreach ($menu_items as $menu_item) {
                    if (!$menu_item->menu_item_parent) {
                        $top_level_nav[$menu_item->ID] = $menu_item->title;
                    }
                }
            }
            return $top_level_nav;
        } else {
            return false;
        }
    }

}
/* --------------------------------------------
 * List of available animations in animate.css
  --------------------------------------------- */

if (!function_exists('pi_animate_css_animations')) {

    function pi_animate_css_animations() {
        $animations = array(
            'disabled' => 'Animation disabled',
            'bounce' => "Bounce",
            'flash' => "Flash",
            'pulse' => "Pulse",
            'rubberBand' => "Rubber Band",
            'shake' => "Shake",
            'swing' => "Swing",
            'tada' => "Tada",
            'wobble' => "Wobble",
            'bounceIn' => "Bounce In",
            'bounceInDown' => "Bounce In Down",
            'bounceInLeft' => "Bounce In Left",
            'bounceInRight' => "Bounce In Right",
            'bounceInUp' => "Bounce In Up",
            'bounceOut' => "Bounce Out",
            'bounceOutDown' => "Bounce Out Down",
            'bounceOutLeft' => "Bounce Out Left",
            'bounceOutRight' => "Bounce Out Right",
            'bounceOutUp' => "Bounce Out Up",
            'fadeIn' => "Fade In",
            'fadeInDown' => "Fade In Down",
            'fadeInDownBig' => "Fade In Down Big",
            'fadeInLeft' => "Fade In Left",
            'fadeInLeftBig' => "Fade In Left Big",
            'fadeInRight' => "Fade In Right",
            'fadeInRightBig' => "Fade In Right Big",
            'fadeInUp' => "Fade In Up",
            'fadeInUpBig' => "Fade In Up Big",
            'fadeOut' => "Fade Out",
            'fadeOutDown' => "Fade Out Down",
            'fadeOutDownBig' => "Fade Out Down Big",
            'fadeOutLeft' => "Fade Out Left",
            'fadeOutLeftBig' => "Fade Out Left Big",
            'fadeOutRight' => "Fade Out Right",
            'fadeOutRightBig' => "Fade Out Right Big",
            'fadeOutUp' => "Fade Out Up",
            'fadeOutUpBig' => "Fade Out Up Big",
            'flip' => "Flip",
            'flipInX' => "Flip In-X",
            'flipInY' => "Flip In-Y",
            'flipOutX' => "Flip Out-X",
            'flipOutY' => "Flip Out-Y",
            'lightSpeedIn' => "Light Speed In",
            'lightSpeedOut' => "Light Speed Out",
            'rotateIn' => "Rotate In",
            'rotateInDownLeft' => "Rotate In Down Left",
            'rotateInDownRight' => "Rotate In Down Right",
            'rotateInUpLeft' => "Rotate In Up Left",
            'rotateInUpRight' => "Rotate In Up Right",
            'rotateOut' => "Rotate Out",
            'rotateOutDownLeft' => "Rotate Out Down Left",
            'rotateOutDownRight' => "Rotate Out Down Right",
            'rotateOutUpLeft' => "Rotate Out Up Left",
            'rotateOutUpRight' => "Rotate Out Up Right",
            'slideInDown' => "Slide In Down",
            'slideInLeft' => "Slide In Left",
            'slideInRight' => "Slide In Right",
            'slideOutLeft' => "Slide Out Left",
            'slideOutRight' => "Slide Out Right",
            'slideOutUp' => "Slide Out Up",
            'hinge' => "Hinge",
            'rollIn' => "Roll In",
            'rollOut' => "Roll Out"
        );

        return $animations;
    }

}

/* --------------------------------------------
 * Check version of plugin that is hosted 
 * in private repository
  --------------------------------------------- */

if (!function_exists('pi_plugin_version_check')) {

    function pi_plugin_version_check($plugin) {

        $versions = get_transient('pi_plugins_version_check');
        //$versions = '';

        if (empty($versions)) {

            // URL to file with plugin versions
            $url = "https://bitbucket.org/pixelindustry/public-repository/downloads/version-check.json";

            // fetch data from remote location and decode JSON
            $request = wp_remote_get($url, array('sslverify'   => false));

            if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
                $versions = wp_remote_retrieve_body( $request );
                $versions = json_decode($request['body'], true);
            } else {
                $versions = '';
            }           

            set_transient('pi_plugins_version_check', $versions, DAY_IN_SECONDS);
        }

        if (isset($versions['plugins'][$plugin])) {
            $plugin_version = $versions['plugins'][$plugin];
        } else {
            $plugin_version = '';
        }

        return $plugin_version;
    }

}
/* --------------------------------------------
 * Simple Share Buttons Added 
 * - list of social networks
  --------------------------------------------- */

if (!function_exists('pi_simple_share_buttons_list')) {

    function pi_simple_share_buttons_list() {
        return array(
            'buffer' => 'Buffer',
            'diggit' => 'Diggit',
            'email' => 'Email',
            'facebook' => 'Facebook',
            'flattr' => 'Flattr',
            'google' => 'Google',
            'linkedin' => 'LinkedIn',
            'pinterest' => 'Pinterest',
            'print' => 'Print',
            'reddit' => 'Reddit',
            'stumbleupon' => 'Stumbleupon',
            'tumblr' => 'Tumblr',
            'twitter' => 'Twitter'
        );
    }

}
?>
