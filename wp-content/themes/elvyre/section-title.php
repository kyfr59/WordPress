<?php
/*
 * Title section for pages and posts.
 */

global $page_title, $pi_theme_options, $is_retina;

$parallax_active = '';

// get page id
if (is_home() || is_singular('post') || is_category() || is_tag() || is_year() || is_month() || is_day() || is_author() || is_search() || is_404()) {
    $page_id = ( 'page' == get_option('show_on_front') ? get_option('page_for_posts') : get_the_ID() );
} else if (PI_WOOCOMMERCE && is_shop()) {
    $page_id = get_option('woocommerce_shop_page_id');
} else {
    $page_id = get_the_ID();
}

// defaults if Core plugin isn't activated
if (!ELVYRE_CORE) {
    $style = '1';
    $additional_image = false;

    // page title color or background image
    $page_title_color = '#ededed';
    $page_title_image = false;
} else {
    // title style
    if (is_singular('pi_portfolio') || is_tax('portfolio-category')) {
        $style = $pi_theme_options['portfolio_single_title_style'];
        $additional_image = isset($pi_theme_options['portfolio_single_title_additional_image']) ? $pi_theme_options['portfolio_single_title_additional_image'] : '';

        // page title color or background image
        $page_title_color = $pi_theme_options['portfolio_single_title_color'];
        $page_title_first_image = isset($pi_theme_options['portfolio_single_title_image']) ? $pi_theme_options['portfolio_single_title_image'] : '';
    } else if (PI_WOOCOMMERCE && is_singular('product')) {
        $style = $pi_theme_options['products_single_title_style'];
        $additional_image = isset($pi_theme_options['products_single_title_additional_image']) ? $pi_theme_options['products_single_title_additional_image'] : '';

        // page title color or background image
        $page_title_color = $pi_theme_options['products_single_title_color'];
        $page_title_first_image = isset($pi_theme_options['products_single_title_image']) ? $pi_theme_options['products_single_title_image'] : '';
    } else {

        $style = rwmb_meta('pg_title_style', '', $page_id);

        if (empty($style))
            $style = "1";

        $additional_image = rwmb_meta('pg_additional_title_image', 'type=image&size=full', $page_id);

        if (!(empty($additional_image)))
            $additional_image = reset($additional_image);

        // page title color
        $page_title_color = rwmb_meta('pg_title_color', '', $page_id);
        if (empty($page_title_color))
            $page_title_color = '#ededed';

        // page title image
        $page_title_image = rwmb_meta('pg_title_image', 'type=image&size=full', $page_id);

        if (!empty($page_title_image))
            $page_title_first_image = reset($page_title_image);
    }
}

// animation
$page_title_animation = $pi_theme_options['title_animation'];

if (!empty($page_title_first_image) && !empty($page_title_first_image['url'])) {

    // if user is on retina device
    if ($is_retina && isset($page_title_image) && count($page_title_image) >= 2) {

        // check if second image is uploaded (retina image)
        $second_image = array_slice($page_title_image, 1, 1);

        if (!empty($second_image)) {
            $image = $second_image[0]['url'];
        } else {
            $image = $page_title_first_image['url'];
        }
    } else {
        $image = $page_title_first_image['url'];
    }


} 
// additional image on the right side of page title
$additional_image_animation = $pi_theme_options['animated_image_animation'];

// breadcrumbs
$show_breadrumbs = $pi_theme_options['show_breadcrumbs'];
$breadrumbs_animation = $pi_theme_options['breadcrumbs_animation'];

// check if parallax is enabled
$parallax = $pi_theme_options['parallax'];
$parallax_page = rwmb_meta('pg_parallax', '', $page_id);

if (!empty($parallax) && $parallax_page == '1') {
    // get parallax background ratio
    if (CONTENT_MANAGER) {
        $data_stellar_background_ratio = "data-stellar-background-ratio='" . cma_get_settings('data-stellar-background-ratio') . "'";
    } else {
        $data_stellar_background_ratio = 'data-stellar-background-ratio="0.4"';
    }
} else {
    $data_stellar_background_ratio = '';
    $parallax_active = 'no-parallax';
}

$months[1] = 'Janvier';
$months[2] = 'Février';
$months[3] = 'Mars';
$months[4] = 'Avril';
$months[5] = 'Mai';
$months[6] = 'Juin';
$months[7] = 'Juillet';
$months[8] = 'Août';
$months[9] = 'Septembre';
$months[10] = 'Octobre';
$months[11] = 'Novembre';
$months[12] = 'Décembre';

?>
<!-- .page-title-container start -->
<section id="page-title" class="page-title-<?php echo $style ?> <?php echo $parallax_active ?>" <?php echo $data_stellar_background_ratio ?>>
    <h1 class="article-title"><?php echo $page_title ?></h1>
    <?php if(!is_page()): ?>
        <h2 class="article-title"><?php the_time('d') ?> <?php echo $months[(int)get_the_time('m')]; ?> <?php the_time('Y') ?></h2>
    <?php endif; ?>

    <?php if (($style == '2' || $style == '3') && !empty($show_breadrumbs)): ?>
        <?php
        if (PI_WOOCOMMERCE && is_woocommerce()) {
            do_action('pi_woocommerce_breadcrumb');
        } else {
            pi_breadcrumbs();
        }
        ?>
    <?php endif; ?>

    <?php if ($style == '1' && !empty($additional_image['url'])): ?>
        <!-- .grid_4 start -->
        <div class="grid_12">
            <div class="pt-image-container">
                <div class="pt-image <?php if ($additional_image_animation != "disabled") echo "triggerAnimation animated"; ?>" <?php if ($additional_image_animation != "disabled"): ?> data-animate="<?php echo $additional_image_animation ?>" <?php endif; ?>>
                    <img class="float-right" src="<?php echo $additional_image['url'] ?>" alt="about us page title image" />
                </div>
            </div>
        </div><!-- .grid_4 end -->
    <?php endif; ?>

</section><!-- #page-title end -->


