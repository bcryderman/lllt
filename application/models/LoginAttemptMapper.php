<?php

class LLLT_Model_LoginAttemptMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_LoginAttempt');
        }
        
        return $this->_dbTable;
    }
     
    public function create(LLLT_Model_Login $login) {
   	
    	$data = array('emp_id'       => $login->getEmp_id(),
    				  'user_name'    => $login->getUsername(),
			          'password'     => $login->getPassword(),
			          'ip'           => $_SERVER['REMOTE_ADDR'],
    				  'attempt_date' => date('Y-m-d H:i:s'));
    	
    	$this->getDbTable()->insert($data);
    }
}