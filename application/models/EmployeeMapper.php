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
        
    public function add(LLLT_Model_Employee $employee) {
    			    	
	    $data = array('first_name'            => $employee->getFirst_name(),
				      'last_name'             => $employee->getLast_name(),
				      'addr'                  => $employee->getAddr(),
	    			  'addr2'                 => $employee->getAddr2(),
	    			  'city'                  => $employee->getCity(),
	    			  'state'                 => $employee->getState(),
	    			  'zip'                   => $employee->getZip(),
	    			  'zip4'                  => $employee->getZip4(),
	    		      'active'                => 1,
	    			  'vehicle_id'            => $employee->getVehicle_id(),
	    			  'role_id'               => $employee->getRole_id(),
					  'email'                 => $employee->getEmail(),
					  'phone' 			      => $employee->getPhone(),
					  'phone_ext'		      => $employee->getPhone_ext(),
					  'phone_primary'	      => $employee->getPhone_primary(),
					  'cell_phone'		   	  => $employee->getCell_phone(),
					  'cell_phone_primary'    => $employee->getCell_phone_primary(),
					  'communication_type_id' => $employee->getCommunication_type_id(),
	    			  'created'            	  => $employee->getCreated(),
	    			  'created_by'            => $employee->getCreated_by(),
	    			  'last_updated'          => $employee->getLast_updated(),
	    			  'last_updated_by'       => $employee->getLast_updated_by());
	    	    	
	    $empId = $this->getDbTable()
					 ->insert($data);
					
		$data = array('emp_id' 			=> $empId,
					  'username'		=> $employee->getUsername(),
					  'password' 		=> $employee->getPassword(),
					  'user_type_id' 	=> $employee->getUser_type_id(),
					  'created' 		=> $employee->getCreated(),
					  'created_by' 		=> $employee->getCreated_by(),
					  'last_updated' 	=> $employee->getLast_updated(),
					  'last_updated_by' => $employee->getLast_updated_by());
			
		$login = new LLLT_Model_DbTable_Login();
		$login->insert($data);
	    
	    return $empId;
    }

 	public function delete($id) {
    	
		$login = new LLLT_Model_DbTable_Login();
		$login->delete($login->getAdapter()
		  					 ->quoteInto('emp_id = ?', $id));
		
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('emp_id = ?', $id);
			
    	$this->getDbTable()
			 ->delete($where);
    }

   	public function edit(LLLT_Model_Employee $employee) {
			
	    $data = array('emp_id'  		  	  => $employee->getEmp_id(),
					  'first_name'       	  => $employee->getFirst_name(),
				      'last_name'        	  => $employee->getLast_name(),
				      'addr'               	  => $employee->getAddr(),
	    			  'addr2'             	  => $employee->getAddr2(),
	    			  'city'              	  => $employee->getCity(),
	    			  'state'             	  => $employee->getState(),
	    			  'zip'               	  => $employee->getZip(),
	    			  'zip4'              	  => $employee->getZip4(),
	    		      'active'            	  => $employee->getActive(),
	    			  'vehicle_id'       	  => $employee->getVehicle_id(),
	    			  'role_id'          	  => $employee->getRole_id(),
					  'email'             	  => $employee->getEmail(),
					  'phone' 			  	  => $employee->getPhone(),
					  'phone_ext'		  	  => $employee->getPhone_ext(),
					  'phone_primary'	   	  => $employee->getPhone_primary(),
					  'cell_phone'		  	  => $employee->getCell_phone(),
					  'cell_phone_primary' 	  => $employee->getCell_phone_primary(),
					  'communication_type_id' => $employee->getCommunication_type_id(),
	    			  'last_updated'      	  => $employee->getLast_updated(),
	    			  'last_updated_by'   	  => $employee->getLast_updated_by());

		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('emp_id = ?', $employee->getEmp_id());
							
	    $this->getDbTable()
			 ->update($data, $where);

		if (!is_null($employee->getPassword())) {
			
			$data = array('emp_id' 			=> $employee->getEmp_id(),
						  'username'		=> $employee->getUsername(),
						  'password' 		=> $employee->getPassword(),
						  'user_type_id' 	=> $employee->getUser_type_id(),
						  'last_updated' 	=> $employee->getLast_updated(),
						  'last_updated_by' => $employee->getLast_updated_by());

			$login = new LLLT_Model_DbTable_Login();
			$login->update($data, $login->getAdapter()
			  							->quoteInto('emp_id = ?', $employee->getEmp_id()));
		}
												
	    return $this;
    }
          
    public function fetchAll($where, $order = null) {
    	
		$sql = 'SELECT e.*, 
					   l.username,
			  		   r.role_name,
			  		   ut.user_type, 
					   ut.user_type_id,
					   ct.communication_type AS cell_carrier
				FROM tbl_employee e, 
				 	 tbl_login l,
					 tbl_role r,
					 tbl_user_type ut,
					 tbl_communication_type ct
				WHERE e.role_id = r.role_id
				AND e.emp_id = l.emp_id
				AND l.user_type_id = ut.user_type_id
				AND e.communication_type_id = ct.communication_type_id';
				
		if (!is_null($where)) {
			
			$sql .= ' AND ' . $where;
		}
		
		if (!is_null($order)) {
			
			$sql .= ' ORDER BY ' . $order;
		}
		
		$stmt = $this->getDbTable()
					 ->getAdapter()
					 ->query($sql);
		
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$resultSet = $stmt->fetchAll();
        
        $employees = array();
        
        foreach ($resultSet as $row) {
        	
	        $employee = new LLLT_Model_Employee();
	        $employee->setEmp_id($row->emp_id)
					 ->setUsername($row->username)
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
					 ->setUser_type_id($row->user_type_id)
					 ->setUser_type($row->user_type)
		        	 ->setActive($row->active)
		        	 ->setEmail($row->email)
					 ->setPhone($row->phone, true)
					 ->setPhone_ext($row->phone_ext)
					 ->setPhone_primary($row->phone_primary)
					 ->setCell_phone($row->cell_phone, true)
					 ->setCell_phone_primary($row->cell_phone_primary)
					 ->setCell_carrier($row->cell_carrier)
					 ->setCommunication_type_id($row->communication_type_id)
		        	 ->setCreated($row->created)
		        	 ->setCreated_by($row->created_by)
		        	 ->setLast_updated($row->last_updated)
		        	 ->setLast_updated_by($row->last_updated_by);
                  
            $employees[] = $employee;
        }
        
        return $employees;
    }
    
	public function find($id) {
									
		$sql = 'SELECT e.*, 
					   l.username,
			  		   r.role_name,
			  		   ut.user_type, 
					   ut.user_type_id,
					   ct.communication_type AS cell_carrier
				FROM tbl_employee e, 
				 	 tbl_login l,
					 tbl_role r,
					 tbl_user_type ut,
					 tbl_communication_type ct
				WHERE e.emp_id = ' . $id . '
				AND e.role_id = r.role_id
				AND e.emp_id = l.emp_id
				AND l.user_type_id = ut.user_type_id
				AND e.communication_type_id = ct.communication_type_id';

		$this->getDbTable()
			 ->getAdapter()
			 ->setFetchMode(Zend_Db::FETCH_OBJ);

		$row = $this->getDbTable()
					->getAdapter()
					->fetchRow($sql);
        
        if (0 == count($row)) {
        	
            return 'The employee could not be found.';
        }
                
        $employee = new LLLT_Model_Employee();
        $employee->setEmp_id($row->emp_id)
				 ->setUsername($row->username)
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
				 ->setUser_type_id($row->user_type_id)
				 ->setUser_type($row->user_type)
	        	 ->setActive($row->active)
	        	 ->setEmail($row->email)
				 ->setPhone($row->phone, true)
				 ->setPhone_ext($row->phone_ext)
				 ->setPhone_primary($row->phone_primary)
				 ->setCell_phone($row->cell_phone, true)
				 ->setCell_phone_primary($row->cell_phone_primary)
				 ->setCell_carrier($row->cell_carrier)
				 ->setCommunication_type_id($row->communication_type_id)
	        	 ->setCreated($row->created)
	        	 ->setCreated_by($row->created_by)
	        	 ->setLast_updated($row->last_updated)
	        	 ->setLast_updated_by($row->last_updated_by);

        return $employee;
    }
}