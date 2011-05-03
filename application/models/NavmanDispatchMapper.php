<?php

class LLLT_Model_NavmanDispatchMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_NavmanDispatch');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_NavmanDispatch $navmanDispatch) {
    	    			    	
	    $data = array('load_id'          => $navmanDispatch->getLoad_id(),
				      'emp_id'           => $navmanDispatch->getEmp_id(),
	    			  'sent_date'        => $navmanDispatch->getSent_date(),
	    			  'message_id'       => $navmanDispatch->getMessage_id(),
	    			  'system_post_date' => $navmanDispatch->getSystem_post_date(),
	    			  'navman_post_date' => $navmanDispatch->getNavman_post_date());
	  	    	    	
	    $navmanDispatchId = $this->getDbTable()->insert($data);
	    
	    return $navmanDispatchId;
    }
    
 	public function delete(LLLT_Model_NavmanDispatch $navmanDispatch) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('navman_dispatch_id = ?', $navmanDispatch->getNavman_dispatch_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_NavmanDispatch $navmanDispatch) {
    	
	    $data = array('navman_dispatch_id' => $navmanDispatch->getNavman_dispatch_id(),
					  'load_id'            => $navmanDispatch->getLoad_id(),
				      'emp_id'             => $navmanDispatch->getEmp_id(),
	    			  'sent_date'          => $navmanDispatch->getSent_date(),
	    			  'message_id'         => $navmanDispatch->getMessage_id(),
	    			  'system_post_date'   => $navmanDispatch->getSystem_post_date(),
	    			  'navman_post_date'   => $navmanDispatch->getNavman_post_date());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('navman_dispatch_id = ?', $navmanDispatch->getNavman_dispatch_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $navmanDispatch = new LLLT_Model_NavmanDispatch();
            
        	$navmanDispatch->setNavman_dispatch_id($row->navman_dispatch_id)        		  
	        	  		   ->setLoad_id($row->load_id)
	        	  		   ->setEmp_id($row->emp_id)
	        	  		   ->setSent_date($row->sent_date)
	        	  		   ->setMessage_id($row->message_id)
	        	  		   ->setSystem_post_date($row->system_post_date)
	        	  		   ->setNavman_post_date($row->navman_post_date);
                  
            $entries[] = $navmanDispatch;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The navman dispatch could not be found.';
        }
        
        $row = $result->current();
        
        $navmanDispatch = new LLLT_Model_NavmanDispatch();
        
    	$navmanDispatch->setNavman_dispatch_id($row->navman_dispatch_id)        		  
	 				   ->setLoad_id($row->load_id)
        	  		   ->setEmp_id($row->emp_id)
        	  		   ->setSent_date($row->sent_date)
        	  		   ->setMessage_id($row->message_id)
        	  		   ->setSystem_post_date($row->system_post_date)
        	  		   ->setNavman_post_date($row->navman_post_date);
	        	
	    return $navmanDispatch;
    }
}