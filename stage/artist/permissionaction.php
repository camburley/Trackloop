<?php
require_once('../config.php');
require_once($path."/apicaller.php");
$ipaddress	=	$_SERVER['REMOTE_ADDR'];
$signupdate	=	date('Y/m/d h:i:s');
$apicaller	=	new ApiCaller();
$apicaller->filterRequest();
extract($_POST);
$sections	=	$_GET['selectedsections'];
$artistuniqueid	=	$_GET['artistuniqueid'];
$admindate	=	date('y-m-d');
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
if(strlen($password)<8)
{
	echo "Password should be 8 digits.";
	exit;
}
$pkmemberid	=	$_GET['pkmemberid'];
$username	=	trim($username);
$password	=	trim($password);
$req		=	array(
							'controller'	=>	'Permission',
							'action'		=>	'memberpermission',
							'artistuniqueid' =>	$artistuniqueid,
							'username'		=>	$username,
							'password'		=>	$password,
							'sections'		=>	$sections,
							'pkmemberid'	=>	$pkmemberid
						);
$memebers	=	$apicaller->sendRequest($req);
echo $memebers->message;
?>