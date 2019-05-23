<?php

Application::allow('artist, member', SECTION_BUZZ);

$artistuniqueid	= $_SESSION['artistuniqueid'];


// get artist albums
$albums = $apicaller->sendRequest(array(
	'controller' => 'Album',
	'action'	 => 'readalbum',
	'uniqueid'	 => $artistuniqueid
));

foreach($albums as $album) {
	$albumuniqueid[]	=	$album->uniqueid;
	$albumname[]		=	$album->albumname;
	$coverimage[]		=	'166x153' . $album->coverimage;
	$albumstatus[]		=	$album->albumstatus;
	$albumdate[]		=	date("m/d/y",strtotime($album->albumdate));
	
	// get album track count
	$counttracks =	$apicaller->sendRequest(array(
		'controller' 	=>	'Track',
		'action'		=>	'readtotaltrack',
		'albumuniqueid' =>	$album->uniqueid
	));
	$counttrackalbum[] = $counttracks[0]->totalrec;
	
	// get album downloads count
	$downloads = $apicaller->sendRequest(array(
		'controller' 	=>	'Download',
		'action'		=>	'readtotaldownload',
		'albumuniqueid' =>	$album->uniqueid
	));
	$totaldownload[]	= $downloads[0]->totaldown;
	$agrdownload	   += $downloads[0]->totaldown;
	
	// get album reach
	$reaches = $apicaller->sendRequest(array(
		'controller' 	=>	'Reach',
		'action'		=>	'readreach',
		'uniqueid' 		=>	$album->uniqueid
	));
	foreach($reaches as $reach) {
		$totalfollower +=	$reach->totalfollower;
	}
	$totalfollowers[]	=	$totalfollower;
	$agrfollowers	   +=	$totalfollower;
	
	// get album impressions
	$readimpressions = $apicaller->sendRequest(array(
		'controller' 	=>	'Impression',
		'action'		=>	'readimpression',
		'albumuniqueid' =>	$album->uniqueid
	));
	$totalimpression   += $readimpressions[0];
	$totalimpressions[] = $readimpressions[0];
	
	// get fan locations
	$locations = $apicaller->sendRequest(array(
		'controller' 	=>	'Download',
		'action'		=>	'readlocationbyalbum',
		'albumuniqueid' =>	$album->uniqueid
	));
	
	foreach($locations as $location) {
		if($location->countloaction) {
			$countuniqueid[]	= $location->uniqueid;
			$countloaction[]	= $location->countloaction;
			$downloadlocation[] = $location->downloadlocation;
		}
	}
}

// get overall artist fans locations
$locationsbyartist = $apicaller->sendRequest(array(
	'controller' 	=>	'Download',
	'action'		=>	'readlocationbyartist',
	'artistuniqueid' =>	$artistuniqueid
));
foreach($locationsbyartist as $locationbyartist) {
	if($locationbyartist->countloaction) {
		$countloactionbyartist[]		=	$locationbyartist->countloaction;
		$downloadlocationbyartist[]		=	$locationbyartist->downloadlocation;
	}	
}

$view->assign("albumuniqueid", $albumuniqueid);
$view->assign("albumname", $albumname);
$view->assign("albumdate", $albumdate);
$view->assign("coverimage", $coverimage);
$view->assign("albumstatus", $albumstatus);
$view->assign("counttrackalbum", $counttrackalbum);
$view->assign("totaldownload", $totaldownload);
$view->assign("totalfollowers", $totalfollowers);
$view->assign("agrfollowers", $agrfollowers);
$view->assign("agrdownload", $agrdownload);
$view->assign("totalimpression", $totalimpression);
$view->assign("totalimpressions", $totalimpressions);
$view->assign("countloaction", $countloaction);
$view->assign("downloadlocation", $downloadlocation);
$view->assign("countuniqueid", $countuniqueid);
$view->assign("countloactionbyartist", $countloactionbyartist);
$view->assign("downloadlocationbyartist", $downloadlocationbyartist);
$view->assign("artistuniqueid", $artistuniqueid);
$view->assign("domain", 'http://trackloop.fm/stage/');

Application::render('buzz', 'baseLayout');