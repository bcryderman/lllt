<?php

class RemindertypesController extends Zend_Controller_Action {

    public function init() {}

    public function addAction() {
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$remType = new LLLT_Model_ReminderType();
		    	$remType->setReminder_type(trim($params['reminder_type']));
		    	$remType->setActive($params['active']);
		    	$remType->setDescription(trim($params['description']));
		    	$remType->setAsset_or_employee($params['asset_or_employee']);		    	
		    	
		    	$remTypeMapper = new LLLT_Model_ReminderTypeMapper();
		    	$remTypeMapper->add($remType);
		    	
		    	$this->_redirect('remindertypes/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}

		$this->view->type = 'add';
		$this->renderScript('remindertypes/form.phtml');
    }
    
    public function deleteAction() { 
	    
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$remTypeMapper = new LLLT_Model_ReminderTypeMapper();
	    $remType = $remTypeMapper->find($params['reminder_type_id']);
	    	
    	if ($request->isPost()) {
    		
    		$remTypeMapper->delete($remType);
	    	
	    	$this->_redirect('remindertypes/view');
    	}    	
     	
    	$this->view->remType = $remType;	
    	$this->view->params = $params;
    }
    
    public function editAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$remType = new LLLT_Model_ReminderType();
		    	$remType->setReminder_type_id($params['reminder_type_id']);
		    	$remType->setReminder_type(trim($params['reminder_type']));
		    	$remType->setActive($params['active']);
		    	$remType->setDescription(trim($params['description']));
		    	$remType->setAsset_or_employee($params['asset_or_employee']);		    	
		    	
		    	$remTypeMapper = new LLLT_Model_ReminderTypeMapper();
		    	$remTypeMapper->edit($remType);
		    	
		    	$this->_redirect('remindertypes/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->reminderTypeId = $params['reminder_type_id'];
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$remTypeMapper = new LLLT_Model_ReminderTypeMapper();
	    	$remType = (array) $remTypeMapper->find($params['reminder_type_id']);
	    	    	
	    	$fields = array();
	    	
	    	foreach ($remType as $k => $v) {
	  
	    		$fields[substr($k, 4)] = $remType[$k];
	    	}
	    	
	    	$this->view->reminderTypeId = $params['reminder_type_id'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('remindertypes/form.phtml');
    }
    
    public function viewAction() {
    	
    	$remTypeMapper = new LLLT_Model_ReminderTypeMapper();
    	$remTypes = $remTypeMapper->fetchAll(null, 'reminder_type asc');
    	
    	$this->view->remTypes = $remTypes;
    }
    
    public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['reminder_type'])) {
    		
    		$errors['reminder_type'] = 'You must enter a reminder type.';
    	}
    	
    	if (strlen($params['description']) > 1000) {
    		
    		$errors['description'] = 'Description cannot exceed 1,000 characters.';
    	}
    	
    	if (empty($params['asset_or_employee'])) {
    		
    		$errors['asset_or_employee'] = 'You must choose either Asset or Employee.';
    	}
    	
    	return $errors;
    }
}