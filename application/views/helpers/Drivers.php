<?php

class Zend_View_Helper_Drivers {
	
    protected $_drivers;
 
    public function drivers($empId = null) {
    	
    	$employeeMapper = new LLLT_Model_EmployeeMapper();
    	
    	if (is_null($empId)) {
    	
    		$this->_drivers = $employeeMapper->fetchAll('tbl_employee.active = 1 AND tbl_employee.role_id = 2', 'tbl_employee.last_name asc');
    	}
    	else {
    	
    		$this->_drivers = $employeeMapper->find($empId);
    	}

    	return $this->_drivers; 
    }
}