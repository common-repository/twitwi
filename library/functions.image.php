<?php
/*----------------------------------------------------------------------*
 |
 *----------------------------------------------------------------------*/
function twitwi_set_thumbsize() {
	global $wpdb;
	
	//
	add_image_size('twitwi-header-thumbnail', 140, 80, true);
	add_image_size('twitwi-header-thumbnail-reverse', 100, 120, true);
	add_image_size('twitwi-post-thumbnail', 280, 160, true);
}