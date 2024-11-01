<?php
// +------------------------------------------------------------------------+
// | @author		<xuxu.fr@gmail.com>
// | @version 		1.3 (2016/10/17) XN
// | @version 		1.2 (2014/03/01) XN
// | @version 		1.1 (2014/03/01) XN
// | @version 		1.0 (2013/12/28) XN
// | Copyright 		(c) 2013 Xuan NGUYEN
// +------------------------------------------------------------------------+

//
require_once(WP_PLUGIN_DIR."/twitwi/inc/twitteroauth/autoload.php");
//
use Abraham\TwitterOAuth\TwitterOAuth;

//
$consumer_key = get_option('twitwi_consumer_key');
$consumer_secret = get_option('twitwi_consumer_secret');
$include_entities = get_option('twitwi_include_entities');
$url_signin = get_site_url()."/twitwi/connect/";

//
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
 
if (empty($oauth_verifier) ||
    empty($_SESSION['request_token']) ||
    empty($_SESSION['request_token_secret'])
) {
    // something's missing, go and login again
    header('Location: '.$url_signin);
	exit;
}

if(isset($_GET['oauth_token'])) { 
	//
    $twitteroauth = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['request_token'], $_SESSION['request_token_secret']);

	// request user token
	$access_token = $twitteroauth->oauth(
	    'oauth/access_token', [
	        'oauth_verifier' => $oauth_verifier
	    ]
	);

    if(!empty($access_token)) {
        $twitteroauth = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $params =array();
        $params['include_entities'] = $include_entities;
        $content = $twitteroauth->get('account/verify_credentials', $params);

 		//
        if($content && isset($content->screen_name) && isset($content->name)) {
			//
			$args = array(
				'orderby' => 'display_name',
				'order' => 'ASC',
				'blog_id'=>1,
				'meta_key'=>'twitwi_user_id',
				'meta_value'=>$content->id
			);
			$the_query = new WP_User_Query($args);
			$users = $the_query->get_results();

			if (sizeof($users) == 0) {
				//
				$random_password = wp_generate_password($length = 8, $include_standard_special_chars = false);

				//
				$twitwi_domain_mail_default = get_option('twitwi_domain_mail_default');
				$twitwi_domain_mail_default = (empty($twitwi_domain_mail_default)) ? "twitwi.org" : $twitwi_domain_mail_default;

				$user_id = wp_create_user($content->screen_name, $random_password, $content->screen_name."@".$twitwi_domain_mail_default);

				//
				$twitwi_role_default = get_option('twitwi_role_default');
				$U = new WP_User($user_id);
				$U->add_role($twitwi_role_default);

				//
				do_action('twitwi_user_created', $user_id);

				// send mail
				$blogname = get_bloginfo('name');
				$mailadmin = get_bloginfo('admin_email');

				//
				$twitwi_register_notif = get_option('twitwi_register_notif');
				if (!empty($twitwi_register_notif) && $twitwi_register_notif > 0) {
					//$attachments = array( WP_CONTENT_DIR . '/uploads/file_to_attach.zip');
					$attachments = "";
					$headers = 'From: '.$blogname.' <'.$mailadmin.'>'."\r\n";
					$message = "
						<strong>".__('A new user just subscribed with Twitwi.', 'twitwi')."</strong><br />
						<p>Email : <strong>".$content->screen_name."</strong></p>
						<p>".__('Name', 'twitwi')." : <strong>".$content->name."</strong></p>
					";
					wp_mail($mailadmin, '['.$blogname.'] '.__('New user registered', 'twitwi').' : '.$name, $message, $headers, $attachments);
				}
			}
			else {
				$user_id = $users[0]->ID;
			}

			$params = array(
				"ID"=>$user_id,
				"last_name"=>$content->name,
				"first_name"=>"",
				"display_name"=>$content->screen_name,
				"description"=>$content->description,
			);

			//
			do_action('twitwi_user_before_update', $user_id, $params, $content);

			//
			wp_update_user($params);

			//
		   	update_user_meta($user_id, 'twitwi_user_id', $content->id);

		   	// avatar manage
			$picture_path = $content->profile_image_url;
			$picture_path = str_replace("_normal", "", $picture_path);

			$twitwi_picture_max = get_user_meta($user_id, 'twitwi_picture_max', 1);
			$twitwi_picture_imported = get_user_meta($user_id, 'twitwi_picture_imported', 1);

			$avatar_filename = "twitwi_".$user_id."_".$content->id."_".basename($picture_path);
			
			$upload_dir = wp_upload_dir();
			$final_url = $upload_dir['url']."/".$avatar_filename;
			$final_path = $upload_dir['path']."/".$avatar_filename;

			if (!file_exists($final_path) || ($twitwi_picture_max != $content->profile_image_url)) {			
				//
				if (!empty($twitwi_picture_imported)) {
					wp_delete_attachment($twitwi_picture_imported, 1);
				}

			   	// Avatar manage
			   	$f = fopen($picture_path, 'r');
				$contents = '';
				while (!feof($f)) { $contents .= fread($f, 8192); }
				fclose($f);

			   	$f = fopen($final_path, 'w+');
			   	fwrite($f, $contents);
			   	fclose($f);

				$wp_filetype = wp_check_filetype(basename($final_path), null);
				$attachment = array(
					'guid' => $upload_dir['url'].'/'.basename($final_path), 
					'post_author' => $user_id,
					'post_type' => 'attachment',  
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($final_path)),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$subpath = $upload_dir['subdir']."/".basename($final_path);
				$subpath = preg_replace("/^\//", "", $subpath);
				$attach_id = wp_insert_attachment($attachment, $subpath);

				// you must first include the image.php file
				// for the function wp_generate_attachment_metadata() to work
				require_once ABSPATH.'wp-admin/includes/image.php';
				$attach_data = wp_generate_attachment_metadata($attach_id, $final_path);
				wp_update_attachment_metadata($attach_id, $attach_data);

			   	update_user_meta($user_id, 'twitwi_picture_imported', $attach_id);

			   	update_user_meta($user_id, 'twitwi_picture_max', $content->profile_image_url);

				//
				do_action('twitwi_user_avatar_updated', $user_id, $attach_id);
			}

			wp_set_auth_cookie($user_id, $remember = true, $secure = '');

			//
			do_action('twitwi_user_authenticated', $user_id, $content);

			//
			$twitwi_logged_redirect = get_option('twitwi_logged_redirect');
			if (!empty($twitwi_logged_redirect)) {
				wp_redirect($twitwi_logged_redirect);
			}
			else {
				wp_redirect(home_url());
			}
        }
        else {
			echo __('NO USER FOUND :/', 'twitwi');
        }
    }
	else {
		echo __('ACCESS TOKEN INVALID', 'twitwi');
	}
}
else {
	header("Location: /");
}
exit;