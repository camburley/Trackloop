<?php

// Authorization
Application::allow('artist, member', SECTION_RELEASES);

$albums = $apicaller->sendRequest(array(
	'controller' =>	'Album',
	'action'	 =>	'readalbum',
	'uniqueid' 	 =>	$_SESSION['artistuniqueid']
));

/* for ($i = 0; $i < count($albums); $i++) {
	$trackcount = $apicaller->sendrequest(array(
		'controller' => 'Track',
		'action'     => 'readtotaltrack',
		'albumuniqueid' => $albums[$i]->uniqueid,
	));
	$album[$i]['trackcount'] = $trackcount[0]->totalrec;
} */

foreach($albums as $album)
{
	$coverfile = '166x153' . $album->coverimage;
	$albumuniqueid[]	=	$album->uniqueid;
	$albumname[]		=	$album->albumname;
	$coverimage[]		=	$coverfile;
	$albumdate[]		=	date("m/d/y",strtotime($album->albumdate));
	$counttracks =	$apicaller->sendRequest(array(
		'controller' 	=>	'Track',
		'action'		=>	'readtotaltrack',
		'albumuniqueid' =>	$album->uniqueid
	));
	$counttrackalbum[]	=	$counttracks[0]->totalrec;
}

$view->assign("artistuniqueid", $_SESSION['artistuniqueid']);
$view->assign("albumuniqueid", $albumuniqueid);
$view->assign("coverimage", $coverimage);
$view->assign("albumname", $albumname);
$view->assign("albumdate", $albumdate);
$view->assign("counttrack", $counttrackalbum);
$view->assign("domain", 'http://trackloop.dev/stage');

Application::render('releases', 'baseLayout');