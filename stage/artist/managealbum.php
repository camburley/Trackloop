<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");
$apicaller->filterRequest();
extract($_POST);
$artistuniqueid	=	$_SESSION['artistuniqueid'];
/********************artistname***********************
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
*/
require_once($path."/artist/leftmenu.php");
/*****************************************/
$req		=	array(
						'controller' 	=>	'Album',
						'action'		=>	'readalbum',
						'uniqueid' 		=>	$artistuniqueid
						);
$albums = $apicaller->sendRequest($req);
//$apicaller->dump($albums);
foreach($albums as $album)
{
	$coverfile = '166x153' . $album->coverimage;
	$albumuniqueid[]	=	$album->uniqueid;
	$albumname[]		=	$album->albumname;
	$coverimage[]		=	$coverfile;
	$albumdate[]		=	date("m/d/y",strtotime($album->albumdate));
	$req2		=	array(
							'controller' 	=>	'Track',
							'action'		=>	'readtotaltrack',
							'albumuniqueid' =>	$album->uniqueid
						);
	$counttracks =	$apicaller->sendRequest($req2);
	//$apicaller->dump($counttracks);
	foreach($counttracks as $counttrack)
	{
		$counttrackalbum[]	=	$counttrack->totalrec;
	}
}
$smarty->assign("artistuniqueid",$artistuniqueid);
$smarty->assign("albumuniqueid",$albumuniqueid);
$smarty->assign("coverimage",$coverimage);
$smarty->assign("albumname",$albumname);
$smarty->assign("albumdate",$albumdate);
$smarty->assign("counttrack",$counttrackalbum);
$smarty->assign("path",$path);
$smarty->assign("domain",$domain);
$smarty->display("managealbum.tpl");
require_once($path."/artist/footer.php");
?>