<?php
@session_start();
require_once($path.'/classes/Smarty.class.php');
require_once($path.'/classes/class.resize.php');
require_once($path.'/classes/Zebra_Pagination.php');
require_once($path.'/apicaller.php');
$apicaller	=	new ApiCaller();
$pager		=	new Zebra_Pagination();
$smarty		=	new Smarty();
require_once($path.'/classes/pagination.class.php');
$myPagination = new pagination();
if(!($currentFile =="index.php"||$currentFile	==	"account.php"||$currentFile	==	"album.php"||$currentFile	==	"login.php"))
{
	
	$artistuniqueid	=	$_SESSION['artistuniqueid'];
	if(!($artistuniqueid)>0)
	{			
		header("Location:index.php");	
		exit;
	}
}
$currentFilename =     basename($_SERVER['PHP_SELF']);
if(!($currentFile =="index.php" || $currentFilename =="welcome.php" ))
{
	$sectionid	=	$_SESSION['sectionid'];
	if($sectionid)
	{
		
		if($currentFilename=="managealbum.php")
		{
			 $allowsection	=	1;
		}
		if($currentFilename=="buzz.php")
		{
			$allowsection	=	2;
		}
		if($currentFilename=="fan.php")
		{
			$allowsection	=	3;
		}
		if($currentFilename=="account.php")
		{
			$allowsection	=	4;
		}
		if($currentFilename=="permission.php")
		{
			$allowsection	=	5;
		}
		if(!in_array($allowsection,$_SESSION['sectionid']))
		{			
			header("Location:welcome.php");	
			exit;
		}
	}
}
//$smarty->clearAllCache();
?>
