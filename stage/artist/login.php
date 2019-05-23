<?php

$currentFile = "login.php";
$title = 'ARTIST LOGIN';

require_once("../config.php");
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");

$cusername = $cpassword = '';
if(isset($_COOKIE['cusername']))
{
	$iv = md5(md5($key));
	$cusername	=	$_COOKIE['cusername'];
	$cpassword	=	mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($_COOKIE['cpassword']), MCRYPT_MODE_CBC, $iv);
	$cpassword	=	trim($cpassword);
}

$smarty->assign('cusername',$cusername);
$smarty->assign('cpassword',$cpassword);
$smarty->display("login.tpl");

require_once($path."/artist/footer.php");