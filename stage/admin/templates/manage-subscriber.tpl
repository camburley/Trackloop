<script>
function doSearch()
{
	var searchterm	=	$("#txtsearch").val();
	window.location.href	=	"manage-subscriber.php?searchterm="+searchterm;
}
</script>
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
<title>Subscriber</title>
<h1 class="title">View/Edit Subscriber</h1>
<div class="inv-content" style="padding-bottom:100px;">
  <div style="margin-bottom:15px;">
    <input type="text" value="{$searchterm}" class="invoice-search" name="txtsearch" id="txtsearch" placeholder="Search Subscriber" />
    <button class="btn-search" type="button" onClick="doSearch()">Search</button>
  </div>
  <table class="tbl-invoices" class="tablesorter" id="tablesorter-demo" >
    <thead>
      <tr>
        <th>Subscriber ID<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Subscriber<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Email Addy<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Date Added<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
    {if $totalrecords>0}
      {section name=outer loop=$pkartistid}
      <tr>
        <td>{$pkartistid[outer]}</td>
        <td>{$firstname[outer]} {$lastname[outer]}</td>
        <td>{$username[outer]}</td>
        <td>{$signupdate[outer]}</td>
        <td><a href="artistdetail.php?pkartistid={$pkartistid[outer]}">Edit</a></td>
      </tr>
      {/section}
      {/if}
    </tbody>
  </table>
  {section name=outer loop=$getpager}
    <div class="pagination"> {$getpager[outer]} </div>
    <!--navSplitPagesLinks--> 
    {/section}
</div>
<!-- end content --> 