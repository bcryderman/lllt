<?php

class LLLT_Model_AssetMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Asset');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_Asset $asset) {
    	    			    	
	    $data = array('asset_type_id'     => $asset->getAsset_type_id(),
				      'asset_name'        => $asset->getAsset_name(),
	    			  'compartment_count' => $asset->getCompartment_count(),
	    			  'active'            => $asset->getActive(),
	    			  'customer_id'       => $asset->getCustomer_id(),
	    			  'navman_vehicle_id' => $asset->getNavman_vehicle_id(),
	    			  'created'           => $asset->getCreated(),
	    			  'created_by'        => $asset->getCreated_by(),
	    			  'last_updated'      => $asset->getLast_updated(),
	    			  'last_updated_by'   => $asset->getLast_updated_by());
	  	    	    	
	    $assetId = $this->getDbTable()
						->insert($data);
	    
	    return $assetId;
    }
    
 	public function delete($id) {
    	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('asset_id = ?', $id);
			
    	$this->getDbTable()
			 ->delete($where);
    }
    
   	public function edit(LLLT_Model_Asset $asset) {
    	
	    $data = array('asset_type_id'     => $asset->getAsset_type_id(),
				      'asset_name'        => $asset->getAsset_name(),
	    			  'compartment_count' => $asset->getCompartment_count(),
	    			  'active'            => $asset->getActive(),
	    			  'customer_id'       => $asset->getCustomer_id(),
	    			  'navman_vehicle_id' => $asset->getNavman_vehicle_id(),
	    			  'last_updated'      => $asset->getLast_updated(),
	    			  'last_updated_by'   => $asset->getLast_updated_by());
    	 
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('asset_id = ?', $asset->getAsset_id());

		$this->getDbTable()
			 ->update($data, $where);
    }
    
    public function fetchAll($where, $order) {
    			
		$sql = 'SELECT tbl_asset.*, tbl_asset_type.asset_type, tbl_customer.name 
				FROM tbl_asset
				LEFT JOIN tbl_asset_type ON tbl_asset.asset_type_id = tbl_asset_type.asset_type_id
				LEFT JOIN tbl_customer ON tbl_asset.customer_id = tbl_customer.customer_id';
				
		if (!is_null($where)) {
			
			$sql .= ' WHERE ' . $where;
		}
		
		if (!is_null($order)) {
			
			$sql .= ' ORDER BY ' . $order;
		}
		
		$stmt = $this->getDbTable()
					 ->getAdapter()
					 ->query($sql);
		
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$resultSet = $stmt->fetchAll();

        $assets = array();
        
        foreach ($resultSet as $row) {
        	
            $asset = new LLLT_Model_Asset();
        	$asset->setAsset_id($row->asset_id)        		  
	        	  ->setAsset_type_id($row->asset_type_id)
	        	  ->setAsset_name($row->asset_name)
				  ->setAsset_type($row->asset_type)
	        	  ->setCompartment_count($row->compartment_count)
	        	  ->setActive($row->active)
	        	  ->setCustomer_id($row->customer_id)
				  ->setCustomer_name($row->name)
	        	  ->setNavman_vehicle_id($row->navman_vehicle_id)
	        	  ->setCreated($row->created)
	        	  ->setCreated_by($row->created_by)
	        	  ->setLast_updated($row->last_updated)
	        	  ->setLast_updated_by($row->last_updated_by);
                  
            $assets[] = $asset;            
        }
        
        return $assets;
    }
    
	public function find($id) {

		$sql = 'SELECT tbl_asset.*, tbl_asset_type.asset_type, tbl_customer.name
				FROM tbl_asset
				LEFT JOIN tbl_asset_type ON tbl_asset.asset_type_id = tbl_asset_type.asset_type_id
				LEFT JOIN tbl_customer ON tbl_asset.customer_id = tbl_customer.customer_id
				WHERE tbl_asset.asset_id = ' . $id;

		$this->getDbTable()
			 ->getAdapter()
			 ->setFetchMode(Zend_Db::FETCH_OBJ);

		$row = $this->getDbTable()
					->getAdapter()
					->fetchRow($sql);
							        
        if (0 == count($row)) {
        	
        	return 'The asset could not be found.';
        }
        
        $asset = new LLLT_Model_Asset();
 		$asset->setAsset_id($result->asset_id)        		
	          ->setAsset_type_id($result->asset_type_id)
			  ->setAsset_type($result->asset_type)
	          ->setAsset_name($result->asset_name)
	          ->setCompartment_count($result->compartment_count)
	          ->setActive($result->active)
	          ->setCustomer_id($result->customer_id)
			  ->setCustomer_name($result->name)
	          ->setNavman_vehicle_id($result->navman_vehicle_id)
	          ->setCreated($result->created)
	          ->setCreated_by($result->created_by)
	       	  ->setLast_updated($result->last_updated)
	       	  ->setLast_updated_by($result->last_updated_by);

	    return $asset;
    }
}