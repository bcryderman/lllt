<?php

class Zend_View_Helper_Assets {
	
    protected $_assets;
 
    public function assets($assetId = null) {
    	
    	$assetMapper = new LLLT_Model_AssetMapper();
    	
    	if (is_null($assetId)) {
    	
    		$this->_assets = $assetMapper->fetchAll('tbl_asset.active = 1', 'tbl_asset.asset_name asc');
    	}
    	else {
    	
    		$this->_assets = $assetMapper->find($assetId);
    	}

    	return $this->_assets; 
    }
}