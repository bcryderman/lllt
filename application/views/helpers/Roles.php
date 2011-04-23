<?php

class Zend_View_Helper_Roles {
	
    protected $_roles;
 
    public function roles($roleId = null) {
    	
    	$roleMapper = new LLLT_Model_RoleMapper();
    	
    	if (is_null($roleId)) {
    		
    		$this->_roles = $roleMapper->fetchAll('active = 1', 'role_name asc');
    	}
    	else {
    		
    		$this->_roles = $roleMapper->find($roleId);
    	}   	

    	return $this->_roles; 
    }
}