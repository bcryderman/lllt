<?php

class LLLT_Model_ReminderMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Reminder');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_Reminder $reminder) {
    	    			    	
	    $data = array('reminder_type_id' => $reminder->getReminder_type_id(),
				      'asset_id'         => $reminder->getAsset_id(),
	    			  'employee_id'      => $reminder->getEmployee_id(),
	    			  'due_date'         => $reminder->getDue_date(),
	    			  'completed_date'   => $reminder->getCompleted_date(),
	    			  'notes'            => $reminder->getNotes(),
	    			  'created'          => $reminder->getCreated(),
	    			  'created_by'       => $reminder->getCreated_by(),
	    			  'last_updated'     => $reminder->getLast_updated(),
	    			  'last_updated_by'  => $reminder->getLast_updated_by());
	  	    	    	
	    $reminderId = $this->getDbTable()->insert($data);
	    
	    return $reminderId;
    }
    
    public function copy(LLLT_Model_Reminder $reminder) {
    	    			    	
	    $data = array('reminder_type_id' => $reminder->getReminder_type_id(),
	    			  'asset_id'         => $reminder->getAsset_id(),
	    			  'employee_id'      => $reminder->getEmployee_id(),
	    			  'due_date'         => $reminder->getDue_date(),
	    			  'completed_date'   => $reminder->getCompleted_date(),
	    			  'notes'            => $reminder->getNotes(),
	    			  'created'          => $reminder->getCreated(),
	    			  'created_by'       => $reminder->getCreated_by(),
	    			  'last_updated'     => $reminder->getLast_updated(),
	    			  'last_updated_by'  => $reminder->getLast_updated_by());
	  	    	    	
	    $reminderId = $this->getDbTable()->insert($data);
	    
	    return $reminderId;
    }
    
    public function delete(LLLT_Model_Reminder $reminder) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('reminder_id = ?', $reminder->getReminder_id());
			
    	$this->getDbTable()->delete($where);
    }
    
    public function edit(LLLT_Model_Reminder $reminder) {
    	
    	$data = array('reminder_type_id' => $reminder->getReminder_type_id(),
				      'asset_id'         => $reminder->getAsset_id(),
	    			  'due_date'         => $reminder->getDue_date(),
	    			  'completed_date'   => $reminder->getCompleted_date(),
	    			  'notes'            => $reminder->getNotes(),
	    			  'last_updated'     => $reminder->getLast_updated(),
	    			  'last_updated_by'  => $reminder->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('reminder_id = ?', $reminder->getReminder_id());

		$this->getDbTable()->update($data, $where);
    }
     
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_Reminder();
            
        	$entry->setReminder_id($row->reminder_id)
	        	  ->setReminder_type_id($row->reminder_type_id)
	        	  ->setAsset_id($row->asset_id)
	        	  ->setEmployee_id($row->employee_id)
	        	  ->setDue_date($row->due_date)
	        	  ->setCompleted_date($row->completed_date)
	        	  ->setNotes($row->notes)
	        	  ->setCreated($row->created)
	        	  ->setCreated_by($row->created_by)
	        	  ->setLast_updated($row->last_updated)
	        	  ->setLast_updated_by($row->last_updated_by);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
            return 'The reminder could not be found.';
        }
        
        $row = $result->current();
        
        $reminder = new LLLT_Model_Reminder();
        $reminder->setReminder_id($row->reminder_id);
	    $reminder->setReminder_type_id($row->reminder_type_id);
	    $reminder->setAsset_id($row->asset_id);
	    $reminder->setEmployee_id($row->employee_id);
	    $reminder->setDue_date($row->due_date);
	    $reminder->setCompleted_date($row->completed_date);
	    $reminder->setNotes($row->notes);	
	    $reminder->setCreated($row->created);
    	$reminder->setCreated_by($row->created_by);
    	$reminder->setLast_updated($row->last_updated);
    	$reminder->setLast_updated_by($row->last_updated_by);
	        	
	    return $reminder;
    }
}