<?php
require_once("classes/class.db.php");
class Tweet extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readtweetAction()
	{
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$fanuniqueid	=	$this->_params['fanuniqueid'];
		$sql	=	"SELECT pktweetalbumid FROM tblalbum al,tblfans f,tbltweetalbum ta WHERE al.uniqueid = '$albumuniqueid' AND f.uniqueid = '$fanuniqueid' AND pkalbumid = ta.fkalbumid AND pkfansid	=	ta.fkfansid";
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
	public function createtweetAction()
	{
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$fanuniqueid	=	$this->_params['fanuniqueid'];
		$tweetdate		=	$this->_params['tweetdate'];
		$sqluniqueid		=	"SELECT pkalbumid,pkfansid FROM tblalbum a,tblfans f WHERE a.uniqueid='$albumuniqueid' AND f.uniqueid='$fanuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		$pkfansid	=	$arr['pkfansid'];
		if($pkalbumid&&$pkfansid>0)
		{
			$sql	=	"INSERT INTO 
									tbltweetalbum 
								SET 
									fkalbumid	=	'$pkalbumid',
									fkfansid	=	'$pkfansid',
									tweetdate	=	'$tweetdate'
								";
			
			$this->query($sql);
			$pktweetalbumid	=	 mysqli_insert_id($this->link);
			if(mysqli_affected_rows($this->link)>0)
			{
				return array(/*$this->message(13),*/'pktweetalbumid'=>$pktweetalbumid);
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