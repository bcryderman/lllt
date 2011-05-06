<?php

class LLLT_Model_LoginMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Login');
        }
        
        return $this->_dbTable;
    }
    
	public function add(LLLT_Model_Login $login) {
    	
    	$data = array('emp_id'          => $login->getEmp_id(),
    				  'username'        => $login->getUsername(),
			          'password'        => $login->getPassword(),
			          'user_type_id'    => $login->getUser_type_id(),
    				  'created'         => $login->getCreated(),
    				  'created_by'      => $login->getCreated_by(),
    				  'last_updated'    => $login->getLast_updated(),
    				  'last_updated_by' => $login->getLast_updated_by());
    	
    	$empId = $this->getDbTable()->insert($data);
    	
    	return $empId;
    }
        
    public function auth(LLLT_Model_Login $login) {
    	
    	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
    	
    	$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);  
  
		$authAdapter->setTableName('tbl_login')  
            		->setIdentityColumn('username')  
            	 	->setCredentialColumn('password')
            	 	->setCredentialTreatment('MD5(?)');
            			
        $authAdapter->setIdentity($login->getUsername())  
            		->setCredential($login->getPassword());  
            		
		$auth = Zend_Auth::getInstance(); 
			
		$result = $auth->authenticate($authAdapter);
			
    	if ($result->isValid()) {  
    		
    		$authData = $authAdapter->getResultRowObject(null); 
    	
    		$login->setOptions((array) $authData);
    		  
    		$emp = new LLLT_Model_Employee();
    		$empMapper = new LLLT_Model_EmployeeMapper();
    		$emp = $empMapper->find($authData->emp_id);
    					
			if ($emp->getActive() == 1) {
				
				$loginAttemptMapper = new LLLT_Model_LoginAttemptMapper();
				$loginAttemptMapper->create($login);
				
				$authStorage = $auth->getStorage();  
   				$authStorage->write(array('Login'    => $login, 
   										  'Employee' => $emp)); 

   				return true;
			}	

			return $this->authErrorCode('INACTIVE');
		}		
		
		return $this->authErrorCode($result->getCode());
    }
    
   	protected function authErrorCode($errorCode) {
		
		switch ($errorCode) {
	
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
				
				return 'The username you entered does not exist. Please try again.';
				
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
				
				return 'The username or password you entered is incorrect. Please try again.';
				
			case 'INACTIVE':
				
				return 'The username you entered is inactive. Please contact LLLT for futher action.';
				
			default:
				
				return 'An error occurred. Please try again.';				
		}
	}
	
   	public function changePassword(LLLT_Model_Login $login) {
    	
        $data = array('password'        => $login->getPassword(),
			          'last_updated'    => $login->getLast_updated(),
			          'last_updated_by' => $login->getLast_updated_by());
 
      	$this->getDbTable()->update($data, array('emp_id = ?' => $login->getEmp_id()));
    }

 	public function delete(LLLT_Model_Login $login) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ?', $login->getEmp_id());
			
    	$this->getDbTable()->delete($where);
    }

   	public function edit(LLLT_Model_Login $login) {
    	
	    $data = array('emp_id'          => $login->getEmp_id(),
			          'password'        => $login->getPassword(),
			          'user_type_id'    => $login->getUser_type_id(),
    				  'last_updated'    => $login->getLast_updated(),
    				  'last_updated_by' => $login->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('emp_id = ?', $login->getEmp_id());

		$this->getDbTable()->update($data, $where);
    }

    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_Login();
            
        	$entry->setEmp_id($row->emp_id)
				  ->setUsername($row->username)
				  ->setPassword($row->password)
				  ->setUser_type_id($row->user_type_id)
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
        	
        	return 'The login could not be found.';
        }
        
        $row = $result->current();
        
        $login = new LLLT_Model_Login();

        $login->setEmp_id($row->emp_id)
			  ->setUsername($row->username)
			  ->setPassword($row->password)
			  ->setUser_type_id($row->user_type_id)
	          ->setCreated($row->created)
	          ->setCreated_by($row->created_by)
	          ->setLast_updated($row->last_updated)
	          ->setLast_updated_by($row->last_updated_by);

	    return $login;
    }
        
    public function usernameAvail($username) {
    	
    	$result = $this->getDbTable()->fetchRow($this->getDbTable()->select()
																   ->where('username = ?', $username));						

		if (count($result) > 0) {
        	
            return false;
        }

        return true;
    }
}