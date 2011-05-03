<?php

class RemindertypesController extends Zend_Controller_Action {

    public function init() {
	
		$this->view->title = 'Reminder Types';
	}

    public function addAction() {
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$reminderType = new LLLT_Model_ReminderType();
		    	$reminderType->setReminder_type(trim($params['reminder_type']));
		    	$reminderType->setActive($params['active']);
		    	$reminderType->setDescription(trim($params['description']));
		    	$reminderType->setAsset_or_employee($params['asset_or_employee']);		    	
		    	
		    	$reminderTypeMapper = new LLLT_Model_ReminderTypeMapper();
		    	$reminderTypeMapper->add($reminderType);
		    	
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
    	
    	$reminderTypeMapper = new LLLT_Model_ReminderTypeMapper();
	    $reminderType = $reminderTypeMapper->find($params['reminder_type_id']);
	    	
    	if ($request->isPost()) {
    		
    		$reminderTypeMapper->delete($reminderType);
	    	
	    	$this->_redirect('remindertypes/view');
    	}    	
     	
    	$this->view->reminderType = $reminderType;	
    	$this->view->params = $params;
    }
    
    public function editAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$reminderType = new LLLT_Model_ReminderType();
		    	$reminderType->setReminder_type_id($params['reminder_type_id']);
		    	$reminderType->setReminder_type(trim($params['reminder_type']));
		    	$reminderType->setActive($params['active']);
		    	$reminderType->setDescription(trim($params['description']));
		    	$reminderType->setAsset_or_employee($params['asset_or_employee']);		    	
		    	
		    	$reminderTypeMapper = new LLLT_Model_ReminderTypeMapper();
		    	$reminderTypeMapper->edit($reminderType);
		    	
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
    		
	    	$reminderTypeMapper = new LLLT_Model_ReminderTypeMapper();
	    	$reminderType = (array) $reminderTypeMapper->find($params['reminder_type_id']);
	    	    	
	    	$fields = array();
	    	
	    	foreach ($reminderType as $k => $v) {
	  
	    		$fields[substr($k, 4)] = $reminderType[$k];
	    	}
	    	
	    	$this->view->reminderTypeId = $params['reminder_type_id'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('remindertypes/form.phtml');
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

		$reminderTypeMapper = new LLLT_Model_ReminderTypeMapper();
    	$reminderTypes = $reminderTypeMapper->fetchAll(null, array($params['column'] . ' ' . $params['sort'],
																   'reminder_type ' . $params['sort']));
    	
    	$this->view->reminderTypes = $reminderTypes;

		$this->renderScript('remindertypes/tabulardata.phtml');
	}
    
    public function viewAction() {
    	
    	$reminderTypeMapper = new LLLT_Model_ReminderTypeMapper();
    	$reminderTypes = $reminderTypeMapper->fetchAll(null, 'reminder_type asc');
    	
    	$this->view->reminderTypes = $reminderTypes;
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