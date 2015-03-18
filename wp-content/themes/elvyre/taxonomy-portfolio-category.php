<?php
get_header();

global $page_title;

$page_title = single_cat_title('', false);

// get title section
get_template_part('section', 'title');

// get portfolio page content
get_template_part('cpt', 'portfolio'); 

get_footer(); ?>