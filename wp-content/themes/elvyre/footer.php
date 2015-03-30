<?php
/*
 * The template for displaying the footer.
 */
global $pi_theme_options;

$show_footer = $pi_theme_options['footer_show'];
$footer_animation = $pi_theme_options['widgets_animation'];
?>


<?php if ($pi_theme_options['website_layout'] == 'boxed'): ?>
    <!-- .page-wrapper start -->
    <div class="clearfix">
    <?php endif; ?>

    <div class="clear"></div>


    <!-- Studen's footer integration -->
    <style>#footer-content {border-left:none !important; border-right:none !important;}</style>
    <?php 
    $url = OMEKA_URL."shared/footer";
    require($url);
    ?>
    
</body>
</html>
