<?php
require_once('../config.php');
require_once($path."/apicaller.php");
$ipaddress	=	$_SERVER['REMOTE_ADDR'];
$signupdate	=	date('Y/m/d h:i:s');
$apicaller	=	new ApiCaller();
$apicaller->filterRequest();
extract($_POST);
if(sizeof($_POST) > 0)
{
	$req		=	array(
							'controller'	=>	'User',
							'action'		=>	'createfan',
							'username'		=>	$username,
							'password'		=>	$password,
							'firstname'		=>	$firstname,
							'lastname'		=>	$lastname,
							'address1'		=>	$address1,
							'address2'		=>	$address2,
							'phone'			=>	$phone,
							'mobile'		=>	$mobile,
							'twitterid'		=>	$twitterid,
							'location'		=>	$location,
							'ipaddress'		=>	$ipaddress,
							'signupdate'	=>	$signupdate
						);
}
else
{
	$req		=	array(
							'controller'	=>	'User',
							'action'		=>	'createfan',
							'username'		=>	'muqtadir007@gumptech.net',
							'password'		=>	'gumptech',
							'firstname'		=>	'abdul',
							'lastname'		=>	'lastname',
							'address1'		=>	'address1',
							'address2'		=>	'address2',
							'phone'			=>	'phone',
							'mobile'		=>	'mobile',
							'twitterid'		=>	'amuqtadir88',
							'location'		=>	'Jhanda Chichi, Rawalpindi, Punjab,Pakistan',
							'ipaddress'		=>	$ipaddress,
							'signupdate'	=>	$signupdate
						);
}
$users	=	$apicaller->sendRequest($req);
$apicaller->dump($users,1);
?>