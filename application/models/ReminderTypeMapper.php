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
    
    public function add(LLLT_Model_ReminderType $remType) {
    	    			    	
	    $data = array('reminder_type'     => $remType->getReminder_type(),
				      'active'            => $remType->getActive(),
	    			  'description'       => $remType->getDescription(),
	    			  'asset_or_employee' => $remType->getAsset_or_employee());
	  	    	    	
	    $remTypeId = $this->getDbTable()->insert($data);
	    
	    return $remTypeId;
    }
    
    public function delete(LLLT_Model_ReminderType $remType) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('reminder_type_id = ?', $remType->getReminder_type_id());
			
    	$this->getDbTable()->delete($where);
    }
    
    public function edit(LLLT_Model_ReminderType $remType) {
    	
    	$data = array('reminder_type'     => $remType->getReminder_type(),
				      'active'            => $remType->getActive(),
	    			  'description'       => $remType->getDescription(),
	    			  'asset_or_employee' => $remType->getAsset_or_employee());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('reminder_type_id = ?', $remType->getReminder_type_id());

		$this->getDbTable()->update($data, $where);
    }
     
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_ReminderType();
            
        	$entry->setReminder_type_id($row->reminder_type_id)
        		  ->setReminder_type($row->reminder_type)
	        	  ->setActive($row->active)
	        	  ->setDescription($row->description)
	        	  ->setAsset_or_employee($row->asset_or_employee);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
            return 'The reminder type could not be found.';
        }
        
        $row = $result->current();
        
        $remType = new LLLT_Model_ReminderType();
        $remType->setReminder_type_id($row->reminder_type_id)
        		->setReminder_type($row->reminder_type)
	        	->setActive($row->active)
	        	->setDescription($row->description)
	        	->setAsset_or_employee($row->asset_or_employee);
	        	
	    return $remType;
    }
}