<?php

class Zend_View_Helper_Commtypes {
	
    protected $_commTypes;
 
    public function commtypes() {
    	
    	$commTypeMapper = new LLLT_Model_CommTypeMapper();
    	$this->_commTypes = $commTypeMapper->fetchAll('active = 1', 'communication_type asc');

    	return $this->_commTypes; 
    }
}