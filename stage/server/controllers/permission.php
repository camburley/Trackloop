<?php
require_once("classes/class.db.php");
class Permission extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	
	public function memberpermissionAction()
	{
		
		$username		=	$this->_params['username'];
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		$password		=	$this->_params['password'];
		$sections		=	$this->_params['sections'];
		$pkmemberid		=	$this->_params['pkmemberid'];
		if($pkmemberid)
		{
			$sqluser		=	"SELECT username FROM tblmember WHERE username='$username' AND pkmemberid != '$pkmemberid' ";
			$this->query($sqluser);
			
			if(empty ($username))
			{
				return $this->message(2);
			}
			if(!filter_var($username, FILTER_VALIDATE_EMAIL))
			{
				return $this->message(4);
			}
			else if(empty ($password))
			{
				return $this->message(3);
			}		
			else if(mysqli_num_rows($this->queryresult) > 0)
			{
				return $this->message(1);
			}
			$sql	=	"UPDATE 
										tblmember 
									SET 
										username	=	'$username',
										password	=	'$password',
										sectionid	=	'$sections'
										
									WHERE
										pkmemberid	=	'$pkmemberid'
										";
			
			$this->query($sql);
			return array('uniqueid'=>$pkmemberid);
		}
		else
		{
			$sqluser		=	"SELECT username FROM tblmember WHERE username='$username'";
			$this->query($sqluser);
			
			if(empty ($username))
			{
				return $this->message(2);
			}
			if(!filter_var($username, FILTER_VALIDATE_EMAIL))
			{
				return $this->message(4);
			}
			else if(empty ($password))
			{
				return $this->message(3);
			}		
			else if(mysqli_num_rows($this->queryresult) > 0)
			{
				return $this->message(1);
			}
			$sqluniqueid		=	"SELECT pkartistid FROM tblartist WHERE uniqueid='$artistuniqueid'";
			$this->query($sqluniqueid);
			$arr	=	mysqli_fetch_assoc($this->queryresult);
			$pkartistid	=	$arr['pkartistid'];
			$sql	=	"INSERT INTO 
										tblmember 
									SET 
										username	=	'$username',
										password	=	'$password',
										sectionid	=	'$sections',
										fkartistid	=	'$pkartistid'
										";
			
			$this->query($sql);
			if(mysqli_affected_rows($this->link)>0)
			{
				return array($this->message(13),'uniqueid'=>$uniqueid);
			}
			else
			{
				return $this->message(14);
			}
		}
	}
	public function readmemberpermissionAction()
	{
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		 $sqluser		=	"SELECT pkmemberid,m.username memberusername,m.password as memberpassword FROM tblartist ar,tblmember m WHERE ar.pkartistid = m.fkartistid AND ar.uniqueid='$artistuniqueid'";
		$this->query($sqluser);
		while($arr	=	mysqli_fetch_assoc($this->queryresult))
		{
			$array[]	=	$arr;
		}
		return $array;
	}
	public function readememberpermissionAction()
	{
		$memberid	=	$this->_params['memberid'];
		$sqluser		=	"SELECT * FROM tblmember WHERE pkmemberid	=	'$memberid'";
		$this->query($sqluser);
		while($arr	=	mysqli_fetch_assoc($this->queryresult))
		{
			$array[]	=	$arr;
		}
		return $array;
	}
	public function deletememberAction()
	{
		
		$pkmemberid	=	$this->_params['pkmemberid'];
		$sql	=	"DELETE FROM tblmember WHERE pkmemberid	=	'$pkmemberid'";
		$this->query($sql);
		return array('pkmemberid'=>$pkmemberid);
	}
	
}