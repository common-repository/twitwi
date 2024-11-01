<?php
// +------------------------------------------------------------------------+
// | @author		<xuxu.fr@gmail.com>
// | @version       1.2 (2016/10/18) XN
// | @version       1.1 (2016/10/17) XN
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
$oauth_callback = get_site_url()."/twitwi/connected";
// echo "\$consumer_key = $consumer_key<hr />";
// echo "\$consumer_secret = $consumer_secret<hr />";
// echo "\$oauth_callback = $oauth_callback<hr />";

//
$twitteroauth = new TwitterOAuth($consumer_key, $consumer_secret);
//
$request_token = $twitteroauth->oauth(
    'oauth/request_token', [
        'oauth_callback' => $oauth_callback
    ]
);
//
if (is_array($request_token) && sizeof($request_token) > 0) {
    $token = $request_token['oauth_token'];
    $_SESSION['request_token'] = $token;
    $_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];
 
    if ($twitteroauth->getLastHttpCode() != 200) {
		echo __('Connection with twitter failed', 'twitwi');
    }
    else {
        // generate the URL to make request to authenticate our application
        $url = $twitteroauth->url(
            'oauth/authenticate', [
                'oauth_token' => $request_token['oauth_token']
            ]
        );

        header("Location: ". $url);
        exit;
    }
}
else { //error receiving request token
    echo __('Error Receiving Request Token', 'twitwi');
}

exit;