<?php

class DispatchController extends Zend_Controller_SecureAction {

    public function init() {}

    public function indexAction() {
        $vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;
    	$employees = $vemploadsMapper->fetchAll($where,'last_name asc');

    	//$this->view->employees = $employees;
    var_dump($employees);
    }
    
    public function getdriversAction(){
    	
    	$employeeMapper = new LLLT_Model_EmployeeMapper();
    	$employees = $employeeMapper->fetchAll(null, array('e.last_name asc', 'e.first_name asc'));

    	$this->view->employees = $employees;
    }
    
public function emptabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();


    	$vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;

		if ($params['column'] === 'last_name') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'last_name ' . $params['sort']);
		}
		else if ($params['column'] === 'dispatched_loads') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'dispatched_loads ' . $params['sort']);
		}
		else if ($params['column'] === 'pending_loads') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'pending_loads ' . $params['sort']);
		}
		else {
			
			$employees = $vemploadsMapper->fetchAll(null, 'last_name ' . $params['sort']);
		}

    	$this->view->data = $employees;
	}
    
    public function viewAction() {
    	
    	$vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;
    	$employees = $vemploadsMapper->fetchAll($where,'last_name asc');
    	  	
    	$this->view->data = $employees;
    }
}