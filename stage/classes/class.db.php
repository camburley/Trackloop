<?php
set_time_limit(0);
class DB
{
	private	$db			=	"asaamico_gumption_cam_trackloop";
	private	$user		=	"gumption";
	private	$pass		=	"gumption";
	private	$dbhost		=	"localhost";
	private $dbport		=	"3306";
	public $queryresult	=	"";
	public $baseurl		=	"";
	
	public function toArray()
	{
		//$array	=	array('success'=>1);
		
		while($arr	=	mysql_fetch_assoc($this->queryresult))
		{
			$array[]	=	$arr;
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
		$res	=	mysql_query($query) or die(mysql_error());
		/*$fp = fopen('../data.txt', 'w');
		fwrite($fp, $q);
		fclose($fp);*/
		$this->queryresult	=	$res;
		$this->newid	=	mysql_insert_id();
		if(@mysql_num_rows($this->queryresult))
		{
			return ($this->toArray());
		}
		else
		{
			return (array('success'=>1));
		}
	}
	private function connect()
	{
		if(mysql_connect($this->dbhost,$this->user,$this->pass))
		{
			$q	=	"Connected...";
		}
		else
		{
			echo $q	=	mysql_error();
		}
		if(	mysql_select_db($this->db))
		{
			$q	=	"DB selected";
		} 
		else
		{
			$q	=	mysql_error();
		}
	}
	function filter($input)
	{
	 if (get_magic_quotes_gpc()==1) 
	 {
	  return(htmlentities(trim($input),ENT_QUOTES));
	 }
	 else
	 {
	  return(htmlentities(addslashes(trim($input)),ENT_QUOTES));
	 }
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
		
		foreach($_POST as $key=>$val)
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
				$_POST[$key]	=	$val;
				//print_r($val);
			}
			else
			{
				$_POST[$key]	=	$this->filter($val);
			}
		}
		
		foreach($_GET as $key=>$val)
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
				$_GET[$key]	=	$val;
				//print_r($val);
			}
			else
			{
				$_GET[$key]	=	$this->filter($val);
			}
		}
	}
	function dateformat($date,$time=0)
	{
		if($time==0)
		{
		return (date('m/d/Y',strtotime($date)));
		}
		else
		{
		return (date("m/d/Y H:i:s",strtotime($date)));
		}
	}
	function formatcurrency($currency)
	{
		$cur	=	number_format($currency, 2, '.', ',');
		return $cur;
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
	
	function generatePassword ($length = 16)
	{
			
			// start with a blank password
			$password = "";
			
			// define possible characters - any character in this string can be
			// picked for use in the password, so if you want to put vowels back in
			// or add special characters such as exclamation marks, this is where
			// you should do it
			$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
			
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
			return $password;
			
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

	
	
	//echo getTimeDiff("23:30","01:30");


}//end of class Helper
?>
