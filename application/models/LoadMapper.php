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
					  'active'           => $load->getActive(),
	    			  'driver_compartment_number'	=> $load->getDriver_compartment_number());
	  	    	    	
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
    
    public function lockload(LLLT_Model_Load $load){
    	$data = array('load_id'          => $load->getLoad_id(),
    				  'load_locked'      => $load->getLoad_locked(),
					  'locked_by'        => $load->getLocked_by(),
					  'last_updated'     => $load->getLast_updated(),
					  'last_updated_by'  => $load->getLast_updated_by());
    			$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('load_id = ?', $load->getLoad_id());

		$this->getDbTable()
			 ->update($data, $where);
    	
    }
    
    public function dispatchload(LLLT_Model_Load $load){
    	$data = array('driver_id'     	 => $load->getDriver_id(),
					  'delayed_dispatch' => $load->getDelayed_dispatch(),
					  //'bill_rate'		 => $load->getBill_rate(),
    				  //'fuel_surchage'	 => $load->getFuel_surcharge(),
					  'last_updated'     => $load->getLast_updated(),
					  'last_updated_by'  => $load->getLast_updated_by(),
    				  'dispatched'		 => $load->getDispatched(),
    				  'notes'			 => $load->getNotes(),
    				  'load_date'		 => $load->getLoad_date());
    			$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('load_id = ?', $load->getLoad_id());

		$this->getDbTable()
			 ->update($data, $where);
    	
    }
    
	public function updatedriverload($data,$load_id){
 
    			$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('load_id = ?', $load_id);

		$this->getDbTable()
			 ->update($data, $where);
    	
    }
    
    
    public function fetchAll($where, $order = null) {
    	
		$sql = 'SELECT l.*, 
					   c1.name AS carrier, 
                       c1.color_code AS carrier_color,
					   c2.name AS bill_to,
                       c2.color_code AS bill_to_color,
					   c3.name AS shipper,
                       c3.color_code AS shipper_color,
					   c4.city AS origin_city,
					   c4.state AS origin_state,
					   c4.name AS origin_name,
                       c4.color_code AS origin_color,
					   c5.name AS customer,
                       c5.color_code AS customer_color,
					   c6.city AS destination_city,
					   c6.state AS destination_state,
					   c6.name AS destination_name,
                       c6.color_code AS destination_color,
					   pt.product_type AS product,
					   e.first_name AS driver_first_name,
					   e.last_name AS driver_last_name					   
				FROM tbl_load l
				LEFT JOIN tbl_customer AS c1 ON l.carrier_id = c1.customer_id
				LEFT JOIN tbl_customer AS c2 ON l.bill_to_id = c2.customer_id
				LEFT JOIN tbl_customer AS c3 ON l.shipper_id = c3.customer_id
				LEFT JOIN tbl_customer AS c4 ON l.origin_id = c4.customer_id
				LEFT JOIN tbl_customer AS c5 ON l.customer_id = c5.customer_id
				LEFT JOIN tbl_customer AS c6 ON l.destination_id = c6.customer_id
				LEFT JOIN tbl_product_type AS pt ON l.product_id = pt.product_type_id
				LEFT JOIN tbl_employee AS e ON l.driver_id = e.emp_id';
		
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

        $entries = array();
       
        foreach ($resultSet as $row) {
        	
            $load = new LLLT_Model_Load();
        	$load->setLoad_id($row->load_id)        		  
	        	 ->setCarrier_id($row->carrier_id)
				 ->setCarrier($row->carrier)
				 ->setCarrier_color($row->carrier_color)
	        	 ->setBill_to_id($row->bill_to_id)
	 			 ->setBill_to($row->bill_to)
	 			 ->setBill_to_color($row->bill_to_color)
	        	 ->setShipper_id($row->shipper_id)
				 ->setShipper($row->shipper)
				 ->setShipper_color($row->shipper_color)
	        	 ->setOrigin_id($row->origin_id)
				 ->setOrigin(array('city'  => $row->origin_city,
								   'state' => $row->origin_state,
								   'name'  => $row->origin_name))
				 ->setOrigin_color($row->origin_color)
	        	 ->setCustomer_id($row->customer_id)
				 ->setCustomer($row->customer)
				 ->setCustomer_color($row->customer_color)
	        	 ->setDestination_id($row->destination_id)
	 			 ->setDestination(array('city'  => $row->destination_city,
								   		'state' => $row->destination_state,
								   		'name'  => $row->destination_name))
	 			 ->setDestination_color($row->destination_color)
				 ->setProduct_id($row->product_id)
				 ->setProduct($row->product)
				 ->setDriver_id($row->driver_id)
				 ->setDriver(array('first_name' => $row->driver_first_name,
								   'last_name'  => $row->driver_last_name))
				 ->setDelayed_dispatch($row->delayed_dispatch)
				 ->setLoad_date($row->load_date)
				 ->setLoad_time($row->load_date)
				 ->setDelivery_date($row->delivery_date)
				 ->setDelivery_time($row->delivery_date)
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
				 ->setActive($row->active)
				 ->setDriver_compartment_number($row->driver_compartment_number)
				 ->setJson_obj($this->build_json_obj($row));
				 
                  
            $entries[] = $load;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
		$sql = 'SELECT l.*, 
					   c1.name AS carrier, 
                       c1.color_code AS carrier_color,
					   c2.name AS bill_to,
                       c2.color_code AS bill_to_color,
					   c3.name AS shipper,
                       c3.color_code AS shipper_color,
					   c4.city AS origin_city,
					   c4.state AS origin_state,
					   c4.name AS origin_name,
                       c4.color_code AS origin_color,
					   c5.name AS customer,
                       c5.color_code AS customer_color,
					   c6.city AS destination_city,
					   c6.state AS destination_state,
					   c6.name AS destination_name,
                       c6.color_code AS destination_color,
					   pt.product_type AS product,
					   e.first_name AS driver_first_name,
					   e.last_name AS driver_last_name
				FROM tbl_load l
				LEFT JOIN tbl_customer AS c1 ON l.carrier_id = c1.customer_id
				LEFT JOIN tbl_customer AS c2 ON l.bill_to_id = c2.customer_id
				LEFT JOIN tbl_customer AS c3 ON l.shipper_id = c3.customer_id
				LEFT JOIN tbl_customer AS c4 ON l.origin_id = c4.customer_id
				LEFT JOIN tbl_customer AS c5 ON l.customer_id = c5.customer_id
				LEFT JOIN tbl_customer AS c6 ON l.destination_id = c6.customer_id
				LEFT JOIN tbl_product_type AS pt ON l.product_id = pt.product_type_id
				LEFT JOIN tbl_employee AS e ON l.driver_id = e.emp_id
				WHERE l.load_id = ' . $id;
		
		$this->getDbTable()
			 ->getAdapter()
			 ->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$row = $this->getDbTable()
					->getAdapter()
					->fetchRow($sql);
        
		$load = new LLLT_Model_Load();
    	$load->setLoad_id($row->load_id)        		  
	         ->setCarrier_id($row->carrier_id)
			 ->setCarrier($row->carrier)
			 ->setCarrier_color($row->carrier_color)
	         ->setBill_to_id($row->bill_to_id)
	 		 ->setBill_to($row->bill_to)
	 		 ->setBill_to_color($row->bill_to_color)
	         ->setShipper_id($row->shipper_id)
			 ->setShipper($row->shipper)
			 ->setShipper_color($row->shipper_color)
	         ->setOrigin_id($row->origin_id)
			 ->setOrigin(array('city'  => $row->origin_city,
							   'state' => $row->origin_state,
							   'name'  => $row->origin_name))
			 ->setOrigin_color($row->origin_color)
	         ->setCustomer_id($row->customer_id)
			 ->setCustomer($row->customer)
			 ->setCustomer_color($row->customer_color)
	         ->setDestination_id($row->destination_id)
	 		 ->setDestination(array('city'  => $row->destination_city,
							   		'state' => $row->destination_state,
							   		'name'  => $row->destination_name))
	 		 ->setDestination_color($row->destination_color)
			 ->setProduct_id($row->product_id)
			 ->setProduct($row->product)
			 ->setDriver_id($row->driver_id)
			 ->setDriver(array('first_name' => $row->driver_first_name,
							   'last_name'  => $row->driver_last_name))
			 ->setDelayed_dispatch($row->delayed_dispatch)
			 ->setLoad_date($row->load_date)
			 ->setLoad_time($row->load_date)
			 ->setDelivery_date($row->delivery_date)
			 ->setDelivery_time($row->delivery_date)
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
			 ->setActive($row->active)
			 ->setDriver_compartment_number($row->driver_compartment_number);
	        	
	    return $load;
    }
    
    public function build_json_obj($load){
    
    	$obj = new LLLT_Model_Object2Array();
    	return json_encode($load);
    }

}