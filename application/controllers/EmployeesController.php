<?php

class EmployeesController extends Zend_Controller_SecureAction {

    public function init() { }

    public function indexAction() { }
    
    public function createAction() {
    	    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {
	    		    		   	
	    	$params = $request->getParams();
	    	$params['password'] = md5($params['password']);
		    	
			$auth = Zend_Auth::getInstance()->getIdentity(); 
	    	$date = date('Y-m-d H:i:s');
	    	
	    	$loginMapper = new LLLT_Model_LoginMapper();
	    	$usernameAvail = $loginMapper->usernameAvail($params['username']);
	    	
	    	if ($usernameAvail) {
	    		
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
	    		$emp->SetLast_updated_by($auth['Employee']->getEmp_id());
	    		
	    		$empMapper = new LLLT_Model_EmployeeMapper();
	    		$empId = $empMapper->create($emp);
	    		
	    		if ($params['phone'] !== '') {
	    			
	    			$empComm = new LLLT_Model_EmployeeComm();
	    			$empComm->setEmp_id($empId);
	    			$empComm->setCommunication_type_id(1);
	    			$empComm->setPhone($params['phone']);
	    			$empComm->setPhone_ext($params['phone_ext']);
	    			
	    			if (!isset($params['phone_primary'])) {
	    				
	    				$empComm->setPrimary(0);	
	    			}
	    			else {
	    				
	    				$empComm->setPrimary(1);
	    			}
	    			
	    			$empComm->setCreated($date);
		    		$empComm->setCreated_by($auth['Employee']->getEmp_id());
		    		$empComm->setLast_updated($date);
		    		$empComm->SetLast_updated_by($auth['Employee']->getEmp_id());
		    		
		    		$empCommMapper = new LLLT_Model_EmployeeCommMapper();
		    		$empCommMapper->create($empComm);
	    		}
	    	
	    		if ($params['cell_phone'] !== '') {
	    			
	    			$empComm = new LLLT_Model_EmployeeComm();
	    			$empComm->setEmp_id($empId);
	    			$empComm->setCommunication_type_id($params['communication_type_id']);
	    			$empComm->setPhone($params['cell_phone']);
	    				    			
	    			if (!isset($params['cell_phone_primary'])) {
	    				
	    				$empComm->setPrimary(0);	
	    			}
	    			else {
	    				
	    				$empComm->setPrimary(1);
	    			}	    			
	    			
	    			$empComm->setCreated($date);
		    		$empComm->setCreated_by($auth['Employee']->getEmp_id());
		    		$empComm->setLast_updated($date);
		    		$empComm->SetLast_updated_by($auth['Employee']->getEmp_id());
		    		
		    		$empCommMapper = new LLLT_Model_EmployeeCommMapper();
		    		$empCommMapper->create($empComm);
	    		}
	    		
	    		$login = new LLLT_Model_Login();
	    		$login->setEmp_id($empId);	    
				$login->setUsername($params['username']);
				$login->setPassword(md5($params['password']));
				$login->setUser_type_id($params['user_type_id']);
				$login->setCreated($date);
		    	$login->setCreated_by($auth['Employee']->getEmp_id());
		    	$login->setLast_updated($date);
		    	$login->SetLast_updated_by($auth['Employee']->getEmp_id());
		    		
	    		$loginMapper = new LLLT_Model_LoginMapper();
	    		$loginMapper->create($login); 
		    	
		    	$this->view->status = array('success' => 'The user has successfully been created.');
	    	}
	    	else {
	    		
	      		$this->view->params = $params;	    	
	    		$this->view->status = array('error' => 'The username you chose is unavailable. Please try again.');
	    	}
		}
    }
        
    /*public function modifyAction() {
    	
    	$empMapper = new LLLT_Model_EmployeeMapper();
        $emps = $empMapper->fetchAll('active = 1', array('last_name asc', 'first_name asc'));
        
        $this->view->emps = $emps;
    }*/
    
    /*public function editAction() {
    	
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender();
	    
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {
	    		    	   	
    		$params = $request->getParams();   
    		 		        		
        	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
        	$usersTable = new Zend_Db_Table('tbl_employee');					
			$data = array('first_name' => $params['fname'], 'last_name' => $params['lname']);					
			$where = $usersTable->getAdapter()->quoteInto('emp_id = ?', $params['empid']); 
			$usersTable->update($data, $where);  
		}
    }*/

   /* public function deleteAction() {
    	
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender();
	    
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {
	    		    	   	
    		$params = $request->getParams();   
    		 		        		
        	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
        	$usersTable = new Zend_Db_Table('tbl_employee');					
			$data = array('active' => 0);					
			$where = $usersTable->getAdapter()->quoteInto('emp_id = ?', $params['empid']); 
			$usersTable->update($data, $where);  
		}
    }*/
}