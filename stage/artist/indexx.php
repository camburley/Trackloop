<?php
@session_start();
require_once("../config.php");
$currentFile	=	"index.php";
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");
$smarty->assign("path",$path);
$smarty->assign("domain",$domain);
$smarty->display("index.tpl");
//require_once($path."/artist/footer.php");
?>