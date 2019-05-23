<?php
// already logged-in?
if (!empty($_SESSION['role'])) {
	Application::redirect('/artist/releases');
}

$key = Registry::get('config')->read('security.salt');

if(isset($_REQUEST['email'])) {	
	if (!empty($_REQUEST['email'])) {
		// login user
		$response = $apicaller->sendRequest(array(
			'controller' =>	'User',
			'action'     =>	'verifyFacebookUser',
			'facebookid' => $_REQUEST['email']
		));		

		// login failed?
		if (!empty($response->message)) {			
			sessionInvalidate();
			Application::redirect('/?error=true');
		} else {
			// is artist?
			if (!empty($response[0]->uniqueid)) {
				$_SESSION['role'] = 'artist';
				$_SESSION['artistuniqueid']	= $response[0]->uniqueid;
				
				$req = array(
					'controller' =>	'User',
					'action'     => 'readartist',
					'uniqueid' 	 =>	$response[0]->uniqueid
				);
				$artist = $apicaller->sendRequest($req);
				
				$_SESSION['firstname'] 	= $artist[0]->firstname;
				$_SESSION['lastname'] 	= $artist[0]->lastname;
				$_SESSION['twitterid'] 	= $artist[0]->twitterid;
				$_SESSION['facebookid'] = $artist[0]->facebookid;
				$username 				= $artist[0]->username;
				$password 				= $artist[0]->password;
				
			}
			
			Application::redirect('/artist/releases');
		} 	
		
		$iv = md5(md5($key));
		$enpassword	= base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $password, MCRYPT_MODE_CBC, $iv));
		$expire		= time()+60*60*24*7;
		setcookie('cusername',$username,$expire);
		setcookie('cpassword',$enpassword,$expire);
	} else {
		sessionInvalidate();
		Application::redirect('/?error=true');
	}	
} else {
	sessionInvalidate();
	Application::redirect('/?error=true');
}

function sessionInvalidate() {
	$_SESSION = array();
	session_destroy();
}
?>