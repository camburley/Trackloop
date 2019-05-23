<?php

// Authorization
//Remove following line because, If user access this page by login, 
//Then user will get same page with data and if user try to access this page without login then page
//will show without data and menu. 
//Application::allow('artist, member', SECTION_ACCOUNT);

$artistuniqueid	= $_SESSION['artistuniqueid'];

/**
 * POST request? Handle submitted data
 * and decide whether the required action is to save or update the user
*/
if (!empty($_POST)) {
	extract($_POST);
	
	if (!empty($artistuniqueid)) {
		// update an existing user
		$user = $apicaller->sendRequest(array(
			'controller'	 => 'User',
			'action'		 => 'updateartist',
			'artistuniqueid' => $artistuniqueid,
			'password'		 => $password,
			'firstname'		 => $firstname,
			'lastname'		 => $lastname,
			'mobile'		 => $mobile,
			'twitterid'		 => $twitterid,
			'facebookid'	 => $facebookid,
			'location'		 => $location,
			'ipaddress'		 => $ipaddress
		));
		$action = 'update';
		
		$albumDirectory = "uploads/albums/" . $artistuniqueid;
		if(!file_exists($albumDirectory)) {
			mkdir($albumDirectory);
		}
	}
	
	// create a new user
	else {
		$user = $apicaller->sendRequest(array(
			'controller' => 'User',
			'action'	 => 'createartist',
			'username'	 => $username,
			'password'	 => $password,
			'firstname'	 => $firstname,
			'lastname'	 => $lastname,
			'mobile'	 => $mobile,
			'twitterid'	 => $twitterid,
			'facebookid' => $facebookid,
			'location'	 => $location,
			'ipaddress'	 => $ipaddress,
			'signupdate' => $signupdate
		));
		$action = 'signup';
		
		// auto-login the newly created user
		$new_artistuniqueid			= $user->uniqueid;
		$_SESSION['role']			= 'artist';
		$_SESSION['artistuniqueid']	= $new_artistuniqueid;
		$_SESSION['firstname']		= $firstname;
		$_SESSION['lastname']		= $lastname;
		
		// create artist upload directory
		$albumDirectory = "uploads/albums/" . $new_artistuniqueid;
		if(!file_exists($albumDirectory)) {
			mkdir($albumDirectory);
		}
		
		// This funciton send the welcome mail when user is created
		sendWelcomeMail($username, $firstname);
	}
	
	// send Ajax response
	if (!empty($user->message)) {
		echo $loginusers->message;
	} else {
		echo $action;
	}
	exit;
}

if (!empty($artistuniqueid)) {
	$artist = $apicaller->sendRequest(array(
		'controller' 	=>	'User',
		'action'		=>	'readartist',
		'uniqueid' 		=>	$artistuniqueid
	));
	$view->assign('artist', $artist[0]);
}

Application::render('account', 'baseLayout');