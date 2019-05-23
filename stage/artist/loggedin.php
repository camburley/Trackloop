<?php
@session_start();
//print_r($_SESSION);
if($_SESSION['pkmemberid'] > 0)
{
	switch($_SESSION['sectionid'][0])
	{
		case 1:
			$url	=	"managealbum.php";
			break;
		case 2:
			$url	=	"buzz.php";
			break;
		case 3:
			$url	=	"fans.php";			
			break;
		case 4:
			$url	=	"account.php";			
			break;
		case 5:
			$url	=	"persmission.php";		
			break;
		default:
			$url	=	"welcome.php";
			break;
	}
}
else
{
	$url	=	"managealbum.php";
}
//echo $url;
//exit;
//header("Location : $url");
//exit;
?>
<script type="text/javascript">
	window.location	=	"<?php echo $url;?>";
</script>