<?php 

class LLLT_Model_CarrierDiscount {

	protected $_id; 	 	 	 	 	 	
	protected $_company_id;	 
	protected $_start_date; 	 	 	 	 	
	protected $_end_date; 	 	 	 	 	 	
	protected $_discount;
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
        	
            throw new Exception('Invalid carrier discount property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid carrier discount property');
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
    	
        $this->_id = $val;
        
        return $this;
    }
 
    public function getId() {
    	
        return $this->_id;
    }
    
 	public function setCompany_id($val) {
    	
        $this->_company_id = $val;
        
        return $this;
    }
 
    public function getCompany_id() {
    	
        return $this->_company_id;
    }
        
 	public function setStart_date($val) {
    	
        $this->_start_date = $val;
        
        return $this;
    }
 
    public function getStart_date() {
    	
        return $this->_start_date;
    }
    
 	public function setEnd_date($val) {
    	
        $this->_end_date = $val;
        
        return $this;
    }
 
    public function getEnd_date() {
    	
        return $this->_end_date;
    }
    
    public function setDiscount($val) {
    	
        $this->_discount = $val;
        
        return $this;
    }
 
    public function getDiscount() {
    	
        return $this->_discount;
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