<?php 

class LLLT_Model_EmployeeComm {
	
 	protected $_emp_id;
 	protected $_communication_type_id;
 	protected $_phone;
 	protected $_phone_ext;
 	protected $_primary;
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
        	
            throw new Exception('Invalid login property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid login property');
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
     
    public function setCommunication_type_id($val) {
    	
        $this->_communication_type_id = $val;
        
        return $this;
    }
 
    public function getCommunication_type_id() {
    	
        return $this->_communication_type_id;
    }
    
	public function setPhone($val) {
    	
    	if (strlen($val) === 14) {
    		
    		$areaCode = substr($val, 1, 3);
    		$next3    = substr($val, 6, 3);
    		$last4    = substr($val, 10, 4);
    		
    		$val = $areaCode . $next3 . $last4;
    	}

        $this->_phone = $val;

        return $this;
    }
 
    public function getPhone() {
    	
        return $this->_phone;
    }
    
	public function setPhone_ext($val) {
    	
        $this->_phone_ext = $val;
        
        return $this;
    }
 
    public function getPhone_ext() {
    	
        return $this->_phone_ext;
    }
    
	public function setPrimary($val) {
    	
        $this->_primary = $val;
        
        return $this;
    }
 
    public function getPrimary() {
    	
        return $this->_primary;
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