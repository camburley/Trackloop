<?php

// Authorization
Application::allow('artist, member', SECTION_PERMISSIONS);

$artistuniqueid = $_SESSION['artistuniqueid'];

/**
 * Users with the "member" role don't get their artist's name loaded to the session at login
 * Here we check if the current role is "member" then we issue a call to get and set the proper artist name
*/
if ('member' == $_SESSION['role']) {
	$artist = $apicaller->sendRequest(array(
		'controller' =>	'User',
		'action'	 =>	'readartist',
		'uniqueid' 	 =>	$artistuniqueid
	));
	
	$_SESSION['firstname'] = ucfirst($artist[0]->firstname);
	$_SESSION['lastname']  = ucfirst($artist[0]->lastname);
}

// POST request? Try to save the submitted user permissions
if (!empty($_POST)) {
	extract($_POST);
	$sections = $_GET['selectedsections'];
	$username = trim($username);
	$password = trim($password);
	
	// data validation
	if ($username == "") {
		echo "User Name cannot be empty.";
		exit;
	}
	if ($password == "") {
		echo "Password cannot be empty.";
		exit;
	}
	if (strlen($password) < 8) {
		echo "Password should be 8 digits.";
		exit;
	}
	
	$response = $apicaller->sendRequest(array(
		'controller'	 =>	'Permission',
		'action'		 =>	'memberpermission',
		'artistuniqueid' =>	$artistuniqueid,
		'username'		 =>	$username,
		'password'		 =>	$password,
		'sections'		 =>	$sections,
	));
	
	// Ajax response
	echo $response->message; exit;
}

$view->assign('artistuniqueid', $artistuniqueid);

Application::render('permissions', 'baseLayout');