<?php
@session_start();
session_destroy();
$_SESSION['appkey']	=	"";
$_SESSION['appid']	=	"";
header("Location: login.php");
exit;
?>