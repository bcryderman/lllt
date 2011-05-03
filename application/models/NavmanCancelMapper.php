<?php

class LLLT_Model_NavmanCancelMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_NavmanCancel');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_NavmanCancel $navmanCancel) {
    	    			    	
	    $data = array('load_id'          => $navmanCancel->getLoad_id(),
				      'emp_id'           => $navmanCancel->getEmp_id(),
	    			  'sent_date'        => $navmanCancel->getSent_date(),
	    			  'message_id'       => $navmanCancel->getMessage_id(),
	    			  'system_post_date' => $navmanCancel->getSystem_post_date(),
	    			  'navman_post_date' => $navmanCancel->getNavman_post_date());
	  	    	    	
	    $navmanCancelId = $this->getDbTable()->insert($data);
	    
	    return $navmanCancelId;
    }
    
 	public function delete(LLLT_Model_NavmanCancel $navmanCancel) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('navman_cancel_id = ?', $navmanCancel->getNavman_cancel_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_NavmanCancel $navmanCancel) {
    	
	    $data = array('navman_cancel_id' => $navmanCancel->getNavman_cancel_id(),
					  'load_id'          => $navmanCancel->getLoad_id(),
				      'emp_id'           => $navmanCancel->getEmp_id(),
	    			  'sent_date'        => $navmanCancel->getSent_date(),
	    			  'message_id'       => $navmanCancel->getMessage_id(),
	    			  'system_post_date' => $navmanCancel->getSystem_post_date(),
	    			  'navman_post_date' => $navmanCancel->getNavman_post_date());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('navman_cancel_id = ?', $navmanCancel->getNavman_cancel_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $navmanCancel = new LLLT_Model_NavmanCancel();
            
        	$navmanCancel->setNavman_cancel_id($row->navman_cancel_id)        		  
	        	  		 ->setLoad_id($row->load_id)
	        	  		 ->setEmp_id($row->emp_id)
	        	  		 ->setSent_date($row->sent_date)
	        	  		 ->setMessage_id($row->message_id)
	        	  		 ->setSystem_post_date($row->system_post_date)
	        	  		 ->setNavman_post_date($row->navman_post_date);
                  
            $entries[] = $navmanCancel;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The navman cancel could not be found.';
        }
        
        $row = $result->current();
        
        $navmanCancel = new LLLT_Model_NavmanCancel();
        
    	$navmanCancel->setNavman_cancel_id($row->navman_cancel_id)        		  
        	  		 ->setLoad_id($row->load_id)
        	  		 ->setEmp_id($row->emp_id)
        	  		 ->setSent_date($row->sent_date)
        	  		 ->setMessage_id($row->message_id)
        	  		 ->setSystem_post_date($row->system_post_date)
        	  		 ->setNavman_post_date($row->navman_post_date);
	        	
	    return $navmanCancel;
    }
}