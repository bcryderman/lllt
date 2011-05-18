<?php

class Zend_View_Helper_Drivers {
	
    protected $_drivers;
 
    public function drivers($empId = null) {
    	
    	$employeeMapper = new LLLT_Model_EmployeeMapper();
    	
    	if (is_null($empId)) {
    	
    		$this->_drivers = $employeeMapper->fetchAll('e.active = 1 AND e.role_id = 2', 'e.last_name asc');
    	}
    	else {
    	
    		$this->_drivers = $employeeMapper->find($empId);
    	}

    	return $this->_drivers; 
    }
}