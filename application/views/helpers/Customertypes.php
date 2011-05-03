<?php

class Zend_View_Helper_Customertypes {
	
    protected $_data;
 
    public function customertypes($return=array()) {
    	
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
    	$dataMapper = new LLLT_Model_CustomerTypeMapper();
    	$this->_data = $dataMapper->fetchAll('active = 1', 'customer_type_id asc');
    	
    	return $this->_data; 
    }
    
    public function buildarrayid($data){
    		$retval=array();
    		foreach($data as $item)
    		{
    			$retval[$item->getCustomer_type_id()]=array(
    				'customer_type'	=>$item->getCustomer_type(),
    				'active'		=>$item->getActive(),
    				'description'	=>$item->getDescription()
    			);

    		}
    	return $retval;
    }
}