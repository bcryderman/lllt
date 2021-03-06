<?php

class IndexController extends Zend_Controller_SecureAction {

    public function init() {
	
		$this->view->title = 'Home';
	}

    public function indexAction() {
    
    	$auth = Zend_Auth::getInstance()->getIdentity(); 
    	
    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('employee_id = ' . $auth['Employee']->getEmp_id(), 
											   'tbl_reminder.due_date asc', 'tbl_reminder.reminder_type asc');

    	$this->view->reminders = $reminders;
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

		$auth = Zend_Auth::getInstance()->getIdentity();

    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('employee_id = ' . $auth['Employee']->getEmp_id(), 
											   $params['column'] . ' ' . $params['sort'] . ', tbl_reminder.due_date asc');

    	$this->view->reminders = $reminders;

		$this->renderScript('index/tabulardata.phtml');
	}
}

