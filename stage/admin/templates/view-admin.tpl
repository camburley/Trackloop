<link rel="stylesheet" href="../sorttable/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../sorttable/jquery-latest.js"></script>
	<script type="text/javascript" src="../sorttable/jquery.tablesorter.js"></script>
<script type="text/javascript">
	$(function() {		
		$("#tablesorter-demo").tablesorter({
			sortList:[[0,0],[2,1]], widgets: ['zebra']});
		$("#options").tablesorter({
			sortList: [[0,0]], headers: {
			 3:{
				 sorter: false}, 4:{
				 sorter: false}}});
	});	                                                    
</script>                  
<h1 class="title">View Admin</h1>
<div class="content" style="padding-bottom:100px;">
  <table class="tbl-promo-codes" class="tablesorter" id="tablesorter-demo" >
    <thead>
      <tr>
        <th>Date Added<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Username<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Password<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      {section name = outer loop=$pkuserid}
      <tr>
        <td>{$admindate[outer]}</td>
        <td>{$username[outer]}</td>
        <td>{$password[outer]}</td>
        <td><a href="add-new-admin.php?userid={$pkuserid[outer]}">edit</a></td>
      </tr>
      {/section}
    </tbody>
  </table>
</div>
<!-- end content -->

<div class="content" style="padding-bottom:100px;">
  <p>
    <button style="float:left; margin-top:-30px; margin-left:3px;" class="btn-add-promo" type="button" onClick="addnew();">ADD ADMIN</button>
  </p>
  <!--<p style="margin-top:150px;">
    <button class="btn-submit">DONE</button>
  </p>-->
</div>
<!-- end content -->
<script type="text/javascript">
function addnew()
{
	window.location.href	=	"add-new-admin.php";
}
</script>