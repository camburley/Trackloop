<?php
if(file_exists("classes/class.db.php"))
{
	require_once("classes/class.db.php");
}
else
{
	require_once("../classes/class.db.php");
}
class Transaction extends DB
{
	private $_params;
	public function __construct($params)
	{
		$this->_params = $params;
	}
	public function submitAction()
	{
		$userid		=	$this->_params['user_id'];
		$services	=	$this->_params['services'];
		//echo "I am here...";
		//$this->dump($services);
		if(!is_array($services))
		{
			//echo "1";
			$ob	=	json_decode($this->_params['services']);
			if($ob === null)
			{
				//echo "2";
				// $ob is null because the json cannot be decoded
				//services[1]=20:1000,10:300&services[2]=30:1000,10:39&services[3]=3:122,4:125
				$services1	=	explode("&amp;",$services);
				//print_r($services);
				foreach($services1 as $service)
				{
					//$service	=	services[1]=20:1000,10:300
					$service1	=	array();
					list($all_services,$all_quantities_pricings)	=	explode("=",$service);
					
					//Find service ID by removing word "Services[" and then "]["
					$service1	=	trim($all_services,"services[");
					list($serviceid,$xxx)		=	explode("][",$service1);
					//$serviceid	=	trim("]",$service1);
					//$serviceid	=	$s2[0];
					
					//20:1000
					if(strpos($all_quantities_pricings,",")===false)
					{
						list($quantity,$price)	=	explode(":",$qp);
						$qps[$quantity]			=	$price;
					}
					else//20:1000,10:300
					{
						$quantities_pricings	=	explode(",",$all_quantities_pricings);
						$qps					=	array();
						foreach($quantities_pricings as $qp)
						{
							list($quantity,$price)	=	explode(":",$qp);
							$qps[$quantity]			=	$price;
						}
					}
					$allservices[trim($serviceid,"]")]	=	$qps;
					
					//$this->dump($allservices);
					
/*					$services_array	=	array(
						1=>array(
									20=>100,
									30=>120
								),
						2=>array(
									30=>100,
									40,200
									),
						3=>array(
									30=>122,
									10,30
								)
					);
*/					/*
					/*$service1	=	array();
					$service1	=	explode("=",$service);
					
					$charges	=	$service1[1];
					$service1	=	trim($service1[0],"services[");
					$s2			=	explode("][",$service1);
					$serviceid	=	$s2[0];
					
					$quantity	=	trim($s2[1],"]");
					$allservices[$serviceid]	=	array($quantity,$charges);*/
				}
				$services	=	$allservices;
				//$this->dump($services,1);
				
			}
			else
			{
				//echo "3";
				//echo "$services is JSON...";
				$services	=	json_decode($this->_params['services'],1);
			}
			
		}
		else
		{
			//echo "4";
		}
		$pkterminalid	=	$this->validateterminal($this->_params['terminal_id']);
		if($pkterminalid ==-1)
		{
			return $this->message(35);
		}
		
		$customername		=	$this->_params['customername'];
		$customeremail		=	$this->_params['customeremail'];
		$total				=	$this->_params['total'];
		$subtotal			=	$this->_params['subtotal'];
		$taxrate			=	$this->_params['taxrate'];
		$taxcollected		=	$this->_params['taxcollected'];
		$pmtref				=	$this->_params['pmtref'];
		$testmode			=	$this->_params['testmode'];
		$status				=	$this->_params['status'];
		$collectedpercent	=	$this->_params['collectedpercent'];
		//validate user id
		$pkuserid	=	$this->validateuser($userid);
		if($pkuserid ==-1)
		{
			return $this->message(33);
		}
		
		
		
		
		$transaction_unique_id	=	$this->generateUniqueTransactionID();
	
		
		$transactiondate	=	date('Y-m-d H:i:s');
		$sql				=	"INSERT INTO 
											tbltransaction 
										SET 
											fkterminalid	=	'$pkterminalid',
											total			=	'$total',
											subtotal		=	'$subtotal',
											taxrate			=	'$taxrate',
											taxcollected	=	'$taxcollected',
											pmtref			=	'$pmtref',
											testmode		=	'$testmode',
											status			=	'$status',
											fkuserid		=	'$pkuserid',
											transactiondate	=	'$transactiondate',
											uniqueid		=	'$transaction_unique_id',
											customername	=	'$customername',
											customeremail	=	'$customeremail'
									";
		$this->query($sql);
		
		$transactionid	=	mysqli_insert_id($this->link);
		
//		$this->dump($services,1);
		/*
				Array
				(
					[1] => Array
						(
							[20] => 100
							[30] => 120
						)
				
					[2] => Array
						(
							[30] => 100
							[40] => 200
						)
				
					[3] => Array
						(
							[30] => 122
							[10] => 30
						)
				
				)
			*/
		foreach($services as $pkserviceid=>$servicedetails)
		{
			//$this->dump($servicedetails);
			
			foreach($servicedetails as $quantity=>$charges)
			{
				$pages			=	$quantity;//$servicedetails[0];
				$serviceprice	=	$charges;//$servicedetails[1];	
			
			
			
			$query			=	"INSERT INTO tbltransactiondetail 
										SET 
											fkserviceid		=	'$pkserviceid',
											price			=	'$serviceprice',
											quantity		=	'$pages',
											fktransactionid	=	'$transactionid'
								";
			//echo "<br>";
			$this->query($query);
			}
			//$pkserviceid	=	$this->validateservice($serviceid);
			//if($pkserviceid	==	-1)
			//{
				//return $this->message(34);
			//}
		}
		if(mysqli_affected_rows($this->link) > 0)
		{
			return array('transactionid'=>$transaction_unique_id,'message'=>$this->message(36));
		}
		else
		{
			return $this->message(37);
		}
	}
}