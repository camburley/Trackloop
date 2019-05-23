<?php
@session_start();
if($_SESSION['appid']=="" || $_SESSION['appkey']=="")
{
	header("Location: login.php");
	exit;
}
?>