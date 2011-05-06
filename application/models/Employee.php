<?php 

class LLLT_Model_Employee {
	
 	protected $_emp_id;
 	protected $_first_name;
 	protected $_last_name;
 	protected $_addr;
 	protected $_addr2;
 	protected $_city;
 	protected $_state;
 	protected $_zip;
 	protected $_zip4;
 	protected $_vehicle_id;
 	protected $_role_id;
	protected $_role_name;
 	protected $_active = 0;
 	protected $_email;
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
        	
            throw new Exception('Invalid employee property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid employee property');
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
    
    public function setEmp_id($val) {
    	
        $this->_emp_id = (int) $val;
        
        return $this;
    }
 
    public function getEmp_id() {
    	
        return $this->_emp_id;
    }
       
    public function setFirst_name($val) {
    	
        $this->_first_name = $val;
        
        return $this;
    }
 
    public function getFirst_name() {
    	
        return $this->_first_name;
    }
    
    public function setLast_name($val) {
    	
        $this->_last_name = $val;
        
        return $this;
    }
 
    public function getLast_name() {
    	
        return $this->_last_name;
    }
    
    public function setAddr($val) {
    	
        $this->_addr = $val;
        
        return $this;
    }
 
    public function getAddr() {
    	
        return $this->_addr;
    }
    
    public function setAddr2($val) {
    	
        $this->_addr2 = $val;
        
        return $this;
    }
 
    public function getAddr2() {
    	
        return $this->_addr2;
    }
    
    public function setCity($val) {
    	
        $this->_city = $val;
        
        return $this;
    }
 
    public function getCity() {
    	
        return $this->_city;
    }
    
    public function setState($val) {
    	
        $this->_state = $val;
        
        return $this;
    }
 
    public function getState() {
    	
        return $this->_state;
    }
    
    public function setZip($val) {
    	
        $this->_zip = $val;
        
        return $this;
    }
 
    public function getZip() {
    	
        return $this->_zip;
    }
    
    public function setZip4($val) {
    	
        $this->_zip4 = $val;
        
        return $this;
    }
 
    public function getZip4() {
    	
        return $this->_zip4;
    }
    
    public function setVehicle_id($val) {
    	
        $this->_vehicle_id = $val;
        
        return $this;
    }
 
    public function getVehicle_id() {
    	
        return $this->_vehicle_id;
    }
    
    public function setRole_id($val) {
    	
        $this->_role_id = (int) $val;
        
        return $this;
    }
 
    public function getRole_id() {
    	
        return $this->_role_id;
    }

    public function setRole_name($val) {
    	
        $this->_role_name = $val;
        
        return $this;
    }
 
    public function getRole_name() {
    	
        return $this->_role_name;
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
    
    public function setEmail($val) {
    	
        $this->_email = $val;
        
        return $this;
    }
 
    public function getEmail() {
    	
        return $this->_email;
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
    
    public function getLast_udpated_by() {
    	
        return $this->_last_updated_by;
    } 
}