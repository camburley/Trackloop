<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
$apicaller->filterRequest();
extract($_POST);
$uniqueid	=	'3F6TBYG2QCMXAPJ4';
$req		=	array(
						'controller' 	=>	'Download',
						'action'		=>	'readdownload',
						'uniqueid' 		=>	$uniqueid
						);
$download = $apicaller->sendRequest($req);
//$apicaller->dump($albums);
//echo $download;
?>