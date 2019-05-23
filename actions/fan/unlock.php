<?php

require TL_INCLUDE_PATH . 'libs/twitteroauth/twitteroauth.php';

$albumuniqueid  = Application::param('album');
$artistuniqueid	= Application::param('artist');

// load Twitter APP configuration params
$config = Registry::get('config');
$consumer_key    = $config->read('twitter.consumer_key');
$consumer_secret = $config->read('twitter.consumer_secret'); 

$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$method	=	'users/show/'.$_SESSION['access_token']['screen_name'];
$response = $connection->get($method);

$followers_count = $response->followers_count;
$user_location = $response->location;
$_SESSION['user_location'] = $user_location;

$totalreach = $apicaller->sendRequest(array(
	'controller' 	 =>	'Reach',
	'action'		 =>	'createreach',
	'albumuniqueid'  =>	$albumuniqueid,
	'reachdate' 	 =>	date('Y/m/d h:i:s'),
	'totalfollowers' =>	$followers_count + 1,
	'twitterid'		 =>	$_SESSION['access_token']['screen_name'],
	'location'		 =>	$user_location
));

$albumurl = Registry::get('config')->read('app.url') . 'artist/album/' . $artistuniqueid . '/' . $albumuniqueid;
$tinyurl = get_tiny_url($albumurl);

$tweettext = $_POST['tweettext'] . ' ' . $tinyurl;
$status = $connection->post('statuses/update', array(
	'status' => $tweettext
));

echo "Tweet Posted";