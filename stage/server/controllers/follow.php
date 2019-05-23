<?php
require_once("classes/class.db.php");
class Follow extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readfollowAction()
	{
		$artistuniqueid		=	$this->_params['artistuniqueid'];
		$sql	=	"SELECT pkfollowid FROM tblfollow,tblartist WHERE uniqueid = '$artistuniqueid' AND pkartistid = fkartistid";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		return array($rows);		
	}
	public function createfollowAction()
	{
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		$ipaddress	=	$this->_params['ipaddress'];
		$followdate		=	$this->_params['followdate'];
		$sqluniqueid		=	"SELECT pkartistid FROM tblartist a WHERE a.uniqueid='$artistuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkartistid	=	$arr['pkartistid'];
		if($pkartistid>0)
		{
			$sql	=	"SELECT pkfollowid FROM tblfollow WHERE fkartistid = '$pkartistid' AND followipaddress = '$ipaddress'";
			$this->query($sql);
			$rows	=	mysqli_num_rows($this->queryresult);
			if($rows>0)
			{
				$sql	=	"DELETE FROM
									tblfollow 
								WHERE 
									fkartistid		=	'$pkartistid' AND
									followipaddress	=	'$ipaddress'
									
								";
			
				$this->query($sql);
				$sql	=	"INSERT INTO 
										tblfollow 
									SET 
										fkartistid		=	'$pkartistid',
										followipaddress	=	'$ipaddress',
										followdate		=	'$followdate'
									";
				
				$this->query($sql);
			}
			else
			{
				$sql	=	"INSERT INTO 
										tblfollow 
									SET 
										fkartistid		=	'$pkartistid',
										followipaddress	=	'$ipaddress',
										followdate		=	'$followdate'
									";
				
				$this->query($sql);
			}
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
	public function deletefollowAction()
	{
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		$ipaddress	=	$this->_params['ipaddress'];
		$sqluniqueid		=	"SELECT pkartistid FROM tblartist a WHERE a.uniqueid='$artistuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkartistid	=	$arr['pkartistid'];
		if($pkartistid>0)
		{
			$sql	=	"DELETE FROM
									tblfollow 
								WHERE 
									fkartistid		=	'$pkartistid' AND
									followipaddress	=	'$ipaddress'
									
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