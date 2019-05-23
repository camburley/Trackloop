<?php
@session_start();
require_once("../config.php");
require_once($path."/apicaller.php");
$apicaller	=	new ApiCaller();
$apicaller->filterRequest();
$albumdate	=	date('Y/m/d h:i:s');
$ipaddress		=	$_SERVER['REMOTE_ADDR'];
extract($_POST);
$covername	=	$_SESSION['covename'];

if($_REQUEST['save'])
{
	echo "<pre>";
	print_r($_FILES['files']);
	exit;
	$save		=	$_REQUEST['save'];
}
else
{
	$save		=	0;
}
//$_SESSION['trackfiles']	=	array();
$trackfiles	=	$_SESSION['trackfiles'];
//print_r($trackfiles);
$albumsessionid	=	session_id();
$artistuniqueid	=	$_SESSION['artistuniqueid'];
if($save==0)
{
	if(empty($description))
	{
		echo "Description cannot be empty.";
		exit;
	}
}
else
{
	if($albumid)
	{
		
		$req		=	array(
								'controller' 		=>	'Track',
								'action'			=>	'deletetrack',
								'albumuniqueid'		=>	$albumid	
							);
		$tracksdel = $apicaller->sendRequest($req);
		$req		=	array(
								'controller' 		=>	'Album',
								'action'			=>	'updatealbum',
								'albumname' 		=>	$releasename,
								'coverimage'		=>	$covername,
								'description'		=>	$description,
								'tagsinput'			=>	$tagsinput,
								'albumuniqueid'		=>	$albumid,
								'save'				=>	$save
							);
		$albums = $apicaller->sendRequest($req);
		for($i=0; $i<sizeof($trackfiles); $i++)
		{
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
										'albumuniqueid'		=>	$albumid,
										'save'				=>	$save
										);
				$tracks = $apicaller->sendRequest($req);
			}
		}
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
		for($i=0; $i<sizeof($trackfiles); $i++)
		{
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
	}
	unset($_SESSION['filehandlealbumid']);
	unset($_SESSION['trackfiles']);
	unset($_SESSION['covename']);
}
?>