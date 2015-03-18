<?php
/* -----------------------------------------------------------------------------------

  Plugin Name: Contact Info Widget
  Plugin URI: http://www.pixel-industry.com
  Description: A widget that displays contact information.
  Version: 1.0
  Author: Pixel Industry
  Author URI: http://www.pixel-industry.com

  ----------------------------------------------------------------------------------- */


// Add function to widgets_init that'll load our widget
add_action('widgets_init', 'pi_contact_info');

// Register widget
function pi_contact_info() {
    register_widget('pi_contact_info');
}

// Widget class
class pi_contact_info extends WP_Widget {
    /* ----------------------------------------------------------------------------------- */
    /* 	Widget Setup
      /*----------------------------------------------------------------------------------- */

    function pi_contact_info() {

        // Widget settings
        $widget_options = array(
            'classname' => 'contact-info',
            'description' => __('A widget that displays contact information.', 'pi_framework')
        );


        // Create the widget
        $this->WP_Widget('pi_contact_info', __('Contact Info', 'pi_framework'), $widget_options);
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Display Widget
      /*----------------------------------------------------------------------------------- */

    function widget($args, $instance) {
        extract($args);

        // Our variables from the widget settings
        $title = apply_filters('widget_title', $instance['title']);

        // Before widget (defined by theme functions file)
        echo $before_widget;

        // Display the widget title if one was input
        if ($title)
            echo $before_title . $title . $after_title;
        
        $address_string = !empty($instance['address_string']) ? $instance['address_string'] : __('Address:', 'pi_framework');
        $phone_string = !empty($instance['phone_string']) ? $instance['phone_string'] : __('Phone:', 'pi_framework');
        $fax_string = !empty($instance['fax_string']) ? $instance['fax_string'] : __('Fax:', 'pi_framework');

        echo $instance['before'];

        echo "<ul class='contact-info-list'>";

        if (!empty($instance['address']))
            echo "<li>
                        <p>
                            <i class='icon-home'></i>
                            <span class='strong'>{$address_string} </span>
                            {$instance['address']}
                        </p>
                    </li>";
                            
        do_action('wci_print_home');

        if (!empty($instance['phone']))
            echo "<li>
                        <p>
                            <i class='icon-phone'></i>
                            <span class='strong'>{$phone_string} </span>
                            {$instance['phone']}
                        </p>
                    </li>";
                            
        do_action('wci_print_phone');

        if (!empty($instance['fax']))
            echo "<li>
                        <p>
                            <i class='icon-phone'></i>
                            <span class='strong'>{$fax_string} </span>
                            {$instance['fax']}
                        </p>
                    </li>";
                            
        do_action('wci_print_fax');

        echo "</ul>";

        echo $instance['after'];

        // After widget (defined by theme functions file)
        echo $after_widget;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Update Widget
      /*----------------------------------------------------------------------------------- */

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['before'] = $new_instance['before'];
        $instance['address_string'] = strip_tags($new_instance['address_string']);
        $instance['address'] = strip_tags($new_instance['address']);
        $instance['phone_string'] = strip_tags($new_instance['phone_string']);
        $instance['phone'] = strip_tags($new_instance['phone']);
        $instance['fax_string'] = strip_tags($new_instance['fax_string']);
        $instance['fax'] = strip_tags($new_instance['fax']);
        $instance['after'] = $new_instance['after'];

        // No need to strip tags

        return $instance;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Widget Settings (Displays the widget settings controls on the widget panel)
      /*----------------------------------------------------------------------------------- */

    function form($instance) {

        // Set up some default widget settings
        $defaults = array(
            'title' => 'Contact Info',
            'before' => '',
            'address_string' => 'Address:',
            'address' => '',
            'phone_string' => 'Phone:',
            'phone' => '',
            'fax_string' => 'Fax:',
            'fax' => '',
            'after' => '',
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'pi_framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <!-- Before: Textarea -->
        <p>
            <label for="<?php echo $this->get_field_id('before'); ?>"><?php _e('Before:', 'pi_framework') ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('before'); ?>" name="<?php echo $this->get_field_name('before'); ?>"><?php echo $instance['before']; ?></textarea>
        </p>
        
        <!-- Address String: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('address_string'); ?>"><?php _e('Address Text:', 'pi_framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('address_string'); ?>" name="<?php echo $this->get_field_name('address_string'); ?>" value="<?php echo $instance['address_string']; ?>" />
        </p>


        <!-- Address: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'pi_framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo $instance['address']; ?>" />
        </p>
        
        <!-- Phone String: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('phone_string'); ?>"><?php _e('Phone Text:', 'pi_framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('phone_string'); ?>" name="<?php echo $this->get_field_name('phone_string'); ?>" value="<?php echo $instance['phone_string']; ?>" />
        </p>

        <!-- Phone: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', 'pi_framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $instance['phone']; ?>" />
        </p>
        
        <!-- Fax string: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('fax_string'); ?>"><?php _e('Fax Text:', 'pi_framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('fax_string'); ?>" name="<?php echo $this->get_field_name('fax_string'); ?>" value="<?php echo $instance['fax_string']; ?>" />
        </p>

        <!-- Fax: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax:', 'pi_framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" value="<?php echo $instance['fax']; ?>" />
        </p>

        <!-- After: Textarea -->
        <p>
            <label for="<?php echo $this->get_field_id('after'); ?>"><?php _e('After:', 'pi_framework') ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('after'); ?>" name="<?php echo $this->get_field_name('after'); ?>"><?php echo $instance['after']; ?></textarea>
        </p>

        <?php
    }

}
?>