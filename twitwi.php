<?php
/*
Plugin Name: 	Twitwi
Version:       1.11
Date:          2016/10/18
Plugin URI:		http://xuxu.fr/2013/12/30/twitwi-twitter-connect-basique-pour-wordpress/
Description:	Twitwi, Another Twitter Connect for WordPress
Text Domain:   twitwi
Domain Path:   /languages/
Author:			xuxu.fr
Author URI:		http://xuxu.fr
*/

/* +---------------------------------------------------------------------------------------------------+
   | 
   +---------------------------------------------------------------------------------------------------+ */
session_start();

/* +---------------------------------------------------------------------------------------------------+
   | CONSTANTES
   +---------------------------------------------------------------------------------------------------+ */
if (!defined('WP_PLUGIN_DIR')) {
	$plugin_dir = str_replace('twitwi/', '', dirname(__FILE__));
	define('WP_PLUGIN_DIR', $plugin_dir);
}
define('TWITWI_PLUGIN_DIR', WP_PLUGIN_DIR."/twitwi/");

/* +---------------------------------------------------------------------------------------------------+
   | INCLUDES
   +---------------------------------------------------------------------------------------------------+ */
require_once(WP_PLUGIN_DIR."/twitwi/library/includes/compat.php");
require_once(WP_PLUGIN_DIR."/twitwi/library/install.php");
require_once(WP_PLUGIN_DIR."/twitwi/library/functions.php");
require_once(WP_PLUGIN_DIR."/twitwi/library/functions.image.php");

/* +---------------------------------------------------------------------------------------------------+
   | INCLUDES & Widgets
   +---------------------------------------------------------------------------------------------------+ */
require_once(WP_PLUGIN_DIR."/twitwi/widgets/connect.php");
add_action("widgets_init", create_function("", "return register_widget('WP_Twitwi_Connect');"));

/* +---------------------------------------------------------------------------------------------------+
   | REGISTER ACTIVATION
   +---------------------------------------------------------------------------------------------------+ */
//
register_activation_hook(__FILE__, 'twitwi_install');
register_deactivation_hook(__FILE__, 'twitwi_uninstall');

/* +---------------------------------------------------------------------------------------------------+
   | TEXT DOMAIN
   +---------------------------------------------------------------------------------------------------+ */
function twitwi_load_textdomain() {
   load_plugin_textdomain('twitwi', false, dirname(plugin_basename(__FILE__)).'/languages'); 
}
add_action('init', 'twitwi_load_textdomain');

/* +---------------------------------------------------------------------------------------------------+
   | PARAMS
   +---------------------------------------------------------------------------------------------------+ */
// Gestion thumbs
// 
if (function_exists('add_theme_support')) {
	//
	add_theme_support('post-thumbnails');

	// ajoute des nouvelles dimensions aux thumbs
	twitwi_set_thumbsize();
}