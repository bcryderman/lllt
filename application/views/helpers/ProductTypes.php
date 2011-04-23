<?php

class Zend_View_Helper_Producttypes {
	
    protected $_prodTypes;
 
    public function producttypes() {
    	
    	$prodTypeMapper = new LLLT_Model_ProductTypeMapper();
    	$this->_prodTypes = $prodTypeMapper->fetchAll(null, 'product_type asc');
    
    	return $this->_prodTypes; 
    }
}