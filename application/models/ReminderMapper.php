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
    	
		if ($where === null) {
			
			$resultSet = $this->getDbTable()
							  ->fetchAll($this->getDbTable()
											  ->select()
											  ->setIntegrityCheck(false)
											  ->from(array('r' => 'tbl_reminder'))											
											  ->order($order)
											  ->join(array('rt' => 'tbl_reminder_type'),
													 'r.reminder_type_id = rt.reminder_type_id',
													 array('reminder_type'))
											  ->join(array('a' => 'tbl_asset'),
													 'r.asset_id = a.asset_id',
													 array('asset_name'))
											  ->join(array('at' => 'tbl_asset_type'),
													 'a.asset_type_id = at.asset_type_id',
													 array('asset_type')));
		}
		else {
			
			$resultSet = $this->getDbTable()
							  ->fetchAll($this->getDbTable()
											  ->select()
											  ->setIntegrityCheck(false)
											  ->from(array('r' => 'tbl_reminder'))
											  ->where($where)
											  ->order($order)
											  ->join(array('rt' => 'tbl_reminder_type'),
													 'r.reminder_type_id = rt.reminder_type_id',
													 array('reminder_type'))
											  ->join(array('a' => 'tbl_asset'),
													 'r.asset_id = a.asset_id',
													 array('asset_name'))
											  ->join(array('at' => 'tbl_asset_type'),
													 'a.asset_type_id = at.asset_type_id',
													 array('asset_type')));
		}
        
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
		
        $result = $this->getDbTable()
					   ->fetchRow($this->getDbTable()
									   ->select()
									   ->setIntegrityCheck(false)
									   ->from(array('r' => 'tbl_reminder'))
									   ->where('reminder_id = ?', $id)	
									   ->join(array('rt' => 'tbl_reminder_type'),
											  'r.reminder_type_id = rt.reminder_type_id',
										      array('reminder_type'))
									   ->join(array('a' => 'tbl_asset'),
											  'r.asset_id = a.asset_id',
											  array('asset_name'))
									   ->join(array('at' => 'tbl_asset_type'),
											  'a.asset_type_id = at.asset_type_id',
											  array('asset_type')));
        
        if (0 == count($result)) {
        	
            return 'The reminder could not be found.';
        }
                
		$reminder = new LLLT_Model_Reminder();
    	$reminder->setReminder_id($result->reminder_id)
        	  	 ->setReminder_type_id($result->reminder_type_id)
				 ->setReminder_type($result->reminder_type)
				 ->setAsset_type($result->asset_type)
        	  	 ->setAsset_id($result->asset_id)
				 ->setAsset_name($result->asset_name)
        	  	 ->setEmployee_id($result->employee_id)
	        	 ->setDue_date($result->due_date, true)
	        	 ->setCompleted_date($result->completed_date, true)
	        	 ->setNotes($result->notes)
	        	 ->setCreated($result->created)
	        	 ->setCreated_by($result->created_by)
	        	 ->setLast_updated($result->last_updated)
	        	 ->setLast_updated_by($result->last_updated_by);
	        	
	    return $reminder;
    }
}