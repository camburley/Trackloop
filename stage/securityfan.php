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
/*if(!($currentFile =="customersignup.php"))
{
	$loggedincustomerid	=	$_SESSION['loggedincustomerid'];
	if(!($loggedincustomerid)>0)
	{
		header("Location:$domain/home.php");
		exit;
	}
}*/
//$smarty->clearAllCache();
?>
