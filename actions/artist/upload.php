<?php

$albumuniqueid = Application::param('id');
$artistuniqueid	=	$_SESSION['artistuniqueid'];

if(!$_SESSION['filehandlealbumid']) {
	$_SESSION['filehandlealbumid']	=	session_id();
}

// Authorization
if (empty($albumuniqueid)) {
	// set authorization for uploading new releases
	Application::allow('artist, member', SECTION_UPLOAD);
} else {
	// set authorization for editing releases
	Application::allow('artist, member', SECTION_EDIT);
}

if (!empty($_POST)) {
	if ('saveAlbum' == $_POST['operation']) {
		$albumdate	=	date('Y-m-d h:i:s');
		$ipaddress		=	$_SERVER['REMOTE_ADDR'];
		extract($_POST);
		$covername	=	$_SESSION['coverimage'];
		$trackfiles	=	$_SESSION['trackfiles'];
		$albumsessionid	=	$_SESSION['filehandlealbumid']; //session_id();
		$artistuniqueid	=	$_SESSION['artistuniqueid'];
		if (empty($releasename)) {
			echo "Release name cannot be empty.";
			exit;
		}

		if (empty($description)) {
			echo "Description cannot be empty.";
			exit;
		}

		if (empty($tagsinput)) {
			echo "Genres cannot be empty.";
			exit;
		}


		// update an existing release?
		if ($albumid) {
			// delete old tracks
			/*$tracksdel = $apicaller->sendRequest(array(
				'controller' 	=>	'Track',
				'action'		=>	'deletetrack',
				'albumuniqueid'	=>	$albumid
			));*/
			
			$albums = $apicaller->sendRequest(array(
				'controller' 	=>	'Album',
				'action'		=>	'updatealbum',
				'albumname' 	=>	$releasename,
				'coverimage'	=>	$covername,
				'description'	=>	$description,
				'tagsinput'		=>	$tagsinput,
				'albumuniqueid'	=>	$albumid
			));
			
			$tfs = array();
			for ($i = 0; $i < sizeof($trackfiles); $i++) {
				$tfs[] = $trackfiles[$i][0];
				$filename = 'uploads/albums/' . $artistuniqueid . '/' . $albumid . '/' . $trackfiles[$i][0];
				if(file_exists($filename)) {
					$tracks = $apicaller->sendRequest(array(
						'controller' 	=>	'Track',
						'action'		=>	'updatetrack',
						'trackname' 	=>	$trackfiles[$i][0],
						'titlesong'		=>	$i+1,
						'trackfile'		=>	$trackfiles[$i][0],
						'trackdate'		=>	$albumdate,
						'tracklength'	=>	$trackfiles[$i][1],
						'albumuniqueid'	=>	$albumid
					));
				}
			}
			$albumuniqueid	=	$albumid;
		} else {
			// adding a new release
			$albums = $apicaller->sendRequest(	array(
				'controller' 	 =>	'Album',
				'action'		 =>	'createalbum',
				'albumname' 	 =>	$releasename,
				'coverimage'	 =>	$covername,
				'artistuniqueid' =>	$artistuniqueid,
				'albumdate'		 =>	$albumdate,
				'description'	 =>	$description,
				'tagsinput'		 =>	$tagsinput
			));
			
			$albumuniqueid = $albums->uniqueid;
			$uploadAlbumPath = "uploads/albums/$artistuniqueid/$albumuniqueid";
			if(!is_dir($uploadAlbumPath)) {
				$albumSessionIdPath = TL_PATH . 'uploads'. DS . 'albums'. DS .$artistuniqueid . DS .$albumsessionid;
				$albumuniqueIdPath = TL_PATH . 'uploads'. DS . 'albums'. DS  .$artistuniqueid.DS.$albumuniqueid;
				
				rename($albumSessionIdPath, $albumuniqueIdPath);
			}
			$tfs	=	array();
			for($i=0; $i<sizeof($trackfiles); $i++) {
				$tfs[]	=	$trackfiles[$i][0];
				$filenameesixt	=	TL_PATH . "uploads" . DS . "albums". DS .$artistuniqueid. DS .$albumuniqueid. DS .$trackfiles[$i][0];
				if(file_exists($filenameesixt)) {
					$tracks = $apicaller->sendRequest(array(
						'controller' 	=>	'Track',
						'action'		=>	'createtrack',
						'trackname' 	=>	$trackfiles[$i][0],
						'titlesong'		=>	$i+1,
						'trackfile'		=>	$trackfiles[$i][0],
						'trackdate'		=>	$albumdate,
						'tracklength'	=>	$trackfiles[$i][1],
						'albumuniqueid'	=>	$albumuniqueid,
					));
				}
			}
			//echo "Added New";
		}

		unset($_SESSION['filehandlealbumid']);
		unset($_SESSION['trackfiles']);
		unset($_SESSION['covename']);
		exit;
	} if ('deleteTrack' == $_POST['operation']) {
		// delete selected track
		$tracksdel = $apicaller->sendRequest(array(
			'controller' 	=>	'Track',
			'action'		=>	'deletetrackByUniqueId',
			'uniqueid'	=>	$_POST['track']
		));	
		
		
		if (!empty($tracksdel)) {
			//Logic to unloink track
			$trackFile	= TL_PATH . 'uploads' . DS . 'albums' . DS . $_POST['artistuniqueid'] . DS . $_POST['albumuniqueid'];
			$trackFile	= $trackFile . DS . $tracksdel[0]->trackfile;
			
			if(file_exists($trackFile)) {
				unlink($trackFile);
			}
		}	
		exit;
	} else if ('editTrackName' == $_POST['operation']) {
		//Call encode special character function for remove special characters
		$_POST['newTrackName'] = encodeSpecialCharacter($_POST['newTrackName']);
		
		$getTrackDetail = $apicaller->sendRequest(array(
					'controller' 		=>	'Track',
					'action'			=>	'getTrackDetailByTrackId',
					'uniqueId'			=>	$_POST['trackUniqueId'],
		));	
		
		if($_POST['newTrackName'] != $getTrackDetail->trackname || $_POST['newSequenceId'] != $getTrackDetail->sequence) {
			//Edit track name
			$trackDetail = $apicaller->sendRequest(array(
						'controller' 		=>	'Track',
						'action'			=>	'updateTrackName',
						'uniqueId'			=>	$_POST['trackUniqueId'],
						'artistUniqueId'	=>	$_POST['artistUniqueId'],
						'albumUniqueId'		=>	$_POST['albumUniqueId'],
						'trackfile' 		=>	$_POST['newTrackName'],
						'newSequenceId' 	=>	$_POST['newSequenceId'],
						'oldSequenceId' 	=>	$_POST['oldSequenceId']
			));	
			
			if (!empty($trackDetail)) {
				//Logic to rename track
				$trackFile	= TL_PATH . 'uploads' . DS . 'albums' . DS . $_POST['artistUniqueId'] . DS . $_POST['albumUniqueId'];
				
				if(file_exists($trackFile . DS . $_POST['oldTrackName'])) {
					if(!is_writable($trackFile . DS . $_POST['oldTrackName'])) {
						chmod(TL_PATH . 'uploads' . DS . 'albums' . DS . $_POST['artistUniqueId'], 0777);
						chmod(TL_PATH . 'uploads' . DS . 'albums' . DS . $_POST['artistUniqueId'] . DS . $_POST['albumUniqueId'], 0777);
						chmod($trackFile . DS . $_POST['oldTrackName'], 0777);
					}
					rename($trackFile . DS . $_POST['oldTrackName'], $trackFile . DS . $trackDetail[0]->trackfile);
				}
			}
		}
		exit;
	} else {
		require TL_INCLUDE_PATH . 'libs/UploadHandler.php';
		$upload_handler = new UploadHandler();
		exit;
	}
}

