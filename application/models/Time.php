<?php 

class LLLT_Model_Time {

	protected $_hours   = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
	protected $_minutes = array(0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55);
 	protected $_time;

    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid time property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid time property');
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
    
 	public function setTime($val) {
    	
        $this->_time = array('hour'   => (int) substr($val, 0, 2),
							 'minute' => (int) substr($val, 3, 2));
        
        return $this;
    }
 
    public function getTime() {
    	
        return $this->_time;
    }

	public function isValid() {

		$valid = false;
		
		foreach ($this->_hours as $key => $val) {
			
			if ($this->_time['hour'] == $this->_hours[$key]) {
				
				foreach ($this->_minutes as $k => $v) {
					
					if ($this->_time['minute'] == $this->_minutes[$k]) {
						
						$valid = true;
					}
				}
			}
		}
		
		return $valid;
	}
}