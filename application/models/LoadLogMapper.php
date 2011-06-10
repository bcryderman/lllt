<?php

class LLLT_Model_LoadLogMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_LoadLog');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_LoadLog $loadLog) {
		
	    $data = array('load_id'               => $loadLog->getLoad_id(),
	    			  'load_activity_type_id' => $loadLog->getLoad_activity_type_id(),
	    			  'activity_time'         => $loadLog->getActivity_time(),
					  'activity_by'           => $loadLog->getActivity_by());
	  	    	    	
	    $loadLog = $this->getDbTable()->insert($data);
	    
	    return $loadLog;
    }
    
 	public function delete(LLLT_Model_LoadLog $loadLog) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('load_id = ?', $loadLog->getLoad_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_LoadLog $loadLog) {
    	
	    $data = array('load_id'               => $loadLog->getLoad_id(),
	    			  'load_activity_type_id' => $loadLog->getLoad_activity_type_id(),
	    			  'activity_time'         => $loadLog->getActivity_time(),
					  'activity_by'           => $loadLog->getActivity_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('load_id = ?', $loadLog->getLoad_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $loadLog = new LLLT_Model_LoadLog();
            
        	$loadLog->setLoad_id($row->load_id)
					->setLoad_activity_type_id($row->load_activity_type_id)
					->setActivity_time($row->activity_time)
					->setActivity_by($row->activity_by);
                  
            $entries[] = $loadLog;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The load log could not be found.';
        }
        
        $row = $result->current();
        
        $loadLog = new LLLT_Model_LoadLog();
        
    	$loadLog->setLoad_id($row->load_id)
				->setLoad_activity_type_id($row->load_activity_type_id)
				->setActivity_time($row->activity_time)
				->setActivity_by($row->activity_by);
	        	
	    return $loadLogs;
    }
}