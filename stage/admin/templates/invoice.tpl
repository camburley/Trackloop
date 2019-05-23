<script>
function doSearch()
{
	var searchterm	=	$("#txtsearch").val();
	window.location.href	=	"invoice.php?searchterm="+searchterm;
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
<title>Invoice</title>
<h1 class="title"><img  src="../img/invoice.png" /> Invoices</h1>
<div class="inv-content" style="padding-bottom:100px;">
  <div style="margin-bottom:15px;">
    <input type="text" value="{$searchterm}" class="invoice-search" name="txtsearch" id="txtsearch" placeholder="Search Invoices" />
    <button class="btn-search" type="button" onClick="doSearch()">Search</button>
  </div>
  <table class="tbl-invoices" class="tablesorter" id="tablesorter-demo">
    <thead>
      <tr>
        <th>Subscriber<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Invoice Number<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Invoice Date<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Fee Type<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Amount<img class="arrow-up" src="../img/up-arr.png" /></th>
      </tr>
    </thead>
    <tbody>
    {if $totalrecords>0}
   {section name=outer loop=$invoicenumber}
      <tr>
        <td>{$firstname[outer]}</td>
        <td>{$invoicenumber[outer]}</td>
        <td>{$date1[outer]}</td>
        <td>{$promotype[outer]}</td>
        <td>${$currency1[outer]}</td>
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

