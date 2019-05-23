<?php
	require_once("classes.php");	
	$db->filterRequest();
	extract($_POST);
	$code		=	trim($code);
	$discount	=	trim($discount);
	$username	=	trim($username);
	$promotype	=	trim($promotype);
	if($promoid)
	{
		$query	=	"UPDATE tblpromo SET promocode ='$code', fkadminuserid = '$username',discount = '$discount',fkpromotypeid = '$promotype' WHERE pkpromoid = '$promoid'";
		$db->query($query);
	}
	else
	{
		$query	=	"INSERT INTO tblpromo SET promocode ='$code', fkadminuserid = '$username',discount = '$discount',fkpromotypeid = '$promotype'";
		$db->query($query);
	}
	header('Location:promo.php');
	exit;
?>