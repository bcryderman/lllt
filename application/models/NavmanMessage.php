<?php 

class LLLT_Model_NavmanMessage {

	protected $_message_id;
	protected $_message_thread_id;
	protected $_navman_vehicle_id;
	protected $_message_body;
	protected $_processed = 0;//db defaults to zero but cannot be null.
	protected $_message_date;

 	 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid navman message property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid navman message property');
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
    
 	public function setMessage_id($val) {
    	
        $this->_message_id = $val;
        
        return $this;
    }
 
    public function getMessage_id() {
    	
        return $this->_message_id;
    }
    
 	public function setMessage_thread_id($val) {
    	
        $this->_message_thread_id = $val;
        
        return $this;
    }
 
    public function getMessage_thread_id() {
    	
        return $this->_message_thread_id;
    }
        
 	public function setNavman_vehicle_id($val) {
    	
        $this->_navman_vehicle_id = $val;
        
        return $this;
    }
 
    public function getNavman_vehicle_id() {
    	
        return $this->_navman_vehicle_id;
    }
    
 	public function setMessage_body($val) {
    	
        $this->_message_body = $val;
        
        return $this;
    }
 
    public function getMessage_body() {
    	
        return $this->_message_body;
    }
    
    public function setProcessed($val) {
    	
        $this->_processed = $val;
        
        return $this;
    }
 
    public function getProcessed() {
    	
        return $this->_processed;
    }
    
    public function setMessage_date($val) {
    	
        $this->_message_date = $val;
        
        return $this;
    }
 
    public function getMessage_date() {
    	
        return $this->_message_date;
    }
    
    public function setMessage_dispatch($val) {
    	
        $this->_message_dispatch = $val;
        
        return $this;
    }
 
}