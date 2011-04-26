<?php

class LLLT_Model_LoadActivityTypeMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_LoadActivityType');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_LoadActivityType $loadActivityType) {
		
	    $data = array('load_activity' => $loadActivityType->getLoad_activity(),
	    			  'active'        => $loadActivityType->getActivity(),
	    			  'description'   => $loadActivityType->getDescription());
	  	    	    	
	    $loadActivityTypeId = $this->getDbTable()->insert($data);
	    
	    return $loadActivityTypeId;
    }
    
 	public function delete(LLLT_Model_LoadActivityType $loadActivityType) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('load_activity_type_id = ?', $loadActivityType->getLoad_activity_type_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_LoadActivityType $loadActivityType) {
    	
		$data = array('load_activity_type_id' => $loadActivityType->getLoad_activity_type_id(),
					  'load_activity'         => $loadActivityType->getLoad_activity(),
		    		  'active'                => $loadActivityType->getActivity(),
		    	 	  'description'           => $loadActivityType->getDescription());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('load_activity_type_id = ?', $loadActivityType->getLoad_activity_type_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $loadActivityType = new LLLT_Model_LoadActivityType();
            
        	$loadActivityType->setLoad_activity_type_id($row->load_activity_type_id)
        		  			 ->setLoad_activity($row->load_activity)
							 ->setActive($row->active)
							 ->setDescription($row->description);
                  
            $entries[] = $loadActivityType;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The load activity type could not be found.';
        }
        
        $row = $result->current();
        
		$loadActivityType = new LLLT_Model_LoadActivityType();
        
    	$loadActivityType->setLoad_activity_type_id($row->load_activity_type_id)
    		  			 ->setLoad_activity($row->load_activity)
						 ->setActive($row->active)
						 ->setDescription($row->description);
	        	
	    return $loadActivityType;
    }
}