<?php

class RemindersController extends Zend_Controller_Action {

    public function init() {
	
		$this->view->title = 'Reminders';
	}

    public function addAction() {
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');
		    			    	
		    	$reminder = new LLLT_Model_Reminder();
		    	$reminder->setReminder_type_id($params['reminder_type_id']);
		    	$reminder->setAsset_id($params['asset_id']);
		    	$reminder->setEmployee_id($auth['Employee']->getEmp_id());
		    	$reminder->setDue_date(date('Y-m-d', strtotime($params['due_date'])));
		    	$reminder->setCompleted_date(date('Y-m-d', strtotime($params['completed_date'])));
		    	$reminder->setNotes($params['notes']);	
		    	$reminder->setCreated($date);
	    		$reminder->setCreated_by($auth['Employee']->getEmp_id());
	    		$reminder->setLast_updated($date);
	    		$reminder->setLast_updated_by($auth['Employee']->getEmp_id());
	    		
		    	$reminderMapper = new LLLT_Model_ReminderMapper();
		    	$reminderMapper->add($reminder);
		    	
		    	$this->_redirect('reminders/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}
    
    	$this->view->type = 'add';
    	$this->renderScript('reminders/form.phtml');
    }
    
	public function copyAction() {
    
		$request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');

	    		$reminder = new LLLT_Model_Reminder();
	    		$reminder->setReminder_type_id($params['reminder_type_id']);
		    	$reminder->setAsset_id($params['asset_id']);
		    	$reminder->setEmployee_id($auth['Employee']->getEmp_id());
		    	$reminder->setDue_date(date('Y-m-d', strtotime($params['due_date'])));
		    	$reminder->setCompleted_date(date('Y-m-d', strtotime($params['completed_date'])));
		    	$reminder->setNotes($params['notes']);	
		    	$reminder->setCreated($date);
	    		$reminder->setCreated_by($auth['Employee']->getEmp_id());
	    		$reminder->setLast_updated($date);
	    		$reminder->setLast_updated_by($auth['Employee']->getEmp_id());	    	
		    	
		    	$reminderMapper = new LLLT_Model_ReminderMapper();
		    	$reminderMapper->copy($reminder);
		    	
		    	$this->_redirect('reminders/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;	
		    	$this->view->type = 'copy';	    	
		    }
		}		
    	else {
    		
	    	$reminderMapper = new LLLT_Model_ReminderMapper();
	    	$reminder = (array) $reminderMapper->find($params['reminder_id']);
	    	    	
	    	$fields = array();
	    	
	    	foreach ($reminder as $k => $v) {
	  
	    		$fields[substr($k, 4)] = $reminder[$k];
	    	}
	    	
	    	$this->view->reminderId = $params['reminder_id'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'copy';
    	}    	

    	$this->renderScript('reminders/form.phtml');
    }
    
	public function deleteAction() {
		    
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$reminderMapper = new LLLT_Model_ReminderMapper();
	    $reminder = $reminderMapper->find($params['reminder_id']);
	    	
    	if ($request->isPost()) {
    		
    		$reminderMapper->delete($reminder);
	    	
	    	$this->_redirect('reminders/view');
    	}    	
     	
    	$this->view->reminder = $reminder;	
    	$this->view->params = $params;
	}
    
    public function editAction() {
    
		$request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');

	    		$reminder = new LLLT_Model_Reminder();
	    		$reminder->setReminder_id($params['reminder_id']);
	    		$reminder->setReminder_type_id($params['reminder_type_id']);
		    	$reminder->setAsset_id($params['asset_id']);
		    	$reminder->setDue_date(date('Y-m-d', strtotime($params['due_date'])));
		    	$reminder->setCompleted_date(date('Y-m-d', strtotime($params['completed_date'])));
		    	$reminder->setNotes($params['notes']);	
	    		$reminder->setLast_updated($date);
	    		$reminder->setLast_updated_by($auth['Employee']->getEmp_id());	    	
		    	
		    	$reminderMapper = new LLLT_Model_ReminderMapper();
		    	$reminderMapper->edit($reminder);
		    	
		    	$this->_redirect('reminders/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->reminderId = $params['reminder_id'];
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$reminderMapper = new LLLT_Model_ReminderMapper();
	    	$reminder = (array) $reminderMapper->find($params['reminder_id']);
	    	    	
	    	$fields = array();
	    	
	    	foreach ($reminder as $k => $v) {
	  
	    		$fields[substr($k, 4)] = $reminder[$k];
	    	}
	    	
	    	$this->view->reminderId = $params['reminder_id'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('reminders/form.phtml');
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

		$auth = Zend_Auth::getInstance()->getIdentity();

    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('employee_id = ' . $auth['Employee']->getEmp_id(), 
											   array($params['column'] . ' ' . $params['sort'], 'due_date asc'));

    	$this->view->reminders = $reminders;

		$this->renderScript('reminders/tabulardata.phtml');
	}
            
    public function viewAction() {
    	
    	$auth = Zend_Auth::getInstance()->getIdentity(); 
    	
    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('employee_id = ' . $auth['Employee']->getEmp_id(),
											   array('due_date asc', 'reminder_type asc'));
    	  	
    	$this->view->reminders = $reminders;
    }
    
	public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['reminder_type_id'])) {
    		
    		$errors['reminder_type_id'] = 'You must select a reminder type.';
    	}
    	
		if (empty($params['asset_id'])) {
    		
    		$errors['asset_id'] = 'You must select an asset type.';
    	}
    	    	
		if (empty($params['due_date'])) {
    		
    		$errors['due_date'] = 'You must enter a due date.';
    	}
    	else if (!is_int((int) substr($params['due_date'], 0, 2)) || 
				 !is_int((int) substr($params['due_date'], 3, 2)) || 
				 !is_int((int) substr($params['due_date'], 6, 4)) ||    			 
    			 !checkdate((int) substr($params['due_date'], 0, 2), (int) substr($params['due_date'], 3, 2), (int) substr($params['due_date'], 6, 4))) {
    		
    		$errors['due_date'] = 'The date you entered is formatted incorrectly.';    		
    	}
    	    	
		if (!empty($params['completed_date']) && 
			(!is_int((int) substr($params['completed_date'], 0, 2)) || 
			 !is_int((int) substr($params['completed_date'], 3, 2)) || 
			 !is_int((int) substr($params['completed_date'], 6, 4)) ||    			 
    		 !checkdate((int) substr($params['completed_date'], 0, 2), (int) substr($params['completed_date'], 3, 2), (int) substr($params['completed_date'], 6, 4)))) {
    		
    		$errors['completed_date'] = 'The date you entered is formatted incorrectly.';    		
    	}
    	
    	if (strlen($params['notes']) > 1000) {
    		
    		$errors['notes'] = 'Notes cannot exceed 1,000 characters.';
    	}
    	
    	return $errors;
    }
}