<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");
$apicaller->filterRequest();
extract($_POST);
$artistuniqueid	=	$_SESSION['artistuniqueid'];
/********************artistname***********************/
$req		=	array(
						'controller' 	=>	'User',
						'action'		=>	'readartist',
						'uniqueid' 		=>	$artistuniqueid
						);
$artists = $apicaller->sendRequest($req);
//$apicaller->dump($artists);
foreach($artists as $artist)
{
	$firstname	=	ucfirst($artist->firstname);
	$lastname	=	ucfirst($artist->lastname);
}
require_once($path."/artist/leftmenu.php");
$smarty->assign("welfirstname",$firstname);
$smarty->assign("wellastname",$lastname);
$smarty->assign("path",$path);
$smarty->assign("domain",$domain);
$smarty->display("welcome.tpl");
?>