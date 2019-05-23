<?php
require_once("classes.php");
$username	=	$_POST['username'];
$userid		=	$_POST['userid'];
if($userid > 0)
{
	$and	=	" AND 	pkadminuserid <> '$userid' ";
}
$query	=	"SELECT * FROM tbladminuser WHERE username = '$username' $and";
$db->query($query);
if(mysql_num_rows($db->queryresult) > 0)
{
	echo "User Name already in use.";
	exit;
}
?>