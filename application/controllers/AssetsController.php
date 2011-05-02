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
		    			    	
		    	$asset = new LLLT_Model_Asset();
		    	$asset->setAsset_type_id($params['asset_type_id']);
		    	$asset->setAsset_name($params['asset_name']);
		    	$asset->setCompartment_count($params['compartment_count']);
				$asset->setActive($params['active']);
				$asset->setCustomer_id($params['customer_id']);
				$asset->setNavman_vehicle_id($params['navman_vehicle_id']);
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
        
    public function deleteAction() {
    
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$assetMapper = new LLLT_Model_AssetMapper();
	    $asset = $assetMapper->find($params['asset_id']);
	    	    	
    	if ($request->isPost()) {
    		
    		$assetMapper->delete($asset);
	    	
	    	$this->_redirect('assets/view');
    	}    	
     	
    	$this->view->asset = $asset;	
    	$this->view->params = $params;
    }
        
    public function editAction() {
    
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');  

	    		$asset = new LLLT_Model_Asset();
	    		$asset->setAsset_id($params['asset_id']);
		    	$asset->setAsset_type_id($params['asset_type_id']);
		    	$asset->setAsset_name($params['asset_name']);
		    	$asset->setCompartment_count($params['compartment_count']);
				$asset->setActive($params['active']);
				$asset->setCustomer_id($params['customer_id']);
				$asset->setNavman_vehicle_id($params['navman_vehicle_id']);
	    		$asset->setLast_updated($date);
	    		$asset->setLast_updated_by($auth['Employee']->getEmp_id());
		    	
		    	$assetMapper = new LLLT_Model_AssetMapper();
		    	$assetMapper->edit($asset);
		    	
		    	$this->_redirect('assets/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->assetId = $params['asset_id'];
		    	$this->view->params = $params;	
		    	$this->view->type = 'edit';	    	
		    }
		}		
    	else {
    		
	    	$assetMapper = new LLLT_Model_AssetMapper();
	    	$asset = (array) $assetMapper->find($params['asset_id']);
	    	    	
	    	$fields = array();
	    	
	    	foreach ($asset as $k => $v) {
	  
	    		$fields[substr($k, 4)] = $asset[$k];
	    	}
	    	
	    	$this->view->assetId = $params['asset_id'];
	    	$this->view->params = $fields;  
	    	$this->view->type = 'edit';
    	}    	

    	$this->renderScript('assets/form.phtml');
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

    	$assetMapper = new LLLT_Model_AssetMapper();
    	$assets = $assetMapper->fetchAll(null, array($params['column'] . ' ' . $params['sort'], 
													 'asset_name ' . $params['sort']));

    	$this->view->assets = $assets;

		$this->renderScript('assets/tabulardata.phtml');
	}
    
    public function viewAction() {
    	
    	$assetMapper = new LLLT_Model_AssetMapper();
    	$assets = $assetMapper->fetchAll(null, 'asset_name asc');

    	$this->view->assets = $assets;
    }
    
	public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['asset_type_id'])) {
    		
    		$errors['asset_type_id'] = 'You must select an asset type.';
    	}
    	
		if (empty($params['asset_name'])) {
    		
    		$errors['asset_name'] = 'You must enter an asset name.';
    	}
    	
		if (empty($params['compartment_count'])) {
    		
    		$errors['compartment_count'] = 'You must enter a compartment count.';
    	}
    	
	    if (empty($params['customer_id'])) {
    		
    		$errors['customer_id'] = 'You must select a customer.';
    	}
    	
    	return $errors;
    }
}