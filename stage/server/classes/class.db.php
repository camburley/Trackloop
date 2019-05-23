<?php
set_time_limit(0);
class DB
{	
	private	$db		=	"asaamico_gumption_cam_trackloop";
	private	$user		=	"gumption";
	private	$pass		=	"gumption";
	private	$dbhost		=	"localhost";
	/***************************/
	private $dbport		=	"3306";
	public $queryresult	=	"";
	public $logid		=	"";
	public $link		=	"";
	public	$baseurl	=	"";
	
	/*********************************/
	function __construct()
	{
		//echo $_SERVER['HTTP_HOST'];
		if($_SERVER['HTTP_HOST'] == 'localhost')
		{
			$this->db	=	"gumption_cam_trackloop";
			$this->user	=	"root";
			$this->pass	=	"";
			$this->dbhost	=	"localhost";
			$this->dbport	=	"3306";
			$this->baseurl	=	"";
		}
	}
	
	function grab_dump($var)
	{
		ob_start();
		print_r($var);
		return ob_get_clean();
	}
	public function validateterminal($name)
	{
		$terminalquery	=	"SELECT pkterminalid FROM `tblterminal` WHERE status = 1 AND name = '$name' ";
		$this->query($terminalquery);
		$result		=	$this->queryresult;
		if(mysqli_num_rows($result))
		{
			$terminalobj		=	mysqli_fetch_object($result);
			return($terminalobj->pkterminalid);
		}
		else
		{
			return(-1);
		}
	}
	public function validateservice($serviceid)
	{
		return 1;
		$servicesquery	=	"SELECT pkserviceid FROM `tblservice` WHERE status = 1 AND pkserviceid = '$serviceid' ";
		$this->query($servicesquery);
		$result			=	$this->queryresult;
		if(mysqli_num_rows($result))
		{
			$serviceobj		=	mysqli_fetch_object($result);
			return($serviceobj->pkservice);
		}
		else
		{
			return(-1);
		}
	}
	public function validateuser($userid)
	{
		return 1;
		$userquery		=	"SELECT pkuserid FROM tbluser WHERE uniqueid = '$userid'";
		$this->query($userquery);
		$result			=	$this->queryresult;
		if(mysqli_num_rows($result))
		{
			$userobj		=	mysqli_fetch_object($result);
			return($userobj->pkuserid);
		}
		else
		{
			return(-1);
		}
	}
	public function toArray()
	{
		$array	=	array();
		$rows	=	mysqli_num_rows($this->queryresult);
		if($rows > 0)
		{
			/*$array['success'] =	1;
			$array['message'] =	"Total records found = $rows";*/
			while($arr	=	mysqli_fetch_assoc($this->queryresult))
			{
				$array[]	=	$arr;
			}
		}
		else
		{
			$array['failure'] =	1;
			$array['message'] =	"Total records found = $rows";
		}
		return $array;
	}
	public function formatdate($date)
	{
		$time	=	strtotime($date);
		return(date('M d, Y', $time));
	}
	public function query($query)
	{
		$this->connect();
		$res	=	mysqli_query($this->link,$query);
		if($res)
		{
			$this->queryresult	=	$res;
			
		}
		else
		{
			die(mysqli_error($this->link)."....<br>$query");
			//return(array('failure'=>1,'message'=>mysqli_error()));
		}
	}
	public function connect()
	{
		//echo $this->dbhost.":".$this->dbport."..........".$this->user.".............".$this->pass;
		$this->link	=	mysqli_connect($this->dbhost,$this->user,$this->pass,$this->db);
		if($this->link)
		{
			
			$q	=	"Connected...";
		}
		else
		{
			echo $q	=	mysqli_error($this->link);
		}
		if(	mysqli_select_db($this->link,$this->db))
		{
			 $q	=	"DB selected";
		} 
		else
		{
			echo $q	=	mysqli_error($this->link);
		}
		
	}
	function filter($text)
	{
		$text	=	mysql_escape_string($text);
		return(htmlentities($text,ENT_QUOTES));
	}
	function filterRequest()
	{
		//array_walk_recursive($_REQUEST,$this->filter);
		foreach($_REQUEST as $key=>$val)
		{
			$ob	=	json_decode($val);
			if($ob !== null) // JSON valid then don't filter it out...
			{
				continue;
			}
			else if(is_array($val))
			{
				foreach($val as $k=>$v)
				{
					if(is_array($v))
					{
						
						foreach($v as $k1=>$v1)
						{
							//echo "$v1 ...";
							$v[$k1]	=	$v1;//$this->filter($v1);
						}
						$val[$k]	=	$v;
					}
					else
					{
						$val[$k]	=	$this->filter($v);
					}
				}
				$_REQUEST[$key]	=	$val;
				//print_r($val);
			}
			else
			{
				$_REQUEST[$key]	=	$this->filter($val);
			}
		}
	}
	public function dump($var,$exit=0)//dump the variable and exist if exit =1
	{
		print"<pre>";
		print_r($var);
		print"</pre>";
		if($exit !=0)
		{
			exit;
		}
	}//dump
	
