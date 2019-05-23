<?php
@session_start();
$source_dir = '../uploads/albumbs/'.$_SESSION['artistid'].'/'.$_SESSION['albumid'];
$zip_file = '../uploads/albumbs/'.$_SESSION['artistid'].'/archive.zip';
$file_list = Utils::listDirectory($source_dir);
 
$zip = new ZipArchive();
if ($zip->open($zip_file, ZIPARCHIVE::CREATE) === true) {
  foreach ($file_list as $file) {
    if ($file !== $zip_file) {
      $zip->addFile($file, substr($file, strlen($source_dir)));
    }
  }
  $zip->close();
}
?>