<?php 
class Zend_Controller_Action_Helper_QbInvoice extends 
Zend_Controller_Action_Helper_Abstract {

	private $_db = 'mysql://root:D1sp@tch3r@localhost/qb_lllt';
	private $_user = 'llldispatch';
	private $_customer_id;
	

	
	private function setup(){

			}
			
	public function add_qb_queue($obj){
		$queue = new LLLT_Model_QbQueueMapper();
		$queuedata = new LLLT_Model_QbQueue();
		$queue_id = $obj->getOrigin_id().'-'.$obj->getDestination_id().'-'.$obj->getDriver_id();
		
		$queuedata->setQueue_id($queue_id)
				  ->setLoad_id($obj->getLoad_id())
				  ->setActive(1);
		$queue->add($queuedata);
		
		$this->buildInvoice($obj);
	}
			
	public function buildInvoice($obj){
		
		error_reporting(E_ALL | E_STRICT);
		ini_set('display_errors', 1);
		
		// 
		if (function_exists('date_default_timezone_set'))
		{
			date_default_timezone_set('America/Chicago');
		}
		
		// 
		ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . 'C:/servers/qb/v153');
		
		
		
		/**
		 * 
		 */
		require_once 'QuickBooks.php';
		
		/****Get Bill address and Ship address*/
		
		//Bill to
		$this->_customer_id = $obj->getBill_to_id();
		$billaddy = $this->getcustomerinfo();
	
		//Ship to
		$this->_customer_id = $obj->getShipper_id();
		$shipaddy = $this->getcustomerinfo();
		
		//QuickBooks_Utilities::createUser($this->_db, 'llltdispatch', 'p3terbu1lt');
		
		$user = 'llltdispatch';
		$source_type = QuickBooks_API::SOURCE_WEB;
		$api_driver_dsn = $this->_db;
		//$api_driver_dsn = 'pgsql://pgsql@localhost/quickbooks';
		//$source_dsn = 'http://quickbooks:test@localhost/path/to/server.php';
		$source_dsn = 'http://qbtest.localhost:test@localhostQuickBooks/server.php';
		$api_options = array();
		$source_options = array();
		$driver_options = array();
		 $date = date('Y-m-d');
		 $API = new QuickBooks_API($this->_db, $user, $source_type, $source_dsn, $api_options, $source_options, $driver_options);
		 // INVOICES
		$Invoice = new QuickBooks_Object_Invoice();
//		//$Invoice->setOther('test of other');		// for some reason this field doesn't work...
//		$Invoice->setCustomerName('ConsoliBYTE Solutions');
//		//$Invoice->setCustomerName($obj->getCustomer());
//		$Invoice->setTransactionDate($date);
//		$Invoice->setBillAddress($billaddy->getAddr(), $billaddy->getAddr2(), '',  '',  '', $billaddy->getCity(), $billaddy->getState(), '',  $billaddy->getZip(),'', '');
//		$Invoice->setShipAddress($shipaddy->getAddr(), $shipaddy->getAddr2(), '',  '',  '', $shipaddy->getCity(), $shipaddy->getState(), '',  $shipaddy->getZip(),'', '');
//		$Invoice->setIsToBePrinted('true');
//		$Invoice->setIsToBeEmailed('true');///Not sure if it will work in QB
//		
//		$IL1 = new QuickBooks_Object_Invoice_InvoiceLine();
//		$IL1->setItemName('Freight Chg');
//		$IL1->setDescription($obj->getBill_of_lading());
//		$IL1->setQuantity($obj->getNet_gallons());
//		$IL1->setRate($obj->getBill_rate());
//		
//		$Invoice->addInvoiceLine($IL1);
//		
//		if($obj->getFuel_surcharge() > 0)
//		{
//			$IL2 = new QuickBooks_Object_Invoice_InvoiceLine();
//			$IL2->setItemName('Fuel Surcharge');
//			$IL2->setRatePercent(1.5);
//			$Invoice->addInvoiceLine($IL2);
//		}
		
		
		$queue_id = $obj->getOrigin_id().'-'.$obj->getDestination_id().'-'.$obj->getDriver_id();
		
		$API->addInvoice($Invoice, '_quickbooks_ca_invoice_add_callback',$queue_id);

		 
		
	}
	
	private function getcustomerinfo(){
			$data = new LLLT_Model_CustomerMapper();
			return $data->find($this->_customer_id);
	}
	
	private function buildIl1($obj)
	{
		
	}

}

?>