<?php 

class LLLT_Model_EmployeeAttrib {

	protected $_emp_id; 	 	 	 	 	 	
	protected $_attrib_id;	 
	protected $_value; 	 	 	 	 	
	protected $_created;
	protected $_created_by;
	protected $_last_updated;
	protected $_last_updated_by;

    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid employee attrib property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid employee attrib property');
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

 	public function setAttrib_id($val) {
    	
        $this->_attrib_id = $val;
        
        return $this;
    }
 
    public function getAttrib_id() {
    	
        return $this->_attrib_id;
    }
        
 	public function setValue($val) {
    	
        $this->_value = $val;
        
        return $this;
    }
 
    public function getValue() {
    	
        return $this->_value;
    }
            
    public function setCreated($val) {
    	
        $this->_created = $val;
        
        return $this;
    }
 
    public function getCreated() {
    	
        return $this->_created;
    }
    
    public function setCreated_by($val) {
    	
        $this->_created_by = $val;
        
        return $this;
    }
 
    public function getCreated_by() {
    	
        return $this->_created_by;
    }
    
    public function setLast_updated($val) {
    	
        $this->_last_updated = $val;
        
        return $this;
    }
 
    public function getLast_updated() {
    	
        return $this->_last_updated;
    }
    
    public function setLast_updated_by($val) {
    	
        $this->_last_updated_by = $val;
        
        return $this;
    }
    
    public function getLast_updated_by() {
    	
        return $this->_last_updated_by;
    }
}