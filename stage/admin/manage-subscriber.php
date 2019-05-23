<?php
$currentsection	=	"4";
require_once("classes.php");
require_once("include.php");
$pager->getshow(1);
$section	=	"customer";
/******************************************Search**************************************/
$pkfansid	=	$_GET['pkfansid'];
$searchterm	=	$_GET['searchterm'];
if($searchterm)
{
	$search	=	"WHERE (firstname LIKE '%$searchterm%' OR lastname LIKE '%$searchterm%') ";
}
if($pkfansid)
{
	$tblartistfans	=	",tblartistfans";
	$artistsearch	=	"WHERE fkfansid	=	'$pkfansid' AND pkartistid	=	fkartistid";
}
if($pkfansid)
{
	$query	=	"SELECT * FROM tblfans WHERE pkfansid	=	'$pkfansid'";
	$fans	=	$db->query($query);
	foreach($fans as $fan)
	{
		$fanfirstname	=	ucfirst($fan['firstname']);
		$fanlastname	=	ucfirst($fan['lastname']);
	}
}
$smarty->assign('fanfirstname',$fanfirstname);
$smarty->assign('fanlastname',$fanlastname);

/******************************************ORDER BY**************************************/
$orderfield	=	$_GET['orderfield'];
switch($orderfield)
{
	case 1:
		$orderby	=	"firstname";
		break;
	case 2:
		$orderby	=	"lastname";
		break;
	default:
		$orderby	=	"firstname";
		break;
}
/**************************************************************************************/
$records_per_page	=	25;
$currentlyshowing	=	($pager->get_page() - 1) * $records_per_page;
$limit				=	$currentlyshowing.",". $records_per_page;
$query				=	"SELECT SQL_CALC_FOUND_ROWS * FROM tblartist $tblartistfans   $artistsearch $search ORDER BY $orderby ASC LIMIT $limit";
$customers			=	$db->query($query);
$rows				=	$db->query("SELECT FOUND_ROWS() as totalrecords");
$totalrecords		=	$rows[0]['totalrecords'];
/******************************************Paging**************************************/
// pass the total number of records to the pagination class
$pager->records($totalrecords);
$pager->records_per_page($records_per_page);
$getpager[]	=	$pager->render();
foreach($customers as $customer)
{
	$pkartistid[]	=	$customer['pkartistid'];
	$firstname[]	=	ucfirst($customer['firstname']);
	$lastname[]		=	ucfirst($customer['lastname']);
	$signupdate[]	=	date('Y-m-d',strtotime($customer['signupdate']));
	$username[]		=	$customer['username'];
	$ipaddress[]	=	$customer['ipaddress'];
	$twitterid[]	=	$customer['twitterid'];
	$location[]		=	$customer['location'];
	$query2			=	"SELECT SQL_CALC_FOUND_ROWS pkalbumid FROM tblalbum  WHERE fkartistid	=	'".$customer['pkartistid']."'";
	$albums			=	$db->query($query2);
	$albumsrec		=	$db->query("SELECT FOUND_ROWS() as totalalbums");
	$totalalbums[]	=	$albumsrec[0]['totalalbums'];
	$query3			=	"SELECT SQL_CALC_FOUND_ROWS pkartistfansid FROM tblartistfans  WHERE fkartistid	=	'".$customer['pkartistid']."'";
	$albums			=	$db->query($query3);
	$fansrec		=	$db->query("SELECT FOUND_ROWS() as totalfans");
	$totalfans[]	=	$fansrec[0]['totalfans'];
	$query4			=	"SELECT SQL_CALC_FOUND_ROWS pkfollowid FROM tblfollow  WHERE fkartistid	=	'".$customer['pkartistid']."'";
	$follows		=	$db->query($query4);
	$followsrec		=	$db->query("SELECT FOUND_ROWS() as totalfollows");
	$totalfollows[]	=	$followsrec[0]['totalfollows'];
}
$smarty->assign('pkfansid',$pkfansid);
$smarty->assign('pkartistid',$pkartistid);
$smarty->assign('firstname',$firstname);
$smarty->assign('lastname',$lastname);
$smarty->assign('username',$username);
$smarty->assign('signupdate',$signupdate);
$smarty->assign('ipaddress',$ipaddress);
$smarty->assign('twitterid',$twitterid);
$smarty->assign('location',$location);
$smarty->assign('totalalbums',$totalalbums);
$smarty->assign('totalfans',$totalfans);
$smarty->assign('getpage',$pager->get_page());
$smarty->assign('getpager',$getpager);
$smarty->assign('totalfollows',$totalfollows);
$smarty->assign('totalrecords',$totalrecords);
$smarty->assign('searchterm',$searchterm);
$smarty->assign('orderfield',$orderfield);
$smarty->display("manage-subscriber.tpl");
require_once("footer.php");
?>