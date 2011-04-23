<?php

class EmployeesController extends Zend_Controller_SecureAction {

    public function init() { }

    public function indexAction() { }
    
    public function addAction() {
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		
    		$params = $request->getParams();
    		
    		$errors = $this->validation($params);
    		
    		if (empty($errors)) {
    			
    			$params['password'] = md5($params['password']);
    			
    			$loginMapper = new LLLT_Model_LoginMapper();
		    	$usernameAvail = $loginMapper->usernameAvail($params['username']);
		    	
		    	if ($usernameAvail) {
		    	
					$auth = Zend_Auth::getInstance()->getIdentity(); 
			    	$date = date('Y-m-d H:i:s');
			    	
			    	$emp = new LLLT_Model_Employee(); 	
			    	$emp->setFirst_name($params['first_name']);
			    	$emp->setLast_name($params['last_name']);
			    	$emp->setAddr($params['addr']);
			    	$emp->setAddr2($params['addr2']);
			    	$emp->setCity($params['city']);
					$emp->setState($params['state']);
	 				$emp->setZip($params['zip']);
	 				$emp->setZip4($params['zip4']);
	 				//$emp->setVehicle_id($params['vehicle_id']);
					$emp->setRole_id($params['role_id']);
					$emp->setActive(1);
					$emp->setEmail($params['email']); 	
			    	$emp->setCreated($date);
		    		$emp->setCreated_by($auth['Employee']->getEmp_id());
		    		$emp->setLast_updated($date);
		    		$emp->setLast_updated_by($auth['Employee']->getEmp_id());
		    		
		    		$empMapper = new LLLT_Model_EmployeeMapper();
		    		$empId = $empMapper->add($emp);
		    		
		    		if ($params['phone'] !== '') {
	    			
		    			$empComm = new LLLT_Model_EmployeeComm();
		    			$empComm->setEmp_id($empId);
		    			$empComm->setCommunication_type_id(1);
		    			$empComm->setPhone($params['phone']);
		    			$empComm->setPhone_ext($params['phone_ext']);
		    			$empComm->setPrimary($params['phone_primary']);		    			
		    			$empComm->setCreated($date);
			    		$empComm->setCreated_by($auth['Employee']->getEmp_id());
			    		$empComm->setLast_updated($date);
			    		$empComm->setLast_updated_by($auth['Employee']->getEmp_id());
			    		
			    		$empCommMapper = new LLLT_Model_EmployeeCommMapper();
			    		$empCommMapper->add($empComm);
		    		}
		    		
			    	if ($params['cell_phone'] !== '') {
		    			
		    			$empComm = new LLLT_Model_EmployeeComm();
		    			$empComm->setEmp_id($empId);
		    			$empComm->setCommunication_type_id($params['communication_type_id']);
		    			$empComm->setPhone($params['cell_phone']);
		    			$empComm->setPrimary($params['cell_phone_primary']);	    				    			
		    			$empComm->setCreated($date);
			    		$empComm->setCreated_by($auth['Employee']->getEmp_id());
			    		$empComm->setLast_updated($date);
			    		$empComm->setLast_updated_by($auth['Employee']->getEmp_id());
			    		
			    		$empCommMapper = new LLLT_Model_EmployeeCommMapper();
			    		$empCommMapper->add($empComm);
		    		}
		    		
		    		$login = new LLLT_Model_Login();
		    		$login->setEmp_id($empId);	    
					$login->setUsername($params['username']);
					$login->setPassword(md5($params['password']));
					$login->setUser_type_id($params['user_type_id']);
					$login->setCreated($date);
			    	$login->setCreated_by($auth['Employee']->getEmp_id());
			    	$login->setLast_updated($date);
			    	$login->setLast_updated_by($auth['Employee']->getEmp_id());
			    		
		    		$loginMapper = new LLLT_Model_LoginMapper();
		    		$loginMapper->add($login); 
			    	
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
    	
    	$empMapper = new LLLT_Model_EmployeeMapper();
	    $emp = $empMapper->find($params['emp_id']);
	
		$loginMapper = new LLLT_Model_LoginMapper();
		$login = $loginMapper->find($params['emp_id']);
		
    	if ($request->isPost()) {

			$loginMapper->delete($login);
			
			$empCommMapper = new LLLT_Model_EmployeeCommMapper();
			$empComm = $empCommMapper->fetchAll('emp_id = ' . $params['emp_id'], 'communication_type_id asc');
			
			foreach ($empComm as $item) {
				
				$empCommMapper->delete($item);
			}
			
    		$empMapper->delete($emp);
	    	
	    	$this->_redirect('employees/view');
    	}    	
     	
    	$this->view->emp = $emp;	
		$this->view->login = $login;
    	$this->view->params = $params;
	}
    
    public function editAction() {
    	
    	$request = $this->getRequest();
    	$params = $request->getParams();

    	if ($request->isPost()) {
			
    		$errors = $this->validation($params, true);
			var_dump($errors);
			
			if (empty($errors)) { 
				
				$auth = Zend_Auth::getInstance()->getIdentity(); 
				$date = date('Y-m-d H:i:s');

				if (isset($params['password']) && isset($params['confpass'])) {

					$params['password'] = md5($params['password']);

					$loginMapper = new LLLT_Model_LoginMapper();

					$login = new LLLT_Model_Login();
		    		$login->setEmp_id($params['emp_id']);	    
					$login->setPassword(md5($params['password']));
					$login->setUser_type_id($params['user_type_id']);
			    	$login->setLast_updated($date);
			    	$login->setLast_updated_by($auth['Employee']->getEmp_id());

		    		$loginMapper = new LLLT_Model_LoginMapper();
		    		$loginMapper->edit($login);
				}

				$emp = new LLLT_Model_Employee(); 	
				$emp->setEmp_id($params['emp_id']);
		    	$emp->setFirst_name($params['first_name']);
		    	$emp->setLast_name($params['last_name']);
		    	$emp->setAddr($params['addr']);
		    	$emp->setAddr2($params['addr2']);
		    	$emp->setCity($params['city']);
				$emp->setState($params['state']);
 				$emp->setZip($params['zip']);
 				$emp->setZip4($params['zip4']);
 				//$emp->setVehicle_id($params['vehicle_id']);
				$emp->setRole_id($params['role_id']);
				$emp->setActive($params['active']);
				$emp->setEmail($params['email']); 	
	    		$emp->setLast_updated($date);
	    		$emp->setLast_updated_by($auth['Employee']->getEmp_id());

	    		$empMapper = new LLLT_Model_EmployeeMapper();
	    		$empId = $empMapper->edit($emp);

	    		if ($params['phone'] !== '') {

	    			$empComm = new LLLT_Model_EmployeeComm();
	    			$empComm->setEmp_id($empId);
	    			$empComm->setCommunication_type_id(1);
	    			$empComm->setPhone($params['phone']);
	    			$empComm->setPhone_ext($params['phone_ext']);
	    			$empComm->setPrimary($params['phone_primary']);		    			
		    		$empComm->setLast_updated($date);
		    		$empComm->setLast_updated_by($auth['Employee']->getEmp_id());

		    		$empCommMapper = new LLLT_Model_EmployeeCommMapper();
		    		$empCommMapper->edit($empComm);
	    		}

		    	if ($params['cell_phone'] !== '') {

	    			$empComm = new LLLT_Model_EmployeeComm();
	    			$empComm->setEmp_id($empId);
	    			$empComm->setCommunication_type_id($params['communication_type_id']);
	    			$empComm->setPhone($params['cell_phone']);
	    			$empComm->setPrimary($params['cell_phone_primary']);	    				    			
		    		$empComm->setLast_updated($date);
		    		$empComm->setLast_updated_by($auth['Employee']->getEmp_id());

		    		$empCommMapper = new LLLT_Model_EmployeeCommMapper();
		    		$empCommMapper->edit($empComm);
	    		}

				$this->_redirect('employees/view');
			}
			else {
				
				$this->view->errors = $errors;
				$this->view->params = $params;
				$this->view->type = 'edit';
			}
		}
		else {

			$empMapper = new LLLT_Model_EmployeeMapper();
	    	$emp = (array) $empMapper->find($params['emp_id']);

	    	$fields = array();

	    	foreach ($emp as $k => $v) {

	    		$fields[substr($k, 4)] = $emp[$k];
	    	}

			$loginMapper = new LLLT_Model_LoginMapper();
			$login = (array) $loginMapper->find($params['emp_id']);

			foreach ($login as $k => $v) {

	    		$fields[substr($k, 4)] = $login[$k];
	    	}

			$empCommMapper = new LLLT_Model_EmployeeCommMapper();
			$empComm = (array) $empCommMapper->fetchAll(null, 'communication_type_id asc');

			foreach ($empComm as $k => $v) {

				if ($empComm[$k]->getCommunication_type_id() === 1) {

					$fields['phone'] = $empComm[$k]->getPhone();
					$fields['phone_ext'] = $empComm[$k]->getPhone_ext();

					if ($empComm[$k]->getPrimary()) {

						$fields['phone_primary'] = $empComm[$k]->getCommunication_type_id();
					}
				}
				else {

					$fields['cell_phone'] = $empComm[$k]->getPhone();
					$fields['communication_type_id'] = $empComm[$k]->getCommunication_type_id();

					if ($empComm[$k]->getPrimary()) {

						$fields['cell_phone_primary'] = $empComm[$k]->getCommunication_type_id();
					}
				} 		
	    	}

	    	$this->view->empId = $params['emp_id'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
		}
		
		$this->renderScript('employees/form.phtml');
    }
        
    public function viewAction() {
    	
    	$empMapper = new LLLT_Model_EmployeeMapper();
    	$emps = $empMapper->fetchAll(null, array('last_name asc', 'first_name asc'));
    	
    	$roleMapper = new LLLT_Model_RoleMapper();
    	$roles = $roleMapper->fetchAll('active = 1', 'role_name asc');
    	
    	$rolesArr = array();
    	
    	foreach ($roles as $item) {
    		
    		$rolesArr[$item->getRole_id()] = $item;
    	}

    	$this->view->emps = $emps;
    	$this->view->roles = $rolesArr;
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
    	
    	/*$validator = new Zend_Validate_EmailAddress();

    	if (!empty($params['email']) && !$validator->isValid($params['email'])) {
				
    		$errors['email'] = 'The e-mail address entered is not valid.';
    	}*/
		
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
}