<?php 

class LLLT_Model_Role {
	
 	protected $_role_id;
 	protected $_role_name;
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
        	
            throw new Exception('Invalid role property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid role property');
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
         
    public function setRole_id($val) {
    	
        $this->_role_id = $val;
        
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