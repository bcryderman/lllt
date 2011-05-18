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
    	
		$sql = 'SELECT tbl_carrier_discount.*, tbl_customer.name
				FROM tbl_carrier_discount
				LEFT JOIN tbl_customer ON tbl_carrier_discount.company_id = tbl_customer.customer_id';
				
		if (!is_null($where)) {
			
			$sql .= ' WHERE ' . $where;
		}
		
		if (!is_null($order)) {
			
			$sql .= ' ORDER BY ' . $order;
		}
		
		$stmt = $this->getDbTable()
					 ->getAdapter()
					 ->query($sql);
		
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$resultSet = $stmt->fetchAll();
        
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
		
		$sql = 'SELECT tbl_carrier_discount.*, tbl_customer.name
				FROM tbl_carrier_discount
				LEFT JOIN tbl_customer ON tbl_carrier_discount.company_id = tbl_customer.customer_id 
				WHERE tbl_carrier_discount.id = ' . $id;

		$this->getDbTable()
			 ->getAdapter()
			 ->setFetchMode(Zend_Db::FETCH_OBJ);

		$row = $this->getDbTable()
					->getAdapter()
					->fetchRow($sql);
        
        if (0 == count($row)) {
        	
        	return 'The carrier discount could not be found.';
        }
        
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
	        	
	    return $carrierDiscount;
    }
}