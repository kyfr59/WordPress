<?php
/**
 * The template for displaying all pages.
 */
get_header();

global $page_title, $pi_theme_options;

$page_title = '404';

get_template_part('section', 'title');
?>
<!-- .page-content start -->
<section class="page-content">
    <!-- container start -->
    <div class="container">
        <!-- .row start -->
        <div class="row">
            <article class="col-md-12">
                <div class="note">
                    <h2><?php _e('404 Error. Page Not Found', 'pi_framework'); ?></h2>
                    <p><?php _e('We are sorry but the page you are looking for cannot be found on the server. It may be deleted or replaced. You can try search by another term.', 'pi_framework'); ?></p>
                </div>
                <br/>
                <br/>
                <div class="error-page">
                    <?php the_widget('WP_Widget_Search'); ?>
                </div>
            </article>
        </div><!-- .row end -->
    </div><!-- .container end -->
</section><!-- .page-content end -->
<?php
get_footer();
?>