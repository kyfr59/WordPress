<?php
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);

global $pi_theme_options;
$color_style = $pi_theme_options['custom_color_style'];

$lighter_color = pi_adjust_color_brightness($color_style, 16);
$darker_color = pi_adjust_color_brightness($color_style, -5);
$rgb_color = pi_hex2rgb($color_style);

header('Content-type: text/css');
?>
a:hover, 
#top-bar .contact-info li a:hover, 
.post-body a h3:hover, 
.pi_recent_posts .widget-post-info a h6:hover, 
#filters li.active a, 
.sharrre.portfolio-item-like:hover, 
.icons-list.colored, 
.btn-medium.empty, 
#page-title.page-title-3 .breadcrumbs li a:hover,
.woocommerce .page-title-3  .woocommerce-breadcrumb a:hover, 
.woocommerce-page .page-title-3  .woocommerce-breadcrumb a:hover,
.service-box-1 a:hover h5, 
.service-box-2:hover .icon i, 
.tabs.vertical li.active a, 
.latest-posts li a:hover h5{
color: <?php echo $color_style; ?> !important;
}

#search, 
.wpcf7-submit:hover, 
.widget .newsletter .submit:hover, 
.widget_tag_cloud a:hover, 
.breadcrumbs, 
.woocommerce .page-title-1  .woocommerce-breadcrumb, 
.woocommerce-page .page-title-1 .woocommerce-breadcrumb,
.woocommerce .page-title-2  .woocommerce-breadcrumb, 
.woocommerce-page .page-title-2  .woocommerce-breadcrumb,
#top-bar .social-links li:hover a, 
.post-info .post-category, 
.post-info-container .post-category,
.post-meta li a::after, 
.nivo-prevNav, 
.highlighted-color, 
.pagination li:hover, 
.sharrre .right, 
#respond #comment-reply:hover, 
#filters li.active .item-number, 
#filters li:hover .item-number, 
.portfolio-img-container .portfolio-img-hover li:hover, 
.btn-medium.empty:hover, 
.btn-big.empty:hover,
.btn-medium:hover, 
.btn-big:hover,
.carousel-nav li:hover,
.expand, 
.team-member-hover .mask, 
.history .year-holder span.year, 
.service-box-1:hover .icon, 
.tabs.vertical.services-tabs li.active .icon, 
.tabs.vertical.services-tabs li:hover .icon, 
.service-box-2 .icon i, 
.service-box-2:hover, 
.process-box:hover, 
.header-style-4 .social-links li:hover, 
.pricing-table-col.selected .price, 
.pagination li.active, 
.dropcap.colored, 
.numbers-counter li,
.widget.widget_calendar #wp-calendar #today{
background-color: <?php echo $color_style; ?>;
}

.nivo-prevNav, 
.nivo-nextNav{
background-color: rgba(<?php echo $rgb_color[0]; ?>, <?php echo $rgb_color[1]; ?>, <?php echo $rgb_color[2]; ?>, 0.6);
}

#nav > ul > li.current-menu-item > a,
#nav > ul > li.current-menu-ancestor > a,
.blog-posts li.blog-post.sticky{
border-bottom: 3px solid <?php echo $color_style; ?>;
}

blockquote{
border-left: 3px solid <?php echo $color_style; ?>;
}

.btn-medium.empty, 
.btn-big.empty,
.btn-medium.empty.white:hover, 
.btn-big.empty.white:hover{
border: 1px solid <?php echo $color_style; ?>;

-webkit-border-radius: 3px;
-moz-border-radius: 3px;
-o-border-radius: 3px;
border-radius: 3px;
}

.history .year-holder{
border: 3px solid <?php echo $color_style; ?>;
}

.carousel-nav .c_next:hover{
background-image: url('<?php echo TEMPLATEURL; ?>/img/c_next_hover.png');
}

.carousel-nav .c_prev:hover{
background-image: url('<?php echo TEMPLATEURL; ?>/img/c_prev_hover.png');
}

.tabs li.active{
border-top: 1px solid <?php echo $color_style; ?>;
}

.accordion .title{
background-image: url('<?php echo TEMPLATEURL; ?>/img/accordion-closed.png');    
}

.accordion .title.active{
background-image: url('<?php echo TEMPLATEURL; ?>/img/accordion-opened.png');
}

.history-arrow-right{   
background: url('<?php echo TEMPLATEURL; ?>/img/timeline-right.png') no-repeat center center;
background-size: 100%;
}

.history-arrow-left{   
background: url('<?php echo TEMPLATEURL; ?>/img/timeline-left.png') no-repeat center center;
background-size: 100%;
}



/* DARKER BLUE COLOR 
==============================================================================*/
.widget .newsletter .submit:hover{
border: 1px solid <?php echo $darker_color; ?>;
}

.portfolio-img-container .portfolio-img-hover .mask, 
.btn-medium, 
.btn-big{
background: <?php echo $darker_color; ?>;
}

