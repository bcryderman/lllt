<?php

class Zend_View_Helper_Remindertypes {
	
    protected $_reminderTypes;
 
    public function remindertypes($reminderTypeId = null) {
    	
    	$remTypeMapper = new LLLT_Model_ReminderTypeMapper();
    	
    	if (is_null($reminderTypeId)) {
    		    		
    		$this->_reminderTypes = $remTypeMapper->fetchAll('active = 1', 'reminder_type asc');
    	}
    	else {
    	
    		$this->_reminderTypes = $remTypeMapper->find($reminderTypeId);
    	}

    	return $this->_reminderTypes; 
    }
}