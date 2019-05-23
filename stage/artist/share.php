<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
$apicaller->filterRequest();
extract($_POST);
$uniqueid	=	'JXRZDB4Y6QG98LC3';
$req		=	array(
						'controller' 	=>	'Share',
						'action'		=>	'readshare',
						'uniqueid' 		=>	$uniqueid
						);
$share = $apicaller->sendRequest($req);
//$apicaller->dump($albums);
//echo $share;
?>