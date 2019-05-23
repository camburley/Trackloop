<?php

require_once(TL_PATH . 'audio/config147852369741.php');

require_once(TL_PATH . 'audio/AudioHandler.php');

$tweet = Application::data('tweet');

$albumuniqueid  = Application::param('album');
$artistuniqueid	= Application::param('artist');

$albumurl = Registry::get('config')->read('app.url') . 'artist/album/' . $artistuniqueid . '/' . $albumuniqueid;
$tinyurl = get_tiny_url($albumurl);

// load album information
$albums = $apicaller->sendRequest(array(
	'controller' 	 =>	'Track',
	'action'		 =>	'readartistalbum',
	'albumuniqueid'  =>	$albumuniqueid,
	'artistuniqueid' =>	$artistuniqueid
));
$artistalbum = $albums[0];

$albumdate		  = date("m/d/y", strtotime($artistalbum->albumdate));
$coverimage		  = "199x182" . $artistalbum->coverimage;
$albumname		  = $artistalbum->albumname;
$firstname		  = $artistalbum->firstname;
$lastname		  = $artistalbum->lastname; 	
$twitterid		  = $artistalbum->twitterid;
$albumdescription = $artistalbum->albumdescription;
$location		  = $artistalbum->location;
$_SESSION['reciveremail'] = $artistalbum->username;
$_SESSION['zipalbumname'] = $artistalbum->albumname;

// pass album information to template
$view->assign("albumdate", $albumdate);
$view->assign("coverimage", $coverimage);
$view->assign("albumname", $albumname);
$view->assign("firstname", $firstname);
$view->assign("lastname", $lastname);
$view->assign("twitterid", $twitterid);
$view->assign("albumdescription", $albumdescription);
$view->assign("location", $location);
$view->assign("albumuniqueid", $albumuniqueid);
$view->assign("artistuniqueid", $artistuniqueid);

// get album tracks
$tracks = $apicaller->sendRequest(array(
	'controller' 	 =>	'Track',
	'action'		 =>	'readtrackBySequence',
	'uniqueid' 		 =>	$albumuniqueid,
	'artistuniqueid' =>	$artistuniqueid
));

//This array contain all audio keys and values of file
$audioquality = array();
foreach($tracks as $track) {	
	//------------ Add logic for creating .mp3 & .ogg files ----------------------//
	//Create object of AudioHandler class for read file content	
	$audioHandler = new AudioHandler($uploadPath . DS . $artistuniqueid . DS . $albumuniqueid . DS . $track->trackfile);
	
	//This function create .mp3 & .ogg files to write content of specified length 
	$audioHandler->splitAudioFile($splitFilePath . $track->trackfile, $fileSplitLength);
	
	$trackuniqueid[] = $track->uniqueid;
	$trackname[]	 = $track->trackname;
	$trackurl[]		 = $track->url;
	$titlesong[]	 = $track->titlesong;
	$trackfile[]	 = $track->trackfile;
	$tracklength[]	 = $track->tracklength;
	
	if(empty($track->audioquality)) {
		$audioquality[]  =  '128 KBPS MP3';
	} else {
		$audioquality[]  =  $track->audioquality;
	}

	if(1 == $track->titlesong) {
		$trackfiletitle = $track->trackfile;
	}
	
}

$view->assign("trackuniqueid",$trackuniqueid);
$view->assign("trackname",$trackname);
$view->assign("trackurl",$trackurl);
$view->assign("titlesong",$titlesong);
$view->assign("tracklength",$tracklength);
$view->assign("trackfile",$trackfile);
$view->assign("trackfiletitle",$trackfiletitle);
$view->assign("noOfTrack",count($trackfile));
$view->assign("audioquality",$audioquality[0]);

// follows
$follows = $apicaller->sendRequest(array(
	'controller' 	=>	'Follow',
	'action'		=>	'readfollow',
	'artistuniqueid' =>	$artistuniqueid
));
$view->assign("totalfollow", $follows[0]);

// shares
$shares = $apicaller->sendRequest(array(
	'controller' 	=>	'Share',
	'action'		=>	'readshare',
	'albumuniqueid' =>	$albumuniqueid
));
$view->assign("totalshares", $shares[0]);

// downloads
$downloads = $apicaller->sendRequest(array(
	'controller' 	=>	'Download',
	'action'		=>	'readdownload',
	'albumuniqueid' =>	$albumuniqueid
));
$view->assign("totaldownload", $downloads[0]);

// increment album impression stats
$impressions = $apicaller->sendRequest(array(
	'controller' 	=>	'Impression',
	'action'		=>	'createimpression',
	'albumuniqueid' =>	$albumuniqueid,
	'artistuniqueid' =>	$artistuniqueid
));

$view->assign("tinyurl", $tinyurl);
$view->assign("tweet", $tweet);

//---------------- Detect mobile browser or desktop browser ----------------// 
//Call detect mobile for site open on mobile or not
$mobile = detectMobile();
//Initialise isMobile false
$isMobile = false; 
if($mobile === true) {
	//If site open on mobile then isMobile will be true
	$isMobile = true;
}	
$view->assign("isMobile", $isMobile);

Application::render('album', 'unloackLayout');