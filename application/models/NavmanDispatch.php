<?php 

class LLLT_Model_NavmanDispatch {

	protected $_navman_dispatch_id;
	protected $_load_id;
	protected $_emp_id;
	protected $_sent_date;
	protected $_message_id;
	protected $_system_post_date;
	protected $_navman_post_date;
 	 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid navman cancel property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid navman cancel property');
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
    
 	public function setNavman_dispatch_id($val) {
    	
        $this->_navman_dispatch_id = $val;
        
        return $this;
    }
 
    public function getNavman_dispatch_id() {
    	
        return $this->_navman_dispatch_id;
    }
    
 	public function setLoad_id($val) {
    	
        $this->_load_id = $val;
        
        return $this;
    }
 
    public function getLoad_id() {
    	
        return $this->_load_id;
    }
        
 	public function setEmp_id($val) {
    	
        $this->_emp_id = $val;
        
        return $this;
    }
 
    public function getEmp_id() {
    	
        return $this->_emp_id;
    }
    
 	public function setSent_date($val) {
    	
        $this->_sent_date = $val;
        
        return $this;
    }
 
    public function getSent_date() {
    	
        return $this->_sent_date;
    }
    
    public function setMessage_id($val) {
    	
        $this->_message_id = $val;
        
        return $this;
    }
 
    public function getMessage_id() {
    	
        return $this->_message_id;
    }
    
    public function setSystem_post_date($val) {
    	
        $this->_system_post_date = $val;
        
        return $this;
    }
 
    public function getSystem_post_date() {
    	
        return $this->_system_post_date;
    }
            
    public function setNavman_post_date($val) {
    	
        $this->_navman_post_date = $val;
        
        return $this;
    }
 
    public function getNavman_post_date() {
    	
        return $this->_navman_post_date;
    }
}