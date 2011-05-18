<?php

class Zend_View_Helper_Time {
	
    protected $_time;
 
    public function time($timestamp) {
    	
    	$this->_time = substr($timestamp, 11, 5);

    	return $this->_time; 
    }
}