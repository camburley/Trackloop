<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
$apicaller->filterRequest();
extract($_POST);
$sharedate		=	date('Y/m/d h:i:s');
$ipaddress		=	$_SERVER['REMOTE_ADDR'];
$fanuniqueid	=	'8RHPWY145ewrDJ9';
$req		=	array(
						'controller' 	=>	'Share',
						'action'		=>	'createshare',
						'albumuniqueid' =>	$albumuniqueid,
						'ipaddress' 	=>	$ipaddress,
						'sharedate' 	=>	$sharedate,
						'shareon'		=>	$shareon
						);
$share = $apicaller->sendRequest($req);
//$apicaller->dump($albums);

?>