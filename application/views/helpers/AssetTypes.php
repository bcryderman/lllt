<?php

class Zend_View_Helper_AssetTypes {
	
    protected $_assetTypes;
 
    public function assetTypes() {
    	
    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
    	$this->_assetTypes = $assetTypeMapper->fetchAll('active = 1', 'asset_type asc');
    	  	

    	return $this->_assetTypes; 
    }
}