<?php

/**
 * Template Name: Portfolio
 */
get_header();

global $page_title, $page_style;

$page_id = get_the_ID();
$page_title = get_the_title();

$hide_page_title = get_post_meta($page_id, 'pg_hide_title', true);
$hide_page_title = empty($hide_page_title) ? '0' : $hide_page_title;

// get title section
if ($hide_page_title == '0') {
    get_template_part('section', 'title');
}

// load main content
get_template_part('cpt', 'portfolio');

// footer
get_footer();
?>