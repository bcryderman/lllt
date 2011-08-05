<?php

class LLLT_Model_VemploadsMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Vemploads');
        }
        
        return $this->_dbTable;
    }
    
   
    
    public function fetchAll($where, $order = null) {
    	
		$sql = 'SELECT * FROM v_emp_loads';
		
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
        	
            $load = new LLLT_Model_Vemploads();
        	$load->setEmp_id($row->emp_id)        		  
	        	 ->setFirst_name($row->first_name)
				 ->setLast_name($row->last_name)
	        	 ->setCompartments($row->compartments)
	 			 ->setDispatched_loads($row->dispatched_loads)
	        	 ->setPending_loads($row->pending_loads)
	        	 ->setLast_dispatch($row->last_dispatch)
	        	 ->setNavman_vehicle_id($row->navman_vehicle_id);
                  
            $entries[] = $load;            
        }
        
        return $entries;
    }
    
    public function find($id){
    	$sql = 'SELECT * FROM v_emp_loads
				WHERE v_emp_loads.emp_id = ' . $id;

		$this->getDbTable()
			 ->getAdapter()
			 ->setFetchMode(Zend_Db::FETCH_OBJ);

		$row = $this->getDbTable()
					->getAdapter()
					->fetchRow($sql);
							        
        if (0 == count($row)) {
        	
        	return 'The asset could not be found.';
        }
        
       $load = new LLLT_Model_Vemploads();
        	$load->setEmp_id($row->emp_id)        		  
	        	 ->setFirst_name($row->first_name)
				 ->setLast_name($row->last_name)
	        	 ->setCompartments($row->compartments)
	 			 ->setDispatched_loads($row->dispatched_loads)
	        	 ->setPending_loads($row->pending_loads)
	        	 ->setLast_dispatch($row->last_dispatch)
	        	 ->setNavman_vehicle_id($row->navman_vehicle_id);

	    return $load;
    }
    
//	public function find($id) {
//		
//		$sql = 'SELECT l.*, 
//					   c1.name AS carrier, 
//					   c2.name AS bill_to,
//					   c3.name AS shipper,
//					   c4.city AS origin_city,
//					   c4.state AS origin_state,
//					   c4.name AS origin_name,
//					   c5.name AS customer,
//					   c6.city AS destination_city,
//					   c6.state AS destination_state,
//					   c6.name AS destination_name,
//					   pt.product_type AS product,
//					   e.first_name AS driver_first_name,
//					   e.last_name AS driver_last_name
//				FROM tbl_load l
//				LEFT JOIN tbl_customer AS c1 ON l.carrier_id = c1.customer_id
//				LEFT JOIN tbl_customer AS c2 ON l.bill_to_id = c2.customer_id
//				LEFT JOIN tbl_customer AS c3 ON l.shipper_id = c2.customer_id
//				LEFT JOIN tbl_customer AS c4 ON l.origin_id = c4.customer_id
//				LEFT JOIN tbl_customer AS c5 ON l.customer_id = c5.customer_id
//				LEFT JOIN tbl_customer AS c6 ON l.destination_id = c6.customer_id
//				LEFT JOIN tbl_product_type AS pt ON l.product_id = pt.product_type_id
//				LEFT JOIN tbl_employee AS e ON l.driver_id = e.emp_id
//				WHERE l.load_id = ' . $id;
//		
//		$this->getDbTable()
//			 ->getAdapter()
//			 ->setFetchMode(Zend_Db::FETCH_OBJ);
//		
//		$row = $this->getDbTable()
//					->getAdapter()
//					->fetchRow($sql);
//        
//		$load = new LLLT_Model_Load();
//    	$load->setLoad_id($row->load_id)        		  
//        	 ->setCarrier_id($row->carrier_id)
//			 ->setCarrier($row->carrier)
//        	 ->setBill_to_id($row->bill_to_id)
// 			 ->setBill_to($row->bill_to)
//        	 ->setShipper_id($row->shipper_id)
//			 ->setShipper($row->shipper)
//        	 ->setOrigin_id($row->origin_id)
//			 ->setOrigin(array('city'  => $row->origin_city,
//							   'state' => $row->origin_state,
//							   'name'  => $row->origin_name))
//        	 ->setCustomer_id($row->customer_id)
//			 ->setCustomer($row->customer)
//        	 ->setDestination_id($row->destination_id)
// 			 ->setDestination(array('city'  => $row->destination_city,
//							   		'state' => $row->destination_state,
//							   		'name'  => $row->destination_name))
//			 ->setProduct_id($row->product_id)
//			 ->setProduct($row->product)
//			 ->setDriver_id($row->driver_id)
//			 ->setDriver(array('first_name' => $row->driver_first_name,
//							   'last_name'  => $row->driver_last_name))
//			 ->setDelayed_dispatch($row->delayed_dispatch)
//			 ->setLoad_date($row->load_date)
//			 ->setLoad_time($row->load_date)
//			 ->setDelivery_date($row->delivery_date)
//			 ->setDelivery_time($row->delivery_date)
//			 ->setOrder_number($row->order_number)
//			 ->setBill_of_lading($row->bill_of_lading)
//			 ->setNet_gallons($row->net_gallons)
//			 ->setBill_rate($row->bill_rate)
//			 ->setFuel_surcharge($row->fuel_surchage)
//			 ->setDiscount($row->discount)
//			 ->setInvoice_date($row->invoice_date)
//			 ->setDispatched($row->dispatched)
//			 ->setNotes($row->notes)
//			 ->setLoad_locked($row->load_locked)
//			 ->setLocked_by($row->locked_by)
//			 ->setDelivered($row->delivered)
//        	 ->setCreated($row->created)
//        	 ->setCreated_by($row->created_by)
//        	 ->setLast_updated($row->last_updated)
//        	 ->setLast_updated_by($row->last_updated_by)
//			 ->setActive($row->active)
//			 ->setDriver_compartment_number($row->driver_compartment_number);
//	        	
//	    return $load;
//    }
}