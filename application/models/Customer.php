<?php 

class LLLT_Model_Customer {
	
 	protected $_customer_id;
 	protected $_name;
 	protected $_addr;
 	protected $_addr2;
 	protected $_city;
 	protected $_state;
 	protected $_zip;
 	protected $_zip4;
 	protected $_fein;
 	protected $_color_code;
 	protected $_customer_type_id;
 	protected $_primary_customer_contact_id;
 	protected $_carrier_navman_owner_id;
 	protected $_quickbook_print;
 	protected $_active;
 	protected $_notes;
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
        	
            throw new Exception('Invalid customer property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid customer property');
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
    	
    public function setCustomer_id($val) {
    	
        $this->_customer_id = $val;
        
        return $this;
    }
 
    public function getCustomer_id() {
    	
        return $this->_customer_id;
    }
       
    public function setName($val) {
    	
        $this->_name = $val;
        
        return $this;
    }
 
    public function getName() {
    	
        return $this->_name;
    }
    
    public function setAddr($val) {
    	
        $this->_addr = $val;
        
        return $this;
    }
 
    public function getAddr() {
    	
        return $this->_addr;
    }
    
    public function setAddr2($val) {
    	
        $this->_addr2 = $val;
        
        return $this;
    }
 
    public function getAddr2() {
    	
        return $this->_addr2;
    }
    
    public function setCity($val) {
    	
        $this->_city = $val;
        
        return $this;
    }
 
    public function getCity() {
    	
        return $this->_city;
    }
    
    public function setState($val) {
    	
        $this->_state = $val;
        
        return $this;
    }
 
    public function getState() {
    	
        return $this->_state;
    }
    
    public function setZip($val) {
    	
        $this->_zip = $val;
        
        return $this;
    }
 
    public function getZip() {
    	
        return $this->_zip;
    }
    
    public function setZip4($val) {
    	
        $this->_zip4 = $val;
        
        return $this;
    }
 
    public function getZip4() {
    	
        return $this->_zip4;
    }
 	
    public function setFein($val) {
    	
        $this->_fein = $val;
        
        return $this;
    }
 
    public function getFein() {
    	
        return $this->_fein;
    }

    public function setColor_code($val) {
    	
        $this->_color_code = $val;
        
        return $this;
    }
 
    public function getColor_code() {
    	
        return $this->_color_code;
    }
    
    public function setCustomer_type_id($val) {
    	
        $this->_customer_type_id = $val;
        
        return $this;
    }
 
    public function getCustomer_type_id() {
    	
        return $this->_customer_type_id;
    }

    public function setPrimary_customer_contact_id($val) {
    	
        $this->_primary_customer_contact_id = $val;
        
        return $this;
    }
 
    public function getPrimary_customer_contact_id() {
    	
        return $this->_primary_customer_contact_id;
    }
    
    public function setCarrier_navman_owner_id($val) {
    	
        $this->_carrier_navman_owner_id = $val;
        
        return $this;
    }
 
    public function getCarrier_navman_owner_id() {
    	
        return $this->_carrier_navman_owner_id;
    }
    
    public function setQuickbook_print($val) {
    	
        $this->_quickbook_print = $val;
        
        return $this;
    }
 
    public function getQuickbook_print() {
    	
        return $this->_quickbook_print;
    }
    
    public function setActive($val) {
    	    	
        $this->_active = $val;
        
        return $this;
    }
 
    public function getActive() {
    	
        return $this->_active;
    }
       
    public function setNotes($val) {
    	
        $this->_notes = $val;
        
        return $this;
    }
 
    public function getNotes() {
    	
        return $this->_notes;
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