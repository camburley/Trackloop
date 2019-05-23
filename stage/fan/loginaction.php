<?php
@session_start();
require_once("../config.php");
require_once($path."/apicaller.php");
$apicaller = new ApiCaller();
$apicaller->filterRequest();
extract($_POST);
$username	=	'muqtadir@gumptech.net';
$password	=	'gumptech';
$req		=	array(
						'controller' 	=>	'Login',
						'action'		=>	'readloginfan',
						'username' 		=>	$username,
						'password' 		=>	$password
						);

$users = $apicaller->sendRequest($req);
	
?>