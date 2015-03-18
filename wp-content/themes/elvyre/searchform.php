<?php
/**
 * The template for displaying search forms in theme
 *
 */
?>
<!-- search start -->
<form action="<?php echo esc_url(home_url('/')); ?>" method="get">
    <input class="a_search" name="s" type="text" placeholder="<?php _e('Type and hit enter...', 'pi_framework') ?>" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }"/>
    <input class="search-submit" type="submit" />
</form>