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
		    }
		}		
    	else {
    		
	    	$reminderMapper = new LLLT_Model_ReminderMapper();
	    	$reminder = (array) $reminderMapper->find($params['reminder_id']);
	    	    	
			$object2Array = new LLLT_Model_Object2Array();
			$object2Array->setFields($reminder);
	    	
	    	$this->view->params = $object2Array->getFields();  
    	}  
  	
		$this->view->type = 'copy';

    	$this->renderScript('reminders/form.phtml');
    }
    
	public function deleteAction() {
		    
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$reminderMapper = new LLLT_Model_ReminderMapper();
	    	
    	if ($request->isPost()) {
    		
    		$reminderMapper->delete($params['reminder_id']);
	    	
	    	$this->_redirect('reminders/view');
    	}    	
		else {
			
			$reminder = $reminderMapper->find($params['reminder_id']);
			
			$this->view->reminder = $reminder;	
	    	$this->view->params = $params;
		}
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
		    	$this->view->params = $params;	
		    }
		}		
    	else {
    		
	    	$reminderMapper = new LLLT_Model_ReminderMapper();
	    	$reminder = (array) $reminderMapper->find($params['reminder_id']);
	    	    	
			$object2Array = new LLLT_Model_Object2Array();
			$object2Array->setFields($reminder);
	    	
	    	$this->view->params = $object2Array->getFields();  
    	}   

 		$this->view->type = 'edit';

    	$this->renderScript('reminders/form.phtml');
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

		$auth = Zend_Auth::getInstance()->getIdentity();

    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('tbl_reminder.employee_id = ' . $auth['Employee']->getEmp_id(), 
											   $params['column'] . ' ' . $params['sort'] . ', tbl_reminder.due_date asc');

    	$this->view->reminders = $reminders;

		$this->renderScript('reminders/tabulardata.phtml');
	}
            
    public function viewAction() {
    	
    	$auth = Zend_Auth::getInstance()->getIdentity(); 
    	
    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('tbl_reminder.employee_id = ' . $auth['Employee']->getEmp_id(), 
											   'tbl_reminder.due_date asc, tbl_reminder_type.reminder_type asc');
    	  	
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

		if (!empty($params['due_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['due_date']));
			
			if (!$date->isValid()) {
				
				$errors['due_date'] = 'Due Date is formatted incorrectly or an invalid date.';
			}
		}
    	 
   		if (!empty($params['completed_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['completed_date']));
			
			if (!$date->isValid()) {
				
				$errors['completed_date'] = 'Completed Date is formatted incorrectly or an invalid date.';
			}
		}
    	
    	if (!empty($params['notes']) && strlen($params['notes']) > 1000) {
    		
    		$errors['notes'] = 'Notes cannot exceed 1,000 characters.';
    	}
    	
    	return $errors;
    }
}