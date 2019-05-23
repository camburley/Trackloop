<?php
session_start();

define('DS', 				DIRECTORY_SEPARATOR);
$uploadPath = dirname(dirname(__FILE__)) . DS . "uploads" . DS . "albums" ;

$splitFilePath = dirname(dirname(__FILE__)) . DS . 'uploads' . DS . 'temp' . DS;

$fileSplitLength = 30;
?>
