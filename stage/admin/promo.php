<?php
$currentsection	=	"1";
require_once("classes.php");
require_once("include.php");
$query12	=	"SELECT * FROM tblpromo, tbladminuser, tblpromotype WHERE fkadminuserid	=	pkadminuserid AND pkpromotypeid	=	fkpromotypeid";
$res=$db->query($query12);
foreach($res as $res1) 
{
	
		$pkpromoid[]	=	$res1['pkpromoid'];
		$currency		=	$res1['discount'];
		$currency1[]	=	$currency;
		$promocode[]	=	$res1['promocode'];
		$adminusername[]=	$res1['username'];
		$promotype[]	=	$res1['promotype'];
	
}
$query3	=	"SELECT * FROM tbladminuser" ;	
$mem	=	$db->query($query3);
foreach($mem as $mem1)
{
	$pkadminuserid[]	=	$mem1['pkadminuserid']; 
	$username[]			=	$mem1['username'];
}
$query4	=	"SELECT * FROM tblpromotype" ;	
$promoalltypes	=	$db->query($query4);
foreach($promoalltypes as $promoalltype)
{
	$pkpromotypeid[]	=	$promoalltype['pkpromotypeid']; 
	$promotypes[]		=	$promoalltype['promotype'];
}
$smarty->assign('pkpromoid',$pkpromoid);
$smarty->assign('adminusername',$adminusername);
$smarty->assign('currency1',$currency1);
$smarty->assign('promocode',$promocode);
$smarty->assign('promotype',$promotype);
$smarty->assign('pkadminuserid',$pkadminuserid);
$smarty->assign('username',$username);
$smarty->assign('pkpromotypeid',$pkpromotypeid);
$smarty->assign('promotypes',$promotypes);

$smarty->display("promo.tpl");
require_once("footer.php");
?>