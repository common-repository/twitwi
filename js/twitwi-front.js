// JavaScript Document

//
jQuery.noConflict();
//
jQuery(document).ready(function() {
	//
	jQuery('.twitwi-btn').click(function() {
		return twiconnect_js();
	});
});

// ----------------------------------------------------------------------------------------------------
// Vars
// ----------------------------------------------------------------------------------------------------
var tw_user_id, tw_access_token;

// ----------------------------------------------------------------------------------------------------
// twiconnect JS
// ----------------------------------------------------------------------------------------------------
var twiconnect_js = function() {
	document.location = '/twitwi/connect';

	return false;
}

// ----------------------------------------------------------------------------------------------------
// via http://www.quirksmode.org/js/cookies.html
// ----------------------------------------------------------------------------------------------------
function createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name) {
	createCookie(name, "", -1);
}