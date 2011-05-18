<?php

class Zend_View_Helper_Pswcustomers extends Zend_View_Helper_Abstract {
	
	protected $_customer;
	
	public function pswcustomers($customerId) {
		
		$customerMapper = new LLLT_Model_CustomerMapper();
		$this->_customer = $customerMapper->find($customerId);
		
		return $this->_customer;
	}
}