<?php
require_once("classes.php");
$db->filterRequest();
$pkpromoid	=	$_GET['pkpromoid'];
$promotype	=	$_GET['promotype'];


	$query	=	"UPDATE tblpromo SET fkpromotypeid='$promotype' WHERE pkpromoid = '$pkpromoid'";
	$db->query($query);
	header("Location:promo.php");
?>