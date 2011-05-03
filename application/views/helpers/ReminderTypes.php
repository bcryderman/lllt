<?php

class Zend_View_Helper_Remindertypes {
	
    protected $_reminderTypes;
 
    public function remindertypes($reminderTypeId = null) {
    	
    	$reminderTypeMapper = new LLLT_Model_ReminderTypeMapper();
    	
    	if (is_null($reminderTypeId)) {
    		    		
    		$this->_reminderTypes = $reminderTypeMapper->fetchAll('active = 1', 'reminder_type asc');
    	}
    	else {
    	
    		$this->_reminderTypes = $reminderTypeMapper->find($reminderTypeId);
    	}

    	return $this->_reminderTypes; 
    }
}