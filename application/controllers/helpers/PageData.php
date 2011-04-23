<?php
class Zend_Controller_Action_Helper_PageData extends 
Zend_Controller_Action_Helper_Abstract {
	
	public $cust_type = array('1'=>'Bill To',
								'2'=>'Shipper',
								'3'=>'Customer',
								'4'=>'Origin',
								'5'=>'Destination');
	
	
	public function build_page_data($id){
		$page_data = array(
							'Page_Title'		=>$this->cust_type[$id],
							'customer_type_id'	=>$id
		);
		
		return $page_data;
	}
	
	public function get_customer_data_by_id($customer_id){
		$data = new LLLT_Model_Customer();
    	$cust_data = $data->sel_customer_by_id($customer_id);
    	return $cust_data;
	}

	
}