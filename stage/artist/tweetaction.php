<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
$apicaller->filterRequest();
$tweetdate	=	date('Y/m/d h:i:s');
extract($_POST);
/*****************************************************************/
$req		=	array(
						'controller' 	=>	'Tweet',
						'action'		=>	'createtweet',
						'albumuniqueid' =>	$albumuniqueid,
						'tweetdate' 	=>	$tweetdate
						);
$tweets = $apicaller->sendRequest($req);
$pktweetalbumid	=	$tweets->pktweetalbumid;
/*foreach($tweets as $tweet)
{
	echo $pktweetalbumid	=	$tweet->pktweetalbumid;
}*/
if($pktweetalbumid)
{
	$req		=	array(
							'controller' 	=>	'Track',
							'action'		=>	'readtrack',
							'uniqueid' 		=>	$albumuniqueid
							);
	$tracks = $apicaller->sendRequest($req);
	//$apicaller->dump($albums);
	foreach($tracks as $track)
	{
		$trackuniqueid[]	=	$track->uniqueid;
		$trackname[]		=	$track->trackname;
		$trackurl[]			=	$track->url;
		echo "<a href='".$track->url."'>'".$track->url."'</a>";
		//echo "</br>";
	}
}
if($pktweetalbumid)
{
	$req		=	array(
							'controller' 	=>	'Reach',
							'action'		=>	'readfan',
							'fanuniqueid' 	=>	$fanuniqueid
							);
	$fans = $apicaller->sendRequest($req);
	//$apicaller->dump($albums);
	foreach($fans as $fan)
	{
		$twitterid	=	$fan->twitterid;
		require_once("twitteroauth-master/test.php");
		
	}
	$req		=	array(
								'controller' 		=>	'Reach',
								'action'			=>	'createreach',
								'albumuniqueid' 	=>	$albumuniqueid,
								'fanuniqueid' 		=>	$fanuniqueid,
								'reachdate' 		=>	$tweetdate,
								'totalfollowers'	=>	$totalfollowers
							);
		$totalreach = $apicaller->sendRequest($req);
}

?>
