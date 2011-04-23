<?php

class Zend_View_Helper_FormatDate {
	
    protected $_date;
 
    public function formatDate($date) {
    	
    	$this->_date = substr($date, 5, 2) . '/' . substr($date, 8, 2) . '/' . substr($date, 0, 4);
    	
    	return $this->_date; 
    }
}