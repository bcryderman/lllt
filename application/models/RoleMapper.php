<?php

class LLLT_Model_RoleMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Role');
        }
        
        return $this->_dbTable;
    }
     
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_Role();
            
        	$entry->setRole_id($row->role_id)
	        	  ->setRole_name($row->role_name)
	        	  ->setActive($row->active)
	        	  ->setDescription($row->description);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }
}