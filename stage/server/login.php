<?php
@session_start();
if(sizeof($_POST) > 0)
{
	require_once("classes/class.db.php");
	$db		=	new	DB();
//	print_r($_REQUEST);
	$appid	=	$db->filter($_REQUEST['appid']);
	$appkey	=	$db->filter($_REQUEST['appkey']);
	$error=	"";
	if(empty($appid) || empty($appkey))
	{
		$error	=	 "<h2  style='color:red;'>Please provide your appid and appkey to view your log.</h2>";
	}
	else
	{
		$query	=	"SELECT * FROM tblapi WHERE appid='$appid' AND appkey='$appkey'";
		$db->query($query);
		if(mysqli_num_rows($db->queryresult))
		{
			$_SESSION['appid']	=	$appid;
			$_SESSION['appkey']	=	$appkey;
		}
		else
		{
			//if($appid=='admin' && $appkey=='admin')
			$query	=	"SELECT * FROM tbladmin WHERE username='$appid' AND password='$appkey'";
			$db->query($query);
			if(mysqli_num_rows($db->queryresult))
			{
				$_SESSION['admin']	=	'1';
				$_SESSION['appid']	=	$appid;
				$_SESSION['appkey']	=	$appkey;
			}
			else
			{
				$error	=	 "<h2  style='color:red;'>Please provide valid appid and appkey to view log.</h2>";
			}
		}
	}
	
	if($error=="")
	{
		header("Location: showlog.php");
		exit;
	}
}
?>
<script type="text/javascript">
function altRows(id){
	if(document.getElementsByTagName){  
		
		var table = document.getElementById(id);  
		var rows = table.getElementsByTagName("tr"); 
		 
		for(i = 0; i < rows.length; i++){          
			if(i % 2 == 0){
				rows[i].className = "evenrowcolor";
			}else{
				rows[i].className = "oddrowcolor";
			}      
		}
	}
}

window.onload=function(){
	altRows('alternatecolor');
}
</script>
<style type="text/css">
table.altrowstable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #a9c6c9;
	border-collapse: collapse;
}
table.altrowstable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
table.altrowstable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
.oddrowcolor{
	background-color:#d4e3e5;
}
.evenrowcolor{
	background-color:#c3dde0;
}
</style>
<form method="post" action="">
<?php
if($error)
{
	echo $error;
}
?>
<table class="altrowstable" id="alternatecolor" width="100%">
    <caption style="background-color:#099; height:30px; color:#FFF; padding-top:15px; font-size:16px; font-weight:bold">
    Login to See API Calls Trace
    </caption>
    <tr>
        <th width="42%" align="right">APP ID</th>
        <td width="58%"><input type="text" name="appid" /></td>
    </tr>
    <tr>
     	 <th align="right">App Key</th>
         <td><input type="text" name="appkey" /></td>
    </tr>
    <tr>
     	 <th colspan="2">
         	<input type="submit" name="sbtlogin"  value="Login" />
         </td>
    </tr>
</table>
</form>