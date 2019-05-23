<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
$apicaller->filterRequest();
$followdate	=	date('Y/m/d h:i:s');
$ipaddress		=	$_SERVER['REMOTE_ADDR'];
extract($_POST);
/*****************************************************************/
$req		=	array(
						'controller' 		=>	'Follow',
						'action'			=>	'deletefollow',
						'artistuniqueid' 	=>	$artistuniqueid,
						'ipaddress'			=>	$ipaddress
						);
$follows = $apicaller->sendRequest($req);

?>
