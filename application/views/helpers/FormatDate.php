<?php

class Zend_View_Helper_Formatdate {
	
    protected $_date;
 
    public function formatdate($date) {
    	
    	$this->_date = substr($date, 5, 2) . '/' . substr($date, 8, 2) . '/' . substr($date, 0, 4);
    	
    	return $this->_date; 
    }
}