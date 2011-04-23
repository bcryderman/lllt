<?php 

class LLLT_Model_AssetType {
	 	 	 	
	protected $_asset_type_id;	 
	protected $_asset_type;	 	 	 	 	 	
	protected $_active;
	protected $_description;
	 	 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid asset type property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid asset type property');
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
        
 	public function setAsset_type_id($val) {
    	
        $this->_asset_type_id = $val;
        
        return $this;
    }
 
    public function getAsset_type_id() {
    	
        return $this->_asset_type_id;
    }
    
 	public function setAsset_type($val) {
    	
        $this->_asset_type = $val;
        
        return $this;
    }
 
    public function getAsset_type() {
    	
        return $this->_asset_type;
    }

    public function setActive($val) {
    	
    	if ($val === 'on') {
    		
    		$this->_active = 1;
    	}
    	else {
    		
    		$this->_active = $val;
    	}
        
        return $this;
    }
 
    public function getActive() {
    	
        return $this->_active;
    }
    
 	public function setDescription($val) {
    	
        $this->_description = $val;
        
        return $this;
    }
 
    public function getDescription() {
    	
        return $this->_description;
    }
}