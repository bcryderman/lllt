<?php
class LLLT_Model_Customercontact{
	

	protected $_contact_id;
	protected $_customer_id;
	protected $_first_name;
	protected $_last_name;
	protected $_notes;
	protected $_phone;
	protected $_phone_ext;
	protected $_cell_phone;
	protected $_fax_phone;
	protected $_email;
	protected $_active;
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

	public function setContact_id($val) {
    	
        $this->_contact_id = $val;
        
        return $this;
    }
 
    public function getContact_id() {
    	
        return $this->_contact_id;
    }
    
	public function setCustomer_id($val) {
    	
        $this->_customer_id = $val;
        
        return $this;
    }
 
    public function getCustomer_id() {
    	
        return $this->_customer_id;
    }
    
	public function setFirst_name($val) {
    	
        $this->_first_name = $val;
        
        return $this;
    }
 
    public function getFirst_name() {
    	
        return $this->_first_name;
    }
    
	public function setLast_name($val) {
    	
        $this->_last_name= $val;
        
        return $this;
    }
 
    public function getLast_name() {
    	
        return $this->_last_name;
    }
    
	public function setNotes($val) {
    	
        $this->_notes = $val;
        
        return $this;
    }
 
    public function getNotes() {
    	
        return $this->_notes;
    }
    
	public function setPhone($val) {
    	
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
    
	public function setCell_phone($val) {
    	
        $this->_cell_phone = $val;
        
        return $this;
    }
 
    public function getCell_phone() {
    	
        return $this->_cell_phone;
    }
    
	public function setFax_phone($val) {
    	
        $this->_fax_phone = $val;
        
        return $this;
    }
 
    public function getFax_phone() {
    	
        return $this->_fax_phone;
    }
    
	public function setEmail($val) {
    	
        $this->_email = $val;
        
        return $this;
    }
 
    public function getEmail() {
    	
        return $this->_email;
    }
    
	public function setActive($val) {
    	
        $this->_active = $val;
        
        return $this;
    }
 
    public function getActive() {
    	
        return $this->_active;
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