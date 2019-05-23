<script type="text/javascript">
function addnew()
{
	window.location.href	=	"editpromo.php";
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
<title>Promo Code</title>
<h1 class="title">Create, Edit and Remove Promo Codes</h1>
<div class="content" style="padding-bottom:100px;">
  <table class="tbl-promo-codes" class="tablesorter" id="tablesorter-demo" >
    <thead>
      <tr>
        <th>Code<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Staff Member<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Discount<img class="arrow-up" src="../img/up-arr.png" /></th>
        <th>Apply to<img class="arrow-up" src="../img/up-arr.png" /></th>
      </tr>
    </thead>
    <tbody>
    {section name=outer loop=$pkpromoid}
      <tr>
        <td><a href="editpromo.php?promoid={$pkpromoid[outer]}">{$promocode[outer]}</a></td>
        <td>{$adminusername[outer]}</td>
        <td>{$currency1[outer]}%</td>
        <td><div class="dropdown"> <button class="dropdown-toggle"  data-toggle="dropdown">{$promotype[outer]}</button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
              {section name=inner loop=$promotypes}
              <li><a href="changestatuscode.php?pkpromoid={$pkpromoid[outer]}&promotype={$pkpromotypeid[inner]}">{$promotypes[inner]}</a></li>
             {/section}
            </ul>
          </div></td>
      </tr>
    {/section}
     </tbody>
  </table>
</div>
<!-- end content -->

<div class="content" style="padding-bottom:100px;">
  <p>
    <button style="float:left; margin-top:-30px; margin-left:3px;" class="btn-add-promo" onclick="addnew();">Add Promo Code</button>
  </p>
  <!--<p style="margin-top:150px;">
    <button class="btn-submit">Submit Changes</button>
  </p>-->
</div>
<!-- end content --> 
