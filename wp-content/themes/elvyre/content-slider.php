<?php
global $pi_theme_options;

//Check in Theme options which slider is selected and call that one.
if(PI_WOOCOMMERCE && is_shop()){
    $slider_id = isset($pi_theme_options['woo_slider_id']) ? $pi_theme_options['woo_slider_id'] : '';
}else{
    $slider_id = isset($pi_theme_options['home_slider_id']) ? $pi_theme_options['home_slider_id'] : '';
}

if (function_exists('putRevSlider') && !empty($slider_id)) {
    echo "<div class='rs-wrapper'>";
    putRevSlider($slider_id);
    echo "<div class='slider-shadow'></div></div>";
}
?>