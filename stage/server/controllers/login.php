<?php
require_once("classes/class.db.php");
class Login extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readloginartistAction()
	{
		$username		=	$this->_params['username'];
		$password		=	$this->_params['password'];
		if($username=="")
		{
			return $this->message(2);
		}
		if($password=="")
		{
			return $this->message(3);
		}
		$sql	=	"SELECT uniqueid FROM tblartist WHERE username = '$username' AND password = '$password'";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			$arr[0]	=	$this->message(15);
			$arr[1]	=	$array;
			return($arr);
		}
		else
		{
			return $this->message(16);
		}
		
	}
	public function readloginfanAction()
	{
		$username		=	$this->_params['username'];
		$password		=	$this->_params['password'];
		if($username=="")
		{
			return $this->message(2);
		}
		if($password=="")
		{
			return $this->message(3);
		}
		$sql	=	"SELECT uniqueid FROM tblfans WHERE username = '$username' AND password = '$password'";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			$arr[0]	=	$this->message(15);
			$arr[1]	=	$array;
			return($arr);
		}
		else
		{
			return $this->message(16);
		}
		
	}
}