<?php

class LLLT_Model_LoadMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Load');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_Load $load) {
    	    			    	
	    $data = array('carrier_id'       => $load->getCarrier_id(),
	    			  'bill_to_id'       => $load->getBill_to_id(),
	    			  'shipper_id'       => $load->getShipper_id(),
	    			  'origin_id'        => $load->getOrigin_id(),
	    			  'customer_id'      => $load->getCustomer_id(),
	    			  'destination_id'   => $load->getDestination_id(),
	    			  'product_id'       => $load->getProduct_id(),
	    			  'driver_id'        => $load->getDriver_id(),
	    			  'delayed_dispatch' => $load->getDelayed_dispatch(),
					  'load_date'        => $load->getLoad_date(),
					  'delivery_date'    => $load->getDelivery_date(),
					  'order_number'     => $load->getOrder_number(),
					  'bill_of_lading'   => $load->getBill_of_lading(),
					  'net_gallons'      => $load->getNet_gallons(),
					  'bill_rate'        => $load->getBill_rate(),
					  'fuel_surchage'    => $load->getFuel_surcharge(),
					  'discount'         => $load->getDiscount(),
					  'invoice_date'     => $load->getInvoice_date(),
					  'dispatched'       => $load->getDispatched(),
					  'notes'            => $load->getNotes(),
					  'load_locked'      => $load->getLoad_locked(),
					  'locked_by'        => $load->getLocked_by(),
					  'delivered'        => $load->getDelivered(),
					  'created'          => $load->getCreated(),
					  'created_by'       => $load->getCreated_by(),
					  'last_updated'     => $load->getLast_updated(),
					  'last_updated_by'  => $load->getLast_updated_by(),
					  'active'           => $load->getActive());
	  	    	    	
	    $loadId = $this->getDbTable()
					   ->insert($data);
	    
	    return $loadId;
    }
    
 	public function delete(LLLT_Model_Load $load) {
    	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('load_id = ?', $load->getLoad_id());
			
    	$this->getDbTable()
			 ->delete($where);
    }
    
   	public function edit(LLLT_Model_Load $load) {
    	
	    $data = array('load_id'          => $load->getLoad_id(),
					  'carrier_id'       => $load->getCarrier_id(),
	    			  'bill_to_id'       => $load->getBill_to_id(),
	    			  'shipper_id'       => $load->getShipper_id(),
	    			  'origin_id'        => $load->getOrigin_id(),
	    			  'customer_id'      => $load->getCustomer_id(),
	    			  'destination_id'   => $load->getDestination_id(),
	    			  'product_id'       => $load->getProduct_id(),
	    			  'driver_id'        => $load->getDriver_id(),
	    			  'delayed_dispatch' => $load->getDelayed_dispatch(),
					  'load_date'        => $load->getLoad_date(),
					  'delivery_date'    => $load->getDelivery_date(),
					  'order_number'     => $load->getOrder_number(),
					  'bill_of_lading'   => $load->getBill_of_lading(),
					  'net_gallons'      => $load->getNet_gallons(),
					  'bill_rate'        => $load->getBill_rate(),
					  'fuel_surchage'    => $load->getFuel_surcharge(),
					  'discount'         => $load->getDiscount(),
					  'invoice_date'     => $load->getInvoice_date(),
					  'dispatched'       => $load->getDispatched(),
					  'notes'            => $load->getNotes(),
					  'load_locked'      => $load->getLoad_locked(),
					  'locked_by'        => $load->getLocked_by(),
					  'delivered'        => $load->getDelivered(),
					  'last_updated'     => $load->getLast_updated(),
					  'last_updated_by'  => $load->getLast_updated_by(),
					  'active'           => $load->getActive());
    	 
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('load_id = ?', $load->getLoad_id());

		$this->getDbTable()
			 ->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()
						  ->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $load = new LLLT_Model_Load();
            
        	$load->setLoad_id($row->load_id)        		  
	        	 ->setCarrier_id($row->carrier_id)
	        	 ->setBill_to_id($row->bill_to_id)
	        	 ->setShipper_id($row->shipper_id)
	        	 ->setOrigin_id($row->origin_id)
	        	 ->setCustomer_id($row->customer_id)
	        	 ->setDestination_id($row->destination_id)
				 ->setProduct_id($row->product_id)
				 ->setDriver_id($row->driver_id)
				 ->setDelayed_dispatch($row->delayed_dispatch)
				 ->setLoad_date($row->load_date)
				 ->setDelivery_date($row->delivery_date)
				 ->setOrder_number($row->order_number)
				 ->setBill_of_lading($row->bill_of_lading)
				 ->setNet_gallons($row->net_gallons)
				 ->setBill_rate($row->bill_rate)
				 ->setFuel_surcharge($row->fuel_surchage)
				 ->setDiscount($row->discount)
				 ->setInvoice_date($row->invoice_date)
				 ->setDispatched($row->dispatched)
				 ->setNotes($row->notes)
				 ->setLoad_locked($row->load_locked)
				 ->setLocked_by($row->locked_by)
				 ->setDelivered($row->delivered)
	        	 ->setCreated($row->created)
	        	 ->setCreated_by($row->created_by)
	        	 ->setLast_updated($row->last_updated)
	        	 ->setLast_updated_by($row->last_updated_by)
				 ->setActive($row->active);
                  
            $entries[] = $load;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()
					   ->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The load could not be found.';
        }
        
        $row = $result->current();
        
		$load = new LLLT_Model_Load();
		
    	$load->setLoad_id($row->load_id)        		  
        	 ->setCarrier_id($row->carrier_id)
        	 ->setBill_to_id($row->bill_to_id)
        	 ->setShipper_id($row->shipper_id)
        	 ->setOrigin_id($row->origin_id)
        	 ->setCustomer_id($row->customer_id)
        	 ->setDestination_id($row->destination_id)
			 ->setProduct_id($row->product_id)
			 ->setDriver_id($row->driver_id)
			 ->setDelayed_dispatch($row->delayed_dispatch)
			 ->setLoad_date($row->load_date)
			 ->setDelivery_date($row->delivery_date)
			 ->setOrder_number($row->order_number)
			 ->setBill_of_lading($row->bill_of_lading)
			 ->setNet_gallons($row->net_gallons)
			 ->setBill_rate($row->bill_rate)
			 ->setFuel_surcharge($row->fuel_surcharge)
			 ->setDiscount($row->discount)
			 ->setInvoice_date($row->invoice_date)
			 ->setDispatched($row->dispatched)
			 ->setNotes($row->notes)
			 ->setLoad_locked($row->load_locked)
			 ->setLocked_by($row->locked_by)
			 ->setDelivered($row->delivered)
        	 ->setCreated($row->created)
        	 ->setCreated_by($row->created_by)
        	 ->setLast_updated($row->last_updated)
        	 ->setLast_updated_by($row->last_updated_by)
			 ->setActive($row->active);
	        	
	    return $load;
    }
}