.widget.widget_calendar #wp-calendar #today a:hover{
color: #fff !important;
}

/* WOOCOMMERCE STYLE COLORS
============================================================================== */
 
.woocommerce ul.products .product-meta .price .amount, 
.woocommerce-page ul.products .product-meta .price .amount, 
.order-total .amount, 
.woocommerce .star-rating span, .woocommerce-page .star-rating span{
	color: <?php echo $color_style; ?>
}

.woocommerce ul.products li.product .add_to_cart_button:hover, 
.woocommerce-page ul.products li.product .add_to_cart_button:hover, 
.woocommerce .woocommerce-info:before, .woocommerce-page .woocommerce-info:before, 
.chosen-container .chosen-results li.active-result:hover, 
.chosen-container .chosen-results li.active-result.result-selected, 
.woocommerce #payment div.payment_box, .woocommerce-page #payment div.payment_box, 
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover, 
.woocommerce #respond input#submit.alt:hover, 
.woocommerce #content input.button.alt:hover, 
.woocommerce-page a.button.alt:hover, 
.woocommerce-page button.button.alt:hover, 
.woocommerce-page input.button.alt:hover, 
.woocommerce-page #respond input#submit.alt:hover, 
.woocommerce-page #content input.button.alt:hover, 
.woocommerce .cart .button:hover, .woocommerce .cart input.button:hover, .woocommerce-page .cart .button:hover, .woocommerce-page .cart input.button:hover, 
.woocommerce .cart-collaterals .shipping_calculator .button:hover, .woocommerce-page .cart-collaterals .shipping_calculator .button:hover, 
.woocommerce .woocommerce-message:before, .woocommerce-page .woocommerce-message:before, 
.woocommerce a.button:hover, 
.woocommerce button.button:hover, 
.woocommerce input.button:hover, 
.woocommerce #respond input#submit:hover, 
.woocommerce #content input.button:hover, 
.woocommerce-page a.button:hover, 
.woocommerce-page button.button:hover, 
.woocommerce-page input.button:hover,
.woocommerce-page #respond input#submit:hover, 
.woocommerce-page #content input.button:hover, 
.woocommerce .addresses .title .edit:hover, .woocommerce-page .addresses .title .edit:hover, 
.woocommerce .quantity .plus:hover, 
.woocommerce .quantity .minus:hover, 
.woocommerce #content .quantity .plus:hover, 
.woocommerce #content .quantity .minus:hover, 
.woocommerce-page .quantity .plus:hover, 
.woocommerce-page .quantity .minus:hover, 
.woocommerce-page #content .quantity .plus:hover, 
.woocommerce-page #content .quantity .minus:hover,
.woocommerce ul.products li.product .onsale,
.woocommerce span.onsale, 
.woocommerce-page span.onsale,
#header-wrapper .header-cart .cart-count,
.woocommerce .widget_product_search #searchsubmit:hover,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range, 
.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce .widget_layered_nav_filters ul li a:hover, 
.woocommerce-page .widget_layered_nav_filters ul li a:hover{
	background: <?php echo $color_style; ?>;
}

/* DARKER BLUE COLOR WOOCOMMERCE
================================================================================ */
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt, 
.woocommerce #respond input#submit.alt, 
.woocommerce #content input.button.alt, 
.woocommerce-page a.button.alt, 
.woocommerce-page button.button.alt, 
.woocommerce-page input.button.alt, 
.woocommerce-page #respond input#submit.alt, 
.woocommerce-page #content input.button.alt, 
.woocommerce .cart .button, .woocommerce .cart input.button, .woocommerce-page .cart .button, .woocommerce-page .cart input.button, 
.woocommerce .cart-collaterals .shipping_calculator .button, .woocommerce-page .cart-collaterals .shipping_calculator .button, 
.woocommerce a.button, 
.woocommerce button.button, 
.woocommerce input.button, 
.woocommerce #respond input#submit, 
.woocommerce #content input.button, 
.woocommerce-page a.button,
 .woocommerce-page button.button, 
 .woocommerce-page input.button, 
 .woocommerce-page #respond input#submit, 
 .woocommerce-page #content input.button, 
 .woocommerce .addresses .title .edit, 
 .woocommerce-page .addresses .title .edit,
 .woocommerce .widget_product_search #searchsubmit,
 .woocommerce .widget_layered_nav_filters ul li a, 
 .woocommerce-page .widget_layered_nav_filters ul li a{
    background: <?php echo $darker_color; ?>;
}

.woocommerce #payment div.payment_box:after, .woocommerce-page #payment div.payment_box:after{
    border: 8px solid <?php echo $color_style; ?>;
    border-right-color: transparent;
    border-left-color: transparent;
    border-top-color: transparent;
}

.woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active{
	border-top: 1px solid <?php echo $color_style; ?>;
}

