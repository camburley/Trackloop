<?php

$key = '123456';

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

	if (!empty($response->message)) {
		pr($response->message);
	} else {
		pr("Login successfull. Your unique ID is: " . $response[0]->uniqueid);
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