	function generateUniqueID ($tbl,$length = 16)
	{
			
			// start with a blank password
			$password = "";
			
			// define possible characters - any character in this string can be
			// picked for use in the password, so if you want to put vowels back in
			// or add special characters such as exclamation marks, this is where
			// you should do it
			$possible = "2346789ABCDFGHJKLMNPQRTVWXYZ";
			
			// we refer to the length of $possible a few times, so let's grab it now
			$maxlength = strlen($possible);
			
			// check for length overflow and truncate if necessary
			if ($length > $maxlength) {
			  $length = $maxlength;
			}
			
			// set up a counter for how many characters are in the password so far
			$i = 0; 
			
			// add random characters to $password until $length is reached
			while ($i < $length) { 
			
			  // pick a random character from the possible ones
			  $char = substr($possible, mt_rand(0, $maxlength-1), 1);
				
			  // have we already used this character in $password?
			  if (!strstr($password, $char)) { 
				// no, so it's OK to add it onto the end of whatever we've already got...
				$password .= $char;
				// ... and increase the counter by one
				$i++;
			  }
			}
			// done!
			$query	=	"SELECT * FROM $tbl WHERE uniqueid = '$password'";
			$this->query($query);
			if(mysqli_num_rows($this->queryresult) > 0)
			{
				$this->generateUniqueID($tbl,$length);
			}
			else
			{
				return $password;		
			}	
	}
	
	function generateUniqueFileID ($length = 7)
	{
			
			// start with a blank password
			$password = "";
			
			// define possible characters - any character in this string can be
			// picked for use in the password, so if you want to put vowels back in
			// or add special characters such as exclamation marks, this is where
			// you should do it
			$possible = "2346789ABCDFGHJKLMNPQRTVWXYZ";
			
			// we refer to the length of $possible a few times, so let's grab it now
			$maxlength = strlen($possible);
			
			// check for length overflow and truncate if necessary
			if ($length > $maxlength) {
			  $length = $maxlength;
			}
			
			// set up a counter for how many characters are in the password so far
			$i = 0; 
			
			// add random characters to $password until $length is reached
			while ($i < $length) { 
			
			  // pick a random character from the possible ones
			  $char = substr($possible, mt_rand(0, $maxlength-1), 1);
				
			  // have we already used this character in $password?
			  if (!strstr($password, $char)) { 
				// no, so it's OK to add it onto the end of whatever we've already got...
				$password .= $char;
				// ... and increase the counter by one
				$i++;
			  }
			}
			// done!
			$query	=	"SELECT * FROM tblfile WHERE uniqueid = '$password'";
			$this->query($query);
			if(mysqli_num_rows($this->queryresult) > 0)
			{
				$this->generateUniqueID($length);
			}
			else
			{
				return $password;		
			}	
	}
	
	function generateUniqueTransactionID ($length = 10)
	{
			
			// start with a blank password
			$password = "";
			
			// define possible characters - any character in this string can be
			// picked for use in the password, so if you want to put vowels back in
			// or add special characters such as exclamation marks, this is where
			// you should do it
			$possible = "2346789ABCDFGHJKLMNPQRTVWXYZ";
			
			// we refer to the length of $possible a few times, so let's grab it now
			$maxlength = strlen($possible);
			
			// check for length overflow and truncate if necessary
			if ($length > $maxlength) {
			  $length = $maxlength;
			}
			
			// set up a counter for how many characters are in the password so far
			$i = 0; 
			
			// add random characters to $password until $length is reached
			while ($i < $length) { 
			
			  // pick a random character from the possible ones
			  $char = substr($possible, mt_rand(0, $maxlength-1), 1);
				
			  // have we already used this character in $password?
			  if (!strstr($password, $char)) { 
				// no, so it's OK to add it onto the end of whatever we've already got...
				$password .= $char;
				// ... and increase the counter by one
				$i++;
			  }
			}
			// done!
			$query	=	"SELECT * FROM tbltransaction WHERE uniqueid = '$password'";
			$this->query($query);
			if(mysqli_num_rows($this->queryresult) > 0)
			{
				$this->generateUniqueTransactionID($length);
			}
			else
			{
				return $password;		
			}	
	}
	
