<?php

require TL_INCLUDE_PATH . 'libs/twitteroauth/twitteroauth.php';

$albumuniqueid  = Application::param('album');
$artistuniqueid	= Application::param('artist');

// load Twitter APP configuration params
$config = Registry::get('config');
$consumer_key    = $config->read('twitter.consumer_key');
$consumer_secret = $config->read('twitter.consumer_secret');

$oauth_token = Application::data('oauth_token');
$oauth_verifier = Application::data('oauth_verifier');

if (!empty($oauth_verifier)) {
	// connect to Twitter API with the temporary access token
	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	
	// obtain a long-lasting user token
	$access_token = $connection->getAccessToken($oauth_verifier);
	$_SESSION['access_token'] = $access_token;
	
	// now we don't need the request token anymore, we'll remove it from the session.
	unset($_SESSION['oauth_token']);
	unset($_SESSION['oauth_token_secret']);
	
	// connect to Twitter API with the user access token
	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$account = $connection->get('account/verify_credentials');
	
	Application::redirect("/artist/album/{$artistuniqueid}/{$albumuniqueid}?tweet=yes");
}

// fresh connection to Twitter API
$callbackurl = Registry::get('config')->read('app.url') . "fan/connect/{$artistuniqueid}/{$albumuniqueid}";
$connection = new TwitterOAuth($consumer_key, $consumer_secret);
$request_token = $connection->getRequestToken($callbackurl);

// connection failed?
if (200 != $connection->http_code) {
    echo 'Could not connect to Twitter. Refresh the page or try again later.';
}

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

/**
 * Authorization successfull?
 * Send the user to our application page where the authorization codes will be recognized and saved
*/
$authorizeUrl = $connection->getAuthorizeURL($request_token['oauth_token']);
header("Location: $authorizeUrl");