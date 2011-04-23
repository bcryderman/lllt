<?php

class Zend_View_Helper_Roles {
	
    protected $_roles;
 
    public function roles() {
    	
    	$roleMapper = new LLLT_Model_RoleMapper();
    	$this->_roles = $roleMapper->fetchAll('active = 1', 'role_name asc');

    	return $this->_roles; 
    }
}