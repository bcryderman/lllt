<?php

class IndexController extends Zend_Controller_SecureAction {

    public function init() {}

    public function indexAction() {
    
    	$auth = Zend_Auth::getInstance()->getIdentity(); 
    	
    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('employee_id = ' . $auth['Employee']->getEmp_id(), 'due_date ASC');
    	
    	$this->view->reminders = $reminders;
    }
}

