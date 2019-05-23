<?php
@session_start();
require_once('../config.php');
require_once($path."/apicaller.php");
$apicaller	=	new ApiCaller();
$apicaller->filterRequest();
extract($_POST);
if($username=="")
{
	echo "User Name cannot be empty.";
	exit;
}
if($password=="")
{
	echo "Password cannot be empty.";
	exit;
}

if($_GET['remember'])
{
	$iv = md5(md5($key));
	$enpassword	=	mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $password, MCRYPT_MODE_CBC, $iv);
	$enpassword = base64_encode($enpassword);
	$expire		=	time()+60*60*24*7;
	setcookie('cusername',$username,$expire);
	setcookie('cpassword',$enpassword,$expire);
}

$req		=	array(
							'controller'	=>	'User',
							'action'		=>	'login',
							'username'		=>	$username,
							'password'		=>	$password,
						);
$loginusers	=	$apicaller->sendRequest($req);
//$apicaller->dump($loginusers,1);
if($loginusers->message)
{
	echo $loginusers->message;
	return;
}
if($loginusers[0]->pkmemberid)
{
	$_SESSION['artistuniqueid']	=	$loginusers[0]->uniqueid;
	$_SESSION['pkmemberid']		=	$loginusers[0]->pkmemberid;
	$_SESSION['sectionid']		=	explode(",",$loginusers[0]->sectionid);
	$_SESSION['firstname']		=	$firstname;
	$_SESSION['lastname']		=	$lastname;
	return;
}
if($loginusers[0]->uniqueid)
{
	$_SESSION['artistuniqueid']	=	$loginusers[0]->uniqueid;
	
	$req		=	array(
						'controller' 	=>	'User',
						'action'		=>	'readartist',
						'uniqueid' 		=>	$loginusers[0]->uniqueid
						);
	$artists = $apicaller->sendRequest($req);
	//$apicaller->dump($artists);
	foreach($artists as $artist)
	{
		$firstname	=	ucfirst($artist->firstname);
		$lastname	=	ucfirst($artist->lastname);
	}
	$_SESSION['firstname']		=	$firstname;
	$_SESSION['lastname']		=	$lastname;
	
}
?>