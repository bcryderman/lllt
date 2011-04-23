<?php

class Zend_View_Helper_ReminderTypes {
	
    protected $_reminderTypes;
 
    public function reminderTypes() {
    	
    	$remTypeMapper = new LLLT_Model_ReminderTypeMapper();
    	$this->_reminderTypes = $remTypeMapper->fetchAll('active = 1', 'reminder_type asc');

    	return $this->_reminderTypes; 
    }
}