	public function getDirectory( $path = '.', $level = 0 )
	{
		$ignore = array( 'cgi-bin', '.', '..' );
		// Directories to ignore when listing output. Many hosts
		// will deny PHP access to the cgi-bin.
		$dh = @opendir( $path );
		// Open the directory to the handle $dh
		while( false !== ( $file = readdir( $dh ) ) ){
		// Loop through the directory
			if( !in_array( $file, $ignore ) ){
			// Check that this file is not to be ignored
				$spaces = str_repeat( '&nbsp;', ( $level * 4 ) );
				// Just to add spacing to the list, to better
				// show the directory tree.
				if( is_dir( "$path/$file" ) ){
				// Its a directory, so we need to keep reading down...
					echo "<strong>$spaces $file</strong><br />";
					getDirectory( "$path/$file", ($level+1) );
					// Re-call this same function but on a new directory.
					// this is what makes function recursive.
				} else {
					echo "$spaces $file<br />";
					// Just print out the filename
				}
			}
		}
		closedir( $dh );
		// Close the directory handle
	}
	
	function format_time($t,$f=':') // t = seconds, f = separator 
	{
	  return sprintf("%02d%s%02d%s%02d", floor($t/3600), $f, ($t/60)%60, $f, $t%60);
	}
	public function message($id)
	{
		$sql	=	"SELECT message FROM tblerror WHERE pkerrorid='$id'";
		$this->query($sql);
		$res1			=	$this->queryresult;
		$obj			=	mysqli_fetch_object($res1);
		$res['message']	=	$obj->message;
		return($res);
	}
function __json_encode( $data ) 
{           
    if( is_array($data) || is_object($data) ) {
        $islist = is_array($data) && ( empty($data) || array_keys($data) === range(0,count($data)-1) );
       
        if( $islist ) {
            $json = '[' . implode(',', array_map('__json_encode', $data) ) . ']';
        } else {
            $items = Array();
            foreach( $data as $key => $value ) {
                $items[] = __json_encode("$key") . ':' . __json_encode($value);
            }
            $json = '{' . implode(',', $items) . '}';
        }
    } elseif( is_string($data) ) {
        # Escape non-printable or Non-ASCII characters.
        # I also put the \\ character first, as suggested in comments on the 'addclashes' page.
        $string = '"' . addcslashes($data, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"';
        $json    = '';
        $len    = strlen($string);
        # Convert UTF-8 to Hexadecimal Codepoints.
        for( $i = 0; $i < $len; $i++ ) {
           
            $char = $string[$i];
            $c1 = ord($char);
           
            # Single byte;
            if( $c1 <128 ) {
                $json .= ($c1 > 31) ? $char : sprintf("\\u%04x", $c1);
                continue;
            }
           
            # Double byte
            $c2 = ord($string[++$i]);
            if ( ($c1 & 32) === 0 ) {
                $json .= sprintf("\\u%04x", ($c1 - 192) * 64 + $c2 - 128);
                continue;
            }
           
            # Triple
            $c3 = ord($string[++$i]);
            if( ($c1 & 16) === 0 ) {
                $json .= sprintf("\\u%04x", (($c1 - 224) <<12) + (($c2 - 128) << 6) + ($c3 - 128));
                continue;
            }
               
            # Quadruple
            $c4 = ord($string[++$i]);
            if( ($c1 & 8 ) === 0 ) {
                $u = (($c1 & 15) << 2) + (($c2>>4) & 3) - 1;
           
                $w1 = (54<<10) + ($u<<6) + (($c2 & 15) << 2) + (($c3>>4) & 3);
                $w2 = (55<<10) + (($c3 & 15)<<6) + ($c4-128);
                $json .= sprintf("\\u%04x\\u%04x", $w1, $w2);
            }
        }
    } else {
        # int, floats, bools, null
        $json = strtolower(var_export( $data, true ));
    }
    return $json;
}
	//echo getTimeDiff("23:30","01:30");


}//end of class Helper
?>
