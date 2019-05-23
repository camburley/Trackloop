<?php
require_once("classes.php");
require_once("include.php");
if(isset($_COOKIE['cusername']))
{
	$iv = md5(md5($key));
	$cusername	=	$_COOKIE['cusername'];
	$cpassword	=	mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($_COOKIE['cpassword']), MCRYPT_MODE_CBC, $iv);
	$cpassword	=	trim($cpassword);
}
$msg	=	$_GET['msg'];
$smarty->assign('cusername',$cusername);
$smarty->assign('cpassword',$cpassword);
$smarty->assign('msg',$msg);
$smarty->display("index.tpl");
require_once("footer.php");
?>