$coverimage = 'public/img/album-cover.png';

if (!empty($albumuniqueid)) {
	// load album information
	$response = $apicaller->sendRequest(array(
		'controller' 	=>	'Track',
		'action'		=>	'readartistalbum',
		'albumuniqueid' =>	$albumuniqueid,
		'artistuniqueid'=>	$artistuniqueid
	));
	
	if (!empty($response->message)) {
		//Application::setFlash($response->message);
		Application::redirect('/artist/releases');
	}
	
	// preload form with album information
	$view->assign('album', $response[0]);
	
	$tracks = $apicaller->sendRequest(array(
		'controller' 	=>	'Track',
		'action'		=>	'readtrackBySequence',
		'uniqueid' 		=>	$albumuniqueid,
		'artistuniqueid'=>	$artistuniqueid
	));
	
	$trackList = array();
	foreach($tracks as $track) {
		$trackfiles_db[]	= $track->trackfile;
		
		//make records
		$record = array();
		$record['trackfile'] = $track->trackfile;
		$record['tracklength'] = $track->tracklength;
		$record['uniqueid'] = $track->uniqueid;
		$record['sequence'] = $track->sequence;
		
		$trackList[] = $record;
	}
	
	/**
	 * album upload folder contains other files than the ones already saved in the database?
	 * try to identify and delete those extra files
	*/
	$directory			= 'uploads' . DS . 'albums' . DS . $artistuniqueid . DS . $albumuniqueid;
	$scanned_directory	= @array_diff(scandir($directory), array('..', '.',''));
	$extra_files		= @array_diff($scanned_directory,$trackfiles_db);
	if(!empty($extra_files)) {
		foreach ($extra_files as $extra_file) {
			$extra_file_path = $directory . '/' . $extra_file;
			if(is_dir($extra_file_path)) {
				continue;
			}
			@unlink($extra_file_path);
		}
	}
	
	//add tracks in smarty request
	
	$view->assign('trackList', $trackList);
	$view->assign('artistuniqueid', $artistuniqueid);
	$view->assign('albumuniqueid', $albumuniqueid);
	
	$_SESSION['filehandlealbumid']	= $albumuniqueid;
	$_SESSION['coverimage']	= $response[0]->coverimage;
	$albumCoverImage = 'uploads/albums/'. $artistuniqueid . '/' . $albumuniqueid . '/coverimage/thumbnail/90x83' . $response[0]->coverimage;
	if(file_exists($albumCoverImage)) {
		$coverimage = $albumCoverImage;
	}
}

$view->assign('albumuniqueid', $albumuniqueid);
$view->assign('coverimage', $coverimage);

Application::render('upload', 'default');