<?php

require_once(TL_PATH . 'config784512.php');
require_once(TL_PATH . 'facebookProcess.php');

$view->assign('createAccountPath', $createAccountPath);
$view->assign('forgotPasswordPath', $forgotPasswordPath);

// already logged-in?
if (!empty($_SESSION['role'])) {
	Application::redirect('/artist/releases');
}

$key = Registry::get('config')->read('security.salt');

if (!empty($_POST)) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// login user
	$response = $apicaller->sendRequest(array(
		'controller' =>	'User',
		'action'     =>	'login',
		'username'   =>	$username,
		'password'   =>	$password,
	));
	
	// login failed?
	if (!empty($response->message)) {
		$view->assign('error', $response->message);
	} else {
		// is member?
		if(!empty($response[0]->pkmemberid)) {
			$_SESSION['role'] = 'member';
			$_SESSION['artistuniqueid']	= $response[0]->uniqueid;
			$_SESSION['pkmemberid'] = $response[0]->pkmemberid;
			$_SESSION['sectionid'] = explode(",",$response[0]->sectionid);
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] =	$lastname;
			$_SESSION['twitterid'] 	= "";
		}
		
		// is artist?
		elseif (!empty($response[0]->uniqueid)) {
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