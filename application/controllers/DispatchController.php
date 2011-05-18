<?php

class DispatchController extends Zend_Controller_SecureAction {

    public function init() {}

    public function indexAction() {
        $employeeMapper = new LLLT_Model_EmployeeMapper();
        $where=array('first_name'=>'Brian','last_name'=>'Cryderman','active'=>1);
    	$employees = $employeeMapper->fetchdispatch($where, array('e.last_name asc', 'e.first_name asc'));

    	//$this->view->employees = $employees;
    var_dump($employees);
    }
    
    public function getdriversAction(){
    	
    	$employeeMapper = new LLLT_Model_EmployeeMapper();
    	$employees = $employeeMapper->fetchAll(null, array('e.last_name asc', 'e.first_name asc'));

    	$this->view->employees = $employees;
    }
}