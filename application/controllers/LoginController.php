<?php

class LoginController extends Zend_Controller_Action {

    public function init() { }

    public function indexAction() { 
    		    
    	$this->_helper->layout->setLayout('noauth');
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {
	    		   	
	    	$params = $request->getParams();
	    	
	    	$login = new LLLT_Model_Login($params);
	    	$loginMapper = new LLLT_Model_LoginMapper();
	    	$authResult = $loginMapper->auth($login);

	    	if ($authResult === true) {

	    		$this->_redirect('/index'); 
	    	}
	    	
	    	$this->view->error = $authResult;	 	    				
		}		
    }
    
    public function logoutAction() {  

    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender();
    	Zend_Auth::getInstance()->clearIdentity();  
    	
    	$this->_redirect('/index');  
	}           
}