<?php
require_once('../config.php');
require_once($path."/apicaller.php");

$apicaller	=	new ApiCaller();
$apicaller->filterRequest();
extract($_POST);
$pkmemberid	=	$_GET['pkmemberid'];
$req		=	array(
							'controller'	=>	'Permission',
							'action'		=>	'deletemember',
							'pkmemberid'	=>	$pkmemberid
						);
$memebers	=	$apicaller->sendRequest($req);
?>