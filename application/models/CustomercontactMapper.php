<?php
class LLLT_Model_CustomercontactMapper{
	
	
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
        	
            $this->setDbTable('LLLT_Model_DbTable_Customercontact');
        }
        
        return $this->_dbTable;
    }
    
 	public function active(LLLT_Model_Customercontact $contact){
    	$data = array('active' => $contact->getActive(),	    			  
    				  'last_updated'       => $contact->getLast_updated(),
	    			  'last_Updated_by'    => $contact->getLast_updated_by());
    	$where = $this->getDbTable()->getAdapter()->quoteInto('contact_id = ?', $contact->getContact_id());

		$this->getDbTable()->update($data, $where);	
    }
    
    public function add(LLLT_Model_Customercontact $contact) {
	
	    $data = array(  'active'			=>$contact->getActive(),
	    				'customer_id'		=>$contact->getCustomer_id(),
				    	'first_name'		=>$contact->getFirst_name(),
				    	'last_name'			=>$contact->getLast_name(),
				    	'notes'				=>$contact->getNotes(),
				    	'phone'				=>$contact->getPhone(),
				    	'phone_ext'			=>$contact->getPhone_ext(),
				    	'cell_phone'		=>$contact->getCell_phone(),
				    	'fax_phone'			=>$contact->getFax_phone(),
	    				'email'				=>$contact->getEmail(),
				    	'created'			=>$contact->getCreated($date),
			    		'created_by'		=>$contact->getCreated_by(),
			    		'last_updated'		=>$contact->getLast_updated(),
			    		'last_updated_by'	=>$contact->getlast_updated_by());
	    	    	
	    $id = $this->getDbTable()->insert($data);
	    
	    return $id;

    }
    
    public function delete(LLLT_Model_Customercontact $contact) {
    	
    	$where = $this->getDbTable()->getAdapter()->quoteInto('contact_id = ?', $customer->getContact_id());
			
    	$this->getDbTable()->delete($where);
    }
    
 	public function edit(LLLT_Model_Customercontact $contact) {
    	
    	$data = array(
    					'first_name'        => $contact->getFirst_name(),
				      	'last_name'        	=> $contact->getLast_name(),
				      	'notes'       		=> $contact->getNotes(),
	    			  	'phone'     		=> $contact->getPhone(),
	    			 	'phone_ext'       	=> $contact->getPhone_ext(),
	    			  	'cell_phone'        => $contact->getCell_phone(),
				     	'fax_phone'        	=> $contact->getFax_phone(),
				     	'email'        		=> $contact->getEmail(),
	    			  	'last_updated'      => $contact->getLast_updated(),
	    			  	'last_Updated_by'	=> $contact->getLast_updated_by());
    	 
		$where = $this->getDbTable()->getAdapter()->quoteInto('contact_id = ?', $contact->getContact_id());

		$this->getDbTable()->update($data, $where);
    }
    
	public function find($id) {
		
		$result = $this->getDbTable()->find($id);
    	
//        $result = $this->getDbTable()->find($id);
        
        if (0 == count($result)) {
        	
            return 'This Customer contact could not be found.';
        }
        $row = $result->current();
        $retval= new LLLT_Model_Customercontact();
        $retval->setContact_id($row->contact_id);
        $retval->setCustomer_id($row->customer_id);
        $retval->setFirst_name($row->first_name);
        $retval->setLast_name($row->last_name);
        $retval->setNotes($row->notes);
        $retval->setPhone($row->phone);
        $retval->setPhone_ext($row->phone_ext);
        $retval->setCell_Phone($row->cell_phone);
        $retval->setFax_phone($row->fax_phone);
        $retval->setEmail($row->email);
        $retval->setActive($row->active);
        $retval->setCreated($row->created);
        $retval->setCreated_by($row->created_by);
        $retval->setLast_updated($row->last_updated);
        $retval->setLast_updated_by($row->last_updated_by);

        return $retval;
    }

	public function fetchall($where, $order) {
		
		$result = $this->getDbTable()
					   ->fetchAll($this->getDbTable()
					   				   ->select()
					 				   ->setIntegrityCheck(false)
									   ->from(array('a' => 'tbl_customer_contact'))
									   ->where('a.customer_id = ?',$where['customer_id'])
					 				   ->where('a.active = ?', $where['active'])
									   ->join(array('at' => 'tbl_customer'),
									       		    'a.customer_id = at.customer_id',
									 		  array('name')));
    	
//        $result = $this->getDbTable()->find($id);

        if (0 == count($result)) {
        	
            return 'This Customer contact could not be found.';
        }
        $retval=array();

         foreach ($result as $row) {
			        $data= new LLLT_Model_Customercontact();
			        $data->setContact_id($row->contact_id);
			        $data->setCustomer_id($row->customer_id);
			        $data->setFirst_name($row->first_name);
			        $data->setLast_name($row->last_name);
			        $data->setNotes($row->notes);
			        $data->setPhone($row->phone);
			        $data->setPhone_ext($row->phone_ext);
			        $data->setCell_Phone($row->cell_phone);
			        $data->setFax_phone($row->fax_phone);
			        $data->setEmail($row->email);
			        $data->setActive($row->active);
			        $data->setCreated($row->created);
			        $data->setCreated_by($row->created_by);
			        $data->setLast_updated($row->last_updated);
			        $data->setLast_updated_by($row->last_updated_by);
			        $data->setCustomer_name($row->name);
			        
			        $retval[]=$data;
         }
        return $retval;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	public function sel_customer_by_contact($contact_id){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->setFetchMode(Zend_Db::FETCH_ASSOC);
		$select = $dbAdapter->select()
				->from('tbl_customer_contact')
				->where('active = 1')
				->where('contact_id = ?',$contact_id);
		$stmt = $dbAdapter->query($select);
		$result = $stmt->fetchAll();
		return $result;	
	}
	
	public function sel_customer_by_customer($customer_id){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->setFetchMode(Zend_Db::FETCH_ASSOC);
		$select = $dbAdapter->select()
				->from('tbl_customer_contact')
				->where('active = 1')
				->where('customer_id = ?',$customer_id);
		$stmt = $dbAdapter->query($select);
		$result = $stmt->fetchAll();
		return $result;	
	}
	
	public function ins_customer_contact($data){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->insert('tbl_customer_contact',$data);
	}
	
	public function upd_customer_contact($contact_id,$data){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$dbAdapter->update('tbl_customer_contact',$data,'contact_id ='.$contact_id);
	}

}