<?php

class LLLT_Model_RouteTypeMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_RouteType');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_RouteType $routeType) {
    	    			    	
	    $data = array('route_type'    => $routeType->getRoute_type(),
	    			  'active'        => $routeType->getActive(),
	    			  'description'   => $routeType->getDescription());
	  	    	    	
	    $routeTypeId = $this->getDbTable()->insert($data);
	    
	    return $routeTypeId;
    }
    
 	public function delete(LLLT_Model_RouteType $routeType) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('route_type_id = ?', $routeType->getRoute_type_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_RouteType $routeType) {
    	
	    $data = array('route_type_id' => $routeType->getRoute_type_id(),
				      'route_type'    => $routeType->getRoute_type(),
	    			  'active'        => $routeType->getActive(),
	    			  'description'   => $routeType->getDescription());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('route_type_id = ?', $routeType->getRoute_type_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $routeType = new LLLT_Model_RouteType();
            
        	$routeType->setRoute_type_id($row->route_type_id)        		  
	        	  	  ->setRoute_type($row->route_type)
	        	  	  ->setActive($row->active)
	        	  	  ->setDescription($row->description);
                  
            $entries[] = $routeType;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The route type could not be found.';
        }
        
        $row = $result->current();
        
        $routeType = new LLLT_Model_RouteType();
        
    	$routeType->setRoute_type_id($row->route_type_id)        		  
        	  	  ->setRoute_type($row->route_type)
        	  	  ->setActive($row->active)
        	  	  ->setDescription($row->description);
	        	
	    return $routeType;
    }
}