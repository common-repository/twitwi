<?php
	//
	function twitwi_install() {
		global $wpdb, $wp, $wp_rewrite;

		$twitwi_db_version = "1.0";
		
		//
		update_option("twitwi_db_version", $twitwi_db_version);

		//
		$twitwi_role_default = get_option("default_role");
		$twitwi_role_default = (empty($twitwi_role_default)) ? "subscriber" : $twitwi_role_default;
		update_option("twitwi_role_default", $twitwi_role_default);

		//
		update_option("twitwi_register_notif", 1);
		update_option("twitwi_include_entities", 0);
		update_option("twitwi_logged_redirect", '');
		update_option("twitwi_logout_redirect", '');
		update_option("twitwi_domain_mail_default", 'twitwi.org');
	}

	//
	function twitwi_uninstall() {
		//
		global $wpdb;

		//
		delete_option('twitwi_db_version');
		delete_option('widget_wp_twitwi_connect');
		delete_option('twitwi_role_default');
		delete_option('twitwi_register_notif');
		delete_option('twitwi_logged_redirect');
		delete_option('twitwi_logout_redirect');
		delete_option('twitwi_domain_mail_default');
		delete_option('twitwi_consumer_key');
		delete_option('twitwi_consumer_secret');
		delete_option('twitwi_include_entities');

		//
        $sql = "
        	DELETE FROM `".$wpdb->usermeta."`
        	WHERE
        		`meta_key` IN ('twitwi_user_id', 'twitwi_picture_imported', 'twitwi_picture_max')
    	";
        $wpdb->query($sql);
	}