<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!$messages)
    return;
if (is_singular('product')):
    ?>
    <!-- .page-content start -->
    <section class="page-content notices">
        <!-- container start -->
        <div class="container">
            <!-- .row start -->
            <div class="row">
                <div class="grid_12">
                <?php endif; ?>

                <?php foreach ($messages as $message) : ?>
                    <div class="woocommerce-info"><?php echo wp_kses_post($message); ?></div>
                <?php endforeach; ?>
                    
                <?php if (is_singular('product')): ?>
                </div>
            </div><!-- .row end -->
        </div><!-- .container end -->
    </section><!-- .page-content end -->
<?php endif; ?>