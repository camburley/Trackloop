<?php
@session_start();
if(file_exists('../classes/class.db.php'))
{
	require_once('../classes/Smarty.class.php');
	require_once('../classes/class.db.php');
	require_once("../classes/Zebra_Pagination.php");
	require_once("../classes/class.resize.php");
}
else
{
	require_once('../../classes/Smarty.class.php');
	require_once('../../classes/class.db.php');
	require_once("../../classes/Zebra_Pagination.php");
	require_once("../../classes/class.resize.php");
}
$db			=	new DB();
$pager		=	new Zebra_Pagination();
$smarty		=	new Smarty();
?>