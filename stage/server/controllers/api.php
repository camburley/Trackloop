<?php
if(file_exists("classes/class.db.php"))
{
	require_once("classes/class.db.php");
}
else
{
	require_once("../classes/class.db.php");
}
class Api extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function testAction()
	{
		return "valid_100";
		
		$app_id		=	$this->_params['app_id'];
		$app_key	=	$this->_params['app_key'];
		$controller	=	ucfirst(strtolower($this->_params['controller']));
		$action		=	strtolower($this->_params['action']).'Action';
		$ipaddress	=	$_SERVER['REMOTE_ADDR'];
		$time		=	date('Y-m-d H:i:s');
		$params_str	=	$this->grab_dump($this->_params);
		if(sizeof($_FILES) > 0)
		{
			$params_str	.=	$this->grab_dump($_FILES);
		}
		$params_str	=	$this->filter($params_str);
		$log_query	=	"INSERT INTO tblapilog SET appid = '$app_id', appkey ='$app_key', ipaddress = '$ipaddress', logtime = '$time', params = '$params_str'";
		$this->query($log_query);
		$this->logid=	mysqli_insert_id($this->link);
		$query		=	"SELECT appkey FROM tblapi WHERE appid= '$app_id'";
		$this->query($query);
		$array		=	mysqli_fetch_assoc($this->queryresult);
		$api_key	=	$array['appkey'];
		if($api_key	!= $app_key)
		{
			$result	=	json_encode($this->message(26));
			$query	=	"UPDATE tblapilog SET returned  = '$result' WHERE pkapilogid = '".$this->logid."'";
			$this->query($query);
			return($result);
		}
		else if(($controller=='Api') && ($action=='testAction') )
		{
			$result	=	json_encode($this->message(31));
			$query	=	"UPDATE tblapilog SET returned  = '$result' WHERE pkapilogid = '".$this->logid."'";
			$this->query($query);
			return $result;
		}
		else
		{
			return "valid_".$this->logid;
		}
	}
}
?>    