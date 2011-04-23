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
     
	public function create(LLLT_Model_EmployeeComm $empComm) {
		    	
    	$data = array('emp_id'                => $empComm->getEmp_id(),
    				  'communication_type_id' => $empComm->getCommunication_type_id(),
			          'phone'                 => $empComm->getPhone(),
			          'phone_ext'    		  => $empComm->getPhone_ext(),
    				  'primary'        		  => $empComm->getPrimary(),
    				  'created'        		  => $empComm->getCreated(),
    				  'created_by'     		  => $empComm->getCreated_by(),
    				  'last_updated'   	 	  => $empComm->getLast_updated(),
    				  'last_updated_by' 	  => $empComm->getLast_updated_by());
    	
    	$this->getDbTable()->insert($data);
    }
    
    /*public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_CommType();
            
        	$entry->setCommunication_type_id($row->communication_type_id)
	        	  ->setCommunication_type($row->communication_type)
	        	  ->setActive($row->active)
	        	  ->setDescription($row->description);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }*/
}