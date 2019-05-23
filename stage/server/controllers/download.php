<?php
require_once("classes/class.db.php");
class Download extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readdownloadAction()
	{
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$sql	=	"SELECT pkdownloadid FROM tbldownload,tblalbum WHERE uniqueid = '$albumuniqueid' AND pkalbumid = fkalbumid";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		return array($rows);		
	}
	public function createdownloadAction()
	{
		$twitterid			=	$this->_params['twitterid'];
		$location			=	$this->_params['location'];
		$downloaddate		=	$this->_params['downloaddate'];
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$sqluniqueid		=	"SELECT pkalbumid FROM tblalbum  WHERE uniqueid='$albumuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		
		$pkalbumid	=	$arr['pkalbumid'];
		
		if($pkalbumid>0)
		{
			$sql	=	"INSERT INTO 
									tbldownload 
								SET 
									
									twitterid			=	'$twitterid',
									downloaddate		=	'$downloaddate',
									fkalbumid			=	'$pkalbumid',
									downloadlocation	=	'$location'
								";
			
			$this->query($sql);
			if(mysqli_affected_rows($this->link)>0)
			{
				//return array(/*$this->message(13),*/);
			}
			else
			{
				//return array(/*$this->message(13),*/'msg'=>'fail');
				//return $this->message(14);
			}
		}
		else
		{
			//return array(/*$this->message(13),*/'pkalbumid'=>$pkalbumid);
		}
	}
	public function readtotaldownloadAction()
	{
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$sql	=	"SELECT count(pkdownloadid) totaldown  FROM tbldownload,tblalbum WHERE uniqueid = '$albumuniqueid' AND pkalbumid = fkalbumid";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			return $array;
	}
	public function readlocationbyalbumAction()
	{
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$sql	=	"SELECT 
							uniqueid,
							count(downloadlocation) countloaction,
							downloadlocation
						FROM
							tbldownload,
							tblalbum
						WHERE
							uniqueid = '$albumuniqueid' AND
							pkalbumid = fkalbumid
						GROUP BY downloadlocation
						ORDER BY countloaction DESC
						LIMIT 0,5
					";
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
			$array[]	=	$countloaction;
			
			return $array;
		}
	}
	public function readlocationbyartistAction()
	{
		$artistuniqueid		=	$this->_params['artistuniqueid'];
		$sql	=	"SELECT 
							count(downloadlocation) countloaction,
							downloadlocation
						FROM
							tbldownload d,
							tblalbum al,
							tblartist ar
						WHERE
							ar.uniqueid = '$artistuniqueid' AND
							ar.pkartistid	=	al.fkartistid AND
							al.pkalbumid = d.fkalbumid
						GROUP BY downloadlocation
						ORDER BY countloaction DESC
						LIMIT 0,5
					";
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
			$array[]	=	$countloaction;
			
			return $array;
		}
	}
}