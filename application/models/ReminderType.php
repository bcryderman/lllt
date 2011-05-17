<?php 

class LLLT_Model_ReminderType {

	protected $_reminder_type_id; 	 	 	 	 	 	
	protected $_reminder_type; 	 	 	 	
	protected $_active;	 	 	 	 	 	 	
	protected $_description; 	 	 	 	 	 	
	protected $_asset_or_employee;
 	 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid reminder type property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid reminder type property');
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
         
 	public function setReminder_type_id($val) {
    	
        $this->_reminder_type_id = (int) $val;
        
        return $this;
    }
 
    public function getReminder_type_id() {
    	
        return $this->_reminder_type_id;
    }
     
    public function setReminder_type($val) {
    	
        $this->_reminder_type = (string) $val;
        
        return $this;
    }
 
    public function getReminder_type() {
    	
        return $this->_reminder_type;
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
        
    public function setDescription($val) {
    	
        $this->_description = (string) $val;
        
        return $this;
    }
 
    public function getDescription() {
    	
        return $this->_description;
    }
    
    public function setAsset_or_employee($val) {
    	
        $this->_asset_or_employee = (string) $val;
        
        return $this;
    }
 
    public function getAsset_or_employee() {
    	
        return $this->_asset_or_employee;
    }
}