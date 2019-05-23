<?php
@session_start();
require_once("../config.php");
require_once($path."/apicaller.php");

$apicaller	=	new ApiCaller();
$apicaller->filterRequest();
$albumdate	=	date('Y/m/d h:i:s');
$ipaddress		=	$_SERVER['REMOTE_ADDR'];
extract($_POST);
$covername	=	$_SESSION['coverimage'];
//$_SESSION['trackfiles']	=	array();
$trackfiles	=	$_SESSION['trackfiles'];
//print_r($trackfiles);
$albumsessionid	=	session_id();
$artistuniqueid	=	$_SESSION['artistuniqueid'];
if(empty($releasename))
{
	echo "Release name cannot be empty.";
	exit;
}

if(empty($description))
{
	echo "Description cannot be empty.";
	exit;
}
if(empty($tagsinput))
{
	echo "Genres cannot be empty.";
	exit;
}


if($albumid)
{
	$req		=	array(
									'controller' 		=>	'Track',
									'action'			=>	'deletetrack',
									'albumuniqueid'		=>	$albumid	
						);
	$tracksdel = $apicaller->sendRequest($req);
//	echo "DELETE old ones";
	//exit;
	$req		=	array(
							'controller' 		=>	'Album',
							'action'			=>	'updatealbum',
							'albumname' 		=>	$releasename,
							'coverimage'		=>	$covername,
							'description'		=>	$description,
							'tagsinput'			=>	$tagsinput,
							'albumuniqueid'		=>	$albumid
						);
	$albums = $apicaller->sendRequest($req);
	$tfs	=	array();
	for($i=0; $i<sizeof($trackfiles); $i++)
	{
		$tfs[]	=	$trackfiles[$i][0];
		$filenameesixt	=	$path."/uploads/albums/".$artistuniqueid."/".$albumid."/".$trackfiles[$i][0];
		if(file_exists($filenameesixt))
		{
			$req		=	array(
									'controller' 		=>	'Track',
									'action'			=>	'updatetrack',
									'trackname' 		=>	$trackfiles[$i][0],
									'titlesong'			=>	$i+1,
									'trackfile'			=>	$trackfiles[$i][0],
									'trackdate'			=>	$albumdate,
									'tracklength'		=>	$trackfiles[$i][1],
									'albumuniqueid'		=>	$albumid	
									);
			$tracks = $apicaller->sendRequest($req);
		}
	}
	//handle if and else case for same name albumuniqueid
	$albumuniqueid	=	$albumid;
	//echo "UPDATED";
}
else
{
	$req		=	array(
							'controller' 		=>	'Album',
							'action'			=>	'createalbum',
							'albumname' 		=>	$releasename,
							'coverimage'		=>	$covername,
							'artistuniqueid'	=>	$artistuniqueid,
							'albumdate'			=>	$albumdate,
							'description'		=>	$description,
							'tagsinput'			=>	$tagsinput
						);
	$albums = $apicaller->sendRequest($req);
	$albumuniqueid	=	$albums->uniqueid;
	if(!is_dir("$path/uploads/albums/$artistuniqueid/$albumuniqueid"))
	{
		rename("$path/uploads/albums/$artistuniqueid/$albumsessionid", "$path/uploads/albums/$artistuniqueid/$albumuniqueid");
	}
	$tfs	=	array();
	for($i=0; $i<sizeof($trackfiles); $i++)
	{
		$tfs[]	=	$trackfiles[$i][0];
		$filenameesixt	=	$path."/uploads/albums/".$artistuniqueid."/".$albumuniqueid."/".$trackfiles[$i][0];
		if(file_exists($filenameesixt))
		{
			$req		=	array(
									'controller' 		=>	'Track',
									'action'			=>	'createtrack',
									'trackname' 		=>	$trackfiles[$i][0],
									'titlesong'			=>	$i+1,
									'trackfile'			=>	$trackfiles[$i][0],
									'trackdate'			=>	$albumdate,
									'tracklength'		=>	$trackfiles[$i][1],
									'albumuniqueid'		=>	$albumuniqueid,	
									);
			$tracks = $apicaller->sendRequest($req);
		}
	}
	//echo "Added New";
}
unset($_SESSION['filehandlealbumid']);
unset($_SESSION['trackfiles']);
unset($_SESSION['covename']);

?>
