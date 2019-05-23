<?php
require_once("classes/class.db.php");
class File extends DB
{
	private $_params;
	public function __construct($params)
	{
		//print_r($params);
		$this->_params = $params;
	}
	public function downloadAction()
	{
		$userid		=	$_REQUEST['user_id'];
		$pkuserid	=	$this->validateuser($userid);
		if($pkuserid > 0)
		{
			$uniqueid	=	$_REQUEST['uniqueid'];
			$uniqueid	=	$this->filter($uniqueid);
			$query		=	"SELECT * FROM tblfile WHERE uniqueid = '$uniqueid'";
			$this->query($query);
			$qs		=	$this->queryresult;
			if(mysqli_num_rows($qs) > 0)
			{
				$obj	=	mysqli_fetch_object($qs);
				if($obj->status ==0)
				{
					return $this->message(28);
				}
				else
				{
					$url	=	$this->baseurl."server/download.php?filename=$obj->filename"; 
					return array("downloadurl"=>$url,"message"=>$this->message(38));
				}
			}
			else
			{
				return $this->message('27');
			}
		}
		else
		{
			return $this->message(33);
		}
	}
	public function uploadAction()
	{
		$userid		=	$_REQUEST['user_id'];
		$pkuserid	=	$this->validateuser($userid);
		if($pkuserid > 0)
		{	
			$filetypequery	=	"SELECT * FROM `tblfiletype`";
			$this->query($filetypequery);
			while($obj	=	mysqli_fetch_object($this->queryresult))
			{
				$filetypes[$obj->pkfiletypeid]			=	strtolower($obj->filetype);
				$fileextensions[$obj->fileextension]	=	strtolower($obj->fileextension);
			}
			$extension	=	pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			$filetype	=	$_FILES['upload']['type'];
		//	$this->dump($filetypes);
//			echo $filetype;
	//		exit;
			if(!in_array(strtolower($extension),$fileextensions))
			{
			  // If the extension is not allowed show an error, else, the file type is valid
				return $this->message(25);
			}
			if(!in_array(strtolower($filetype),$filetypes))
			{
			  // If the type is not allowed show an error, else, the file type is valid
				return $this->message(25);
			}
			
			$filename	=	time().'_'.rand(1000000,9999999).'_'.basename($_FILES['upload']['name']);
			$uploadfile	=	"../../../data/". $filename;
			
		//	if()//10485760
			if(($_FILES['upload']['size'] > '10485760'))
			{
				return $this->message(39);
			}
			if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile))
			{
				$id			=	$this->generateUniqueFileID();
				$uploadtime	=	date('Y-m-d H:i:s');
				$expirydate	=	date('Y-m-d H:i:s', strtotime("+30 days"));
				$query		=	"INSERT INTO tblfile 
										SET 
											filename		=	'$filename',
											uniqueid		=	'$id',
											retrievalcode	=	'$id',
											status			=	'1',
											uploadtime		=	'$uploadtime',
											fkuserid		=	'$pkuserid',
											expirydate		=	'$expirydate'
											
								";
				$this->query($query);
				$url	=	$this->baseurl."server/download.php?filename=$filename"; 
				return array('downloadurl'=>$url,'uniqueid'=>$id,'expirydate'=>$expirydate,'message'=>$this->message(23));
			}
			else
			{
				//print_r($_FILES[
				return $this->message(24);
			}
		
		}
		else
		{
			return $this->message(33);
		}
	}
}
?>    