<?php 

class LLLT_Model_Vemploads {
	
 	protected $_emp_id;
 	protected $_first_name;
 	protected $_last_name;
 	protected $_compartments;
 	protected $_dispatched_loads;
 	protected $_pending_loads;
 	protected $_last_dispatch;
 	protected $_navman_vehicle_id;
 	
 	
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
    	
        $this->_first_name = (string) $val;
        
        return $this;
    }
 
    public function getFirst_name() {
    	
        return $this->_first_name;
    }
    
    public function setLast_name($val) {
    	
        $this->_last_name = (string) $val;
        
        return $this;
    }
 
    public function getLast_name() {
    	
        return $this->_last_name;
    }
    
    public function setCompartments($val) {
    	
        $this->_compartments = (string) $val;
        
        return $this;
    }
 
    public function getCompartments() {
    	
        return $this->_compartments;
    }
    
    public function setDispatched_loads($val) {
    	
        $this->_dispatched_loads = (string) $val;
        
        return $this;
    }
 
    public function getDispatched_loads() {
    	
        return $this->_dispatched_loads;
    }
    
    public function setPending_loads($val) {
    	
        $this->_pending_loads = (string) $val;
        
        return $this;
    }
 
    public function getPending_loads() {
    	
        return $this->_pending_loads;
    }
    
    public function setLast_dispatch($val) {
    	
        $this->_last_dispatch = (string) $val;
        
        return $this;
    }
 
    public function getLast_dispatch() {
    	
        return $this->_last_dispatch;
    }
    
    public function setNavman_vehicle_id($val) {
    	
        $this->_navman_vehicle_id = (string) $val;
        
        return $this;
    }
 
    public function getNavman_vehicle_id() {
    	
        return $this->_navman_vehicle_id;
    }
    
}