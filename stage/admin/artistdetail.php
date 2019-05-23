<?php
$currentsection	=	"4";
require_once("classes.php");
require_once("include.php");
$section	=	"customer";
/******************************************Search**************************************/
$pkartistid	=	$_GET['pkartistid'];
$query				=	"SELECT SQL_CALC_FOUND_ROWS * FROM tblartist WHERE pkartistid = '$pkartistid'";
$customers			=	$db->query($query);
foreach($customers as $customer)
{
	//$pkartistid[]	=	$customer['pkartistid'];
	$username	=	$customer['username'];
	$mobile		=	$customer['mobile'];
	$firstname	=	ucfirst($customer['firstname']);
	$lastname	=	ucfirst($customer['lastname']);
	$signupdate	=	$customer['signupdate'];
	$ipaddress	=	$customer['ipaddress'];
	$twitterid	=	$customer['twitterid'];
	$location	=	$customer['location'];
}
$smarty->assign('pkartistid',$pkartistid);
$smarty->assign('firstname',$firstname);
$smarty->assign('lastname',$lastname);
$smarty->assign('username',$username);
$smarty->assign('mobile',$mobile);
$smarty->assign('signupdate',$signupdate);
$smarty->assign('ipaddress',$ipaddress);
$smarty->assign('twitterid',$twitterid);
$smarty->assign('location',$location);
$smarty->display("artistdetail.tpl");	
require_once("footer.php");
?>