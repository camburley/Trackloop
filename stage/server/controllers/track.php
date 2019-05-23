<?php
require_once("classes/class.db.php");
class Track extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function readtrackAction()
	{
		$uniqueid		=	$this->_params['uniqueid'];
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		$sql	=	"SELECT 
							trackname,
							trackfile,
							tracklength,
							audioquality,
							al.uniqueid,
							t.uniqueid
						FROM
							tblalbum al,
							tbltrack t,
							tblartist ar
						WHERE
							al.uniqueid	=	'$uniqueid' AND 
							pkalbumid	=	fkalbumid AND
							fkartistid	=	pkartistid AND
							ar.uniqueid =	'$artistuniqueid'
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
			return $this->message(18);
		}
	}
	public function readartistalbumAction()
	{
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$artistuniqueid		=	$this->_params['artistuniqueid'];
		$sql	=	"SELECT * FROM tblalbum al,tblartist ar WHERE ar.uniqueid = '$artistuniqueid' AND pkartistid = fkartistid AND al.uniqueid = '$albumuniqueid'" ;
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
	
	public function createtrackAction()
	{
		$trackname	=	$this->_params['trackname'];
		$path_parts = pathinfo($trackname);
		$trackname	=	$path_parts['filename'];
		if(empty($trackname))
		{
			return;
		}
		if($this->_params['titlesong']==1)
		{
			$titlesong		=	$this->_params['titlesong'];
		}
		$trackfile		=	$this->_params['trackfile'];
		$trackdate		=	$this->_params['trackdate'];
		$tracklength	=	$this->_params['tracklength'];
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$uniqueid		=	$this->generateUniqueID('tbltrack');
		
		$sqluniqueid	=	"SELECT pkalbumid FROM tblalbum WHERE uniqueid='$albumuniqueid'";
		$this->query($sqluniqueid);
		/*if(empty ($trackname))
		{
			return $this->message(21);
		}
		if(empty ($trackfile))
		{
			return $this->message(22);
		}
		*/
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		$q_del	=		"DELETE FROM tbltrack WHERE trackname	=	'$trackname' AND trackfile	=	'$trackfile' AND fkalbumid	=	'$pkalbumid'";
		$this->query($q_del);
		$sql	=	"INSERT INTO 
									tbltrack 
								SET 
										trackname	=	'$trackname',
										titlesong	=	'$titlesong',
										trackfile	=	'$trackfile',
										trackdate	=	'$trackdate',
										tracklength	=	'$tracklength',
										uniqueid	=	'$uniqueid',
										fkalbumid	=	'$pkalbumid'
									";
		
		$this->query($sql);
		
		$sql = "UPDATE tbltrack SET sequence = pktrackid WHERE uniqueid = '$uniqueid'";
		$this->query($sql);
		
		if(mysqli_affected_rows($this->link)>0)
		{
			$query2	=	"UPDATE tbltrack SET titlesong = 1 WHERE fkalbumid	=	'$pkalbumid' LIMIT 1";
			$this->query($query2);
			return array(/*$this->message(13),*/'uniqueid'=>$uniqueid);
		}
		else
		{
			//return $this->message(14);
		}
	}
	public function updatetrackAction()
	{
		$trackname	=	$this->_params['trackname'];
		$path_parts = pathinfo($trackname);
		$trackname	=	$path_parts['filename'];
		if(empty($trackname))
		{
			return;
		}
		if($this->_params['titlesong']==1)
		{
			$titlesong		=	$this->_params['titlesong'];
		}
		$trackfile		=	$this->_params['trackfile'];
		$trackdate		=	$this->_params['trackdate'];
		$tracklength	=	$this->_params['tracklength'];
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$uniqueid		=	$this->generateUniqueID('tbltrack');
		$sqluniqueid	=	"SELECT pkalbumid FROM tblalbum WHERE uniqueid='$albumuniqueid'";
		$this->query($sqluniqueid);
		/*if(empty ($trackname))
		{
			return $this->message(21);
		}
		if(empty ($trackfile))
		{
			return $this->message(22);
		}
		*/
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		//$sql	=	"DELETE FROM tbltrack WHERE fkalbumid	=	'$pkalbumid'";
		//$this->query($sql);
		$q_del	=		"DELETE FROM tbltrack WHERE trackname	=	'$trackname' AND trackfile	=	'$trackfile' AND fkalbumid	=	'$pkalbumid'";
		$this->query($q_del);
		$sql	=	"INSERT INTO 
									tbltrack 
								SET 
										trackname	=	'$trackname',
										titlesong	=	'$titlesong',
										trackfile	=	'$trackfile',
										trackdate	=	'$trackdate',
										tracklength	=	'$tracklength',
										uniqueid	=	'$uniqueid',
										fkalbumid	=	'$pkalbumid'
									";
		
		$this->query($sql);
		
		$sql = "SELECT * FROM tbltrack WHERE uniqueid = '$uniqueid'";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		
		if($rows > 0) {
			$pktrackid = 0;
			while($arr	=	mysqli_fetch_assoc($this->queryresult)) {
				$sequence = $arr['sequence'];
				$pktrackid = $arr['pktrackid'];
				break;
			}
			if($sequence != $pktrackid) {
				$sql = "UPDATE tbltrack SET sequence = pktrackid WHERE uniqueid = '$uniqueid'";
				$this->query($sql);
			}
		}
		
		if(mysqli_affected_rows($this->link)>0)
		{
			$query2	=	"UPDATE tbltrack SET titlesong = 1 WHERE fkalbumid	=	'$pkalbumid' LIMIT 1";
			$this->query($query2);
			return array(/*$this->message(13),*/'uniqueid'=>$uniqueid);
		}
		else
		{
			//return $this->message(14);
		}
		
	}
	public function deletetrackAction()
	{
		
		$albumuniqueid	=	$this->_params['albumuniqueid'];
		$sqluniqueid	=	"SELECT pkalbumid FROM tblalbum WHERE uniqueid='$albumuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		$sql	=	"DELETE FROM tbltrack WHERE fkalbumid	=	'$pkalbumid'";
		$this->query($sql);
		return array('uniqueid'=>$albumuniqueid);
	}
	
	
	public function deletetrackByUniqueIdAction() {
		
		$uniqueid	=	$this->_params['uniqueid'];

		$sql	=	"select * from tbltrack where uniqueid = '" . $uniqueid . "'" ;
		$this->query($sql);
		
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0) {
			
			$track = array();
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$track[]	=	$arr;
				break;
			}
			$sql	=	"DELETE FROM tbltrack WHERE uniqueid	=	'$uniqueid'";
			$this->query($sql);
			
			return($track);
		} else {
			return $this->message(18);
		}
	}
	
	public function readtrackfileAction()
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
	}
	public function readtotaltrackAction()
	{
		$albumuniqueid		=	$this->_params['albumuniqueid'];
		$sql	=	"SELECT count(pktrackid) totalrec FROM tbltrack t,tblalbum a WHERE pkalbumid = t.fkalbumid AND a.uniqueid = '$albumuniqueid'";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			return $array;
	}
	
	/**
	 * This function rename the track file i.e rename the track name & also add sequence of this track
	 */
	public function updateTrackNameAction()
	{
		$trackname	=	$this->_params['trackfile'];
		$path_parts = 	pathinfo($trackname);
		$trackname	=	$path_parts['filename'];
		if(empty($trackname))
		{
			return;
		}
		$trackfile		=	$this->_params['trackfile'];
		$albumuniqueid	=	$this->_params['albumUniqueId'];
		$uniqueid		=	$this->_params['uniqueId'];
		$newUniqueid	=	$this->generateUniqueID('tbltrack');
		$newSequenceId	=	$this->_params['newSequenceId'];
		$oldSequenceId	=	$this->_params['oldSequenceId'];
		
		//Get album detail by album unique Id
		$sqluniqueid	=	"SELECT pkalbumid FROM tblalbum WHERE uniqueid='$albumuniqueid'";
		$this->query($sqluniqueid);
		$arr	=	mysqli_fetch_assoc($this->queryresult);
		$pkalbumid	=	$arr['pkalbumid'];
		
		//Update track detail i.e rename track file & track name
		$sql	=	"UPDATE tbltrack 
					SET 
							trackname	=	'$trackname',
							trackfile	=	'$trackfile',
							uniqueid	=   '$newUniqueid'
					WHERE
							uniqueid	=	'$uniqueid' 
							AND	fkalbumid	=	'$pkalbumid'
					";
		$this->query($sql);
		
		$this->updateSequence($oldSequenceId, $newSequenceId);
		
		//Get track detail by track unique Id
		$sql	=	"select * from tbltrack where uniqueid = '" . $newUniqueid . "'" ;
		$this->query($sql);
		
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0) {
			$trackDetail = array();
			while($arr	=	mysqli_fetch_assoc($this->queryresult)) {
				$trackDetail[]	=	$arr;
				break;
			}
			return($trackDetail);
		}
	}
	
	private function updateSequence($oldSequenceId, $newSequenceId) {
		//Update old track sequence
		//Get track detail by track sequence
		$sql = "SELECT * FROM tbltrack WHERE sequence = '$oldSequenceId'";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		
		if($rows > 0) {
			$pktrackid = 0;
			while($arr	=	mysqli_fetch_assoc($this->queryresult)) {
				$pktrackid = $arr['pktrackid'];
				break;
			}
			if($pktrackid > 0) {
				$updateSequenceSql = "UPDATE tbltrack SET sequence= '$oldSequenceId' WHERE sequence = '$newSequenceId'"; 
				$this->query($updateSequenceSql);

				$updateSequenceSql	=	"UPDATE tbltrack SET sequence = '$newSequenceId' WHERE pktrackid = '$pktrackid'"; 
				$this->query($updateSequenceSql);
			}
		}	
	}
	
	public function readtrackBySequenceAction()
	{
		$uniqueid		=	$this->_params['uniqueid'];
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		$sql	=	"SELECT 
							trackname,
							trackfile,
							tracklength,
							audioquality,
							sequence,		
							al.uniqueid,
							t.uniqueid
						FROM
							tblalbum al,
							tbltrack t,
							tblartist ar
						WHERE
							al.uniqueid	=	'$uniqueid' AND 
							pkalbumid	=	fkalbumid AND
							fkartistid	=	pkartistid AND
							ar.uniqueid =	'$artistuniqueid'
						ORDER BY sequence
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
			return $this->message(18);
		}
	}
	
	public function getTrackDetailByTrackIdAction() {
		$uniqueid		=	$this->_params['uniqueId'];
		$sql	=	"SELECT 
							*
						FROM
							tbltrack
						WHERE
							uniqueid =	'$uniqueid'
						";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				return $arr;
			}
			return $this->message(18);
		}
		else
		{
			return $this->message(18);
		}
	}
}