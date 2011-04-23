<?php

class LLLT_Model_RatesMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Rates');
        }
        
        return $this->_dbTable;
    }
    
 	public function add(LLLT_Model_Rates $rate) {
    	    			    	
	    $data = array('bill_to_id' 			=> $rate->getBill_to_id(),
				      'origin_id'         	=> $rate->getOrigin_id(),
	    			  'destination_id'      => $rate->getDestination_id(),
	    			  'start_date'         	=> $rate->getStart_date(),
	    			  'end_date'   			=> $rate->getEnd_date(),
	    			  'route_type_id'       => $rate->getRoute_type_id(),
	    			  'rate'				=> $rate->getRate(),
	    			  'created'          	=> $rate->getCreated(),
	    			  'created_by'       	=> $rate->getCreated_by(),
	    			  'last_updated'     	=> $rate->getLast_updated(),
	    			  'last_updated_by'  	=> $rate->getLast_updated_by());
	  	    	    	
	    $reminderId = $this->getDbTable()->insert($data);
	    
	    return $reminderId;
    }
    
    
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_Rates();
            
        	$entry->setRate_id($row->rate_id)
        		  ->setBill_to_id($row->bill_to_id)
	        	  ->setOrigin_id($row->origin_id)
	        	  ->setDestination_id($row->destination_id)
	        	  ->setStart_date($row->start_date)
	        	  ->setEnd_date($row->end_date)
	        	  ->setRoute_type_id($row->route_type_id)
	        	  ->setRate($row->rate)
	        	  ->setCreated($row->created)
	        	  ->setCreated_by($row->created_by)
	        	  ->setLast_updated($row->last_updated)
	        	  ->setLast_updated_by($row->last_Updated_by);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }
    
    
	public function find($rate_id) {
    	
        $result = $this->getDbTable()->find($rate_id);
        
        if (0 == count($result)) {
        	
            return 'This rate could not be found.';
        }
        
        $row = $result->current();
        $rate= new LLLT_Model_Rates();
        $rate->setRate_id($row->rate_id);
        $rate->setBill_to_id($row->bill_to_id);
        $rate->setOrigin_id($row->origin_id);
        $rate->setDestination_id($row->destination_id);
        $rate->setStart_date($row->start_date);
        $rate->setEnd_date($row->end_date);
        $rate->setRoute_type_id($row->route_type_id);
        $rate->setRate($row->rate);
        $rate->setCreated($row->created);
        $rate->setCreated_by($row->created_by);
        $rate->setLast_updated($row->last_updated);
        $rate->setLast_updated_by($row->last_Updated_by);

        return $rate;
    }
    
    public function create(LLLT_Model_Rates $rate) {
    			    	
	    $data = array('bill_to_id'        => $rate->getBill_to_id(),
	    			  'origin_id'         => $rate->getOrigin_id(),
	   				  'destination_id'    => $rate->getDestination_id(),
				      'start_date'         => $rate->getStart_date(),
				      'end_date'           => $rate->getEnd_date(),
	    			  'route_type_id'	   => $rate->getRoute_type_id(),
	    			  'rate'       		   => $rate->getRate(),
	    			  'created'            => $rate->getCreated(),
	    			  'created_by'         => $rate->getCreated_by(),
	    			  'last_updated'       => $rate->getLast_updated(),
	    			  'last_updated_by'    => $rate->getLast_udpated_by());
	    	    	
	    $idd = $this->getDbTable()->insert($data);
	    
	    return $id;

    }

    public function edit(LLLT_Model_Rates $rate) {
    	
    	$data = array('bill_to_id'        => $rate->getBill_to_id(),
	    			  'origin_id'         => $rate->getOrigin_id(),
	   				  'destination_id'    => $rate->getDestination_id(),
				      'start_date'         => $rate->getStart_date(),
				      'end_date'           => $rate->getEnd_date(),
	    			  'route_type_id'	   => $rate->getRoute_type_id(),
	    			  'rate'       		   => $rate->getRate(),
	    			  'created'            => $rate->getCreated(),
	    			  'created_by'         => $rate->getCreated_by(),
	    			  'last_updated'       => $rate->getLast_updated(),
	    			  'last_Updated_by'    => $rate->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('rate_id = ?', $rate->getRate_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function delete(LLLT_Model_Rates $rate) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('rate_id = ?', $reminder->getRate_id());
			
    	$this->getDbTable()->delete($where);
    }
}