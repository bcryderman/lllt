<?php 

class LLLT_Model_Rates {
	
 	protected $_rate_id;
 	protected $_bill_to_id;
 	protected $_origin_id;
 	protected $_destination_id;
 	protected $_start_date;
 	protected $_end_date;
 	protected $_route_type_id;
 	protected $_rate;
 	protected $_created;
 	protected $_created_by;
 	protected $_last_updated;
 	protected $_last_updated_by;
 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid minimum bill gallons property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid minimum bill gallons property');
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
    
    public function setRate_id($val) {
    	
        $this->_rate_id = (int) $val;
        
        return $this;
    }
 
    public function getRate_id() {
    	
        return $this->_rate_id;
    }
       
    public function setBill_to_id($val) {
    	
        $this->_bill_to_id = $val;
        
        return $this;
    }
    
 
    public function getBill_to_id() {
    	
        return $this->_bill_to_id;
    }
 
    public function getOrigin_id() {
    	
        return $this->_origin_id;
    }
    
    public function setOrigin_id($val) {
    	
        $this->_origin_id = $val;
        
        return $this;
    }
    
    public function getDestination_id() {
    	
        return $this->_destination_id;
    }
    
    public function setDestination_id($val) {
    	
        $this->_destination_id = $val;
        
        return $this;
    }

    public function setStart_date($val) {
    	
        $this->_start_date = $val;
        
        return $this;
    }
 
    public function getStart_date() {
    	
        return $this->_start_date;
    }
    
    public function setEnd_date($val) {
    	
        $this->_end_date = $val;
        
        return $this;
    }
 
    public function getEnd_date() {
    	
        return $this->_end_date;
    }
    
    public function setRoute_type_id($val) {
    	
        $this->_route_type_id = $val;
        
        return $this;
    }
 
    public function getRoute_type_id() {
    	
        return $this->_route_type_id;
    }
    
    public function setRate($val) {
    	
        $this->_rate = $val;
        
        return $this;
    }
 
    public function getRate() {
    	
        return $this->_rate;
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
}