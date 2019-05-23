<?php
/**
 * This class play the audio file,
 * Get the file information using getID3 class,
 * Read file content,
 * Get newly file splitted length,
 * Create .mp3 & .ogg file & write content of specified length
 */
class AudioHandler {

	//Declare constant for .mp3 file mime type  
	const AUDIO_MP3_FILE_TYPE = 'audio/mpeg';

	//Declare constant for .ogg file mime type  
	const AUDIO_OGG_FILE_TYPE = 'application/ogg';
	
	//Declare $audioLength variable for get audio file length
	private $audioLength = 0;
	
	//Declare $audioContent variable for get file content
	private $audioContent = '';
	
	//Declare $splitContent variable for get splitted content in a file
	private $splitContent = '';
	
	//Declare $fileExist variable for for checking file is exist or not
	private $fileExist = false;
	
	/**
	 * This constructor call the getId3Info & readFileContent functions
	 * Also it include the getid3.php file
	 * @param $filename - It holds the audio file name
	 */
	function __construct($filename) {
		//Check file is exist or not
		if(file_exists($filename)) {
			//Include getid3.php file for perform operations. 
			require_once('getID3/getID3/getid3/getid3.php');
			
			//Get id3 info i.e get file information
			$id3Info = $this->getId3Info($filename);
	
			//Get audio file length
			$this->audioLength = $id3Info['playtime_seconds'];
			
			//Get file content
			$this->audioContent = $this->readFileContent($filename); 
			
			$this->fileExist = true;
		}
	}
	
	/**
	 * This function get file information
	 * @param $filename - It holds the audio file name
	 * @return $id3Info - It return the file information
	 */
	private function getId3Info($filename) {
		//Create object of getID3 class
		$getID3 = new getID3();
		
		//Get audio file property
		$id3Info = $getID3->analyze($filename);
		
		//It return file infomation
		return $id3Info;
	}
	
	/**
	 * This function read the file content
	 * @param $filename - It holds the audio file name
	 * @return $content - It return the file content
	 */
	private function readFileContent($filename) {
		//This function open the file in readable format
		$handle = fopen($filename, 'r');  
		
		//This function read the file  content
		$content = fread($handle, filesize($filename)); 
		
		//It return file content after read
		return  $content;
	}
	
	/**
	 * This function read the file content
	 * @param $filePlayLength - It holds the audio file split length
	 * @return $fileSplitLength - It return the new audio file split length
	 */
	private function getFilePlayLength($filePlayLength) {
		//This function count the audio file content length
		$length = strlen($this->audioContent);
		
		//Roun up the audio file length
		$length = round($length / $this->audioLength); 
		
		//Assign new splitted length
		$fileSplitLength =  $length * $filePlayLength;
		
		$fileSplitLength = round($fileSplitLength);
		
		//It return the new splitted length
		return $fileSplitLength;
	}
	
	/**
	 * This function play the file depending on mime type
	 * @param $mimeType - It holds the mime type e.g. audio/mpeg
	 * @param $filePlayLength - It holds the file play length
	 */
	private function playFile($mimeType, $filePlayLength) {
		//Get file split length
		$length = $this->getFilePlayLength($filePlayLength);
		
		//Get content of specified length
		$content = substr($this->audioContent, 0 , $length);  
  		
  		//This function send raw mime type header
		header("Content-Type: {$mimeType}");  

		//This function send raw length header
		header("Content-Length: {$length}"); 
		
		//Print the content 
		print $content; 
	}
	
	/**
	 * This function plat the audio file
	 * @param $format - - It holds the mime type e.g. audio/mpeg
	 * @param  $fileSplitLength - It holds the file play length
	 */
	public function getAudio($format = AudioHandler::AUDIO_MP3_FILE_TYPE, $fileSplitLength = -1) {
		//If fileSplitLength is -1 then assign total file content length
		if($fileSplitLength == -1) {
			//Assign audio file length
			$fileSplitLength = $this->audioLength;
		}

		//Play the audio file
		$this->playFile($format, $fileSplitLength);
	}
	
	/**
	 * This function split audio file in seconds
	 * @param $fileName - It holds the audio file name
	 * $param $splitFileLength - It holds the file splitted length
	 */
	public function splitAudioFile($fileName, $splitFileLength) {
		if($this->fileExist) {
			//Returns information about a file path
			$pathParts = pathinfo($fileName);
			
			//Get the file content depending on splitted length
			$this->splitContent = $this->getFileSplitContent($splitFileLength);
			
			//------------- Write content in .ogg file --------------------------------//
			//Assign ogg file name to $oggFile variable
			$oggFile = $pathParts['dirname'] . DS . $pathParts['filename'] . 'ogg.ogg';
			//Checks whether a file or directory exists
			if(!file_exists($oggFile))
				//Write content in ogg file
				$this->writeAudioFile($oggFile);
			
			//------------- Write content in .mp3 file --------------------------------//
			//Assign mp3 file name to $mp3File variable
			$mp3File = $pathParts['dirname'] . DS . $pathParts['filename'] . 'mp3.mp3';
			//Checks whether a file or directory exists
			if(!file_exists($mp3File)) 
				//Write content in mp3 file
				$this->writeAudioFile($mp3File);
		}
	}
	
	/**
	 * This function write content in a file
	 * @param $filePath - It holds the file path which is to be write
	 */
	private function writeAudioFile($filePath) {
		//Create a file & open in write mode
		$fileHandler = fopen($filePath, 'w');
		
		//Write file content in newly created file
		fwrite($fileHandler, $this->splitContent);
		
		//Close the file
		fclose($fileHandler);
	}
	
	/**
	 * This function play the file depending on mime type
	 * @param $filePlayLength - It holds the file play length
	 * @return - It return the content of specified lengtht
	 */
	private function getFileSplitContent($filePlayLength) {
		//Get file split length
		$length = $this->getFilePlayLength($filePlayLength);
		
		//Get content of specified length
		 return substr($this->audioContent, 0 , $length);  
	}
}
?>