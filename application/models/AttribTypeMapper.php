<?php

class LLLT_Model_AtribbTypeMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_AttribType');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_AttribType $attribType) {
    	    			    	
	    $data = array('attrib_name' => $attribType->getAttrib_name(),
	    			  'active'      => $attribType->getActive(),
	    			  'description' => $attribType->getDescription());
	  	    	    	
	    $attribTypeId = $this->getDbTable()->insert($data);
	    
	    return $attribTypeId;
    }
    
 	public function delete(LLLT_Model_AttribType $attribType) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('attrib_id = ?', $attribType->getAttrib_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_AttribType $attribType) {
    	
	    $data = array('attrib_id'   => $attribType->getAttrib_id(),
				      'attrib_name' => $attribType->getAttrib_name(),
	    			  'active'      => $attribType->getActive(),
	    			  'description' => $attribType->getDescription());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('attrib_id = ?', $attribType->getAttrib_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $attribType = new LLLT_Model_AttribType();
            
        	$attribType->setAttrib_id($row->attrib_id)        		  
	        	  		->setAttrib_name($row->attrib_name)
	        	 		->setActive($row->active)
			        	->setDescription($row->description);
                  
            $entries[] = $attribType;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The attrib type could not be found.';
        }
        
        $row = $result->current();
        
        $attribType = new LLLT_Model_AttribType();
        
    	$attribType->setAttrib_id($row->attrib_id)        		  
        	  		->setAttrib_name($row->attrib_name)
        	 		->setActive($row->active)
		        	->setDescription($row->description);
	        	
	    return $attribType;
    }
}