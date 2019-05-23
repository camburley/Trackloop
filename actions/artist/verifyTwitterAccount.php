<?php
session_start();
include_once(TL_PATH . 'config784512.php');
include_once(TL_INCLUDE_PATH . 'libs/twitteroauth/twitteroauth.php');

$view->assign('createAccountPath', $createAccountPath);
$view->assign('forgotPasswordPath', $forgotPasswordPath);
	
if(!empty($_REQUEST['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
	//Create a TwitterOauth object with consumer/user tokens
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	
	//Get access token i.e. verify oauth verifier key
	$credentials = $connection->getAccessToken($_REQUEST["oauth_verifier"]);
	
	//Get logged in user account detail
	$user = $connection->get('account/verify_credentials');
	
	$twitterUserId = $user->screen_name;
	
	// already logged-in?
	if (!empty($_SESSION['role'])) {
		Application::redirect('/artist/releases');
	}
	
	$key = Registry::get('config')->read('security.salt');
	
	if (!empty($twitterUserId)) {
		// login user
		$response = $apicaller->sendRequest(array(
			'controller' =>	'User',
			'action'     =>	'verifyTwitterUser',
			'twitterId'  => $twitterUserId
		));
	
		// login failed?
		if (!empty($response->message)) {
			$view->assign('error', $response->message);
		} else {
			// is artist?
			if (!empty($response[0]->uniqueid)) {
				$_SESSION['role'] = 'artist';
				$_SESSION['artistuniqueid']	= $response[0]->uniqueid;
				
				$req = array(
					'controller' =>	'User',
					'action'     => 'readartist',
					'uniqueid' 	 =>	$response[0]->uniqueid
				);
				$artist = $apicaller->sendRequest($req);
				
				$_SESSION['firstname'] 	= $artist[0]->firstname;
				$_SESSION['lastname'] 	= $artist[0]->lastname;
				$_SESSION['twitterid'] 	= $artist[0]->twitterid;
				$username 				= $artist[0]->username;
				$password 				= $artist[0]->password;
				
			}
			
			Application::redirect('/artist/releases');
		}
		
		$iv = md5(md5($key));
		$enpassword	= base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $password, MCRYPT_MODE_CBC, $iv));
		$expire		= time()+60*60*24*7;
		setcookie('cusername',$username,$expire);
		setcookie('cpassword',$enpassword,$expire);
	}

	$cusername = $cpassword = '';
	if(isset($_COOKIE['cusername']))
	{
		$iv = md5(md5($key));
		$cusername	=	$_COOKIE['cusername'];
		$cpassword	=	mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($_COOKIE['cpassword']), MCRYPT_MODE_CBC, $iv);
		$cpassword	=	trim($cpassword);
	}
	
	$view->assign('cusername',$cusername);
	$view->assign('cpassword',$cpassword);
	
	Application::render('loginv1', 'loginLayout');
	
} else {
	$response = $apicaller->sendRequest(array(
		'controller' =>	'User',
		'action'     =>	'verifyTwitterUser',
		'twitterId'  => '#'
	));

	$view->assign('error', $response->message);
	
	Application::render('loginv1', 'loginLayout');
}
?>

