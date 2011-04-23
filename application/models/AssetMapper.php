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
	  	    	    	
	    $assetId = $this->getDbTable()->insert($data);
	    
	    return $assetId;
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $entry = new LLLT_Model_Asset();
            
        	$entry->setAsset_id($row->asset_id)        		  
	        	  ->setAsset_type_id($row->asset_type_id)
	        	  ->setAsset_name($row->asset_name)
	        	  ->setCompartment_count($row->compartment_count)
	        	  ->setActive($row->active)
	        	  ->setCustomer_id($row->customer_id)
	        	  ->setNavman_vehicle_id($row->navman_vehicle_id)
	        	  ->setCreated($row->created)
	        	  ->setCreated_by($row->created_by)
	        	  ->setLast_updated($row->last_updated)
	        	  ->setLast_updated_by($row->last_updated_by);
                  
            $entries[] = $entry;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
            return;
        }
        
        $row = $result->current();
        
        $assetType = new LLLT_Model_Asset();
        $assetType->setAsset_id($row->asset_id)        		
	        	  ->setAsset_type_id($row->asset_type_id)
	        	  ->setAsset_name($row->asset_name)
	        	  ->setCompartment_count($row->compartment_count)
	        	  ->setActive($row->active)
	        	  ->setCustomer_id($row->customer_id)
	        	  ->setNavman_vehicle_id($row->navman_vehicle_id)
	        	  ->setCreated($row->created)
	        	  ->setCreated_by($row->created_by)
	        	  ->setLast_updated($row->last_updated)
	        	  ->setLast_updated_by($row->last_updated_by);
	        	
	    return $assetType;
    }
    
    /*public function add(LLLT_Model_ReminderType $remType) {
    	    			    	
	    $data = array('reminder_type'     => $remType->getReminder_type(),
				      'active'            => $remType->getActive(),
	    			  'description'       => $remType->getDescription(),
	    			  'asset_or_employee' => $remType->getAsset_or_employee());
	  	    	    	
	    $remTypeId = $this->getDbTable()->insert($data);
	    
	    return $remTypeId;
    }
    
    public function delete(LLLT_Model_ReminderType $remType) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('reminder_type_id = ?', $remType->getReminder_type_id());
			
    	$this->getDbTable()->delete($where);
    }
    
    public function edit(LLLT_Model_ReminderType $remType) {
    	
    	$data = array('reminder_type'     => $remType->getReminder_type(),
				      'active'            => $remType->getActive(),
	    			  'description'       => $remType->getDescription(),
	    			  'asset_or_employee' => $remType->getAsset_or_employee());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('reminder_type_id = ?', $remType->getReminder_type_id());

		$this->getDbTable()->update($data, $where);
    }*/
}