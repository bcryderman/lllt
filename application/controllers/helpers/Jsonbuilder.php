<?php
class Zend_Controller_Action_Helper_Jsonbuilder extends 
Zend_Controller_Action_Helper_Abstract {
	
	public $cust_type = array('1'=>'bill_to.txt',
								'2'=>'shipper.txt',
								'3'=>'customer.txt',
								'4'=>'origin.txt',
								'5'=>'destination.txt');
	
	
	public function updatejson($cust_type){
		$data = $this->getcustomerdata($cust_type);
		$json = $this->createjson($data);
		$file = $this->createfile($this->cust_type[$cust_type],$json);
		return $file;
	}
	public function getjson($cust_type){
		$cust_data = $this->readjson($cust_type);
		return $cust_data;
	}

	
	public function createfile($filename,$filecontent)
	{
		$filelocation= 'json\\';

		$fp = fopen($filelocation.$filename,'w');
		$x = fwrite($fp,$filecontent);

		return $x;	
	}
		
	public function createjson($data){
		return json_encode($data);
	}
	
	public function getcustomerdata($cust_type){
		$data = new LLLT_Model_Customer();
		$x = $data->sel_customer($cust_type);
		return $x;
	}
	
	public function readjson($cust_type){
		$file = 'json/'.$this->cust_type[$cust_type];
    	if(file_exists($file))
    	{
    		$data = file_get_contents($file);
    		return($data);
    	}
    	else
    	{
    		$data = $this->getcustomerdata($cust_type);
    		$data = $this->createjson($data);
    		$this->createfile($this->cust_type[$cust_type],$data);
			return $data;
    	}
    }
}