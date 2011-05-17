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
    
    public function add(LLLT_Model_CarrierDiscount $carrierDiscount) {
    	    			    	
	    $data = array('company_id'      => $carrierDiscount->getCompany_id(),
	    			  'start_date'      => $carrierDiscount->getStart_date(),
	    			  'end_date'        => $carrierDiscount->getEnd_date(),
	    			  'discount'        => $carrierDiscount->getDiscount(),
	    			  'created'         => $carrierDiscount->getCreated(),
	    			  'created_by'      => $carrierDiscount->getCreated_by(),
	    			  'last_updated'    => $carrierDiscount->getLast_updated(),
	    			  'last_updated_by' => $carrierDiscount->getLast_updated_by());
	  	    	    	
	    $id = $this->getDbTable()
				   ->insert($data);
	    
	    return $id;
    }
    
 	public function delete($id) {
    	
    	$where = $this->getDbTable()
				 	  ->getAdapter()
					  ->quoteInto('id = ?', $id);
			
    	$this->getDbTable()
			 ->delete($where);
    }
    
   	public function edit(LLLT_Model_CarrierDiscount $carrierDiscount) {
    	
	    $data = array('id'              => $carrierDiscount->getId(),
					  'company_id'      => $carrierDiscount->getCompany_id(),
	    			  'start_date'      => $carrierDiscount->getStart_date(),
	    			  'end_date'        => $carrierDiscount->getEnd_date(),
	    			  'discount'        => $carrierDiscount->getDiscount(),
	    			  'last_updated'    => $carrierDiscount->getLast_updated(),
	    			  'last_updated_by' => $carrierDiscount->getLast_updated_by());
    	 
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('id = ?', $carrierDiscount->getId());

		$this->getDbTable()
			 ->update($data, $where);
    }
    
    public function fetchAll($where, $order = null) {
    	
		if ($where === null) {

			$resultSet = $this->getDbTable()
							  ->fetchAll($this->getDbTable()
											  ->select()
											  ->setIntegrityCheck(false)
											  ->from(array('cd' => 'tbl_carrier_discount'))
											  ->order($order)
											  ->join(array('c' => 'tbl_customer'),
													 'cd.company_id = c.customer_id',
													 array('name')));
		}
		else {

			$resultSet = $this->getDbTable()
							  ->fetchAll($this->getDbTable()
											  ->select()
											  ->setIntegrityCheck(false)
											  ->from(array('cd' => 'tbl_carrier_discount'))
											  ->where($where)
											  ->order($order)
											  ->join(array('c' => 'tbl_customer'),
													 'cd.company_id = c.customer_id',
													 array('name')));
		}
        
        $carrierDiscounts = array();
        
        foreach ($resultSet as $row) {
        	
            $carrierDiscount = new LLLT_Model_CarrierDiscount();
        	$carrierDiscount->setId($row->id)        		  
	        	  			->setCompany_id($row->company_id)
						    ->setCompany_name($row->name)
			        	  	->setStart_date($row->start_date, true)
				        	->setEnd_date($row->end_date, true)
				        	->setDiscount($row->discount)
				        	->setCreated($row->created)
				        	->setCreated_by($row->created_by)
				        	->setLast_updated($row->last_updated)
				        	->setLast_updated_by($row->last_updated_by);
                  
            $carrierDiscounts[] = $carrierDiscount;            
        }
        
        return $carrierDiscounts;
    }
    
	public function find($id) {
		
		$result = $this->getDbTable()
					   ->fetchRow($this->getDbTable()
					   				   ->select()
					 				   ->setIntegrityCheck(false)
									   ->from(array('cd' => 'tbl_carrier_discount'))
									   ->where('cd.id = ?', $id)
									   ->join(array('c' => 'tbl_customer'),
									       		    'cd.company_id = c.customer_id',
									 		  array('name')));
        
        if (0 == count($result)) {
        	
        	return 'The carrier discount could not be found.';
        }
        
        $carrierDiscount = new LLLT_Model_CarrierDiscount();
       	$carrierDiscount->setId($result->id)        		  
        	  			->setCompany_id($result->company_id)
						->setCompany_name($result->name)
		        	  	->setStart_date($result->start_date, true)
			        	->setEnd_date($result->end_date, true)
			        	->setDiscount($result->discount)
			        	->setCreated($result->created)
			        	->setCreated_by($result->created_by)
			        	->setLast_updated($result->last_updated)
			        	->setLast_updated_by($result->last_updated_by);
	        	
	    return $carrierDiscount;
    }
}