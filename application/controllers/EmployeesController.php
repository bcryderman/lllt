<?php

class EmployeesController extends Zend_Controller_SecureAction {

    public function init() { 
	
		$this->view->title = 'Drivers &amp; Employees';
	}

    public function indexAction() { }
    
    public function addAction() {
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		
    		$params = $request->getParams();
    		
    		$errors = $this->validation($params);
    		
    		if (empty($errors)) {
    			    			
    			$loginMapper = new LLLT_Model_LoginMapper();
		    	$usernameAvail = $loginMapper->usernameAvail($params['username']);
		    	
		    	if ($usernameAvail) {
		    	
					$auth = Zend_Auth::getInstance()->getIdentity(); 
			    	$date = date('Y-m-d H:i:s');
			    	
			    	$employee = new LLLT_Model_Employee(); 	
					$employee->setUsername($params['username'])
							 ->setPassword(md5($params['password']))
							 ->setFirst_name($params['first_name'])
			    			 ->setLast_name($params['last_name'])
			    		 	 ->setAddr($params['addr'])
			    			 ->setAddr2($params['addr2'])
			    			 ->setCity($params['city'])
							 ->setState($params['state'])
	 						 ->setZip($params['zip'])
	 						 ->setZip4($params['zip4'])
	 						 ->setVehicle_id($params['vehicle_id'])
							 ->setRole_id($params['role_id'])
							 ->setUser_type_id($params['user_type_id'])
							 ->setActive(1)
							 ->setEmail($params['email'])
							 ->setPhone($params['phone'])
							 ->setPhone_ext($params['phone_ext'])
							 ->setPhone_primary($params['phone_primary'])
							 ->setCell_phone($params['cell_phone'])	
							 ->setCell_phone_primary($params['cell_phone_primary'])
							 ->setCommunication_type_id($params['communication_type_id'])
			    			 ->setCreated($date)
		    				 ->setCreated_by($auth['Employee']->getEmp_id())
		    				 ->setLast_updated($date)
		    				 ->setLast_updated_by($auth['Employee']->getEmp_id());			
		    		
		    		$employeeMapper = new LLLT_Model_EmployeeMapper();
		    		$employeeMapper->add($employee);
			    	
	    			$this->_redirect('employees/view');
		    	}
    		}
    		 else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
    	}
    	
    	$this->view->type = 'add';

