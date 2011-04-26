<?php 

class LLLT_Model_LoadLog {

	protected $_load_id;
	protected $_load_activity_type_id;
	protected $_activity_time;
	protected $_activity_by;
 	 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid load log property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid load log property');
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

 	public function setLoad_activity_type_id($val) {
    	
        $this->_load_activity_type_id = $val;
        
        return $this;
    }
 
    public function getLoad_activity_type_id() {
    	
        return $this->_load_activity_type_id;
    }
    
 	public function setActivity_time($val) {
    	
        $this->_activity_time = $val;
        
        return $this;
    }
 
    public function getActivity_time() {
    	
        return $this->_activity_time;
    }

 	public function setActivity_by($val) {
    	
        $this->_activity_by = $val;
        
        return $this;
    }
 
    public function getActivity_by() {
    	
        return $this->_activity_by;
    }
}