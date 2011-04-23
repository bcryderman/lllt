<?php

class IndexController extends Zend_Controller_SecureAction {

    public function init() {}

    public function indexAction() {
    
    	$auth = Zend_Auth::getInstance()->getIdentity(); 
    	
    	$reminderMapper = new LLLT_Model_ReminderMapper();
    	$reminders = $reminderMapper->fetchAll('employee_id = ' . $auth['Employee']->getEmp_id(), 'due_date ASC');

    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
    	$assetTypes = $assetTypeMapper->fetchAll('active = 1', 'asset_type asc');
    	
    	$assetTypesArr = array();
    	
    	foreach ($assetTypes as $item) {
    		
    		$assetTypesArr[$item->getAsset_type_id()] = $item;
    	}
    	
    	$assetMapper = new LLLT_Model_AssetMapper();
    	$assets = $assetMapper->fetchAll('active = 1', 'asset_name ASC');
    	
   	 	$assetsArr = array();
    	
    	foreach ($assets as $item) {
    		
    		$assetsArr[$item->getAsset_id()] = $item;
    	}
    	    	
    	$this->view->assetTypes = $assetTypesArr;
    	$this->view->assets = $assetsArr;
    	$this->view->reminders = $reminders;
    }
}

