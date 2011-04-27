<?php

class LLLT_Model_CarrierDiscountMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_CarrierDiscount');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_CarrierDiscount $carDisc) {
    	    			    	
	    $data = array('company_id'      => $carDisc->getCompany_id(),
	    			  'start_date'      => $carDisc->getStart_date(),
	    			  'end_date'        => $carDisc->getEnd_date(),
	    			  'discount'        => $carDisc->getDiscount(),
	    			  'created'         => $carDisc->getCreated(),
	    			  'created_by'      => $carDisc->getCreated_by(),
	    			  'last_updated'    => $carDisc->getLast_updated(),
	    			  'last_updated_by' => $carDisc->getLast_updated_by());
	  	    	    	
	    $id = $this->getDbTable()->insert($data);
	    
	    return $id;
    }
    
 	public function delete(LLLT_Model_CarrierDiscount $carDisc) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $carDisc->getId());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_CarrierDiscount $carDisc) {
    	
	    $data = array('id'              => $carDisc->getId(),
					  'company_id'      => $carDisc->getCompany_id(),
	    			  'start_date'      => $carDisc->getStart_date(),
	    			  'end_date'        => $carDisc->getEnd_date(),
	    			  'discount'        => $carDisc->getDiscount(),
	    			  'created'         => $carDisc->getCreated(),
	    			  'created_by'      => $carDisc->getCreated_by(),
	    			  'last_updated'    => $carDisc->getLast_updated(),
	    			  'last_updated_by' => $carDisc->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $carDisc->getId());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $carDisc = new LLLT_Model_CarrierDiscount();
            
        	$carDisc->setId($row->id)        		  
	        	  	->setCompany_id($row->company_id)
	        	  	->setStart_date($row->start_date)
		        	->setEnd_date($row->end_date)
		        	->setDiscount($row->discount)
		        	->setCreated($row->created)
		        	->setCreated_by($row->created_by)
		        	->setLast_updated($row->last_updated)
		        	->setLast_updated_by($row->last_updated_by);
                  
            $entries[] = $carDisc;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The carrier discount could not be found.';
        }
        
        $row = $result->current();
        
        $carDisc = new LLLT_Model_CarrierDiscount();

            
       	$carDisc->setId($row->id)        		  
        	  	->setCompany_id($row->company_id)
        	  	->setStart_date($row->start_date)
	        	->setEnd_date($row->end_date)
	        	->setDiscount($row->discount)
	        	->setCreated($row->created)
	        	->setCreated_by($row->created_by)
	        	->setLast_updated($row->last_updated)
	        	->setLast_updated_by($row->last_updated_by);
	        	
	    return $carDisc;
    }
}