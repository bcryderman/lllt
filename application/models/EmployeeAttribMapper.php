<?php

class LLLT_Model_EmployeeAttribMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_EmployeeAttrib');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_EmployeeAttrib $empAttr) {
    	    			    	
	    $data = array('emp_id'          => $empAttr->getEmp_id(),
	    			  'attrib_id'       => $empAttr->getAttrib_id(),
	    			  'value'           => $empAttr->getEnd_date(),
 	    			  'created'         => $empAttr->getCreated(),
	    			  'created_by'      => $empAttr->getCreated_by(),
	    			  'last_updated'    => $empAttr->getLast_updated(),
	    			  'last_updated_by' => $empAttr->getLast_updated_by());
	  	    	    	
	    $empId = $this->getDbTable()->insert($data);
	    
	    return $empId;
    }
    
 	public function delete(LLLT_Model_EmployeeAttrib $empAttr) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ? and attrib_id = ?', $empAttr->getEmp_id(), $empAttr->getAttrib_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_EmployeeAttrib $empAttr) {
    	
	    $data = array('emp_id'          => $empAttr->getEmp_id(),
	    			  'attrib_id'       => $empAttr->getAttrib_id(),
	    			  'value'           => $empAttr->getEnd_date(),
 	    			  'created'         => $empAttr->getCreated(),
	    			  'created_by'      => $empAttr->getCreated_by(),
	    			  'last_updated'    => $empAttr->getLast_updated(),
	    			  'last_updated_by' => $empAttr->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ? and attrib_id = ?', $empAttr->getEmp_id(), $empAttr->getAttrib_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $empAttr = new LLLT_Model_EmployeeAttrib();
            
        	$empAttr->setEmp_id($row->emp_id)        		  
	        	  	->setAttrib_id($row->attrib_id)
	        	  	->setValue($row->value)
		        	->setCreated($row->created)
		        	->setCreated_by($row->created_by)
		        	->setLast_updated($row->last_updated)
		        	->setLast_updated_by($row->last_updated_by);
                  
            $entries[] = $empAttr;            
        }
        
        return $entries;
    }
    
	public function find($empId, $attribId) {
		
        $result = $this->getDbTable()->find(array($empId, $attribId));
        
        if (0 == count($result)) {
        	
        	return 'The employee attrib could not be found.';
        }
        
        $row = $result->current();
        
        $empAttr = new LLLT_Model_EmployeeAttrib();

    	$empAttr->setEmp_id($row->emp_id)        		  
        	  	->setAttrib_id($row->attrib_id)
        	  	->setValue($row->value)
	        	->setCreated($row->created)
	        	->setCreated_by($row->created_by)
	        	->setLast_updated($row->last_updated)
	        	->setLast_updated_by($row->last_updated_by);
	        	
	    return $empAttr;
    }
}