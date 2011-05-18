<?php

class AssettypesController extends Zend_Controller_Action {

    public function init() {
	
		$this->view->title = 'Asset Types';
	}

    public function addAction() {
    	
    	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$assetType = new LLLT_Model_AssetType();
		    	$assetType->setAsset_type(trim($params['asset_type']));
		    	$assetType->setActive($params['active']);
		    	$assetType->setDescription(trim($params['description']));
		    	
		    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
		    	$assetTypeMapper->add($assetType);
		    	
		    	$this->_redirect('assettypes/view');
		    }
		    else {
			
				$this->view->errors = $errors;
			    $this->view->params = $params;
			}					    	
		}

		$this->view->type = 'add';
		
		$this->renderScript('assettypes/form.phtml');
    }
    
    public function deleteAction() { 
	    
    	$request = $this->getRequest();
    	$params = $request->getParams();
	    	
		$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
		
    	if ($request->isPost()) {
    		
    		$assetTypeMapper->delete($params['asset_type_id']);
	    	
	    	$this->_redirect('assettypes/view');
    	}    	
		else {
			
			$assetType = $assetTypeMapper->find($params['asset_type_id']);
			
			$this->view->assetType = $assetType;	
		}		
    }
    
    public function editAction() {
    	
        $request = $this->getRequest();
    	$params = $request->getParams();
    	
	    if ($request->isPost()) {
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$assetType = new LLLT_Model_AssetType();
		    	$assetType->setAsset_type_id($params['asset_type_id']);
		    	$assetType->setAsset_type(trim($params['asset_type']));
		    	$assetType->setActive($params['active']);
		    	$assetType->setDescription(trim($params['description']));
		    	
		    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
		    	$assetTypeMapper->edit($assetType);
		    	
		    	$this->_redirect('assettypes/view');
		    }
			else {
				
				$this->view->errors = $errors;
			    $this->view->params = $params;
			}	
		}		
    	else {
    		
	    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
	    	$assetType = (array) $assetTypeMapper->find($params['asset_type_id']);
	    	    	
			$object2Array = new LLLT_Model_Object2Array();
			$object2Array->setFields($assetType);
	    	
	    	$this->view->params = $object2Array->getFields();  
    	}  

		$this->view->type = 'edit';  	

    	$this->renderScript('assettypes/form.phtml');
    }

	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();
				
		$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
    	$assetTypes = $assetTypeMapper->fetchAll(null, $params['column'] . ' ' . $params['sort'] . ', tbl_asset_type.asset_type ' . $params['sort']);

    	$this->view->assetTypes = $assetTypes;

		$this->renderScript('assettypes/tabulardata.phtml');
	}
    
    public function viewAction() {
    	
    	$assetTypeMapper = new LLLT_Model_AssetTypeMapper();
    	$assetTypes = $assetTypeMapper->fetchAll(null, 'tbl_asset_type.asset_type asc');

    	$this->view->assetTypes = $assetTypes;
    }
    
    public function validation($params) {
    	
    	$errors = array();
	    	
    	if (empty($params['asset_type'])) {
    		
    		$errors['asset_type'] = 'You must enter an asset type.';
    	}
    	
    	if (!empty($params['description']) && strlen($params['description']) > 1000) {
    		
    		$errors['description'] = 'Description cannot exceed 1,000 characters.';
    	}
    	
    	return $errors;
    }
}