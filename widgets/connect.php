<?php
/**
 * Widget WP_Twitwi_Connect
 */
class WP_Twitwi_Connect extends WP_Widget {
    /** constructor */
    function WP_Twitwi_Connect() {
		$options = array(
			"classname" => "",
			"description" => "Twitwi Connect"
		);
		parent::WP_Widget(false, $name = "Twitwi Connect", $options);	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
		global $wpdb, $post, $user_ID;

        extract($args);

		$infos = !empty($instance["infos"]) ? $instance["infos"] : array("title"=>"", "btn_label");		
		$title = $infos["title"];
		$btn_label = $infos["btn_label"];

		echo $before_widget;
		
?>
		<div class="widget-connect">
<?php		
		if ( $title ) { echo $before_title . $title . $after_title; }
?>
            <div class="widget-connect-content">
<?php
			if (!is_user_logged_in()) {
				echo do_shortcode('[twitwi-btn-connect id="fb-connect" label="'.$btn_label.'" class="block btn-primary"]');
			}
			else {
				$current_user = get_userdata($user_ID);
?>
				<div class="avatar">
<?php
			    	echo get_avatar($current_user->ID, 'small');
?>								
				</div>
				<div class="infos">
					<span class="name"><?php echo $current_user->display_name;?></span>
					<span class="logout"><a href="<?php echo wp_logout_url("/");?>"><?php _e('Logout', 'boobook');?></a></span>
				</div>
				<div class="clear"></div>
<?php				
			}
?>

            </div>
        </div>
<?php
		echo $after_widget; 
	}

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['infos'] = array(
			"title"=>$new_instance['title'],
			"btn_label"=>$new_instance['btn_label']		   
		);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
		$infos = !empty($instance["infos"]) ? $instance["infos"] : array("title"=>__('Connect with Twitter', 'twitwi'), "btn_label"=>__('Login', 'twitwi'));
		$title = esc_attr($infos["title"]);
		$btn_label = esc_attr($infos["btn_label"]);
?>
		<p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'twitwi'); ?>
	        	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </label>
		</p>
		<p>
        	<label for="<?php echo $this->get_field_id('btn_label'); ?>"><?php _e('Button label:', 'twitwi'); ?>
	        	<input class="widefat" id="<?php echo $this->get_field_id('btn_label'); ?>" name="<?php echo $this->get_field_name('btn_label'); ?>" type="text" value="<?php echo $btn_label; ?>" />
            </label>
		</p>
<?php 
    }

} // class WP_Twitwi_Links
?>