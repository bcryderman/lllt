<?php 

class LLLT_Model_Load {

	protected $_load_id;
	protected $_carrier_id;
	protected $_bill_to_id;
	protected $_shipper_id;
	protected $_origin_id;
	protected $_customer_id;
	protected $_destination_id;
	protected $_product_id;
	protected $_driver_id;
	protected $_delayed_dispatch;
	protected $_load_date;
	protected $_load_time;
	protected $_delivery_date;
	protected $_delivery_time;
	protected $_order_number;
	protected $_bill_of_lading;
	protected $_net_gallons;
	protected $_bill_rate;
	protected $_fuel_surcharge;
	protected $_discount;
	protected $_invoice_date;
	protected $_dispatched;
	protected $_notes;
	protected $_load_locked;
	protected $_locked_by;
	protected $_delivered;
	protected $_created;
	protected $_created_by;
	protected $_last_updated;
	protected $_last_updated_by;
	protected $_active;
 	 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid load property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid load property');
        }
        
        return $this->$method();
    }
    
    public function setOptions(array $options) {
 		
        $methods = get_class_methods($this);
        
        foreach ($options as $key => $value) {
        	
            $method = 'set' . ucfirst($key);
            
            if (in_array($method, $methods)) {
            	
                $this->$method($value);
            }
        }
        
        return $this;
    }  
    
 	public function setLoad_id($val) {
    	
        $this->_load_id = $val;
        
        return $this;
    }
 
    public function getLoad_id() {
    	
        return $this->_load_id;
    }
    
 	public function setCarrier_id($val) {
    	
        $this->_carrier_id = $val;
        
        return $this;
    }
 
    public function getCarrier_id() {
    	
        return $this->_carrier_id;
    }
        
 	public function setBill_to_id($val) {
    	
        $this->_bill_to_id = $val;
        
        return $this;
    }
 
    public function getBill_to_id() {
    	
        return $this->_bill_to_id;
    }
	
 	public function setShipper_id($val) {
    	
        $this->_shipper_id = $val;
        
        return $this;
    }
 
    public function getShipper_id() {
    	
        return $this->_shipper_id;
    }

 	public function setOrigin_id($val) {
    	
        $this->_origin_id = $val;
        
        return $this;
    }
 
    public function getOrigin_id() {
    	
        return $this->_origin_id;
    }

 	public function setCustomer_id($val) {
    	
        $this->_customer_id = $val;
        
        return $this;
    }
 
    public function getCustomer_id() {
    	
        return $this->_customer_id;
    }

 	public function setDestination_id($val) {
    	
        $this->_destination_id = $val;
        
        return $this;
    }
 
    public function getDestination_id() {
    	
        return $this->_destination_id;
    }

 	public function setProduct_id($val) {
    	
        $this->_product_id = $val;
        
        return $this;
    }
 
    public function getProduct_id() {
    	
        return $this->_product_id;
    }

 	public function setDriver_id($val) {
    	
        $this->_driver_id = $val;
        
        return $this;
    }
 
    public function getDriver_id() {
    	
        return $this->_driver_id;
    }

 	public function setDelayed_dispatch($val) {
    	
		if ($val === 'on' || $val == 1) {
    		
    		$this->_delayed_dispatch = 1;
    	}
    	else if (is_null($val) || $val == 0) {
    		
    		$this->_delayed_dispatch = 0;
    	}
        
        return $this;
    }
 
    public function getDelayed_dispatch() {
    	
        return $this->_delayed_dispatch;
    }
	
 	public function setLoad_date($val, $submit = false) {
    	
		if ($submit) {
			
			$this->_load_date = $val;
		}
		else {
			
			$this->_load_date = substr($val, 0, 10);
		}        
        return $this;
    }
 
    public function getLoad_date() {
    	
        return $this->_load_date;
    }

 	public function setLoad_time($val) {
    	
        $this->_load_time = substr($val, 11, 5);
        
        return $this;
    }
 
    public function getLoad_time() {
    	
        return $this->_load_time;
    }

 	public function setDelivery_date($val, $submit = false) {
    	
		if ($submit) {
			
			$this->_delivery_date = $val;
		}
		else {
			
			$this->_delivery_date = substr($val, 0, 10);
		}        
        
        return $this;
    }
 
    public function getDelivery_date() {
    	
        return $this->_delivery_date;
    }

 	public function setDelivery_time($val) {
    	
        $this->_delivery_time = substr($val, 11, 5);
        
        return $this;
    }
 
    public function getDelivery_time() {
    	
        return $this->_delivery_time;
    }	 	 

 	public function setOrder_number($val) {
    	
        $this->_order_number = $val;
        
        return $this;
    }
 
    public function getOrder_number() {
    	
        return $this->_order_number;
    }

 	public function setBill_of_lading($val) {
    	
        $this->_bill_of_lading = $val;
        
        return $this;
    }
 
    public function getBill_of_lading() {
    	
        return $this->_bill_of_lading;
    }	 	 	 

 	public function setNet_gallons($val) {
    	
        $this->_net_gallons = $val;
        
        return $this;
    }
 
    public function getNet_gallons() {
    	
        return $this->_net_gallons;
    }	 

 	public function setBill_rate($val) {
    	
        $this->_bill_rate = $val;
        
        return $this;
    }
 
    public function getBill_rate() {
    	
        return $this->_bill_rate;
    }	

 	public function setFuel_surcharge($val) {
    	
        $this->_fuel_surcharge = $val;
        
        return $this;
    }
 
    public function getFuel_surcharge() {
    	
        return $this->_fuel_surcharge;
    }

 	public function setDiscount($val) {
    	
        $this->_discount = $val;
        
        return $this;
    }
 
    public function getDiscount() {
    	
        return $this->_discount;
    }

 	public function setInvoice_date($val) {
    	
        $this->_invoice_date = $val;
        
        return $this;
    }
 
    public function getInvoice_date() {
    	
        return $this->_invoice_date;
    }

 	public function setDispatched($val) {
    	
        $this->_dispatched = $val;
        
        return $this;
    }
 
    public function getDispatched() {
    	
        return $this->_dispatched;
    }

 	public function setNotes($val) {
    	
        $this->_notes = $val;
        
        return $this;
    }
 
    public function getNotes() {
    	
        return $this->_notes;
    }

 	public function setLoad_locked($val) {
    	
        $this->_load_locked = $val;
        
        return $this;
    }
 
    public function getLoad_locked() {
    	
        return $this->_load_locked;
    }

 	public function setLocked_by($val) {
    	
        $this->_locked_by = $val;
        
        return $this;
    }
 
    public function getLocked_by() {
    	
        return $this->_locked_by;
    }

 	public function setDelivered($val) {
	
		if ($val === 'on' || $val == 1) {
    		
    		$this->_delivered = 1;
    	}
    	else if (is_null($val) || $val == 0) {
    		
    		$this->_delivered = 0;
    	}
        
        return $this;
    }
 
    public function getDelivered() {
    	
        return $this->_delivered;
    }

    public function setCreated($val) {
    	
        $this->_created = $val;
        
        return $this;
    }
 
    public function getCreated() {
    	
        return $this->_created;
    }
    
    public function setCreated_by($val) {
    	
        $this->_created_by = $val;
        
        return $this;
    }
 
    public function getCreated_by() {
    	
        return $this->_created_by;
    }
    
    public function setLast_updated($val) {
    	
        $this->_last_updated = $val;
        
        return $this;
    }
 
    public function getLast_updated() {
    	
        return $this->_last_updated;
    }
    
    public function setLast_updated_by($val) {
    	
        $this->_last_updated_by = $val;
        
        return $this;
    }
    
    public function getLast_updated_by() {
    	
        return $this->_last_updated_by;
    }

	public function setActive($val) {
    	
		if ($val === 'on' || $val == 1) {
    		
    		$this->_active = 1;
    	}
    	else if (is_null($val) || $val == 0) {
    		
    		$this->_active = 0;
    	}
        
        return $this;
    }
 
    public function getActive() {
    	
        return $this->_active;
    }
}