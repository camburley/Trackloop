<?php
@session_start();
$admin	= $_SESSION['adminid'];	
$allowedsections	=	$_SESSION['allowedsections'];
if(!($admin > 0))
{
	header("Location:index.php");
	exit;
}
if($currentFile!="welcome.php")
{
	if(!in_array($currentsection,$allowedsections))
	{
		header("Location:welcome.php");	
		exit;
	}
}
?>