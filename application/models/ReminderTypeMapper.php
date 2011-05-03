<?php

class LLLT_Model_ReminderTypeMapper {
	
	protected $_dbTable;
 
    public function setDbTable($dbTable) {
    	
        if (is_string($dbTable)) {
        	
            $dbTable = new $dbTable();
        }
        
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
        	
            throw new Exception('Invalid table data gateway provided');
        }
        
        $this->_dbTable = $dbTable;
        
        return $this;
    }
 
    public function getDbTable() {
    	
        if (null === $this->_dbTable) {
        	
            $this->setDbTable('LLLT_Model_DbTable_ReminderType');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_ReminderType $reminderType) {
    	    			    	
	    $data = array('reminder_type'     => $reminderType->getReminder_type(),
				      'active'            => $reminderType->getActive(),
	    			  'description'       => $reminderType->getDescription(),
	    			  'asset_or_employee' => $reminderType->getAsset_or_employee());
	  	    	    	
	    $reminderTypeId = $this->getDbTable()
							   ->insert($data);
	    
	    return $reminderTypeId;
    }
    
    public function delete(LLLT_Model_ReminderType $reminderType) {
    	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('reminder_type_id = ?', $reminderType->getReminder_type_id());
			
    	$this->getDbTable()
			 ->delete($where);
    }
    
    public function edit(LLLT_Model_ReminderType $reminderType) {
    	
    	$data = array('reminder_type'     => $reminderType->getReminder_type(),
				      'active'            => $reminderType->getActive(),
	    			  'description'       => $reminderType->getDescription(),
	    			  'asset_or_employee' => $reminderType->getAsset_or_employee());
    	 
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('reminder_type_id = ?', $reminderType->getReminder_type_id());

		$this->getDbTable()
			 ->update($data, $where);
    }
     
    public function fetchAll($where, $order = null) {
    	
        $resultSet = $this->getDbTable()
						  ->fetchAll($where, $order);
        
        $reminderTypes = array();
        
        foreach ($resultSet as $row) {
        	
            $reminderType = new LLLT_Model_ReminderType();
            
        	$reminderType->setReminder_type_id($row->reminder_type_id)
        		  		 ->setReminder_type($row->reminder_type)
	        	  		 ->setActive($row->active)
	        	  		 ->setDescription($row->description)
	        	  		 ->setAsset_or_employee($row->asset_or_employee);
                  
            $reminderTypes[] = $reminderType;            
        }
        
        return $reminderTypes;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()
					   ->find($id);
        
        if (0 == count($result)) {
        	
            return 'The reminder type could not be found.';
        }
        
        $row = $result->current();
        
        $reminderType = new LLLT_Model_ReminderType();

        $reminderType->setReminder_type_id($row->reminder_type_id)
        			 ->setReminder_type($row->reminder_type)
	        		 ->setActive($row->active)
	        		 ->setDescription($row->description)
	        		 ->setAsset_or_employee($row->asset_or_employee);
	        	
	    return $reminderType;
    }
}