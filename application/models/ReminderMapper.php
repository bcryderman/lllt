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
	  	    	    	
	    $reminderId = $this->getDbTable()
						   ->insert($data);
	    
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
	  	    	    	
	    $reminderId = $this->getDbTable()
						   ->insert($data);
	    
	    return $reminderId;
    }
    
    public function delete($id) {
    	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('reminder_id = ?', $id);
			
    	$this->getDbTable()
			 ->delete($where);
    }
    
    public function edit(LLLT_Model_Reminder $reminder) {
    	
    	$data = array('reminder_type_id' => $reminder->getReminder_type_id(),
				      'asset_id'         => $reminder->getAsset_id(),
	    			  'due_date'         => $reminder->getDue_date(),
	    			  'completed_date'   => $reminder->getCompleted_date(),
	    			  'notes'            => $reminder->getNotes(),
	    			  'last_updated'     => $reminder->getLast_updated(),
	    			  'last_updated_by'  => $reminder->getLast_updated_by());
    	 
		$where = $this->getDbTable()
				      ->getAdapter()
					  ->quoteInto('reminder_id = ?', $reminder->getReminder_id());

		$this->getDbTable()
			 ->update($data, $where);
    }
     
    public function fetchAll($where, $order) {
    	
		$sql = 'SELECT tbl_reminder.*, tbl_reminder_type.reminder_type, tbl_asset.asset_name, tbl_asset_type.asset_type
				FROM tbl_reminder
				LEFT JOIN tbl_reminder_type ON tbl_reminder.reminder_type_id = tbl_reminder_type.reminder_type_id
				LEFT JOIN tbl_asset ON tbl_reminder.asset_id = tbl_asset.asset_id 
				LEFT JOIN tbl_asset_type ON tbl_asset.asset_type_id = tbl_asset_type.asset_type_id';
				
		if (!is_null($where)) {
			
			$sql .= ' WHERE ' . $where;
		}
		
		if (!is_null($order)) {
			
			$sql .= ' ORDER BY ' . $order;
		}
		
		$stmt = $this->getDbTable()
					 ->getAdapter()
					 ->query($sql);
		
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$resultSet = $stmt->fetchAll();
        
        $reminders = array();
        
        foreach ($resultSet as $row) {
        	
            $reminder = new LLLT_Model_Reminder();
        	$reminder->setReminder_id($row->reminder_id)
	        	  	 ->setReminder_type_id($row->reminder_type_id)
					 ->setReminder_type($row->reminder_type)
					 ->setAsset_type($row->asset_type)
	        	  	 ->setAsset_id($row->asset_id)
					 ->setAsset_name($row->asset_name)
	        	  	 ->setEmployee_id($row->employee_id)
		        	 ->setDue_date($row->due_date, true)
		        	 ->setCompleted_date($row->completed_date, true)
		        	 ->setNotes($row->notes)
		        	 ->setCreated($row->created)
		        	 ->setCreated_by($row->created_by)
		        	 ->setLast_updated($row->last_updated)
		        	 ->setLast_updated_by($row->last_updated_by);
                  
            $reminders[] = $reminder;            
        }
        
        return $reminders;
    }
    
	public function find($id) {
		
		$sql = 'SELECT tbl_reminder.*, tbl_reminder_type.reminder_type, tbl_asset.asset_name, tbl_asset_type.asset_type
				FROM tbl_reminder
				LEFT JOIN tbl_reminder_type ON tbl_reminder.reminder_type_id = tbl_reminder_type.reminder_type_id
				LEFT JOIN tbl_asset ON tbl_reminder.asset_id = tbl_asset.asset_id 
				LEFT JOIN tbl_asset_type ON tbl_asset.asset_type_id = tbl_asset_type.asset_type_id
				WHERE tbl_reminder.reminder_id = ' . $id;

		$this->getDbTable()
			 ->getAdapter()
			 ->setFetchMode(Zend_Db::FETCH_OBJ);

		$row = $this->getDbTable()
					->getAdapter()
					->fetchRow($sql);
        
        if (0 == count($row)) {
        	
            return 'The reminder could not be found.';
        }
                
		$reminder = new LLLT_Model_Reminder();
    	$reminder->setReminder_id($row->reminder_id)
        	  	 ->setReminder_type_id($row->reminder_type_id)
				 ->setReminder_type($row->reminder_type)
				 ->setAsset_type($row->asset_type)
        	  	 ->setAsset_id($row->asset_id)
				 ->setAsset_name($row->asset_name)
        	  	 ->setEmployee_id($row->employee_id)
	        	 ->setDue_date($row->due_date, true)
	        	 ->setCompleted_date($row->completed_date, true)
	        	 ->setNotes($row->notes)
	        	 ->setCreated($row->created)
	        	 ->setCreated_by($row->created_by)
	        	 ->setLast_updated($row->last_updated)
	        	 ->setLast_updated_by($row->last_updated_by);
	        	
	    return $reminder;
    }
}