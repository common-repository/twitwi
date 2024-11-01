<?php
	/*----------------------------------------------------------------------*
	 | add option page for twitwi
	 *----------------------------------------------------------------------*/
	function add_twitwi_options() {
		add_options_page(__('Twitwi settings', 'twitwi'), __('Twitwi', 'twitwi'), 'manage_options', 'twitwi-page-options', 'twitwi_options');  
	}
    add_action('admin_menu', 'add_twitwi_options');  

	/*----------------------------------------------------------------------*
	 | option page form for twitwi
	 *----------------------------------------------------------------------*/
	function twitwi_options() {  
		global $wp_roles;
?>  
	<div class="wrap">  
		<h2><?php _e('Twitwi settings', 'twitwi');?></h2>  
		<form method="post" action="options.php">  
			<input type="hidden" name="action" value="update" />  
    		<input type="hidden" name="page_options" value="twitwi_consumer_key, twitwi_consumer_secret, twitwi_include_entities, twitwi_role_default, twitwi_register_notif, twitwi_logged_redirect, twitwi_logout_redirect, twitwi_domain_mail_default" />  
			<?php wp_nonce_field('update-options');?>  
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="twitwi_consumer_key"><?php _e('Consumer Key', 'twitwi');?></label></th>
						<td>
							<input type="text" id="twitwi_consumer_key" name="twitwi_consumer_key" class="regular-text code" value="<?php echo get_option('twitwi_consumer_key');?>" />  
						</td>
					</tr>
					<tr>
						<th><label for="twitwi_consumer_secret"><?php _e('Consumer Secret', 'twitwi');?></label></th>
						<td>
							<input type="text" id="twitwi_consumer_secret" name="twitwi_consumer_secret" class="regular-text code" value="<?php echo get_option('twitwi_consumer_secret');?>" />  
						</td>
					</tr>
					<tr>
						<th><label for="twitwi_include_entities"><?php _e('Include entities', 'twitwi');?></label></th>
						<td>
							<?php $twitwi_include_entities = get_option('twitwi_include_entities');?>
							<select id="twitwi_include_entities" name="twitwi_include_entities">
								<option value="0"<?php echo ($twitwi_include_entities == 0) ? " selected=\"selected\"" : "";?>><?php _e('No', 'twitwi');?></option>
								<option value="1"<?php echo ($twitwi_include_entities == 1) ? " selected=\"selected\"" : "";?>><?php _e('Yes', 'twitwi');?></option>
							</select>
 						</td>
					</tr>
					<tr>
						<th><label for="twitwi_role_default"><?php _e('Default user role when created', 'twitwi');?></label></th>
						<td>
							<select id="twitwi_role_default" name="twitwi_role_default">
<?php
							$twitwi_role_default = get_option('twitwi_role_default');
							foreach($wp_roles->role_objects as $key=>$value) {
								$selected = ($key == $twitwi_role_default) ? " selected=\"selected\"" : "";
								echo "<option value=\"".$key."\"".$selected.">";
								echo translate_user_role(ucfirst($value->name));
								echo "</option>";
							}
?>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="twitwi_domain_mail_default"><?php _e('Default domain name for the temporary email', 'twitwi');?></label></th>
						<td>
							<input type="text" id="twitwi_domain_mail_default" name="twitwi_domain_mail_default" class="regular-text code" value="<?php echo get_option('twitwi_domain_mail_default');?>" /><br />
							<?php _e("The Twitter API does not allow the recovery of the user's email address, a temporary email will be generated to create the WordPress account", 'twitwi');?>
						</td>
					</tr>
					<tr>
						<th><label for="twitwi_register_notif"><?php _e('Receive an email when an user was created', 'twitwi');?></label></th>
						<td>
							<?php $twitwi_register_notif = get_option('twitwi_register_notif');?>
							<select id="twitwi_register_notif" name="twitwi_register_notif">
								<option value="1"<?php echo ($twitwi_register_notif == 1) ? " selected=\"selected\"" : "";?>><?php _e('Yes', 'twitwi');?></option>
								<option value="0"<?php echo ($twitwi_register_notif == 0) ? " selected=\"selected\"" : "";?>><?php _e('No', 'twitwi');?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="twitwi_logged_redirect"><?php _e('Redirect URL after login', 'twitwi');?></label></th>
						<td>
							<input type="text" id="twitwi_logged_redirect" name="twitwi_logged_redirect" class="regular-text code" value="<?php echo get_option('twitwi_logged_redirect');?>" />  
							<br />
 							<em><?php _e('If empty, the person will be redirected to the previous page', 'twitwi');?></em>
 						</td>
					</tr>
					<tr>
						<th><label for="twitwi_logout_redirect"><?php _e('Redirect URL after logout', 'twitwi');?></label></th>
						<td>
							<input type="text" id="twitwi_logout_redirect" name="twitwi_logout_redirect" class="regular-text code" value="<?php echo get_option('twitwi_logout_redirect');?>" />  
							<br />
 							<em><?php _e('If empty, the person will be redirected to the site root &laquo;/&raquo;', 'twitwi');?></em>
 						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" class="button button-primary" name="submit" value="<?php _e('Save', 'twitwi');?>" />
			</p>  
    	</form>  
	</div>  
<?php  
}  


	/*----------------------------------------------------------------------*
	 |
	 *----------------------------------------------------------------------*/
	function twitwi_admin_enqueue_scripts() {
		wp_enqueue_script('twitwi-back', WP_PLUGIN_URL.'/twitwi/js/twitwi-back.js');
	}
	add_action('admin_enqueue_scripts', 'twitwi_admin_enqueue_scripts');


	/*----------------------------------------------------------------------*
	 |
	 *----------------------------------------------------------------------*/
	function twitwi_admin_enqueue_styles() {
		wp_enqueue_style('twitwi-back', WP_PLUGIN_URL.'/twitwi/css/twitwi-back.css');
	}
	add_action('admin_enqueue_scripts', 'twitwi_admin_enqueue_styles');


	/*----------------------------------------------------------------------*
	 |
	 *----------------------------------------------------------------------*/
	function twitwi_enqueue_scripts() {
		//
		do_action('twitwi_hook_scripts');
		//
		wp_enqueue_script('twitwi-front', WP_PLUGIN_URL.'/twitwi/js/twitwi-front.js', array('jquery'));
	}
	add_action('wp_enqueue_scripts', 'twitwi_enqueue_scripts');


	/*----------------------------------------------------------------------*
	 |
	 *----------------------------------------------------------------------*/
	function twitwi_enqueue_styles() {
		//
		do_action('twitwi_hook_styles');
		//
		wp_enqueue_style('twitwi-front', WP_PLUGIN_URL.'/twitwi/css/twitwi-front.css');
	}
	add_action('wp_enqueue_scripts', 'twitwi_enqueue_styles');


	/*----------------------------------------------------------------------*
	 |
	 *----------------------------------------------------------------------*/
	function twitwi_wp_head() {
	?>
		<script type="text/javascript">
			// plugin
			var twitwi_ajax_url = '<?php echo WP_PLUGIN_URL;?>/twitwi/ws/';
			var WP_PLUGIN_URL = '<?php echo WP_PLUGIN_URL;?>';
		</script>
	<?php
	}
	add_action('wp_head', 'twitwi_wp_head');


	/*----------------------------------------------------------------------*
	 | shortcode
	 *----------------------------------------------------------------------*/
	function twitwi_sc($atts) {
		global $wpdb, $post;

		$classes = array("btn", "twitwi-btn", "connect-btn");

		extract(shortcode_atts(array(
			'id' => '',
			'label' => '',
			'class' => '',
		), $atts));

		$class = explode(' ', $class);
		foreach($class as $classname) {
			$classes[] = ltrim(rtrim($classname));
		}

		$id = (!empty($id)) ? "id=\"".$id."\"" : "";
		$label = (!empty($label)) ? $label : __('Login', 'twitwi');;

		if (!is_user_logged_in()) {
			$content = "<button ".$id." class=\"".implode(' ', $classes)."\"><span>".$label."</span></button>";
		}
		else {
			$content = "";	
		}
		
		return $content;
	}
	add_shortcode('twitwi-btn-connect', 'twitwi_sc');


	/*----------------------------------------------------------------------*
	 | Template redirect
	 *----------------------------------------------------------------------*/
	// http://stackoverflow.com/questions/4647604/wp-use-file-in-plugin-directory-as-custom-page-template
	function twitwi_theme_redirect() {
	    global $wp, $wp_query;

	    // twitwi connect
	    if (!empty($_SERVER['REQUEST_URI']) && preg_match("/^\/twitwi\/connect\/?$/", $_SERVER['REQUEST_URI'], $matches)) {
		    //
			$wp_query->is_404 = false;		
			status_header(200);
			//
	        $template_filename = 'connect.php';
			$return_template = TWITWI_PLUGIN_DIR.'template/'.$template_filename;
	        include($return_template);
	    }
	    // twitwi connected
	    if (!empty($_SERVER['REQUEST_URI']) && preg_match("/^\/twitwi\/connected/", $_SERVER['REQUEST_URI'], $matches)) {
		    //
			$wp_query->is_404 = false;		
			status_header(200);
			//
	        $template_filename = 'connected.php';
			$return_template = TWITWI_PLUGIN_DIR.'template/'.$template_filename;
	        include($return_template);
	    }
	}
	add_action('template_redirect', 'twitwi_theme_redirect');

	/*----------------------------------------------------------------------*
	 | Twitwi avatar
	 *----------------------------------------------------------------------*/
	function twitwi_get_avatar($avatar, $id_or_email, $size, $default, $alt) {
		global $wpdb, $user_ID;

		if(is_numeric($id_or_email)) {
			$user_id = $id_or_email;
		}
		else if (is_string($id_or_email)) {
			$query = "SELECT `ID` FROM `$wpdb->users` WHERE `user_email` = '".$id_or_email."'";
			$user_id = $wpdb->get_var($query);
		}
		else {

		}
		if(is_numeric($size)) {
			$style = " width=\"".$size."\" height=\"".$size."\"";
			$size = array($size, $size);
		}
		else if (is_array($size)) {
			$style = " width=\"".$size[0]."\" height=\"".$size[1]."\"";
			$size = $size;
		}
		else if (is_string($size)) {
			$style = "";
			$size = $size;
		}

		$attachment_id = get_user_meta($user_id, 'twitwi_picture_imported', 1);
		if (!empty($attachment_id)) {
			$image = wp_get_attachment_image_src($attachment_id, $size);
			//echo "\$attachment_id = $attachment_id";
			$avatar = "<img src=\"".$image[0]."\"".$style." alt=\"Twitwi avatar\" class=\"avatar photo\" />";
		}

	    return $avatar;
	}
	add_filter('get_avatar', 'twitwi_get_avatar', 10, 5);


	/*----------------------------------------------------------------------*
	 | Twitwi logout
	 *----------------------------------------------------------------------*/
	function twitwi_logout() {
    	foreach($_SESSION as $key=>$value) {
    		$_SESSION[$key] = null;
    		unset($_SESSION[$key]);
    	}
	}
	add_action('wp_logout','twitwi_logout');	


	/*----------------------------------------------------------------------*
	 | Twitwi logout url
	 *----------------------------------------------------------------------*/
	function twitwi_logout_url($logout_url, $redirect = null) {
		$twitwi_logout_redirect = get_option('twitwi_logout_redirect');
		if (!empty($twitwi_logout_redirect)) {
			$_wpnonce = wp_create_nonce('log-out');
			$logout_url_new = home_url()."/wp-login.php?action=logout&redirect_to=".urlencode($twitwi_logout_redirect)."&_wpnonce=".$_wpnonce;
			return $logout_url_new;	
		}

		return $logout_url;
	}
	add_filter('logout_url', 'twitwi_logout_url');

