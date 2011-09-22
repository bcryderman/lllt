<?php

class Zend_View_Helper_LoadTemplates {
	
    protected $_loadTemplates;
 
    public function loadtemplates() {
    	
    	$loadTemplateMapper = new LLLT_Model_LoadTemplateMapper();

    	
    	$this->_loadTemplates = $loadTemplateMapper->fetchAll(null, null);


    	return $this->_loadTemplates; 

	}
}