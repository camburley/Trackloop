<?php
$currentsection	=	"1";
require_once("classes.php");
require_once("include.php");
$promoid	=	$_GET['promoid'];
$query		=	"SELECT * FROM tblpromo WHERE pkpromoid='$promoid'";
$users		=	$db->query($query);
$user		=	$users[0];
$section	=	"customer";

	$pkpromoid		=	$user['pkpromoid'];
	$fkadminuserid	=	$user['fkadminuserid'];
	$discount		=	$user['discount'];
	$promocode		=	$user['promocode'];
	$fkpromotypeid	=	$user['fkpromotypeid'];
$query1			=	"SELECT * FROM tbladminuser";
$staff		=	$db->query($query1);
foreach($staff as $staff1)
{
	$pkadminuserid[]	=	$staff1['pkadminuserid'];
	$username[]			=	$staff1['username'];
}
$query4	=	"SELECT * FROM tblpromotype" ;	
$promoalltypes	=	$db->query($query4);
foreach($promoalltypes as $promoalltype)
{
	$pkpromotypeid[]	=	$promoalltype['pkpromotypeid']; 
	$promotypes[]		=	$promoalltype['promotype'];
}
$smarty->assign('pkpromoid',$pkpromoid);
$smarty->assign('fkadminuserid',$fkadminuserid);
$smarty->assign('discount',$discount);
$smarty->assign('promocode',$promocode);
$smarty->assign('fkpromotypeid',$fkpromotypeid);
$smarty->assign('pkadminuserid',$pkadminuserid);
$smarty->assign('username',$username);
$smarty->assign('pkpromotypeid',$pkpromotypeid);
$smarty->assign('promotypes',$promotypes);
$smarty->assign('promoid',$promoid);
$smarty->display("editpromo.tpl");	
require_once("footer.php");
?>