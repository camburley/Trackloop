<?php
require_once("classes/class.db.php");
require_once("controllers/api.php");
$db			=	new	DB();
//echo "Hi...";
//$db->dump($_REQUEST['services'],1);
$db->filterRequest();
$params	=	$_REQUEST;//(array) $params;
if(sizeof($params) ==0)
{
	echo (json_encode($db->message(10)));
	exit;
}
$test	=	new	Api($params);
$result	=	array();
/************************************************CREATE LOG**********************************************/
$testresult	=	$test->testAction();
if(strpos($testresult,'valid_')===false)
{
	echo $testresult;
	exit;
}
else
{
	$db->logid	=	trim($testresult,"valid_");
}
/*******************************Controllers and Actions**************************/
$controller	=	strtolower($params['controller']);
$action		=	strtolower($params['action']).'Action';
//check if the controller exists.
if(file_exists("controllers/{$controller}.php"))
{
	require_once "controllers/{$controller}.php";
}
else
{
	$controllerres	=	$db->message(11);
	$result			=	json_encode($controllerres);
	$query			=	"UPDATE tblapilog SET returned  = '$result' WHERE pkapilogid = '".$db->logid."'";
	$db->query($query);
	echo $result;
	exit;
}

//check if the action exists in the controller. if not, throw an exception.
$controller	=	ucfirst($controller);
$controller = new $controller($params);
if(method_exists($controller, $action) === false )
{
	$actionres		=	$db->message(12);
	$result			=	json_encode($actionres);
	$query			=	"UPDATE tblapilog SET returned  = '$result' WHERE pkapilogid = '".$db->logid."'";
	$db->query($query);
	echo $result;
	exit();
}
else
{
	//create a new instance of the controller, and pass it the parameters from the request
	$result		=	$controller->$action();
	$result		=	json_encode($result);
	$result		=	str_replace("\/",'/',$result);
	$query		=	"UPDATE tblapilog SET returned  = '$result' WHERE pkapilogid = '".$db->logid."'";
	$db->query($query);
	echo $result;
	exit();
}
?>