<?php
//gets the data from a URL  
function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}
//test it out!
//$new_url = get_tiny_url('http://davidwalsh.name/php-imdb-information-grabber');

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$currentpageurl	=	curPageURL();
//exit;
//returns http://tinyurl.com/65gqpp
//echo $new_url;
//exit;

@session_start();
$currentFile="album.php";
require_once("../config.php");
require_once('../abrahm/config.php');
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");
$apicaller->filterRequest();

$showtweetbox	=	$_SESSION['showtweetbox'];
if($showtweetbox=='1')
{
	/*
	** show tweet box as used is authenticated
	*/
	$show	=	1;
}
else
{
	/*
	** Get Authenticated with Twitter
	*/
	$show	=	0;
	
}
$_SESSION['showtweetbox'] = 0;

//echo 'Number of Followers'.$totalfollowers	=	$_SESSION['totalfollowers'];
//echo $msg	=	$_GET['msg'];
extract($_POST);
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
$_SESSION['access_token']['screen_name'];
//$albumuniqueid	=	'N4BKZXW8RDL2PCY3';
//$artistuniqueid	=	'ZR3yFHT8GVbPBLdx';
if($_GET['albumid'])
{
	$albumuniqueid	=	$_GET['albumid'];
	$_SESSION['albumid']	=	$albumuniqueid;
}
else
{
	$albumuniqueid	=	$_SESSION['albumid'];
}
if($_GET['artistid'])
{
	$artistuniqueid	=	$_GET['artistid'];
	$_SESSION['artistid']	=	$artistuniqueid;
}
else
{
	$artistuniqueid	=	$_SESSION['artistid'];
}
if(empty($_SERVER['QUERY_STRING']))
{
	$currentpageurl	.=	"?artistid=$artistuniqueid&albumid=$albumuniqueid";
}
$albumurl = get_tiny_url($currentpageurl);
$_SESSION['albumurl']= $albumurl;
//$artistuniqueid		=	$_GET['artistid'];
$req		=	array(
						'controller' 	=>	'Track',
						'action'		=>	'readartistalbum',
						'albumuniqueid' =>	$albumuniqueid,
						'artistuniqueid'=>	$artistuniqueid
						);
$artistalbums = $apicaller->sendRequest($req);
//$apicaller->dump($artistalbums);
foreach($artistalbums as $artistalbum)
{
	$albumdate			=	date("m/d/y",strtotime($artistalbum->albumdate));
	$coverimage			=	$artistalbum->coverimage;
	$albumname			=	$artistalbum->albumname;
	$_SESSION['zipalbumname']	=	$artistalbum->albumname;
	$firstname			=	$artistalbum->firstname;
	$lastname			=	$artistalbum->lastname; 	
	$_SESSION['reciveremail']		=	$artistalbum->username;
	$twitterid			=	$artistalbum->twitterid;
	$albumdescription	=	$artistalbum->albumdescription;
	$location			=	$artistalbum->location;
}

$smarty->assign("albumurl",$albumurl);
$smarty->assign("show",$show);
$smarty->assign("albumdate",$albumdate);
$smarty->assign("coverimage",$coverimage);
$smarty->assign("albumname",$albumname);
$smarty->assign("firstname",$firstname);
$smarty->assign("lastname",$lastname);
$smarty->assign("twitterid",$twitterid);
$smarty->assign("albumdescription",$albumdescription);
$smarty->assign("location",$location);
$smarty->assign("albumuniqueid",$albumuniqueid);
$smarty->assign("artistuniqueid",$artistuniqueid);
/*******************************tracks***********************************/
$req		=	array(
						'controller' 	=>	'Track',
						'action'		=>	'readtrack',
						'uniqueid' 		=>	$albumuniqueid,
						'artistuniqueid'=>	$artistuniqueid
						);
$tracks = $apicaller->sendRequest($req);
//$apicaller->dump($tracks);
foreach($tracks as $track)
{
	$trackuniqueid[]	=	$track->uniqueid;
	$trackname[]		=	$track->trackname;
	$trackurl[]			=	$track->url;
	$titlesong[]		=	$track->titlesong;
	$trackfile[]		=	$track->trackfile;
	$tracklength[]		=	$track->tracklength;
	if($track->titlesong==1)
	{
		$trackfiletitle	=	$track->trackfile;
	}
}
$smarty->assign("trackuniqueid",$trackuniqueid);
$smarty->assign("trackname",$trackname);
$smarty->assign("trackurl",$trackurl);
$smarty->assign("titlesong",$titlesong);
$smarty->assign("tracklength",$tracklength);
$smarty->assign("trackfile",$trackfile);
$smarty->assign("trackfiletitle",$trackfiletitle);
/***************************follows**************************************/
$req		=	array(
						'controller' 	=>	'Follow',
						'action'		=>	'readfollow',
						'artistuniqueid' =>	$artistuniqueid
						);
$follows = $apicaller->sendRequest($req);
$totalfollow	=	$follows[0];
$smarty->assign("totalfollow",$totalfollow);
/*******************************share*****************************/
$req		=	array(
						'controller' 	=>	'Share',
						'action'		=>	'readshare',
						'albumuniqueid' =>	$albumuniqueid
						);
$shares = $apicaller->sendRequest($req);
//$apicaller->dump($shares);
$totalshares	=	$shares[0];
$smarty->assign("totalshares",$totalshares);
/******************************downloads*************************/
$req		=	array(
						'controller' 	=>	'Download',
						'action'		=>	'readdownload',
						'albumuniqueid' =>	$albumuniqueid
						);
$downloads = $apicaller->sendRequest($req);
$totaldownload	=	$downloads[0];
$smarty->assign("totaldownload",$totaldownload);
/**********************TWITTER SECTION***********************************/

//if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE')
//{
	///$msg	=	'You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
//	exit;
//}
/* Build an image link to start the redirect process. */
//$content = '<a href="./redirect.php"><img src="./images/lighter.png" alt="Sign in with Twitter"/></a>';
/*****************************************************************/
/*$req		=	array(
						'controller' 	=>	'Tweet',
						'action'		=>	'readtweet',
						'albumuniqueid' =>	$albumuniqueid,
						'fanuniqueid' 	=>	$fanuniqueid
						);
$tweets = $apicaller->sendRequest($req);
foreach($tweets as $tweet)
{
	$pktweetalbumid	=	$tweet->pktweetalbumid;
}
$smarty->assign("albumuniqueid",$albumuniqueid);
$smarty->assign("fanuniqueid",$fanuniqueid);
$smarty->assign("pktweetalbumid",$pktweetalbumid);*/

$req		=	array(
						'controller' 	=>	'Impression',
						'action'		=>	'createimpression',
						'albumuniqueid' =>	$albumuniqueid,
						'artistuniqueid' =>	$artistuniqueid
						);
$impressions = $apicaller->sendRequest($req);


$smarty->assign("path",$path);
$smarty->assign("domain",$domain);
$smarty->display("album.tpl");

require_once($path."/footer.php");
?>