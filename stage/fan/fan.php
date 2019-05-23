<?php
@session_start();
require_once("../config.php");
require_once($path."/securityfan.php");
$apicaller->filterRequest();
extract($_POST);
$uniqueid	=	'8RHPWYGKFX7MQDJ9';
$req		=	array(
						'controller' 	=>	'User',
						'action'		=>	'readfan',
						'uniqueid' 		=>	$uniqueid
						);
$fans = $apicaller->sendRequest($req);
foreach($fans as $fan)
{
	echo $artistuniqueid[]	=	$fan->uniqueid;
	echo $username[]		=	$fan->username;
	echo $password[]		=	$fan->password;
	echo $userpic[]			=	$fan->userpic;
	echo $firstname[]		=	$fan->firstname;
	echo $lastname[]		=	$fan->lastname;
	echo $mobile[]			=	$fan->mobile;
	echo $twitterid[]		=	$fan->twitterid;
	echo $location[]		=	$fan->location;
	echo "</br>";
}
?>