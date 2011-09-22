<?php

class Zend_View_Helper_Destinations {
	
    protected $_dests;
 
    public function destinations($return=array()) {
    	
    $data = $this->getdata();
    	
    	if(isset($return['return'])&& $return['return']=='arrayid')
    	{
    		
    		$retval = $this->buildarrayid($data);
    	}
    	else
    	{
    		$retval = $data;
    	}
    	
    	return $retval;
    }
    
    public function getdata(){
    	$custMapper = new LLLT_Model_CustomerMapper();
    	$this->_dests = $custMapper->fetchAll('customer_type_id = 5', 'city asc');
    	
    	return $this->_dests; 
    }
    
    public function buildarrayid($data){
    		$retval=array();
    		foreach($data as $item)
    		{
    			$retval[$item->getCustomer_id()]=array(
    				'name'							=>$item->getName(),
    				'addr'							=>$item->getAddr(),
    				'addr2'							=>$item->getAddr2(),
    				'city'							=>$item->getCity(),
    				'state'							=>$item->getState(),
    				'zip'							=>$item->getZip(),
    				'zip4'							=>$item->getZip4(),
    				'fein'							=>$item->getFein(),
    				'color_code'					=>$item->getColor_code(),
    				'customer_type_id'				=>$item->getCustomer_type_id(),
    				'primary_customer_contact_id'	=>$item->getPrimary_customer_contact_id(),
    				'carrier_navman_owner_id'		=>$item->getCarrier_navman_owner_id(),
    				'quickbook_print'				=>$item->getQuickbook_print(),
    				'active'						=>$item->getActive(),
    				'notes'							=>$item->getNotes(),
    				'created'						=>$item->getCreated(),
    				'created_by'					=>$item->getCreated_by(),
    				'last_updated'					=>$item->getLast_updated(),
    				'last_updated_by'				=>$item->getLast_updated_by()
    				
    			);

    		}
    	return $retval;
    }
}