<?php

class Zend_View_Helper_Fuelsurchargelatest {
	
    protected $_retVal;
 
    public function fuelsurchargelatest($customer_id) {
    	
    	$dataMapper = new LLLT_Model_FuelsurchargeMapper();
    	$this->_retVal = $dataMapper->getlatest($customer_id);
    
    	return $this->_retVal; 
    }
}