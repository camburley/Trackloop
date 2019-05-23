<?php
@session_start();
require_once("classes.php");
$db->filterRequest();
extract($_POST);
if($_GET['check1'])
{
	$iv = md5(md5($key));
	$enpassword	=	mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $password, MCRYPT_MODE_CBC, $iv);
	$enpassword = base64_encode($enpassword);
	$expire		=	time()+60*60*24*7;
	setcookie('cusername',$username,$expire);
	setcookie('cpassword',$enpassword,$expire);
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
	//header("Location:manage-subscriber.php");
	echo "1";
	exit;
}
else
{
	//echo "2";
	//header("Location:index.php?msg=Username or password incorrect.");
	exit;	
}
?>