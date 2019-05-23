<?php
require_once("classes/class.db.php");
class Reach extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readfanAction()
	{
		$fanuniqueid		=	$this->_params['fanuniqueid'];
		$sql	=	"SELECT twitterid FROM tblfans WHERE uniqueid = '$fanuniqueid'";
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
	}
	public function createreachAction()
	{
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$reachdate		=	$this->_params['reachdate'];
		$totalfollowers	=	$this->_params['totalfollowers'];
		$twitterid		=	$this->_params['twitterid'];
		$location		=	$this->_params['location'];
		
		$sqluniqueid	=	"SELECT a.pkalbumid FROM tblalbum a WHERE a.uniqueid='$albumuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		$sql	=	"INSERT INTO 
									tblreach 
								SET 
										totalfollower	=	'$totalfollowers',
										reachdate		=	'$reachdate',
										fkalbumid		=	'$pkalbumid',
										twitterid		=	'$twitterid',
										location		=	'$location'
										
									";
		
		$this->query($sql);
	}
		/*if(mysqli_affected_rows($this->link)>0)
		{
			return array(/*$this->message(13),*//*'uniqueid'=>$uniqueid);
		}
		else
		{
			//return $this->message(14);
		}
	}*/
	public function readreachAction()
	{
		$uniqueid		=	$this->_params['uniqueid'];
		$sql	=	"SELECT totalfollower FROM tblreach,tblalbum WHERE uniqueid = '$uniqueid' AND pkalbumid = fkalbumid";
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
	}
	
}