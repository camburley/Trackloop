<?php
require_once("classes/class.db.php");
class Album extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readalbumAction()
	{
		$uniqueid		=	$this->_params['uniqueid'];
		$sql	=	"SELECT albumname,coverimage,albumdate,albumstatus,al.uniqueid FROM tblalbum al,tblartist ar WHERE ar.uniqueid = '$uniqueid' AND pkartistid = fkartistid";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			//$arr[0]	=	$this->message(15);
			//$arr[1]	=	$array;
			return($array);
		}
		else
		{
			return $this->message(17);
		}
		
	}
	public function createalbumAction()
	{
		$albumname			=	$this->_params['albumname'];
		$coverimage			=	$this->_params['coverimage'];
		$albumdate			=	$this->_params['albumdate'];
		$artistuniqueid		=	$this->_params['artistuniqueid'];
		$description		=	$this->_params['description'];
		$genresname			=	$this->_params['tagsinput'];
		$sqluniqueid		=	"SELECT pkartistid FROM tblartist WHERE uniqueid='$artistuniqueid'";
		$this->query($sqluniqueid);
		if(empty ($description))
		{
			return $this->message(19);
		}
		/*if(empty ($description))
		{
			return $this->message(20);
		}*/
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkartistid	=	$arr['pkartistid'];
		$uniqueid		=	$this->generateUniqueID('tblalbum');
		$sql	=	"INSERT INTO 
									tblalbum 
								SET 
										albumname			=	'$albumname',
										coverimage			=	'$coverimage',
										uniqueid			=	'$uniqueid',
										albumdate			=	'$albumdate',
										albumdescription	=	'$description',
										genresname			=	'$genresname',
										fkartistid			=	'$pkartistid'
										
									";
		
		$this->query($sql);
		if(mysqli_affected_rows($this->link)>0)
		{
			return array(/*$this->message(13),*/'uniqueid'=>$uniqueid);
		}
		else
		{
			//return $this->message(14);
		}
	}
	public function updatealbumAction()
	{
		$albumname			=	$this->_params['albumname'];
		$coverimage			=	$this->_params['coverimage'];
		$description		=	$this->_params['description'];
		$genresname			=	$this->_params['tagsinput'];
		$albumuniqueid		=	$this->_params['albumuniqueid'];		
		$sql	=	"UPDATE 
									tblalbum 
								SET 
									albumname			=	'$albumname',
									coverimage			=	'$coverimage',
									albumdescription	=	'$description',
									genresname			=	'$genresname'
								WHERE
									 uniqueid		=	'$albumuniqueid'
									";
		
		$this->query($sql);
		return array('uniqueid'=>$albumuniqueid);
	}
}