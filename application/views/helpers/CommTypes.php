<?php

class Zend_View_Helper_CommTypes {
	
    protected $_commTypes;
 
    public function commTypes() {
    	
    	$commTypeMapper = new LLLT_Model_CommTypeMapper();
    	$this->_commTypes = $commTypeMapper->fetchAll('active = 1', 'communication_type asc');

    	return $this->_commTypes; 
    }
}