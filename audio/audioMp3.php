<?php

//Include config147852369741.php file for get uploaded file path 	
require_once('config147852369741.php');

require_once('AudioHandler.php');

if(isset($_REQUEST['id'])) {
	if(isset($_SESSION['audioFileSession'][$_REQUEST['id']])) {
		$path = $uploadPath . DS . $_SESSION['audioFileSession'][$_REQUEST['id']];
		
		//Create object of AudioHandler class	
		$audioHandler = new AudioHandler($path);

		//Call getAudio function to play the file 
		$audioHandler->getAudio(AudioHandler::AUDIO_MP3_FILE_TYPE, $fileSplitLength);
	}	
} else {
	echo "ERROR";
}
?>