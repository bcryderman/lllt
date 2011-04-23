<?php

class Zend_View_Helper_UserTypes {
	
    protected $_userTypes;
 
    public function userTypes() {
    	
    	$userTypeMapper = new LLLT_Model_UserTypeMapper();
    	$this->_userTypes = $userTypeMapper->fetchAll('active = 1', 'user_type asc');

    	return $this->_userTypes; 
    }
}