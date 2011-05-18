<?php

class LLLT_Model_AssetTypeMapper {
	
	protected $_dbTable;
 
    public function setDbTable($dbTable) {
    	
        if (is_string($dbTable)) {
        	
            $dbTable = new $dbTable();
        }
        
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
        	
            throw new Exception('Invalid table data gateway provided');
        }
        
        $this->_dbTable = $dbTable;
        
        return $this;
    }
 
    public function getDbTable() {
    	
        if (null === $this->_dbTable) {
        	
            $this->setDbTable('LLLT_Model_DbTable_AssetType');
        }
        
        return $this->_dbTable;
    }
    
	public function add(LLLT_Model_AssetType $assetType) {
    	    			    	
	    $data = array('asset_type'  => $assetType->getAsset_type(),
				      'active'      => $assetType->getActive(),
	    			  'description' => $assetType->getDescription());
	    	  	    	    	
	    $assetTypeId = $this->getDbTable()
							->insert($data);
	    
	    return $assetTypeId;
    }
    
	public function delete($id) {
    	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('asset_type_id = ?', $id);
			
    	$this->getDbTable()
			 ->delete($where);
    }
    
    public function edit(LLLT_Model_AssetType $assetType) {
    	
    	$data = array('asset_type'  => $assetType->getAsset_type(),
				      'active'      => $assetType->getActive(),
	    			  'description' => $assetType->getDescription());
    	 
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('asset_type_id = ?', $assetType->getAsset_type_id());

		$this->getDbTable()
			 ->update($data, $where);
    }
    
    public function fetchAll($where, $order = null) {
    	
        $resultSet = $this->getDbTable()
						  ->fetchAll($where, $order);
        
        $assetTypes = array();
        
        foreach ($resultSet as $row) {
        	
            $assetType = new LLLT_Model_AssetType();
        	$assetType->setAsset_type_id($row->asset_type_id)
        		  	  ->setAsset_type($row->asset_type)
	        	  	  ->setActive($row->active)
	        	  	  ->setDescription($row->description);
                  
            $assetTypes[] = $assetType;            
        }
                
        return $assetTypes;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()
					   ->find($id);
        
        if (0 == count($result)) {
        	
            return 'The asset type could not be found.';
        }
        
        $row = $result->current();
        
        $assetType = new LLLT_Model_AssetType();
        $assetType->setAsset_type_id($row->asset_type_id)
        		  ->setAsset_type($row->asset_type)
	        	  ->setActive($row->active)
	        	  ->setDescription($row->description);
	        	
	    return $assetType;
    }
}