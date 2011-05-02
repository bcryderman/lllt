<?php 

class LLLT_Model_Asset {

	protected $_asset_id; 	 	 	 	 	 	
	protected $_asset_type_id;	 
	protected $_asset_type_name;
	protected $_asset_name; 	 	 	 	 	
	protected $_compartment_count; 	 	 	 	 	 	
	protected $_active;
	protected $_customer_id;
	protected $_customer_name;
	protected $_navman_vehicle_id;
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
        	
            throw new Exception('Invalid asset property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid asset property');
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
    
 	public function setAsset_id($val) {
    	
        $this->_asset_id = $val;
        
        return $this;
    }
 
    public function getAsset_id() {
    	
        return $this->_asset_id;
    }
    
 	public function setAsset_type_id($val) {
    	
        $this->_asset_type_id = $val;
        
        return $this;
    }
 
    public function getAsset_type_id() {
    	
        return $this->_asset_type_id;
    }

 	public function setAsset_type_name($val) {
    	
        $this->_asset_type_name = $val;
        
        return $this;
    }
 
    public function getAsset_type_name() {
    	
        return $this->_asset_type_name;
    }
        
 	public function setAsset_name($val) {
    	
        $this->_asset_name = $val;
        
        return $this;
    }
 
    public function getAsset_name() {
    	
        return $this->_asset_name;
    }
    
 	public function setCompartment_count($val) {
    	
        $this->_compartment_count = $val;
        
        return $this;
    }
 
    public function getCompartment_count() {
    	
        return $this->_compartment_count;
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
    
    public function setCustomer_id($val) {
    	
        $this->_customer_id = $val;
        
        return $this;
    }
 
    public function getCustomer_id() {
    	
        return $this->_customer_id;
    }
    
    public function setCustomer_name($val) {
    	
        $this->_customer_name = $val;
        
        return $this;
    }
 
    public function getCustomer_name() {
    	
        return $this->_customer_name;
    }

    public function setNavman_vehicle_id($val) {
    	
        $this->_navman_vehicle_id = $val;
        
        return $this;
    }
 
    public function getNavman_vehicle_id() {
    	
        return $this->_navman_vehicle_id;
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