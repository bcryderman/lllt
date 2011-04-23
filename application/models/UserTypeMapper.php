<?php

class LLLT_Model_UserTypeMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_UserType');
        }
        
        return $this->_dbTable;
    }
     
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_UserType();
            
        	$entry->setUser_type_id($row->user_type_id)
	        	  ->setUser_type($row->user_type)
	        	  ->setActive($row->active)
	        	  ->setDescription($row->description);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }
}