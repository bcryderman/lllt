<?php 

class LLLT_Model_QbQueue {

	protected $_id; 	 	 	 	 	 	
	protected $_queue_id;
	protected $_load_id;	 	 	 	 	
	protected $_active;

 	 	
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
    
 	public function setId($val) {
    	
        $this->_id = (int) $val;
        
        return $this;
    }
 
    public function getId() {
    	
        return $this->_id;
    }
    
 	public function setQueue_id($val) {
    	
        $this->_queue_id = $val;
        
        return $this;
    }
 
    public function getQueue_id() {
    	
        return $this->_queue_id;
    }
    
 	public function setLoad_id($val) {
    	
        $this->_load_id = (int) $val;
        
        return $this;
    }
 
    public function getLoad_id() {
    	
        return $this->_load_id;
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
    
  
}