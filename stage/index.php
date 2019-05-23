<?php

// put full path to Smarty.class.php
require('/usr/lib64/php/Smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('/var/www/smarty/templates');
$smarty->setCompileDir('/var/www/smarty/templates_c');
$smarty->setCacheDir('/var/www/smarty/cache');
$smarty->setConfigDir('/var/www/smarty/configs');

$smarty->assign('name', 'Ned');
$smarty->display('index.tpl');

?>
