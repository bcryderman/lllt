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
	    	    	
	    $empId = $this->getDbTable()
					 ->insert($data);
	    
	    return $empId;
    }

 	public function delete(LLLT_Model_Employee $emp) {
    	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('emp_id = ?', $emp->getEmp_id());
			
    	$this->getDbTable()
			 ->delete($where);
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
    	 
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('emp_id = ?', $emp->getEmp_id());

		$this->getDbTable()
			 ->update($data, $where);
    }
          
    public function fetchAll($where = null, $order = null) {
    	
		if ($where === null) {
			
			$resultSet = $this->getDbTable()
							  ->fetchAll($this->getDbTable()
											  ->select()
											  ->setIntegrityCheck(false)
											  ->from(array('e' => 'tbl_employee'))
											  ->order($order)
											  ->join(array('r' => 'tbl_role'),
													 'e.role_id = r.role_id',
													 array('role_name')));
		}
		else {
			
			$resultSet = $this->getDbTable()
							  ->fetchAll($this->getDbTable()
											  ->select()
											  ->setIntegrityCheck(false)
											  ->from(array('e' => 'tbl_employee'))
											  ->where($where)
											  ->order($order)
											  ->join(array('r' => 'tbl_role'),
													 'e.role_id = r.role_id',
													 array('role_id')));
		}
        
        $employees = array();
        
        foreach ($resultSet as $row) {
        	
            $employee = new LLLT_Model_Employee();
            
            $employee->setEmp_id($row->emp_id)
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
					 ->setRole_name($row->role_name)
	        		 ->setActive($row->active)
	        		 ->setEmail($row->email)
	        		 ->setCreated($row->created)
	        		 ->setCreated_by($row->created_by)
	        		 ->setLast_updated($row->last_updated)
	        		 ->setLast_updated_by($row->last_updated_by);
                  
            $employees[] = $employee;
        }
        
        return $employees;
    }
    
	public function find($id) {
    	
		$result = $this->getDbTable()
					   ->fetchRow($this->getDbTable()
					   				   ->select()
					 				   ->setIntegrityCheck(false)
									   ->from(array('e' => 'tbl_employee'))
									   ->where('e.emp_id = ?', $id)
									   ->join(array('r' => 'tbl_role'),
									       		    'e.role_id = r.role_id',
									 		  array('role_name')));
        
        if (0 == count($result)) {
        	
            return 'The employee could not be found.';
        }
                
        $employee = new LLLT_Model_Employee();

        $employee->setEmp_id($result->emp_id)
	        	 ->setFirst_name($result->first_name)
	        	 ->setLast_name($result->last_name)
	        	 ->setAddr($result->addr)
	        	 ->setAddr2($result->addr2)
	        	 ->setCity($result->city)
	        	 ->setState($result->state)
	        	 ->setZip($result->zip)
	         	 ->setZip4($result->zip4)
	        	 ->setVehicle_id($result->vehicle_id)
	        	 ->setRole_id($result->role_id)
				 ->setRole_name($result->role_name)
	        	 ->setActive($result->active)
	        	 ->setEmail($result->email)
	        	 ->setCreated($result->created)
	        	 ->setCreated_by($result->created_by)
	        	 ->setLast_updated($result->last_updated)
	        	 ->setLast_updated_by($result->last_updated_by);

        return $employee;
    }
    
    public function fetchdispatch($where = null, $order = null) {

			//->where('a.customer_id = ?',$where['customer_id'])
			$table = $this->getDbTable();
							$select = $table->select();
							$select->setIntegrityCheck(false);
							$select->from(array('e' => 'tbl_employee'));
							$select->where('e.role_id = ?',2);
								foreach($where as $k=>$v)
									{
										$x='e.'.$k . ' = ?';
										echo $x;
									$select->where($x,$v);
									}
							$select->order($order);
							$select->joinRight(array('l' => 'tbl_load'),
									       		    'e.emp_id = l.driver_id',
									 		  array('dispatched_loads'=>'COUNT(*)'))
								->where('l.dispatched = ?',1);
								//->group('e.emp_id');
//							$select->join(array('l'=> 'tbl_load'),
//											'e.emp_id = l.driver_id',
//											array('dispatched_loads'=>'COUNT(*)'));
			$resultSet = $table->fetchAll($select);
		
        $employees = array();
        
        foreach ($resultSet as $row) {
        	
            $employee = new LLLT_Model_Employee();
            
            $employee->setEmp_id($row->emp_id)
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
	        		 //->setPending_loads($row->pending_loads)
	        		 ->setCreated($row->created)
	        		 ->setCreated_by($row->created_by)
	        		 ->setLast_updated($row->last_updated)
	        		 ->setLast_updated_by($row->last_updated_by);
                  
            $employees[] = $employee;
        }
        
        return $employees;
    }
    
    
    
    
}