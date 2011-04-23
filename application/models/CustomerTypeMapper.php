<?php

class LLLT_Model_CustomerTypeMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_CustomerType');
        }
        
        return $this->_dbTable;
    }
     
    public function fetchAll($where = null, $order = null) {
    	    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_CustomerType();

            $entry->setCustomer_type_id($row->customer_type_id)
            	  ->setCustomer_type($row->customer_type)
        		  ->setActive($row->active)
        		  ->setDescription($row->description);
                  
            $entries[] = $entry;
        }
        
        return $entries;
    }
}