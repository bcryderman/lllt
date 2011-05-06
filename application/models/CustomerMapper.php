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
    
    public function add(LLLT_Model_Customer2 $customer) {
	
	    $data = array(  'active'		=>$customer->getActive(),
	    				'name'			=>$customer->getName(),
				    	'addr'			=>$customer->getAddr(),
				    	'addr2'			=>$customer->getAddr2(),
				    	'city'			=>$customer->getCity(),
				    	'state'			=>$customer->getState(),
				    	'zip'			=>$customer->getZip(),
				    	'zip4'			=>$customer->getZip4(),
				    	'fein'			=>$customer->getFein(),
				    	'color_code'	=>$customer->getColor_code(),
				    	'customer_type_id'=>$customer->getCustomer_type_id(),
				    	'notes'			=>$customer->getNotes(),
				    	'created'		=>$customer->getCreated($date),
			    		'created_by'	=>$customer->getCreated_by(),
			    		'last_updated'	=>$customer->getLast_updated(),
			    		'last_updated_by'=>$customer->getlast_updated_by());
	    	    	
	    $id = $this->getDbTable()->insert($data);
	    
	    return $id;

    }
    
	public function find($id) {
    	
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
            return 'This Customer could not be found.';
        }
        
        $row = $result->current();
        $retval= new LLLT_Model_Customer();
        $retval->setCustomer_id($row->customer_id);
        $retval->setName($row->name);
        $retval->setAddr($row->addr);
        $retval->setAddr2($row->addr2);
        $retval->setCity($row->city);
        $retval->setState($row->state);
        $retval->setZip($row->zip);
        $retval->setZip4($row->zip4);
        $retval->setFein($row->fein);
        $retval->setColor_code($row->color_code);
        $retval->setCustomer_type_id($row->customer_type_id);
        $retval->setPrimary_customer_contact_id($row->primary_customer_contact_id);
        $retval->setCarrier_navman_owner_id($row->carrier_navman_owner_id);
        $retval->setQuickbook_print($row->quickbook_print);
        $retval->setActive($row->active);
        $retval->setNotes($row->notes);
        $retval->setCreated($row->created);
        $retval->setCreated_by($row->created_by);
        $retval->setLast_updated($row->last_updated);
        $retval->setLast_updated_by($row->last_updated_by);

        return $retval;
    }
     
    public function fetchAll($where = null, $order = null) {
    	    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $customer = new LLLT_Model_Customer();
            
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

    
    public function edit(LLLT_Model_Customer $customer) {
    	
    	$data = array('name'        => $customer->getName(),
				      'addr'        => $customer->getAddr(),
				      'addr2'       => $customer->getAddr2(),
	    			  'city'     	=> $customer->getCity(),
	    			  'state'       => $customer->getState(),
	    			  'zip'         => $customer->getZip(),
				      'zip4'        => $customer->getZip4(),
				      'fein'        => $customer->getFein(),
				      'color_code'  => $customer->getColor_code(),
				      'notes'       => $customer->getNotes(),
	    			  'last_updated'       => $customer->getLast_updated(),
	    			  'last_Updated_by'    => $customer->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('customer_id = ?', $customer->getCustomer_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function active(LLLT_Model_Customer $customer){
    	$data = array('active' => $customer->getActive(),	    			  
    				  'last_updated'       => $customer->getLast_updated(),
	    			  'last_Updated_by'    => $customer->getLast_updated_by());
    	$where = $this->getDbTable()->getAdapter()->quoteInto('customer_id = ?', $customer->getCustomer_id());

		$this->getDbTable()->update($data, $where);	
    }
    
    public function delete(LLLT_Model_Customer $customer) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('customer_id = ?', $customer->getId());
			
    	$this->getDbTable()->delete($where);
	}
}