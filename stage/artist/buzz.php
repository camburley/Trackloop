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
	$albumuniqueid[]	=	$album->uniqueid;
	$albumname[]		=	$album->albumname;
	$coverimage[]		=	$album->coverimage;
	$albumstatus[]		=	$album->albumstatus;
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
	$req		=	array(
						'controller' 	=>	'Download',
						'action'		=>	'readtotaldownload',
						'albumuniqueid' =>	$album->uniqueid
						);
	$downloads = $apicaller->sendRequest($req);
	foreach($downloads as $download)
	{
		$totaldownload[]	=	$download->totaldown;
		$agrdownload	+=	$download->totaldown;
	}
	$req		=	array(
						'controller' 	=>	'Reach',
						'action'		=>	'readreach',
						'uniqueid' 		=>	$album->uniqueid
						);
	$reaches = $apicaller->sendRequest($req);
	//$apicaller->dump($albums);
	foreach($reaches as $reach)
	{
		$totalfollower	+=	$reach->totalfollower;
	}
	$totalfollowers[]	=	$totalfollower;
	$agrfollowers	+=	$totalfollower;
	$req		=	array(
						'controller' 	=>	'Impression',
						'action'		=>	'readimpression',
						'albumuniqueid' =>	$album->uniqueid
						);
	$readimpressions = $apicaller->sendRequest($req);
	$totalimpression	+=	$readimpressions[0];
	$totalimpressions[]	=	$readimpressions[0];
	$req		=	array(
						'controller' 	=>	'Download',
						'action'		=>	'readlocationbyalbum',
						'albumuniqueid' =>	$album->uniqueid
						);
	$locations = $apicaller->sendRequest($req);
	//$apicaller->dump($locations);
	foreach($locations as $location)
	{
		if($location->countloaction)
		{
			$countuniqueid[]		=	$location->uniqueid;
			$countloaction[]		=	$location->countloaction;
			$downloadlocation[]		=	$location->downloadlocation;
		}
		
	}
}
$req		=	array(
						'controller' 	=>	'Download',
						'action'		=>	'readlocationbyartist',
						'artistuniqueid' =>	$artistuniqueid
						);
	$locationsbyartist = $apicaller->sendRequest($req);
	//$apicaller->dump($locationsbyartist);
	foreach($locationsbyartist as $locationbyartist)
	{
		if($locationbyartist->countloaction)
		{
			
			$countloactionbyartist[]		=	$locationbyartist->countloaction;
			$downloadlocationbyartist[]		=	$locationbyartist->downloadlocation;
		}
		
	}
//print_r($albumuniqueid);
$smarty->assign("albumuniqueid",$albumuniqueid);
$smarty->assign("albumname",$albumname);
$smarty->assign("albumdate",$albumdate);
$smarty->assign("coverimage",$coverimage);
$smarty->assign("albumstatus",$albumstatus);
$smarty->assign("counttrackalbum",$counttrackalbum);
$smarty->assign("totaldownload",$totaldownload);
$smarty->assign("totalfollowers",$totalfollowers);
$smarty->assign("agrfollowers",$agrfollowers);
$smarty->assign("agrdownload",$agrdownload);
$smarty->assign("totalimpression",$totalimpression);
$smarty->assign("totalimpressions",$totalimpressions);
$smarty->assign("countloaction",$countloaction);
$smarty->assign("downloadlocation",$downloadlocation);
$smarty->assign("countuniqueid",$countuniqueid);
$smarty->assign("countloactionbyartist",$countloactionbyartist);
$smarty->assign("downloadlocationbyartist",$downloadlocationbyartist);
$smarty->assign("artistuniqueid",$artistuniqueid);
$smarty->assign("path",$path);
$smarty->assign("domain",$domain);
$smarty->display("buzz.tpl");
require_once($path."/artist/footer.php");
?>