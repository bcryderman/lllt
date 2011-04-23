<?php

class LLLT_Model_EmployeeMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Employee');
        }
        
        return $this->_dbTable;
    }
        
    public function add(LLLT_Model_Employee $emp) {
    			    	
	    $data = array('first_name'         => $emp->getFirst_name(),
				      'last_name'          => $emp->getLast_name(),
				      'addr'               => $emp->getAddr(),
	    			  'addr2'              => $emp->getAddr2(),
	    			  'city'               => $emp->getCity(),
	    			  'state'              => $emp->getState(),
	    			  'zip'                => $emp->getZip(),
	    			  'zip4'               => $emp->getZip4(),
	    		      'active'             => 1,
	    			  'vehicle_id'         => $emp->getVehicle_id(),
	    			  'role_id'            => $emp->getRole_id(),
					  'email'              => $emp->getEmail(),
	    			  'created'            => $emp->getCreated(),
	    			  'created_by'         => $emp->getCreated_by(),
	    			  'last_updated'       => $emp->getLast_updated(),
	    			  'last_updated_by'    => $emp->getLast_udpated_by());
	    	    	
	    $empId = $this->getDbTable()->insert($data);
	    
	    return $empId;
    }

 	public function delete(LLLT_Model_Employee $emp) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ?', $emp->getEmp_id());
			
    	$this->getDbTable()->delete($where);
    }

   	public function edit(LLLT_Model_Employee $emp) {
    	
	    $data = array('first_name'         => $emp->getFirst_name(),
				      'last_name'          => $emp->getLast_name(),
				      'addr'               => $emp->getAddr(),
	    			  'addr2'              => $emp->getAddr2(),
	    			  'city'               => $emp->getCity(),
	    			  'state'              => $emp->getState(),
	    			  'zip'                => $emp->getZip(),
	    			  'zip4'               => $emp->getZip4(),
	    		      'active'             => $emp->getActive(),
	    			  'vehicle_id'         => $emp->getVehicle_id(),
	    			  'role_id'            => $emp->getRole_id(),
					  'email'              => $emp->getEmail(),
	    			  'last_updated'       => $emp->getLast_updated(),
	    			  'last_updated_by'    => $emp->getLast_udpated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ?', $emp->getEmp_id());

		$this->getDbTable()->update($data, $where);
    }
          
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_Employee();
            
            $entry->setEmp_id($row->emp_id)
            	  ->setFirst_name($row->first_name)
        		  ->setLast_name($row->last_name)
        		  ->setAddr($row->addr)
        		  ->setAddr2($row->addr2)
        		  ->setCity($row->city)
        		  ->setState($row->state)
        		  ->setZip($row->zip)
        		  ->setZip4($row->zip4)
        		  ->setVehicle_id($row->vehicle_id)
        		  ->setRole_id($row->role_id)
        		  ->setActive($row->active)
        		  ->setEmail($row->email)
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
        	
            return 'The employee could not be found.';
        }
        
        $row = $result->current();
        
        $emp = new LLLT_Model_Employee();

        $emp->setEmp_id($row->emp_id)
        	->setFirst_name($row->first_name)
        	->setLast_name($row->last_name)
        	->setAddr($row->addr)
        	->setAddr2($row->addr2)
        	->setCity($row->city)
        	->setState($row->state)
        	->setZip($row->zip)
         	->setZip4($row->zip4)
        	->setVehicle_id($row->vehicle_id)
        	->setRole_id($row->role_id)
        	->setActive($row->active)
        	->setEmail($row->email)
        	->setCreated($row->created)
        	->setCreated_by($row->created_by)
        	->setLast_updated($row->last_updated)
        	->setLast_updated_by($row->last_updated_by);

        return $emp;
    }
}