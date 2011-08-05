<?php
class LLLT_Model_NavmanDispatcher {

	protected $_session_id;
	protected $_owner_id;
	protected $_driver_id;
	protected $_from_date;
	protected $_to_date;
	protected $_message_id;
	protected $_message_body;
	protected $_message_type;
 	 	
    public function __construct(array $options = null) {
        
    	if (is_array($options)) {
    		
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value) {
    	
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid navman cancel property');
        }
        
        $this->$method($value);
    }
 
    public function __get($name) {
    	
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	
            throw new Exception('Invalid navman cancel property');
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
    
 	public function setSession_id($val) {
    	
        $this->_session_id = $val;
        
        return $this;
    }
 
    public function getSession_id() {
    	
        return $this->_session_id;
    }
    
 	public function setOwner_id($val) {
    	
        $this->_owner_id = $val;
        
        return $this;
    }
 
    public function getOwner_id() {
    	
        return $this->_owner_id;
    }
    
 	public function setDriver_id($val) {
    	
        $this->_driver_id = $val;
        
        return $this;
    }
 
    public function getDriver_id() {
    	
        return $this->_driver_id;
    }
    
 	public function setFrom_date($val) {
    	
        $this->_from_date = $val;
        
        return $this;
    }
 
    public function getFrom_date() {
    	
        return $this->_from_date;
    }
    
 	public function setTo_date($val) {
    	
        $this->_to_date = $val;
        
        return $this;
    }
 
    public function getTo_date() {
    	
        return $this->_to_date;
    }
    
 	public function setMessage_id($val) {
    	
        $this->_message_id = $val;
        
        return $this;
    }
 
    public function getMessage_id() {
    	
        return $this->_message_id;
    }
    
 	public function setMessage_body($val) {
    	
        $this->_message_body = $val;
        
        return $this;
    }
 
    public function getMessage_body() {
    	
        return $this->_message_body;
    }
    
 	public function setMessage_type($val) {
    	
        $this->_message_type = $val;
        
        return $this;
    }
 
    public function getMessage_type() {
    	
        return $this->_message_type;
    }
}
// <ns:request>
//            <!--Optional:-->
//            <ns:Session>
//               <ns:SessionId>8a2b05ff-bfdb-4683-bb80-dd0b571b5bb9</ns:SessionId>
//            </ns:Session>
//            <ns:Version>0</ns:Version>
//            <ns:OwnerId>8e8eed99-dd75-42b0-8d9a-46e8f50facbd</ns:OwnerId>
//            <ns:FromDateTime>2011-08-01T00:00:00.000</ns:FromDateTime>
//            <ns:ToDateTime>2011-08-02T00:00:00.000</ns:ToDateTime>
//</ns:request>

?>