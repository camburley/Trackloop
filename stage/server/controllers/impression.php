<?php
require_once("classes/class.db.php");
class Impression extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readimpressionAction()
	{
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$sql	=	"SELECT pkimpressionid FROM tblimpression,tblalbum WHERE uniqueid = '$albumuniqueid' AND pkalbumid = fkalbumid";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		
		$array[]	=	$rows;
		return $array;

	}
	
	public function createimpressionAction()
	{
		$impressiondate	=	date('Y/m/d h:i:s');
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		$sqluniqueid	=	"SELECT pkalbumid,pkartistid FROM tblalbum a,tblartist ar WHERE a.uniqueid='$albumuniqueid' AND ar.uniqueid='$artistuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		$pkartistid	=	$arr['pkartistid'];
		$sql	=	"INSERT INTO 
									tblimpression 
								SET 
										fkalbumid		=	'$pkalbumid',
										fkartistid		=	'$pkartistid',
										impressiondate	=	'$impressiondate'
									";
		
		$this->query($sql);
		if(mysqli_affected_rows($this->link)>0)
		{
			return array(/*$this->message(13),*/'uniqueid'=>$albumuniqueid);
		}
		else
		{
			//return $this->message(14);
		}
	}
	/*public function readtrackfileAction()
	{
		$trackuniqueid		=	$this->_params['trackuniqueid'];
		$sql	=	"SELECT trackfile FROM tbltrack WHERE uniqueid = '$trackuniqueid'";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			return $array;
		}
		else
		{
			return $this->message(18);
		}
	}*/
}