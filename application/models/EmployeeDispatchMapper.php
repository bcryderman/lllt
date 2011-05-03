<?php

class LLLT_Model_EmployeeDispatchMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_EmployeeDispatch');
        }
        
        return $this->_dbTable;
    }

    public function add(LLLT_Model_EmployeeDispatch $empDispatch) {
    	    			    	
	    $data = array('emp_id'        => $empDispatch->getEmp_id(),
	    			  'load_id'       => $empDispatch->getAttrib_id(),
	    			  'dispatch_date' => $empDispatch->getEnd_date());
	  	    	    	
	    $empId = $this->getDbTable()->insert($data);
	    
	    return $empId;
    }
    
 	public function delete(LLLT_Model_EmployeeDispatch $empDispatch) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ? and load_id = ?', $empDispatch->getEmp_id(), $empDispatch->getLoad_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_EmployeeDispatch $empDispatch) {
    	
	    $data = array('emp_id'        => $empDispatch->getEmp_id(),
	    			  'load_id'       => $empDispatch->getAttrib_id(),
	    			  'dispatch_date' => $empDispatch->getEnd_date());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ? and load_id = ?', $empDispatch->getEmp_id(), $empDispatch->getLoad_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $empDispatch = new LLLT_Model_EmployeeDispatch();
            
        	$empDispatch->setEmp_id($row->emp_id)        		  
	        	  		->setLoad_id($row->load_id)
	        	  		->setDispatch_date($row->dispatch_date);
                  
            $entries[] = $empDispatch;            
        }
        
        return $entries;
    }
    
	public function find($empId, $loadId) {
		
        $result = $this->getDbTable()->find(array($empId, $loadId));
        
        if (0 == count($result)) {
        	
        	return 'The employee dispatch could not be found.';
        }
        
        $row = $result->current();
        
        $empDispatch = new LLLT_Model_EmployeeDispatch();
            
        $empDispatch->setEmp_id($row->emp_id)        		  
	        	  	->setLoad_id($row->load_id)
	        	  	->setDispatch_date($row->dispatch_date);
	        	
	    return $empDispatch;
    }
}