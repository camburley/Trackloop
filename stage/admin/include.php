<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="../css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap-select.css">
<script src="../js/jquery-1.9.1.min.js" type="text/javascript"></script>
<!--
<script src="../js/bootstrap.js" type="text/javascript"></script>
-->
<script src="../js/customer-check.js" type="text/javascript"></script>
<script src="../js/bootstrap-button.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/bootstrap-dropdown.js"></script>
<script type="text/javascript" language="javascript" src="../js/common.js"></script>
<script src="../js/bootstrap-select.js"></script>
     <script type="text/javascript">
      window.onload=function(){
       
        $('.selectpicker').selectpicker({
          style: 'btn-mv-inverse-length'
        });
      };
    </script>



</head>
<body>
<?php
$currentFile =     basename($_SERVER['PHP_SELF']);
if($currentFile!="index.php")
{
	require_once("security.php");
}
require_once("header.php");
?>