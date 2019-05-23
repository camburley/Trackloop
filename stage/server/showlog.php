<?php
require_once("checklogin.php");
require_once("classes/class.db.php");
$db		=	new	DB();
$appid	=	$_SESSION['appid'];
$appkey	=	$_SESSION['appkey'];
$admin	=	$_SESSION['admin'];

if(($admin)==1)
{
	$query	=	"SELECT * FROM tblapilog WHERE 1 ORDER BY pkapilogid DESC";
}
else
{
	$query	=	"SELECT * FROM tblapilog WHERE appid='$appid' AND appkey='$appkey' ORDER BY pkapilogid DESC";
}
//echo $query;
$db->query($query);
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
a{ color:#FFF}
a:hover{ color:#F00}
a:visited{ color:#F2F2F2}
</style>

<table class="altrowstable" id="alternatecolor" width="100%">
	<caption style="background-color:#4EAEB6; height:30px; color:#FFF; padding-top:15px; font-size:16px; font-weight:bold">API Calls Log</caption>
	<thead>
		<tr>
			<th align="left" colspan="4" bgcolor="#63B8BE"><a href="logout.php">Sign out</a></th>
            <?php /*?><th>APP ID</th>
			<th>API Key</th><?php */?>
		</tr>
        <tr bgcolor="#99D0D5">
			<th width="8%">Log ID</th>
            <th width="16%">Date & Time</th>
            <?php /*?><th>APP ID</th>
			<th>API Key</th><?php */?>
			<th width="11%">Input </th>
            <th width="65%">Output </th>
		</tr>
	</thead>
    
<tbody>

<?php
while($row = mysqli_fetch_array($db->queryresult))
{
?>
    <tr>
        <td><?php echo $row['pkapilogid'];?></td>
        <td><?php echo date("m/d/Y H:i:s A",strtotime($row['logtime']));?></td>
     <?php /*?>   <td><?php echo $row['appid'];?></td>
        <td><?php echo $row['appkey'];?></td><?php */?>
        <td><?php echo $db->dump($row['params']);?></td>
        <td><?php echo $db->dump(json_decode($row['returned'],1));?></td>
    </tr>
<?php
}
?>
</tbody></table>