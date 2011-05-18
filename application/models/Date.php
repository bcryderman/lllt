<?php 

class LLLT_Model_Date {

	protected $_months = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
	protected $_days   = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31);
 	protected $_date;

    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid date property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid date property');
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
    
 	public function setDate($val) {
    	
        $this->_date = array('month' => (int) substr($val, 0, 2),
							 'day'   => (int) substr($val, 3, 2),
							 'year'  => (int) substr($val, 6, 4));
        
        return $this;
    }
 
    public function getDate() {
    	
        return $this->_date;
    }

	public function isValid() {

		if (checkdate($this->_date['month'], $this->_date['day'], $this->_date['year'])) {
			
			return true;
		}
		
		return false;
	}
}