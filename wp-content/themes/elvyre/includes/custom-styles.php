<?php
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);

global $pi_theme_options;
$custom_css = $pi_theme_options['custom_css'];

header('Content-type: text/css');
echo $custom_css;
?>