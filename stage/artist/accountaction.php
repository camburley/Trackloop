<?php
@session_start();
require_once('../config.php');
require_once($path."/apicaller.php");
$ipaddress	=	$_SERVER['REMOTE_ADDR'];
$signupdate	=	date('Y/m/d h:i:s');
$apicaller	=	new ApiCaller();
$apicaller->filterRequest();
extract($_POST);
//print_r($_SESSION);
$artistuniqueid	=	$_SESSION['artistuniqueid'];
if($artistuniqueid)
{
	$req		=	array(
							'controller'	=>	'User',
							'action'		=>	'updateartist',
							'artistuniqueid' =>	$artistuniqueid,
							'password'		=>	$password,
							'firstname'		=>	$firstname,
							'lastname'		=>	$lastname,
							'mobile'		=>	$mobile,
							'twitterid'		=>	$twitterid,
							'location'		=>	$location,
							'ipaddress'		=>	$ipaddress
						);
	$loginusers	=	$apicaller->sendRequest($req);
}
else
{

	$req		=	array(
							'controller'	=>	'User',
							'action'		=>	'createartist',
							'username'		=>	$username,
							'password'		=>	$password,
							'firstname'		=>	$firstname,
							'lastname'		=>	$lastname,
							'mobile'		=>	$mobile,
							'twitterid'		=>	$twitterid,
							'location'		=>	$location,
							'ipaddress'		=>	$ipaddress,
							'signupdate'	=>	$signupdate
						);
	$loginusers	=	$apicaller->sendRequest($req);
	
}
//$apicaller->dump($loginusers,1);
if($loginusers->message)
{
	echo $loginusers->message;
	exit;
}
else
{	
	if($artistuniqueid)
	{
		echo "update";
	}
	else
	{
		$artistuniqueid1			=	$loginusers->uniqueid;
		$_SESSION['artistuniqueid']	=	$artistuniqueid1;
		$_SESSION['firstname']		=	$firstname;
		$_SESSION['lastname']		=	$lastname;
		if(!file_exists("$path/uploads/albums/$artistuniqueid1"))
		{
			if(mkdir("$path/uploads/albums/$artistuniqueid1"))
			{
				//echo "$artistuniqueid1 folder created.";
			}
			else
			{
				//	echo "$artistuniqueid1 folder cannot be created.";
			}
		}
		echo "signup";
	}
	
	//echo "Your data has been saved successfully.";
}
?>