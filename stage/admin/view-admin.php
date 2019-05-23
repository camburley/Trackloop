<?php
$currentsection	=	"5";
require_once("classes.php");
require_once("include.php");
$query	=	"SELECT * FROM tbladminuser";
$db->filterRequest();
$users	=	$db->query($query);
foreach($users as $user)
{
	$username[]		=	$user['username'];
	$password[]		=	$user['password'];
	$pkuserid[]		=	$user['pkadminuserid'];
	$admindate[]		=	 date('Y-m-d', strtotime($user['admindate']));
}
$smarty->assign('username',$username);
$smarty->assign('password',$password);
$smarty->assign('pkuserid',$pkuserid);
$smarty->assign('admindate',$admindate);
$smarty->display("view-admin.tpl");
require_once("footer.php");
?>