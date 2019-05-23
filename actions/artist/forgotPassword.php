<?php

require_once(TL_PATH . 'config784512.php');

// already logged-in?
if (!empty($_SESSION['role'])) {
	Application::redirect('/artist/releases');
}

if (!empty($_POST)) {
	$username = $_POST['username'];

	// forgot password
	$response = $apicaller->sendRequest(array(
		'controller' =>	'User',
		'action'     =>	'forgotPassword',
		'username'   =>	$username,
	));
	
	// forgot password failed?
	if (!empty($response->message)) {
		$view->assign('error', $response->message);
		$view->assign('forgotPasswordPath', $forgotPasswordPath);
	} else {
		// is member?
		if(!empty($response[0]->pkmemberid)) {
			$role = 'member';
			$username	= $response[0]->username;
			$password = $response[0]->password;
			$firstname = $response[0]->firstname;
		} elseif (!empty($response[0]->uniqueid)) {
			// is artist?
			$role = 'artist';
			$username	= $response[0]->username;
			$password = $response[0]->password;
			$firstname = $response[0]->firstname;
		}
		//Assign login path
		$view->assign('loginPath', $loginPath);
		
		// This funciton send the password to user
		forgotPasswordMail($username, $password, $firstname);
	}
	Application::render('forgotPasswordStaus', 'loginLayout');
}

Application::render('forgotPassword', 'loginLayout');