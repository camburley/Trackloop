<?php
require_once("../classes.php");
$db->filterRequest();
$username	=	$_POST['username'];
$password	=	$_POST['password'];
$userid		=	$_POST['userid'];
$sections	=	$_GET['selectedsections'];
$admindate	=	date('y-m-d');
if($username=="")
{
	echo "User Name cannot be empty.";
	exit;
}
if($password=="")
{
	echo "Password cannot be empty.";
	exit;
}
if(strlen($password)<8)
{
	echo "Password should be 8 digits.";
	exit;
}

$username	=	trim($username);
$password	=	trim($password);
if($userid > 0)
{
	$query	=	"UPDATE tbladminuser SET username='$username', password = '$password' WHERE pkadminuserid = '$userid'";
	$q1		=	"DELETE FROM tbladminusersection WHERE fkadminuserid = '$userid'";
	$db->query($q1);
	$db->query($query);
}
else
{
	$query	=	"INSERT INTO tbladminuser SET username='$username', password = '$password',admindate = '$admindate' ";
	$db->query($query);
	$userid	=	$db->newid;
}
$sections	=	str_replace(",,",",",$sections);
$sections	=	explode(",",trim($sections,","));
foreach($sections as $section)
{
	if(intval($section) > 0)
	{
		$query1	=	"INSERT INTO tbladminusersection SET fkadminuserid = $userid, fksectionid = '$section'";
		$db->query($query1);
	}
}

?>