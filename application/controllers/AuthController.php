<?php

class AuthController extends Zend_Controller_Action {

    public function init() { }

    public function indexAction() { 
    		    
    	$this->_helper->layout->setLayout('public');
    	
    	$request = $this->getRequest();
    	     	
	    if ($request->isPost()) {
	    		   	
	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);
	    	
	    	if (empty($errors)) {
	    		
	    		$login = new LLLT_Model_Login();
	
				$login->setUsername($params['username'])
					  ->setPassword($params['password']);
	
		    	$loginMapper = new LLLT_Model_LoginMapper();
		
		    	$authResult = $loginMapper->auth($login);
	
		    	if ($authResult === true) {
	
		    		$this->_redirect('/'); 
		    	}
		    	
		    	$this->view->error = $authResult;
	    	}
	    	else {
	    		
	    		$this->view->errors = $errors;
	    	}	    	 	  
	  				
			$this->view->params = $params;	
		}	
		else {
			
			$auth = Zend_Auth::getInstance();
			
			if ($auth->hasIdentity()) {
			    
				$this->_redirect('/');
			}
		}	
    }
    
    public function logoutAction() {  

    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender();
	    
    	Zend_Auth::getInstance()->clearIdentity();  
    	
    	$this->_redirect('auth');  
	}         

	public function validation($params) {
		
		$errors = array();
	    	
    	if (empty($params['username'])) {
    		
    		$errors['username'] = 'You must enter a username.';
    	}
    	
    	if (empty($params['password'])) {
    		
    		$errors['password'] = 'You must enter a password.';
    	}
    	
    	return $errors;
	}
}