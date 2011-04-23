<?php 

class LLLT_Model_LoginAttempt {
	
 	protected $_emp_id;
 	protected $_username;
 	protected $_password;
 	protected $_ip;
 	protected $_attempt_date;
 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid login attempt property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid login attempt property');
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
    	
        $this->_emp_id = $val;
        
        return $this;
    }
 
    public function getEmp_id() {
    	
        return $this->_emp_id;
    }
     
    public function setUsername($val) {
    	
        $this->_username = strtolower($val);
        
        return $this;
    }
 
    public function getUsername() {
    	
        return $this->_username;
    }
    
    public function setPassword($val) {
    	
        $this->_password = $val;
        
        return $this;
    }
 
    public function getPassword() {
    	
        return $this->_password;
    }
    
    public function setIp($val) {
    	
        $this->_ip = $val;
        
        return $this;
    }
 
    public function getIp() {
    	
        return $this->_ip;
    }
        
    public function setAttempt_date($val) {
    	
        $this->_attempt_date = $val;
        
        return $this;
    }
    
    public function getAttempt_date() {
    	
        return $this->_attempt_date;
    } 
}