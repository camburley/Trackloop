<?php
require_once("classes/class.db.php");
class User extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function validate($field)
	{
		switch($field)
		{
			case 'username':
				if(trim($this->_params['username'])!="")
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
			case 'password':
				if(trim($this->_params['password'])!="")
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
			case 'userimage':
				if(trim($this->_params['userimage'])!="")
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
			default:
				return false;
				break;
		}
	}
	
	public function authenticateAction()
	{
		$username	=	$this->_params['username'];
		$password	=	$this->_params['password'];
		if($this->_params['username']=="" || $this->_params['password']=="")
		{
			return $this->message(11);;
		}
		$sql		=	"SELECT pkuserid FROM tbluser WHERE username = '$username' AND password =  '$password'";
		$this->query($sql);
		if(mysqli_num_rows($this->queryresult) > 0)
		{
			return $this->message(1);
		}
		else
		{
			return $this->message(2);
		}
	}
	
	public function readAction()
	{
		$username		=	$this->_params['username'];
		if($this->_params['username']=="")
		{
			return(array('failure'=>1,'message'=>'Please provide a username.'));
		}
		$sql	=	"SELECT email,uniqueid,fkstatusid as status FROM tbluser WHERE email='$username'";
		$this->query($sql);
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			$arr[0]	=	$this->message(22);
			$arr[1]	=	$array;
			return($arr);
		}
		else
		{
			return $this->message(21);
		}
		
	}
	public function readartistAction()
	{
		$uniqueid		=	$this->_params['uniqueid'];
		$sqluser		=	"SELECT * FROM tblartist WHERE uniqueid='$uniqueid'";
		$this->query($sqluser);
		while($arr	=	mysqli_fetch_assoc($this->queryresult))
		{
			$array[]	=	$arr;
		}
		return $array;
	}
	public function createartistAction()
	{
		$uniqueid		=	$this->generateUniqueID('tblartist');
		$username		=	$this->_params['username'];
		$firstname		=	$this->_params['firstname'];
		$lastname		=	$this->_params['lastname'];
		$password		=	$this->_params['password'];
		//$phone			=	$this->_params['phone'];
		$mobile			=	$this->_params['mobile'];
		$twitterid		=	$this->_params['twitterid'];
		$facebookid		=	$this->_params['facebookid'];
		$location		=	$this->_params['location'];
		$ipaddress		=	$this->_params['ipaddress'];
		$signupdate		=	$this->_params['signupdate'];
		$sqluser		=	"SELECT username FROM tblartist WHERE username='$username'";
		$this->query($sqluser);
		if(empty ($firstname))
		{
			return $this->message(8);
		}
		if(empty ($lastname))
		{
			return $this->message(9);
		}
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
		else if(empty ($location))
		{
			return $this->message(5);
		}
		else if(empty ($mobile))
		{
			return $this->message(6);
		}
		else if(empty ($twitterid))
		{
			return $this->message(7);
		}
		else if(empty ($facebookid))
		{
			return $this->message(24);
		}
		
		else if(mysqli_num_rows($this->queryresult) > 0)
		{
			return $this->message(1);
		}
		
		$sql	=	"INSERT INTO 
									tblartist 
								SET 
									username	=	'$username',
									firstname	=	'$firstname',
									lastname	=	'$lastname',
									password	=	'$password',
									mobile		=	'$mobile',
									twitterid	=	'$twitterid',
									facebookid	=	'$facebookid',
									location	=	'$location',
									uniqueid	=	'$uniqueid',
									ipaddress	=	'$ipaddress',
									signupdate	=	" . (empty($signupdate)? "now()" :'$signupdate');
		
		$this->query($sql);
		if(mysqli_affected_rows($this->link)>0)
		{
			return array('uniqueid'=>$uniqueid);
		}
		else
		{
			return ;
		}
	}
	public function updateartistAction()
	{
		$artistuniqueid	=	$this->_params['artistuniqueid'];
		//$username		=	$this->_params['username'];
		$firstname		=	$this->_params['firstname'];
		$lastname		=	$this->_params['lastname'];
		$password		=	$this->_params['password'];
		$phone			=	$this->_params['phone'];
		$mobile			=	$this->_params['mobile'];
		$twitterid		=	$this->_params['twitterid'];
		$facebookid		=	$this->_params['facebookid'];
		$location		=	$this->_params['location'];
		$ipaddress		=	$this->_params['ipaddress'];
		//$sqluser		=	"SELECT username FROM tblartist WHERE username='$username' AND  uniqueid != '$artistuniqueid' ";
		//$this->query($sqluser);
		if(empty ($firstname))
		{
			return $this->message(8);
		}
		if(empty ($lastname))
		{
			return $this->message(9);
		}
		/*if(empty ($username))
		{
			return $this->message(2);
		}
		if(!filter_var($username, FILTER_VALIDATE_EMAIL))
		{
			return $this->message(4);
		}*/
		else if(empty ($password))
		{
			return $this->message(3);
		}		
		else if(empty ($location))
		{
			return $this->message(5);
		}
		else if(empty ($mobile))
		{
			return $this->message(6);
		}
		else if(empty ($twitterid))
		{
			return $this->message(7);
		}
		else if(empty ($facebookid))
		{
			return $this->message(24);
		}
		
		else if(mysqli_num_rows($this->queryresult) > 0)
		{
			return $this->message(1);
		}
		
		$sql	=	"UPDATE
									tblartist 
								SET 
									firstname	=	'$firstname',
									lastname	=	'$lastname',
									password	=	'$password',
									mobile		=	'$mobile',
									twitterid	=	'$twitterid',
									facebookid	=	'$facebookid',
									location	=	'$location',
									ipaddress	=	'$ipaddress'
									
								WHERE
									uniqueid	=	'$artistuniqueid'
									";
		
		$this->query($sql);
		if(mysqli_affected_rows($this->link)>0)
		{
			return array('uniqueid'=>$artistuniqueid);
		}
		else
		{
			return;
		}
	}
	
	public function readfanAction()
	{
		$uniqueid		=	$this->_params['uniqueid'];
		$sqluser		=	"SELECT * FROM tblfans WHERE uniqueid='$uniqueid'";
		$this->query($sqluser);
		while($arr	=	mysqli_fetch_assoc($this->queryresult))
		{
			$array[]	=	$arr;
		}
		return $array;
	}
	public function createfanAction()
	{
		$uniqueid		=	$this->generateUniqueID('tblfans');
		$username		=	$this->_params['username'];
		$firstname		=	$this->_params['firstname'];
		$lastname		=	$this->_params['lastname'];
		$password		=	$this->_params['password'];
		$address1		=	$this->_params['address1'];
		$address2		=	$this->_params['address2'];
		$phone			=	$this->_params['phone'];
		$mobile			=	$this->_params['mobile'];
		$twitterid		=	$this->_params['twitterid'];
		$location		=	$this->_params['location'];
		$ipaddress		=	$this->_params['ipaddress'];
		$signupdate		=	$this->_params['signupdate'];
		$sqluser		=	"SELECT username FROM tblfans WHERE username='$username'";
		$this->query($sqluser);
		if(empty ($firstname))
		{
			return $this->message(8);
		}
		if(empty ($lastname))
		{
			return $this->message(9);
		}
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
		else if(empty ($location))
		{
			return $this->message(5);
		}
		else if(empty ($mobile))
		{
			return $this->message(6);
		}
		else if(empty ($twitterid))
		{
			return $this->message(7);
		}
		
		else if(mysqli_num_rows($this->queryresult) > 0)
		{
			return $this->message(1);
		}
		
		$sql	=	"INSERT INTO 
									tblfans 
								SET 
									username	=	'$username',
									firstname	=	'$firstname',
									lastname	=	'$lastname',
									password	=	'$password',  
									address1	=	'$address1',
									address2	=	'$address2',
									phone		=	'$phone',
									mobile		=	'$mobile',
									twitterid	=	'$twitterid',
									location	=	'$location',
									uniqueid	=	'$uniqueid',
									ipaddress	=	'$ipaddress',
									signupdate	=	'$signupdate'
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
	public function resetpassAction()
	{
		$email_address	=	$this->_params['email_address'];
		$old_password	=	$this->_params['oldpassword'];
		$new_password	=	$this->_params['newpassword'];
		/***************************************Validate******************************/
		if(!$this->validate('email_address'))
		{
			return $this->message(12);
		}
		if($old_password=="")
		{
			return $this->message(15);
		}
		if($new_password=="")
		{
			return $this->message(16);
		}
		if($new_password==$old_password)
		{
			return $this->message(17);
		}
		/*********************************Querying****************************/
		$sql	=	"UPDATE tbluser SET password =  '$new_password' WHERE email = '$email_address' AND password = '$old_password'";
		$this->query($sql);
		if(mysqli_affected_rows($this->link))
		{
			return $this->message(6);
		}
		else
		{
			return $this->message(10);
		}
	}
	public function userverificationAction()
	{
		$uniqueid	=	$this->_params['uniqueid'];
		$sql		=	"SELECT status FROM tbluser WHERE uniqueid='$uniqueid' AND status=1";
		$this->query($sql);
		if(mysqli_num_rows($this->queryresult) > 0)
		{
			return $this->message(9);
		}
		
		$sql		=	"UPDATE tbluser SET status	=	1 WHERE uniqueid='$uniqueid'";
		$this->query($sql);
		if(mysqli_affected_rows($this->link)>0)
		{
			return $this->message(7);
		}
		else
		{	
			return array($this->message(8),'uniqueid'=>$uniqueid);
		}	
	}
	public function loginAction()
	{
		$username	=	$this->_params['username'];
		$password	=	$this->_params['password'];
		if($this->_params['username']=="" || $this->_params['password']=="")
		{
			return $this->message(2);
		}
		$sql		=	"SELECT uniqueid FROM tblartist WHERE username = '$username' AND password =  '$password'";
		$this->query($sql);
		if(mysqli_num_rows($this->queryresult) > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			return $array;
		}
		else
		{
			$sql		=	"SELECT sectionid,uniqueid,pkmemberid FROM tblmember m,tblartist a WHERE m.username = '$username' AND m.password =  '$password' AND pkartistid = fkartistid";
			$this->query($sql);
			if(mysqli_num_rows($this->queryresult) > 0)
			{
				while($arr	=	mysqli_fetch_assoc($this->queryresult))
				{
					$array[]	=	$arr;
				}
				return $array;
			}
			else
			{
				return $this->message(16);
			}
		}
	}
	
	/**
	 * This function return the user password i.e functionality for forgot password
	 */
	public function forgotPasswordAction() {
		$username	=	$this->_params['username'];
		if($this->_params['username']=="") {
			return $this->message(2);
		}
		
		$sql		=	"SELECT username, password, firstname, uniqueid FROM tblartist WHERE username = '$username'";
		$this->query($sql);
		if(mysqli_num_rows($this->queryresult) > 0) {
			while($arr	=	mysqli_fetch_assoc($this->queryresult)) {
				$array[]	=	$arr;
			}
			return $array;
		} else {
			$sql		=	"SELECT m.username, m.password, a.firstname, m.pkmemberid, a.uniqueid FROM tblmember m,tblartist a WHERE m.username = '$username' AND pkartistid = fkartistid";
			$this->query($sql);
			if(mysqli_num_rows($this->queryresult) > 0) {
				while($arr	=	mysqli_fetch_assoc($this->queryresult)) {
					$array[]	=	$arr;
				}
				return $array;
			} else {
				return $this->message(16);
			}
		}
	}
	
	/**
	 * This function get user detail using twitter id, if it is present
	 */
	public function verifyTwitterUserAction()
	{
		$twitterid	=	$this->_params['twitterId'];
		if($twitterid == "")
		{
			return $this->message(7);
		}
		$sql		=	"SELECT uniqueid FROM tblartist WHERE twitterid = '$twitterid'";
		$this->query($sql);
		if(mysqli_num_rows($this->queryresult) > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			return $array;
		}
		else
		{
			return $this->message(16);
		}
	}
	
	/**
	 *  This function get user detail using facebookId, if it is present
	 */
	public function verifyFacebookUserAction()
	{
		$facebookid	=	$this->_params['facebookid'];
		if($facebookid == "")
		{
			return $this->message(24);
		}
		$sql		=	"SELECT uniqueid FROM tblartist WHERE facebookid = '$facebookid'";
		$this->query($sql);
		if(mysqli_num_rows($this->queryresult) > 0)
		{
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
			return $array;
		}
		else
		{
			return $this->message(16);
		}
	}
}