<?php

class Zend_Controller_SecureAction extends Zend_Controller_Action {
	
    public function preDispatch() {
    	
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            
        	$this->_redirect('/auth');
        }
    }

}
