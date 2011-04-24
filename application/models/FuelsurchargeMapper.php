<?php

class LLLT_Model_FuelsurchargeMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Fuelsurcharge');
        }
        
        return $this->_dbTable;
    }
    
 	public function add(LLLT_Model_Fuelsurcharge $fuelsurcharge) {
    	    			    	
	    $data = array('customer_id'         => $fuelsurcharge->getCustomer_id(),
	    			  'start_date'         	=> $fuelsurcharge->getStart_date(),
	    			  'end_date'   			=> $fuelsurcharge->getEnd_date(),
	    			  'fuel_surcharge'		=> $fuelsurcharge->getFuel_surcharge(),
	    			  'created'          	=> $fuelsurcharge->getCreated(),
	    			  'created_by'       	=> $fuelsurcharge->getCreated_by(),
	    			  'last_updated'     	=> $fuelsurcharge->getLast_updated(),
	    			  'last_updated_by'  	=> $fuelsurcharge->getLast_updated_by());
	  	    	    	
	    $retval = $this->getDbTable()->insert($data);
	    
	    return $retval;
    }
    
    
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_Fuelsurcharge();
            
        	$entry->setId($row->id)
        		  ->setCustomer_id($row->customer_id)
	        	  ->setStart_date($row->start_date)
	        	  ->setEnd_date($row->end_date)
	        	  ->setFuel_surcharge($row->fuel_surcharge)
	        	  ->setCreated($row->created)
	        	  ->setCreated_by($row->created_by)
	        	  ->setLast_updated($row->last_updated)
	        	  ->setLast_updated_by($row->last_updated_by);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }
    
    
	public function find($id) {
    	
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
            return 'This Fuel surcharge could not be found.';
        }
        
        $row = $result->current();
        $retval= new LLLT_Model_Fuelsurcharge();
        $retval->setId($row->id);
        $retval->setCustomer_id($row->customer_id);
        $retval->setStart_date($row->start_date);
        $retval->setEnd_date($row->end_date);
        $retval->setFuel_surcharge($row->fuel_surcharge);
        $retval->setCreated($row->created);
        $retval->setCreated_by($row->created_by);
        $retval->setLast_updated($row->last_updated);
        $retval->setLast_updated_by($row->last_updated_by);

        return $retval;
    }
    
//    public function create(LLLT_Model_Fuelsurcharge $fuelsurcharge) {
//    			    	
//	    $data = array('bill_to_id'        => $fuelsurcharge->getBill_to_id(),
//	    			  'origin_id'         => $fuelsurcharge->getOrigin_id(),
//	   				  'destination_id'    => $fuelsurcharge->getDestination_id(),
//				      'start_date'         => $fuelsurcharge->getStart_date(),
//				      'end_date'           => $fuelsurcharge->getEnd_date(),
//	    			  'route_type_id'	   => $fuelsurcharge->getRoute_type_id(),
//	    			  'rate'       		   => $fuelsurcharge->getRate(),
//	    			  'created'            => $fuelsurcharge->getCreated(),
//	    			  'created_by'         => $fuelsurcharge->getCreated_by(),
//	    			  'last_updated'       => $fuelsurcharge->getLast_updated(),
//	    			  'last_updated_by'    => $fuelsurcharge->getLast_udpated_by());
//	    	    	
//	    $id = $this->getDbTable()->insert($data);
//	    
//	    return $id;
//
//    }

    public function edit(LLLT_Model_Fuelsurcharge $fuelsurcharge) {
    	
    	$data = array('customer_id'        => $fuelsurcharge->getCustomer_id(),
				      'start_date'         => $fuelsurcharge->getStart_date(),
				      'end_date'           => $fuelsurcharge->getEnd_date(),
	    			  'fuel_surcharge'     => $fuelsurcharge->getFuel_surcharge(),
	    			  'created'            => $fuelsurcharge->getCreated(),
	    			  'created_by'         => $fuelsurcharge->getCreated_by(),
	    			  'last_updated'       => $fuelsurcharge->getLast_updated(),
	    			  'last_Updated_by'    => $fuelsurcharge->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $fuelsurcharge->getId());

		$this->getDbTable()->update($data, $where);
    }
    
    public function delete(LLLT_Model_Fuelsurcharge $fuelsurcharge) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $fuelsurcharge->getId());
			
    	$this->getDbTable()->delete($where);
    }
}