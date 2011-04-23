<?php 

class LLLT_Model_ProductType {
	
 	protected $_product_type_id;
 	protected $_product_type;
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
        	
            throw new Exception('Invalid product type property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid product type property');
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
         
    public function setProduct_type_id($val) {
    	
        $this->_product_type_id = $val;
        
        return $this;
    }
 
    public function getProduct_type_id() {
    	
        return $this->_product_type_id;
    }

    public function setProduct_type($val) {
    	
        $this->_product_type = $val;
        
        return $this;
    }
 
    public function getProduct_type() {
    	
        return $this->_product_type;
    }

    public function setActive($val) {
    	
        $this->_active = $val;
        
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