    	$this->renderScript('employees/form.phtml');
    }

	public function deleteAction() {
		
		$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$employeeMapper = new LLLT_Model_EmployeeMapper();
		
    	if ($request->isPost()) {

    		$employeeMapper->delete($params['emp_id']);
	    	
	    	$this->_redirect('employees/view');
    	}    
		else {
			
			$employee = $employeeMapper->find($params['emp_id']);
			
			$this->view->employee = $employee;	
	    	$this->view->params = $params;
		}
	}
    
    public function editAction() {
    	
    	$request = $this->getRequest();
    	$params = $request->getParams();

    	if ($request->isPost()) {
			
    		$errors = $this->validation($params, true);
			
			if (empty($errors)) { 
				
				$auth = Zend_Auth::getInstance()->getIdentity(); 
				$date = date('Y-m-d H:i:s');

		    	$employee = new LLLT_Model_Employee(); 	
				$employee->setEmp_id($params['emp_id'])
						 ->setUsername($params['username'])
						 ->setPassword(($params['password']) ? md5($params['password']) : null)
						 ->setFirst_name($params['first_name'])
		    			 ->setLast_name($params['last_name'])
		    		 	 ->setAddr($params['addr'])
		    			 ->setAddr2($params['addr2'])
		    			 ->setCity($params['city'])
						 ->setState($params['state'])
 						 ->setZip($params['zip'])
 						 ->setZip4($params['zip4'])
 						 ->setVehicle_id($params['vehicle_id'])
						 ->setRole_id($params['role_id'])
						 ->setUser_type_id($params['user_type_id'])
						 ->setActive(1)
						 ->setEmail($params['email'])
						 ->setPhone($params['phone'], false, true)
						 ->setPhone_ext($params['phone_ext'])
						 ->setPhone_primary($params['phone_primary'])
						 ->setCell_phone($params['cell_phone'], false, true)	
						 ->setCell_phone_primary($params['cell_phone_primary'])
						 ->setCommunication_type_id($params['communication_type_id'])
		    			 ->setCreated($date)
	    				 ->setCreated_by($auth['Employee']->getEmp_id())
	    				 ->setLast_updated($date)
	    				 ->setLast_updated_by($auth['Employee']->getEmp_id());			
	    		
	    		$employeeMapper = new LLLT_Model_EmployeeMapper();
	    		$employeeMapper->edit($employee);

				$this->_redirect('employees/view');
			}
			else {
				
				$this->view->errors = $errors;
				$this->view->params = $params;
			}
		}
		else {

			$employeeMapper = new LLLT_Model_EmployeeMapper();
	    	$employee = (array) $employeeMapper->find($params['emp_id']);

			$object2Array = new LLLT_Model_Object2Array();
	    	$object2Array->setFields($employee);

	    	$this->view->params = $object2Array->getFields();
	    	//Get All asset type 2's for vehicle ID which will give you
	    	//Naveman ID and trailer compartments.
	    	$this->view->assets = $this->getassets(2);  
		}
		
		$this->view->type = 'edit';
		
		$this->renderScript('employees/form.phtml');
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

    	$employeeMapper = new LLLT_Model_EmployeeMapper();
    	$employees = $employeeMapper->fetchAll(null, $params['column'] . ' ' . $params['sort'] . ', tbl_employee.last_name ' . $params['sort']);

    	$this->view->employees = $employees;

		$this->renderScript('employees/tabulardata.phtml');
	}
        
    public function viewAction() {
    	
    	$employeeMapper = new LLLT_Model_EmployeeMapper();
    	$employees = $employeeMapper->fetchAll(null, 'tbl_employee.last_name asc, tbl_employee.first_name asc');

    	$this->view->employees = $employees;
    }
    
    public function validation($params, $modify = false) { 
    																		
		$errors = array();
			    	
    	if (!$modify && empty($params['username'])) {
    		
    		$errors['username'] = 'You must enter a username.';
    	}
    			
		if (!$modify && (isset($params['password']) && !empty($params['password'])) || (isset($params['confpass']) && !empty($params['confpass']))) {
			
   			if (empty($params['password'])) {
   		
	    		$errors['password'] = 'You must enter a password.';
	    	}
   	
			if (empty($params['confpass'])) {
   		
	    		$errors['confpass'] = 'You must enter a confirmation password.';
	    	}
   	
	    	if (!empty($params['password']) && !empty($params['confpass']) && $params['password'] !== $params['confpass']) {
   		
	    		$errors['confpass'] = 'Password and confirmation password do not match.';
	    	}
		}
		
    	if (!empty($params['zip']) && strlen($params['zip']) !== 5) {
    		
    		$errors['zip'] = 'Zip must be 5 digits.';
    	}
    	
		if (!empty($params['zip4']) && strlen($params['zip4']) !== 4) {
    		
    		$errors['zip4'] = 'Zip-4 must be 4 digits.';
    	}
    	
    	if (empty($params['role_id'])) {

    		$errors['role_id'] = 'You must select a role.';
    	}
    	
    	if (empty($params['user_type_id'])) {
    		
    		$errors['user_type_id'] = 'You must select a user type.';
    	}
    	
    	if (!empty($params['phone_ext']) && empty($params['phone'])) {

    		$errors['phone'] = 'You must enter a phone # when entering an extension.';
    	}
    	
    	if (empty($params['communication_type_id']) && !empty($params['cell_phone'])) {
    		
    		$errors['communication_type_id'] = 'You must select a cell carrier when entering a cell #.';
    	}
    	
    	if (!empty($params['communication_type_id']) && empty($params['cell_phone'])) {
    		
    		$errors['cell_phone'] = 'You must enter a cell # when selecting a cell carrier.';
    	}
     	    		
    	return $errors;
    }
    
    public function getassets($asset_type){
    		$assetMapper = new LLLT_Model_AssetMapper();
	    	$asset = $assetMapper->find_type($asset_type);

	    	return $asset;
	    	
    }
}