<?php

/**
 * Helper function to visually debug the data held in a variable
 *
 * @param mixed   $data The data to debug
 * @param boolean $dump  Whether to also debug data types or not
 *
 */
function _debug($data, $type = false) {
	//echo mysql_error();
	echo '<pre>';
	
	if ($type) {
		var_dump($data);
	} else {
		print_r($data);
	}
	
	echo '</pre>';
}

/**
 * Heloper function to get a shortened url using the Tinyurl service.
 * 
 * @param string $url The URL to shorten
 * @return string Shortened URL
*/
function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}

/**
 * This function return random string of given input length.
 * @param $len - optional, and default value is 5.
 */
function getUniqueKey($len = 3){
	$base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
	$max = strlen($base)-1;
	$uniqueKey = '';
	while (strlen($uniqueKey)<$len+1) {
		$uniqueKey.=$base{mt_rand(0,$max)};
	}
	
	$uniqueKey = date("YmdHisu") . $uniqueKey;
	
	return $uniqueKey;
}

/**
 * This function remove the special characters from uploaded file name
 * @param $fileName - Holds the file name
 * @return $fileName - It return the file name after removing special character
 */
function encodeSpecialCharacter($fileName) {
	//Removes the HTML special character code from file name like '&#39;', '&#34;', '&#58;', etc.,
	$fileName = preg_replace("/&#?[a-z0-9]{2,8};/i","",$fileName);
	
	//This function removes the special character from file name like '@',''', '$', '#', etc.,
	$fileName = preg_replace("/[^a-zA-Z0-9_. ]/", "-", $fileName);
	
	//Return the file name
	return $fileName;
}

/**
 * This function send mail to user with password
 * @param $userDetail holds - user detail
 * @param $to holds to address
 * @param $subject - holds subject
 * @param $message - holds message
 */
function sendMail($to, $subject, $message, $from = 'feedback@trackloop.com') {
	if(!empty($to)) {
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers  .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers  .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
		$headers  .= 'From: ' . $from . '' . "\r\n";
		
		// Mail it
		mail($to, $subject, $message, $headers);
	}
}

/**
 * This function sends the welcome mail to the user
 * @param $username - holds username
 * @param $firstname - holds firstname
 * return send the email
 */
function sendWelcomeMail($username, $firstname) {
	$subject = "Your account has been successfully created";
	$message = '
	<table cellpadding="0" cellspacing="0" style="margin-top: 10px;margin-left: 20px;margin-right: 20px;" width="100%">
		<tr>
			<td style="color: #FFFFFF;">
				<p><b>Hi ' . $firstname . ', </b></p>
			</td>
		</tr>
		<tr>
			<td style="color: #FFFFFF;padding-left: 20px;padding-right: 27px;">				
				<p>Thanks for signing up with Trackloop.</p>
				<p>Sign in to get started with a album release.</p>
				<p>We\'re here to help you every step of the way. Contact us anytime at questions@trackloop.fm</p>
				<p style="margin-top: 40px;">Keep loopin\',</p>
				<p>The Track Team</p>
				<p>---</p>
				<p>Questions? Comments? Concerns? Send them to questions@trackloop.fm or utilize our live chat feature.</p>
			</td>
		</tr>
	</table>
	';
	$message = getMailBody($message);
	sendMail($username, $subject, $message);
}

/**
 * This function get the body of the email to the user
 * @param $message- holds the message HTML
 * @return $html return the HTML
 */
function getMailBody($message) {
	$html = '
<html>
<body>
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #F1F1F1;" bgcolor="#F1F1F1">
  <tr>
	<td style="margin: 10px 10px 10px 10px;">
		<table cellpadding="0" cellspacing="0" width="600px"  align="center" bgcolor="#2F3339" style="background-color: #2F3339">
			<tr> 
				<td height="60px" bgcolor="#222222" style="background-color: #222222; height: 60px;">
					<table cellpadding="0" cellspacing="0" width="600px">
						<tr>
							<td width="60px" style="background-color: #3498DB; width: 60px;" align="center" valign="middle">
								<img alt="Trackloop" src="http://trackloop.fm/dev/public/img/logo.png"> 
							</td>
							<td width="540px" style="width: 540px;" align="center">
								<h1 style="color: #FFFFFF;">TRACKLOOP</h1>
							</td>
						</tr>
					</table>
				</td>
			</tr>
	
			<tr> 
				<td width="300px">
					##body##
				</td>
			</tr>
	
			<tr>
				<td style="background-color: #2D3137;" align="center">
					<h4 style="color: #222222; font-family: Myriad Pro; font-size: 25px; margin: 10px 0;">Powered by Trackloop</h4>
					<p style="color: #878787; font-family: Myriad Pro; font-size: 15px; margin: 0 0 10px;">Get your music out there. </p>
				</td>
			</tr>
		</table>
	</td>
  </tr>
</table>
</body>
</html>
';
$html = str_replace('##body##', $message, $html);
return $html;
}

/**
 * This function sends the welcome mail to the user
 * @param $username - holds user name
 * @param $password - holds the password of user
 * @param $firstname - holds first name of user
 * return send the email
 */
function forgotPasswordMail($username, $password, $firstname) {
	$subject = "Your trackloop account password";
	$message = '
	<table cellpadding="0" cellspacing="0" style="margin-left: 20px;">
		<tr>
			<td style="color: #FFFFFF;">
				<p><b>Hi ' . $firstname . ', </b></p>
			</td>
		</tr>
		<tr>
			<td style="color: #FFFFFF;padding-left: 20px;padding-right: 27px;">
				<p>Your account user name is: ' . $username . '</p>
				<p>Your account password is: ' . $password . '</p>
				<p>To login your account, click on the button below: </p>
				<a href="http://beta.trackloop.fm/login-user" style="background-color: #3498DB; border: 0 none; font-size: 18px; margin: 0 232px 15px 16px; padding: 0 15px 21px 16px;color: #FFFFFF;display: block;text-decoration:none"><br/>
		        		Log In		        		
	    			</a>
				<p>
					Or copy and paste the URL into your browser: </p>
					<a target="_blank" style="border:none;color:#3498DB;padding: 0 0 21px 16px;text-decoration:none" href="http://beta.trackloop.fm/login-user">
					http://beta.trackloop.fm/login-user</a>
				<p style="margin-top: 40px;">Keep loopin\',</p>
				<p>The Track Team</p>
			</td>
		</tr>
	</table>
	';
	
	$message = getMailBody($message);
	sendMail($username, $subject, $message);
}

/**
 * This function detect mobile browser & desktop browser
 * If URL open in mobile it return true, otherwise false
 */
function detectMobile()
{
    if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
        return true;
    else
        return false;
}