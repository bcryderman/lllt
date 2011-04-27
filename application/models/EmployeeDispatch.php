<?php 

class LLLT_Model_EmployeeDispatch {

	protected $_emp_id; 	 	 	 	 	 	
	protected $_load_id;	 
	protected $_dispatch_date; 	 	 	 	 	

    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid employee dispatch property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid employee dispatch property');
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

 	public function setLoad_id($val) {
    	
        $this->_load_id = $val;
        
        return $this;
    }
 
    public function getLoad_id() {
    	
        return $this->_load_id;
    }
        
 	public function setDispatch_date($val) {
    	
        $this->_dispatch_date = $val;
        
        return $this;
    }
 
    public function getDispatch_date() {
    	
        return $this->_dispatch_date;
    }
}