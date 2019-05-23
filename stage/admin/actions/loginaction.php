<?php
@session_start();
require_once("../db.php");
$db->filterRequest();
extract($_POST);
if($check1)
{
	$expire		=	time()+60*60*24*7;
	setcookie('cusername',$username,$expire);
	//setcookie('cpassword',md5($password),$expire);
}
$query1	=	"SELECT * FROM tbladminuser WHERE username	=	'$username' AND password	=	'$password'";
$result	=	$db->query($query1);
$adminid	=	$result[0]['pkadminuserid'];	
if($adminid > 0)
{
	$query2		=	"SELECT pksectionid, sectionname, sectionurl FROM tblsection, tbladminuser, tbladminusersection WHERE pksectionid	=	fksectionid AND pkadminuserid	=	fkadminuserid AND pkadminuserid	=	$adminid";
	$sectionsarray	=	$db->query($query2);
	$sections	=	array();
	$allowedsections	=	array();
	foreach($sectionsarray as $section)
	{
		$pksectionid	=	$section['pksectionid'];
		$sectionname	=	$section['sectionname'];
		$sectionurl		=	$section['sectionurl'];
		$sections["$pksectionid"]	= array("sectionname"=>$sectionname,"sectionurl"=>$sectionurl);
		$allowedsections[]	=	$pksectionid;
	}
	$_SESSION['sections']			=	$sections;	
	$_SESSION['allowedsections']	=	$allowedsections;
	$_SESSION['adminid']			=	$adminid;
	header("Location:../index.php");
	exit;
}
else
{
	header("Location:../login.php?msg=Username or password incorrect.");
	exit;	
}
?>