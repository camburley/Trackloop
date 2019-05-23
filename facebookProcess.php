<?php

include_once('config784512.php');
include_once('includes/libs/facebookoauth/facebook.php');  // Include facebook SDK file

$view->assign('createAccountPath', $createAccountPath);
$view->assign('forgotPasswordPath', $forgotPasswordPath);

//Create object of Facebook class
$facebook = new Facebook(array(
  'appId'  => APP_ID,   // Facebook App ID 
  'secret' => APP_SECRET,  // Facebook App Secret
  'cookie' => false
));

//Get facebook logged in user information
$user = $facebook->getUser();

//Set login URL
$loginUrl = $facebook->getLoginUrl(array(
	'scope'			=> 'read_stream, publish_stream, email, user_about_me',
	'redirect_uri'	=> SITE_URL // Permissions to request from the user
));
//Assign facebook url
$view->assign('facebookLoginUrl', $loginUrl);

if(($user)) {
	try {		
		//Get logged in user profile information
		$user_profile = $facebook->api('/me');

		// To Get Facebook email ID
		$email = $user_profile['email'];
		
		//Destroy facebook session
		$facebook->destroySession();

		//Redirect to verify facebook account		
		Application::redirect('/verify-facebook-account?email=' .  $email);		

		exit;
  	} catch (FacebookApiException $e) {
    	error_log($e);
   		$user = null;
  	}
} 
?>