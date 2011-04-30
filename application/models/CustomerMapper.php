<?php

class LLLT_Model_CustomerMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Customer');
        }
        
        return $this->_dbTable;
    }
     
    public function fetchAll($where = null, $order = null) {
    	    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $customer = new LLLT_Model_Customer2();
            
            $customer->setCustomer_id($row->customer_id)
            	  	 ->setName($row->name)
            	     ->setAddr($row->addr)
        		     ->setAddr2($row->addr2)
        		  	 ->setCity($row->city)
        		  	 ->setState($row->state)
        		  	 ->setZip($row->zip)
        		  	 ->setZip4($row->zip4)
        		  	 ->setFein($row->fein)
        		  	 ->setColor_code($row->color_code)
            	  	 ->setCustomer_type_id($row->customer_type_id)
            	  	 ->setPrimary_customer_contact_id($row->primary_customer_contact_id)
            	  	 ->setCarrier_navman_owner_id($row->carrier_navman_owner_id)
            	  	 ->setQuickbook_print($row->quickbook_print)            	  
        		  	 ->setActive($row->active)
        		  	 ->setNotes($row->notes)
        		  	 ->setCreated($row->created)
        		  	 ->setCreated_by($row->created_by)
        		  	 ->setLast_updated($row->last_updated)
        		  	 ->setLast_updated_by($row->last_updated_by);
                  
            $entries[] = $customer;
        }
        
        return $entries;
    }

	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The customer could not be found.';
        }
        
        $row = $result->current();
        
        $customer = new LLLT_Model_Customer2();

        $customer->setCustomer_id($row->customer_id)
        	  	 ->setName($row->name)
        	     ->setAddr($row->addr)
    		     ->setAddr2($row->addr2)
    		  	 ->setCity($row->city)
    		  	 ->setState($row->state)
    		  	 ->setZip($row->zip)
    		  	 ->setZip4($row->zip4)
    		  	 ->setFein($row->fein)
    		  	 ->setColor_code($row->color_code)
        	  	 ->setCustomer_type_id($row->customer_type_id)
        	  	 ->setPrimary_customer_contact_id($row->primary_customer_contact_id)
        	  	 ->setCarrier_navman_owner_id($row->carrier_navman_owner_id)
        	  	 ->setQuickbook_print($row->quickbook_print)            	  
    		  	 ->setActive($row->active)
    		  	 ->setNotes($row->notes)
    		  	 ->setCreated($row->created)
    		  	 ->setCreated_by($row->created_by)
    		  	 ->setLast_updated($row->last_updated)
    		  	 ->setLast_updated_by($row->last_updated_by);
	        	
	    return $customer;
    }
}