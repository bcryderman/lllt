<?php

class LLLT_Model_EmployeeCommMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_EmployeeComm');
        }
        
        return $this->_dbTable;
    }
     
	public function add(LLLT_Model_EmployeeComm $empComm) {
		    	
    	$data = array('emp_id'                => $empComm->getEmp_id(),
    				  'communication_type_id' => $empComm->getCommunication_type_id(),
			          'phone'                 => $empComm->getPhone(),
			          'phone_ext'    		  => $empComm->getPhone_ext(),
    				  'primary'        		  => $empComm->getPrimary(),
    				  'created'        		  => $empComm->getCreated(),
    				  'created_by'     		  => $empComm->getCreated_by(),
    				  'last_updated'   	 	  => $empComm->getLast_updated(),
    				  'last_updated_by' 	  => $empComm->getLast_updated_by());
    	
    	$empId = $this->getDbTable()->insert($data);
    	
    	return $empId;
    }

 	public function delete(LLLT_Model_EmployeeComm $empComm) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ?', $empComm->getEmp_id());
			
    	$this->getDbTable()->delete($where);
    }

   	public function edit(LLLT_Model_EmployeeComm $empComm) {
    	
	    $data = array('emp_id'                => $empComm->getEmp_id(),
    				  'communication_type_id' => $empComm->getCommunication_type_id(),
			          'phone'                 => $empComm->getPhone(),
			          'phone_ext'    		  => $empComm->getPhone_ext(),
    				  'primary'        		  => $empComm->getPrimary(),
    				  'last_updated'   	 	  => $empComm->getLast_updated(),
    				  'last_updated_by' 	  => $empComm->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ?', $empComm->getEmp_id());

		$this->getDbTable()->update($data, $where);
    }

    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_EmployeeComm();
            
        	$entry->setEmp_id($row->emp_id)  
	      		  ->setCommunication_type_id($row->communication_type_id)
			 	  ->setPhone($row->phone)
				  ->setPhone_ext($row->phone_ext)
				  ->setPrimary($row->primary)
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
        	
        	return 'The employee communication could not be found.';
        }
        
        $row = $result->current();
        
        $empComm = new LLLT_Model_EmployeeComm();
        $empComm->setEmp_id($row->emp_id)  
      		    ->setCommunication_type_id($row->communication_type_id)
				->setPhone($row->phone)
				->setPhone_ext($row->phone_ext)
				->setPrimary($row->primary)
	        	->setCreated($row->created)
	        	->setCreated_by($row->created_by)
	        	->setLast_updated($row->last_updated)
		  		->setLast_updated_by($row->last_updated_by);
	        	
	    return $empComm;
    }
}