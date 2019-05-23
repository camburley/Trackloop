<?php
@session_start();
require_once("../config.php");
$currentFile	=	"account.php";
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");
$apicaller->filterRequest();
extract($_POST);
$artistuniqueid	=	$_SESSION['artistuniqueid'];
if($artistuniqueid)
{
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
	$username	=	$artist->username;
	$password	=	$artist->password;
	$mobile		=	$artist->mobile;
	$twitterid	=	$artist->twitterid;
	$location	=	$artist->location;
}
require_once($path."/artist/leftmenu.php");
$smarty->assign("artistuniqueid",$artistuniqueid);
$smarty->assign("firstname",$firstname);
$smarty->assign("lastname",$lastname);
$smarty->assign("username",$username);
$smarty->assign("mobile",$mobile);
$smarty->assign("twitterid",$twitterid);
$smarty->assign("location",$location);
$smarty->assign("password",$password);
}
$smarty->assign("path",$path);
$smarty->assign("domain",$domain);
$smarty->display("account.tpl");
require_once($path."/artist/footer.php");
?>