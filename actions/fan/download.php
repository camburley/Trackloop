<?php

$albumuniqueid  = Application::param('album');
$artistuniqueid	= Application::param('artist');

$trackdir = 'uploads/albums/' . $artistuniqueid . '/' . $albumuniqueid . '/';
$zip_file_name = 'uploads/' . $_SESSION['zipalbumname'].'.zip';
$downloaddate = date('Y/m/d h:i:s');

// add album tracks to zip file
$zip = new ZipArchive;
$res = $zip->open($zip_file_name, ZipArchive::CREATE);
if(true === $res) {
	if(file_exists($trackdir)){
		$dir = opendir($trackdir);
		while (false !== ($file = readdir($dir))) {
			$filepath = $trackdir . $file;
			if (!is_dir($filepath)) {
				$zip->addFile($filepath, basename($filepath));
			}
		}
	}
    $zip->close();
}

// send zip archive for download
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=" . basename($zip_file_name) . ";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($zip_file_name));
readfile($zip_file_name);

// track the download in album stats
$downloads = $apicaller->sendRequest(array(
	'controller' 	=>	'Download',
	'action'		=>	'createdownload',						
	'downloaddate' 	=>	$downloaddate,
	'albumuniqueid' =>	$albumuniqueid,
	'twitterid'		=>	$_SESSION['access_token']['screen_name'],
	'location'		=>	$_SESSION['user_location']
));

// delete zip archive after download
unlink($zip_file_name);