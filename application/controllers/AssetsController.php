<?php

class AssetsController extends Zend_Controller_Action {

    public function init() {}

	public function addAction() {
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');
		    			    	
		    	$asset = new LLLT_Model_Reminder();
		    	$asset->setReminder_type_id($params['asset_type_id']);
		    	$asset->setAsset_id($params['asset_id']);
		    	$asset->setEmployee_id($auth['Employee']->getEmp_id());
		    	$asset->setDue_date(date('Y-m-d', strtotime($params['due_date'])));
		    	$asset->setCompleted_date(date('Y-m-d', strtotime($params['completed_date'])));
		    	$asset->setNotes($params['notes']);	
		    	$asset->setCreated($date);
	    		$asset->setCreated_by($auth['Employee']->getEmp_id());
	    		$asset->setLast_updated($date);
	    		$asset->setLast_updated_by($auth['Employee']->getEmp_id());
	    		
		    	$assetMapper = new LLLT_Model_AssetMapper();
		    	$assetMapper->add($asset);
		    	
		    	$this->_redirect('assets/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;		    	
		    }
		}
    
    	$this->view->type = 'add';
    	$this->renderScript('assets/form.phtml');
    }
        
    public function editAction() {}
    
    public function deleteAction() {}
    
    public function viewAction() {
    	
    	$assetMapper = new LLLT_Model_AssetMapper();
    	$assets = $assetMapper->fetchAll(null, 'asset_name ASC');

    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
    	$assetTypes = $assetTypeMapper->fetchAll('active = 1', 'asset_type asc');
    	
    	$assetTypesArr = array();
    	
    	foreach ($assetTypes as $item) {
    		
    		$assetTypesArr[$item->getAsset_type_id()] = $item;
    	}

    	$this->view->assets = $assets;
    	$this->view->assetTypes = $assetTypesArr;
    }
    
	public function validation($params) {
    	
    	$errors = array();
	    	
    	/*if (empty($params['reminder_type_id'])) {
    		
    		$errors['reminder_type_id'] = 'You must select a reminder type.';
    	}
    	
		if (empty($params['asset_id'])) {
    		
    		$errors['asset_id'] = 'You must select an asset type.';
    	}
    	
		if (empty($params['due_date'])) {
    		
    		$errors['due_date'] = 'You must enter a due date.';
    	}
    	
    	if (strlen($params['notes']) > 1000) {
    		
    		$errors['notes'] = 'Notes cannot exceed 1,000 characters.';
    	}*/
    	
    	return $errors;
    }
}