<?php

class Zend_View_Helper_Assettypes {
	
    protected $_assetTypes;
 
    public function assettypes($assetTypeId = null) {
    	
    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
    	
    	if (is_null($assetTypeId)) {
    		
    		$this->_assetTypes = $assetTypeMapper->fetchAll('at.active = 1', 'at.asset_type asc');
    	}
    	else {
    		
    		$this->_assetTypes = $assetTypeMapper->find($assetTypeId);
    	}    	

    	return $this->_assetTypes; 
    }
}