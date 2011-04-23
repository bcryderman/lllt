<?php

class Zend_View_Helper_Routetypes {
	
    protected $_billTos;
    protected $_routeType = array(
    					1=>'Standard',
    					2=>'Backhaul'
    );
 
    public function routetypes($return=array()) {
    	
    	return $this->_routeType;
	   	
    }
    
   
}