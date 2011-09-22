<?php 

class LLLT_Model_Employee {
	
 	protected $_emp_id;
	protected $_username;
	protected $_password;
 	protected $_first_name;
 	protected $_last_name;
 	protected $_addr;
 	protected $_addr2;
 	protected $_city;
 	protected $_state;
 	protected $_zip;
 	protected $_zip4;
 	protected $_vehicle_id;
 	protected $_role_id;
	protected $_role_name;
	protected $_user_type_id;
	protected $_user_type;
 	protected $_active;
 	protected $_email;
 	protected $_dispatch_loads;
 	protected $_pending_loads;
	protected $_phone;
	protected $_phone_ext;
	protected $_phone_primary;
	protected $_cell_phone;
	protected $_cell_phone_primary;	
	protected $_cell_carrier;
	protected $_communication_type_id;
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
        	
            throw new Exception('Invalid employee property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid employee property');
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
    	
        $this->_emp_id = (int) $val;
        
        return $this;
    }
 
    public function getEmp_id() {
    	
        return $this->_emp_id;
    }

    public function setUsername($val) {
    	
        $this->_username = (string) $val;
        
        return $this;
    }
 
    public function getUsername() {
    	
        return $this->_username;
    }

    public function setPassword($val) {
    	
        $this->_password = (string) $val;
        
        return $this;
    }
 
    public function getPassword() {
    	
        return $this->_password;
    }
       
    public function setFirst_name($val) {
    	
        $this->_first_name = (string) $val;
        
        return $this;
    }
 
    public function getFirst_name() {
    	
        return $this->_first_name;
    }
    
    public function setLast_name($val) {
    	
        $this->_last_name = (string) $val;
        
        return $this;
    }
 
    public function getLast_name() {
    	
        return $this->_last_name;
    }
    
    public function setAddr($val) {
    	
        $this->_addr = (string) $val;
        
        return $this;
    }
 
    public function getAddr() {
    	
        return $this->_addr;
    }
    
    public function setAddr2($val) {
    	
        $this->_addr2 = (string) $val;
        
        return $this;
    }
 
    public function getAddr2() {
    	
        return $this->_addr2;
    }
    
    public function setCity($val) {
    	
        $this->_city = (string) $val;
        
        return $this;
    }
 
    public function getCity() {
    	
        return $this->_city;
    }
    
    public function setState($val) {
    	
        $this->_state = (string) $val;
        
        return $this;
    }
 
    public function getState() {
    	
        return $this->_state;
    }
    
    public function setZip($val) {
    	
		if ($val === 0) {
			
			$this->_zip = null;
		}
		else {
			
			$this->_zip = (int) $val;
		}
        
        return $this;
    }
 
    public function getZip() {
    	
        return $this->_zip;
    }
    
    public function setZip4($val) {
    
		if ($val === 0) {
			
			$this->_zip4 = null;
		}
        else {
	
			$this->_zip4 = (int) $val;
		}
		
        return $this;
    }
 
    public function getZip4() {
    	
        return $this->_zip4;
    }
    
    public function setVehicle_id($val) {
    	if(strlen($val)>0)
    	{$this->_vehicle_id = (string) $val;}
    	else
    	{$this->_vehicle_id = null;}
        
        return $this;
    }
 
    public function getVehicle_id() {
    	
        return $this->_vehicle_id;
    }
    
    public function setRole_id($val) {
    	
        $this->_role_id = (int) $val;
        
        return $this;
    }
 
    public function getRole_id() {
    	
        return $this->_role_id;
    }

    public function setRole_name($val) {
    	
        $this->_role_name = (string) $val;
        
        return $this;
    }
 
    public function getRole_name() {
    	
        return $this->_role_name;
    }
    
    public function setUser_type_id($val) {
    	
        $this->_user_type_id = (int) $val;
        
        return $this;
    }
 
    public function getUser_type_id() {
    	
        return $this->_user_type_id;
    }

    public function setUser_type($val) {
    	
        $this->_user_type = (string) $val;
        
        return $this;
    }
 
    public function getUser_type() {
    	
        return $this->_user_type;
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
    
    public function setEmail($val) {
    	
        $this->_email = (string) $val;
        
        return $this;
    }
 
    public function getEmail() {
    	
        return $this->_email;
    }

    public function setPhone($val, $db = false, $submit = false) {
    	
		if ($val == 0) {
			
			$this->_phone = null;
		}
        else {
	
			if ($submit) {
				
				$this->_phone = (string) substr($val, 1, 3) . substr($val, 6, 3) . substr($val, 10, 4);
			}
			else if ($db) {
				
				$this->_phone = (string) '(' . substr($val, 0, 3) . ') ' . substr($val, 3, 3) . '-' . substr($val, 6, 4);
			}
			else {
				
				$this->_phone = (string) $val;
			}
		}
        
        return $this;
    }
 
    public function getPhone() {
    	
        return $this->_phone;
    }

    public function setPhone_ext($val) {
    	
		if ($val == 0) {
			
			$this->_phone_ext = null;
		}
        else {
			
			$this->_phone_ext = (int) $val;
		}
        
        return $this;
    }
 
    public function getPhone_ext() {
    	
        return $this->_phone_ext;
    }

    public function setPhone_primary($val) {
    	
    	if ($val === 'on' || $val == 1) {
    		
    		$this->_phone_primary = 1;
    	}
    	else if (is_null($val) || $val == 0) {
    		
    		$this->_phone_primary = 0;
    	}
        
        return $this;
    }
 
    public function getPhone_primary() {
    	
        return $this->_phone_primary;
    }

    public function setCell_phone($val, $db = false, $submit = false) {
    	
		if ($val == 0) {
			
			$this->_cell_phone = null;
		}
        else {
	
			if ($submit) {
				
				$this->_cell_phone = (string) substr($val, 1, 3) . substr($val, 6, 3) . substr($val, 10, 4);
			}
			else if ($db) {
				
				$this->_cell_phone = (string) '(' . substr($val, 0, 3) . ') ' . substr($val, 3, 3) . '-' . substr($val, 6, 4);
			}
			else {
				
				$this->_cell_phone = (string) $val;
			}
		}
        
        return $this;
    }
 
    public function getCell_phone() {
    	
        return $this->_cell_phone;
    }

    public function setCell_phone_primary($val) {
    	
    	if ($val === 'on' || $val == 1) {
    		
    		$this->_cell_phone_primary = 1;
    	}
    	else if (is_null($val) || $val == 0) {
    		
    		$this->_cell_phone_primary = 0;
    	}
        
        return $this;
    }
 
    public function getCell_phone_primary() {
    	
        return $this->_cell_phone_primary;
    }

    public function setCell_carrier($val) {
    	
		$this->_cell_carrier = (string) $val;
        
        return $this;
    }
 
    public function getCell_carrier() {
    	
        return $this->_cell_carrier;
    }

    public function setCommunication_type_id($val) {
    	
		$this->_communication_type_id = (int) $val;
        
        return $this;
    }
 
    public function getCommunication_type_id() {
    	
        return $this->_communication_type_id;
    }
    
    public function setDispatch_loads($val) {
    	
        $this->_dispatch_loads = $val;
        
        return $this;
    }
 
    public function getDispatch_loads() {
    	
        return $this->_dispatch_loads;
    }
    
    public function setPending_loads($val) {
    	
        $this->_pending_loads = $val;
        
        return $this;
    }
 
    public function getPending_loads() {
    	
        return $this->_pending_loads;
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