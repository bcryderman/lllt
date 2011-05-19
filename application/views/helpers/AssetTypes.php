<?php

class Zend_View_Helper_Assettypes {
	
    protected $_assetTypes;
 
    public function assettypes($assetTypeId = null) {
    	
    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
    	
    	if (is_null($assetTypeId)) {
    		
    		$this->_assetTypes = $assetTypeMapper->fetchAll('tbl_asset_type.active = 1', 'tbl_asset_type.asset_type asc');
    	}
    	else {
    		
    		$this->_assetTypes = $assetTypeMapper->find($assetTypeId);
    	}    	

    	return $this->_assetTypes; 
    }
}