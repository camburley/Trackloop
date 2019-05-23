<?php
/**
 * @file
 * 
 */

/* Load required lib files. */
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
$apicaller->filterRequest();
$tweetdate	=	date('Y/m/d h:i:s');
require_once('../abrahm/twitteroauth/twitteroauth.php');
require_once('../abrahm/config.php');
require_once("../abrahm/test.php");
$totalfollowers	=	$_SESSION['totalfollowers']+1;
	$req		=	array(
								'controller' 		=>	'Reach',
								'action'			=>	'createreach',
								'albumuniqueid' 	=>	$_SESSION['albumid'],
								'reachdate' 		=>	$tweetdate,
								'totalfollowers'	=>	$totalfollowers,
								'twitterid'			=>	$_SESSION['access_token']['screen_name'],
								'location'			=>	$_SESSION['location']
							);
		$totalreach = $apicaller->sendRequest($req);

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ../abrahm/clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection	=	new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$albumurl	=	$_SESSION['albumurl'];
$tweettext	=	$_POST['tweettext'].' '.$albumurl;

/* If method is set change API call made. Test is called by default. */
//$content = $connection->get('account/rate_limit_status');
/* statuses/update */
//date_default_timezone_set('GMT+5');
$parameters = array('status' => $tweettext);
$status = $connection->post('statuses/update', $parameters);
twitteroauth_row('statuses/update', $status, $connection->http_code, $parameters);

echo "Tweet Posted";
?>