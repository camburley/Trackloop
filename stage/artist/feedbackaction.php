<?php
@session_start();
require_once("../config.php");
require_once($path.'/apicaller.php');
$apicaller	=	new ApiCaller();
$feedbackdate	=	date('Y/m/d h:i:s');
extract($_POST);
$req		=	array(
							'controller' 	=>	'Feedback',
							'action'		=>	'createfeedback',						
							'description' 	=>	$description,
							'optionsRadios' =>	$optionsRadios,
							'senderemail'	=>	$senderemail,
							'sendername'	=>	$sendername,
							'feedbackdate'	=>	$feedbackdate
						);
$feedback = $apicaller->sendRequest($req); 

// multiple recipients
$to  = $senderemail; // note the comma
//$to .= $_SESSION['reciveremail'];

// subject
if($optionsRadios==1)
{
	$subject = 'REPORT A BUG';
}
else if($optionsRadios==2)
{
	$subject = 'SEND A COMMENT';
}
else if($optionsRadios==3)
{
	$subject = 'ASK A QUESTION';
}
else
{
	$subject = '';
}

// message
$message = '
<html>
<head>
  <title>Trackloop Feedback</title>
</head>
<body>
  <table>
    <tr>
      <td>Title</td><td>'.$subject.'</td>
    </tr>
    <tr>
      <td>Description</td><td>'.$description.'</td>
    </tr>
	<tr>
      <td>Sender Name</td><td>'.$sendername.'</td>
    </tr>
	<tr>
      <td>Sender Email</td><td>'.$senderemail.'</td>
    </tr>

  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: '.$senderemail.'' . "\r\n";
//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";*/

// Mail it
mail($to, $subject, $message, $headers);
?>