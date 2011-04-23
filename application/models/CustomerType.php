<?php 

class LLLT_Model_CustomerType {
	
 	protected $_customer_type_id;
 	protected $_customer_type;
 	protected $_active;
 	protected $_description;
 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid login property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid login property');
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
         
    public function setCustomer_type_id($val) {
    	
        $this->_customer_type_id = $val;
        
        return $this;
    }
 
    public function getCustomer_type_id() {
    	
        return $this->_customer_type_id;
    }

    public function setCustomer_type($val) {
    	
        $this->_customer_type = $val;
        
        return $this;
    }
 
    public function getCustomer_type() {
    	
        return $this->_customer_type;
    }

    public function setActive($val) {
    	
    	if ($val === 'on' || $val === 1) {
    		
    		$this->_active = 1;
    	}
    	else if (is_null($val) || $val === 0) {
    		
    		$this->_active = 0;
    	}
        
        return $this;
    }
 
    public function getActive() {
    	
        return $this->_active;
    }
        
    public function setDescription($val) {
    	
        $this->_description = $val;
        
        return $this;
    }
 
    public function getDescription() {
    	
        return $this->_description;
    }
}