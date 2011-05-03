<?php

class LLLT_Model_NavmanMessageMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_NavmanMessage');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_NavmanMessage $navmanMessage) {
    	    			    	
	    $data = array('message_thread_id' => $navmanMessage->getMessage_thread_id(),
				      'navman_vehicle_id' => $navmanMessage->getNavman_vehicle_id(),
	    			  'message_body'      => $navmanMessage->getMessage_body(),
	    			  'processed'         => $navmanMessage->getProcessed(),
	    			  'message_date'      => $navmanMessage->getMessage_date());
	  	    	    	
	    $navmanMessageId = $this->getDbTable()->insert($data);
	    
	    return $navmanMessageId;
    }
    
 	public function delete(LLLT_Model_NavmanMessage $navmanMessage) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('message_id = ?', $navmanMessage->getMessage_id());
			
    	$this->getDbTable()->delete($where);
    }
    
   	public function edit(LLLT_Model_NavmanMessage $navmanMessage) {
    	
	    $data = array('message_id'        => $navmanMessage->getMessage_id(),
					  'message_thread_id' => $navmanMessage->getMessage_thread_id(),
				      'navman_vehicle_id' => $navmanMessage->getNavman_vehicle_id(),
	    			  'message_body'      => $navmanMessage->getMessage_body(),
	    			  'processed'         => $navmanMessage->getProcessed(),
	    			  'message_date'      => $navmanMessage->getMessage_date());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('navman_message_id = ?', $navmanMessage->getMessage_id());

		$this->getDbTable()->update($data, $where);
    }
    
    public function fetchAll($where = null, $order = null) {
    	
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        
        $entries = array();
        
        foreach ($resultSet as $row) {
        	
            $navmanMessage = new LLLT_Model_NavmanMessage();
            
        	$navmanMessage->setMessage_id($row->message_id)        		  
	        	  		  ->setMessage_thread_id($row->load_id)
	        	  		  ->setNavman_vehicle_id($row->emp_id)
	        	  		  ->setMessage_body($row->sent_date)
	        	  		  ->setProcessed($row->message_id)
	        	  		  ->setMessage_date($row->system_post_date);
                  
            $entries[] = $navmanMessage;            
        }
        
        return $entries;
    }
    
	public function find($id) {
		
        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
        	return 'The navman message could not be found.';
        }
        
        $row = $result->current();
        
        $navmanMessage = new LLLT_Model_NavmanMessage();
        
    	$navmanMessage->setMessage_id($row->message_id)        		  
        	  		  ->setMessage_thread_id($row->load_id)
        	  		  ->setNavman_vehicle_id($row->emp_id)
        	  		  ->setMessage_body($row->sent_date)
        	  		  ->setProcessed($row->message_id)
        	  		  ->setMessage_date($row->system_post_date);
	        	
	    return $navmanMessage;
    }
}