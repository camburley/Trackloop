<?php
require_once("classes/class.db.php");
class Feedback extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	
	public function createfeedbackAction()
	{
		$description	=	$this->_params['description'];
		$optionsRadios	=	$this->_params['optionsRadios'];
		$senderemail	=	$this->_params['senderemail'];
		$sendername		=	$this->_params['sendername'];
		$feedbackdate	=	$this->_params['feedbackdate'];
		
			$sql	=	"INSERT INTO 
									tblfeedback 
								SET 
									
									description		=	'$description',
									feedbackoption	=	'$optionsRadios',
									senderemail		=	'$senderemail',
									sendername		=	'$sendername',
									feedbackdate	=	'$feedbackdate'
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
}