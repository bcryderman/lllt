<?php 

class LLLT_Model_Reminder {

	protected $_reminder_id;	 	 	 	 	 	 	
	protected $_reminder_type_id;
	protected $_reminder_type;
	protected $_asset_type;	 	 	 	 	 	 	
	protected $_asset_id;	
	protected $_asset_name;	 	 	 	 	 	 	
	protected $_employee_id; 	 	 	
	protected $_due_date;	 	 	 	 	 	 	
	protected $_completed_date;	 	 	
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
        	
            throw new Exception('Invalid reminder property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid reminder property');
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
         
    public function setReminder_id($val) {
    	
        $this->_reminder_id = (int) $val;
        
        return $this;
    }
 
    public function getReminder_id() {
    	
        return $this->_reminder_id;
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

    public function setAsset_type($val) {
    	
        $this->_asset_type = (string) $val;
        
        return $this;
    }
 
    public function getAsset_type() {
    	
        return $this->_asset_type;
    }
     	
    public function setAsset_id($val) {
    	
        $this->_asset_id = (int) $val;
        
        return $this;
    }
 
    public function getAsset_id() {
    	
        return $this->_asset_id;
    }

    public function setAsset_name($val) {
    	
        $this->_asset_name = (string) $val;
        
        return $this;
    }
 
    public function getAsset_name() {
    	
        return $this->_asset_name;
    }
        
    public function setEmployee_id($val) {
    	
        $this->_employee_id = (int) $val;
        
        return $this;
    }
 
    public function getEmployee_id() {
    	
        return $this->_employee_id;
    }

    public function setDue_date($val, $db = false) {
    	
		if ($db && !is_null($val)) {
			
			$this->_due_date = (string) substr($val, 5, 2) . '/' . substr($val, 8, 2) . '/' . substr($val, 0 , 4);
		}
		else {
			
			$this->_due_date = (string) $val;
		}
        
        return $this;
    }
 
    public function getDue_date() {
    	
        return $this->_due_date;
    }
    
    public function setCompleted_date($val, $db = false) {
    	
		if ($db && !is_null($val)) {
			
			$this->_completed_date = (string) substr($val, 5, 2) . '/' . substr($val, 8, 2) . '/' . substr($val, 0 , 4);
		}
		else {
			
			$this->_completed_date = (string) $val;
		}
        
        return $this;
    }
 
    public function getCompleted_date() {
    	
        return $this->_completed_date;
    }
    
    public function setNotes($val) {
    	
        $this->_notes = (string) $val;
        
        return $this;
    }
 
    public function getNotes() {
    	
        return $this->_notes;
    }
    
    public function setCreated($val) {
    	
        $this->_created = (string) $val;
        
        return $this;
    }
 
    public function getCreated() {
    	
        return $this->_created;
    }
    
    public function setCreated_by($val) {
    	
        $this->_created_by = (int) $val;
        
        return $this;
    }
 
    public function getCreated_by() {
    	
        return $this->_created_by;
    }
    
    public function setLast_updated($val) {
    	
        $this->_last_updated = (string) $val;
        
        return $this;
    }
 
    public function getLast_updated() {
    	
        return $this->_last_updated;
    }
    
    public function setLast_updated_by($val) {
    	
        $this->_last_updated_by = (int) $val;
        
        return $this;
    }
    
    public function getLast_updated_by() {
    	
        return $this->_last_updated_by;
    } 
}