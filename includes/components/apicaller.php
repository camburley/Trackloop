<?php
class ApiCaller
{
	private $_app_id;
	private $_app_key;
	public $_api_url;
	
	function __construct($appID, $appKey, $apiURL)
	{
		$this->_app_id	=	$appID;
		$this->_app_key	=	$appKey;
		$this->_api_url	=	$apiURL;
	}
	//send the request to the API server
	//also encrypts the request, then checks
	//if the results are valid
	function grab_dump($var)
	{
		ob_start();
		print_r($var);
		return ob_get_clean();
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
	}//end of filte
	function filterRequest()
	{
		//array_walk_recursive($_REQUEST,$this->filter);
		foreach($_REQUEST as $key=>$val)
		{
			/*$ob	=	json_decode($val);
			if($ob !== null) // JSON valid then don't filter it out...
			{
				continue;
			}*/
			if(is_array($val))
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
			/*$ob	=	json_decode($val);
			if($ob !== null) // JSON valid then don't filter it out...
			{
				continue;
			}
			else */if(is_array($val))
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
			/*$ob	=	json_decode($val);
			if($ob !== null) // JSON valid then don't filter it out...
			{
				continue;
			}
			else */if(is_array($val))
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
	public function sendRequest($request_params)
	{
		
		//create the params array, which will
		//be the POST/GET parameters
		//$this->dump($request_params);
		$params[]					=	$request_params;
		$request_params['app_id']	=	$this->_app_id;
		$request_params['app_key']	=	$this->_app_key;
		
		//initialize and setup the curl handler
		$ch = curl_init();
		if($ch)
		{
			curl_setopt($ch, CURLOPT_URL, $this->_api_url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request_params);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
			//execute the request
			$result = curl_exec($ch);
			//json_decode the result
			$result = @json_decode($result);
			
			//check if we're able to json_decode the result correctly
			/*if( $result == false)
			{
				print_r($result);
				exit;
			}*/
			
			//if there was an error in the request, throw an exception
			/*if( $result->failure == 1 ) {
				print_r($result);
				exit;
			}*/
			//if everything went great, return the data
			return $result;
		}
		else
		{
			echo "CURL din't initiate.";
		}
	}
}
