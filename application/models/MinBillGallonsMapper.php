<?php

class LLLT_Model_MinBillGallonsMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_MinBillGallons');
        }
        
        return $this->_dbTable;
    }
    
	public function find(LLLT_Model_MinBillGallons $mbg) {
    	
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
            return 'The minimum bill gallons could not be found.';
        }
        
        $row = $result->current();

        $mbg->setEmp_id($row->emp_id)
        	->setFirst_name($row->first_name)
        	->setLast_name($row->last_name)
        	->setAddr($row->addr)
        	->setAddr2($row->addr2)
        	->setCity($row->city)
        	->setState($row->state)
        	->setZip($row->zip)
         	->setZip4($row->zip4)
        	->setVehicle_id($row->vehicle_id)
        	->setRole_id($row->role_id)
        	->setActive($row->active)
        	->setEmail($row->email)
        	->setCreated($row->created)
        	->setCreated_by($row->created_by)
        	->setLast_updated($row->last_updated)
        	->setLast_updated_by($row->last_updated_by);

        return $mbg;
    }
    
    public function create(LLLT_Model_MinBillGallons $mbg) {
    			    	
	    $data = array('customer_id'        => $emp->getCustomer_id(),
				      'start_date'         => $emp->getStart_date(),
				      'end_date'           => $emp->getEnd_date(),
	    			  'minimum_gallons'    => $emp->getMinimum_gallons(),
	    			  'created'            => $emp->getCreated(),
	    			  'created_by'         => $emp->getCreated_by(),
	    			  'last_updated'       => $emp->getLast_updated(),
	    			  'last_updated_by'    => $emp->getLast_udpated_by());
	    	    	
	    $idd = $this->getDbTable()->insert($data);
	    
	    return $id;

    }

}