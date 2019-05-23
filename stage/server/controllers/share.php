<?php
require_once("classes/class.db.php");
class Share extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readshareAction()
	{
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$sql	=	"SELECT pkshareid FROM tblshare,tblalbum WHERE uniqueid = '$albumuniqueid' AND pkalbumid = fkalbumid";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		return array($rows);		
	}
	public function createshareAction()
	{
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$ipaddress		=	$this->_params['ipaddress'];
		$sharedate		=	$this->_params['sharedate'];
		$shareon		=	$this->_params['shareon'];
		$sqluniqueid		=	"SELECT pkalbumid FROM tblalbum a WHERE a.uniqueid='$albumuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		if($pkalbumid>0)
		{
			$sql	=	"INSERT INTO 
									tblshare 
								SET 
									fkalbumid		=	'$pkalbumid',
									shareipaddress	=	'$ipaddress',
									sharedate		=	'$sharedate',
									shareon			=	'$shareon'
								";
			
			$this->query($sql);
			if(mysqli_affected_rows($this->link)>0)
			{
				//return array(/*$this->message(13),*/'trackuniqueid'=>$trackuniqueid);
			}
			else
			{
				//return array(/*$this->message(13),*/'msg'=>'fail');
				//return $this->message(14);
			}
		}
		else
		{
			//return array(/*$this->message(13),*/'msg'=>'fail');
		}
	}
}