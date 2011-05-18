<?php

class MyaccountController extends Zend_Controller_SecureAction {

    public function init() { 
	
		$this->view->title = 'My Account';
	}

	public function changepassAction() {
		
		$request = $this->getRequest();
    	
	    if ($request->isPost()) {
	    		    	   	
    		$params = $request->getParams(); 
    		
    		$errors = $this->validation($params);
	    	
	    	if (empty($errors)) {
	    		
	    		if ($params['newpass'] !== $params['confnewpass']) {
	    			
	    			$this->view->error = 'The new password and confirmation password do not match.';
	    		}
	    		else {
		    						        	    	
			        $auth = Zend_Auth::getInstance();        	
			        $identity = $auth->getIdentity();
			        	          	
				    if ($identity['Login']->getPassword() === md5($params['password'])) {
				       
			        	$login = new LLLT_Model_Login();
						$login->setEmp_id($identity['Login']->getEmp_id())
							  ->setPassword(md5($params['newpass']))
							  ->setLast_updated(date('Y-m-d H:i:s'))
							  ->setLast_updated_by($identity['Login']->getEmp_id());
			        		     			
			   			$loginMapper = new LLLT_Model_LoginMapper();
			   			$loginMapper->changePassword($login);
						
			   			$this->_redirect('auth/logout');
				    }        
					else {
		
						$this->view->error = 'The current password you entered is incorrect.';	
				    } 
	    		}   			
	    	}
			
			$this->view->errors = $errors;
		    $this->view->params = $params;		
		}
	}
	
	public function validation($params) {
		
		$errors = array();
	    	    	
    	if (empty($params['password'])) {
    		
    		$errors['password'] = 'You must enter a password.';
    	}
    	
		if (empty($params['newpass'])) {
    		
    		$errors['newpass'] = 'You must enter a new password.';
    	}
    	
		if (empty($params['confnewpass'])) {
    		
    		$errors['confnewpass'] = 'You must confirm your new password.';
    	}
    	
    	return $errors;
	}
}