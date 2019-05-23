<?php
@session_start();
require_once("../config.php");
require_once($path.'/apicaller.php');
$apicaller	=	new ApiCaller();
$path	=	"../uploads/albums/".$_SESSION['artistid']."/".$_SESSION['albumid']."/";
$the_folder		=	$path;
$zip_file_name	=	$_SESSION['zipalbumname'].'.zip';
$downloaddate	=	date('Y/m/d h:i:s');

$download_file= true;
$delete_file_after_download= true;


class FlxZipArchive extends ZipArchive {
    /** Add a Dir with Files and Subdirs to the archive;;;;; @param string $location Real Location;;;;  @param string $name Name in Archive;;; @author Nicolas Heimann;;;; @access private  **/

    public function addDir($location, $name) {
        $this->addEmptyDir($name);

        $this->addDirDo($location, $name);
     } // EO addDir;

    /**  Add Files & Dirs to archive;;;; @param string $location Real Location;  @param string $name Name in Archive;;;;;; @author Nicolas Heimann
     * @access private   **/
    private function addDirDo($location, $name) {
        $name .= '/';
        $location .= '/';

        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;
            // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } // EO addDirDo();
}

$za = new FlxZipArchive;
$res = $za->open($zip_file_name, ZipArchive::CREATE);
if($res === TRUE) 
{
    $za->addDir($the_folder, basename($the_folder));
    $za->close();
}
else  { echo 'Could not create a zip archive';}

if ($download_file)
{
    ob_get_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=" . basename($zip_file_name) . ";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($zip_file_name));
    readfile($zip_file_name);
	$req		=	array(
							'controller' 	=>	'Download',
							'action'		=>	'createdownload',						
							'downloaddate' 	=>	$downloaddate,
							'albumuniqueid' =>	$_SESSION['albumid'],
							'twitterid'		=>	$_SESSION['access_token']['screen_name'],
							'location'		=>	$_SESSION['location']
						);
	$downloads = $apicaller->sendRequest($req);
    //deletes file when its done...
    if ($delete_file_after_download) 
    {   unlink($zip_file_name); }
}
?>