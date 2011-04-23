<?php

class Zend_View_Helper_Assets {
	
    protected $_assets;
 
    public function assets() {
    	
    	$assetMapper = new LLLT_Model_AssetMapper();
    	$this->_assets = $assetMapper->fetchAll('active = 1', 'asset_name asc');

    	return $this->_assets; 
    }
}