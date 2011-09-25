<?php

class LLLT_Model_QbQueueMapper {
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_QbQueue');
        }
        
        return $this->_dbTable;
    }
    
    public function add(LLLT_Model_QbQueue $queue) {
    	    			    	
	    $data = array('queue_id'          => $queue->getQueue_id(),
	    		      'load_id'			  => $queue->getLoad_id(),
				      'active'	          => $queue->getActive());
	  	    	    	
	    $queueId = $this->getDbTable()
						->insert($data);
	    
	    return $queueId;
    }
    
 	public function delete($id) {
    	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('id = ?', $id);
			
    	$this->getDbTable()
			 ->delete($where);
    }
    
   	public function edit(LLLT_Model_QbQueue $queue) {
    	
	    $data = array('queue_id'          => $queue->getQueue_id(),
	    			  'load_id'			  => $queue->getLoad_id(),
				      'active'	          => $queue->getActive());
    	 
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('id = ?', $queue->getId());

		$this->getDbTable()
			 ->update($data, $where);
    }
    
    public function fetchAll($where, $order) {
    			
		$sql = 'SELECT * from tbl_qb_queue';
				
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

        $queues = array();
        
        foreach ($resultSet as $row) {
        	
            $queue = new LLLT_Model_QbQueue();
        	$queue->setId($row->id)        		  
	        	  ->setQueue_id($row->queue_id)
	        	  ->setLoad_id($row->load_id)
	        	  ->setActive($row->active);
                  
            $queues[] = $queue;            
        }
        
        return $queues;
    }
    
	public function find($id) {

		$sql = 'select * from tbl_qb_queue where id = ' . $id;

		$this->getDbTable()
			 ->getAdapter()
			 ->setFetchMode(Zend_Db::FETCH_OBJ);

		$row = $this->getDbTable()
					->getAdapter()
					->fetchRow($sql);
							        
        if (0 == count($row)) {
        	
        	return 'The qb queue could not be found.';
        }
        
        $queue = new LLLT_Model_QbQueue();
        	$queue->setId($row->id)        		  
	        	  ->setQueue_id($row->queue_id)
	        	  ->setLoad_id($row->load_id)
	        	  ->setActive($row->active);

	    return $queue;
    }
    

    
}