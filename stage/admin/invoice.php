<?php
$currentsection	=	"2";
require_once("classes.php");
require_once("include.php");
$section	=	"customer";
$pager->getshow(1);
/******************************************Search**************************************/
$searchterm	=	$_GET['searchterm'];
$searchdate	=	date("Y-m-d",strtotime($searchterm));
if($searchterm)
{
	$search	=	" AND ((firstname LIKE '%$searchterm%') OR (lastname LIKE '%$searchterm%') OR (invoicenumber LIKE '%$searchterm%') OR 
	(DATE_FORMAT(invoicedate,'%Y-%m-%d') = '$searchdate')) ";
}
/**************************************************************************************/
$records_per_page	=	5;
$currentlyshowing	=	($pager->get_page() - 1) * $records_per_page;
$limit				=	$currentlyshowing.",". $records_per_page;
$query				=	"SELECT SQL_CALC_FOUND_ROWS * FROM tblartist a,tblinvoice i,tblpromotype p, tblinvoicestatus si  WHERE i.fkartistid= pkartistid AND i.fkinvoicestatusid=pkinvoicestatusid AND i.fkpromotypeid  = p.pkpromotypeid $search ORDER BY invoicenumber ASC LIMIT $limit ";
$invoices			=	$db->query($query);
$rows				=	$db->query("SELECT FOUND_ROWS() as totalrecords");
$totalrecords		=	$rows[0]['totalrecords'];
/******************************************Paging**************************************/
// pass the total number of records to the pagination class
$pager->records($totalrecords);
$pager->records_per_page($records_per_page);
$getpager[]	=	$pager->render();
foreach($invoices as $invoice)
{
	$date1[]			=	date('Y-m-d',strtotime($invoice['invoicedate']));
	//$date1[]			=	$db->dateformat($date,1);
	$currency			=	$invoice['invoiceamount'];	
	$currency1[]		=	$db->formatcurrency($currency);
	$invoicenumber[]	=	$invoice['invoicenumber'];
	$firstname[]		=	$invoice['firstname'];
	$lastname[]			=	$invoice['lastname'];
	$invoicestatus[]	=	$invoice['invoicestatus'];
	$promotype[]		=	$invoice['promotype'];
}
$smarty->assign('date1',$date1);
$smarty->assign('currency1',$currency1);
$smarty->assign('invoicenumber',$invoicenumber);
$smarty->assign('firstname',$firstname);
$smarty->assign('lastname',$lastname);
$smarty->assign('invoicestatus',$invoicestatus);
$smarty->assign('promotype',$promotype);
$smarty->assign('getpage',$pager->get_page());
$smarty->assign('getpager',$getpager);
$smarty->assign('totalrecords',$totalrecords);
$smarty->assign('searchterm',$searchterm);
$smarty->display("invoice.tpl");
require_once("footer.php");
?>