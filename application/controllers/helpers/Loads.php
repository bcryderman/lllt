<?php
class Zend_Controller_Action_Helper_Loads extends 
Zend_Controller_Action_Helper_Abstract {
	

	
	
    public function dispatchload($load,$dispatch_status = 1){
    	$load_obj = new LLLT_Model_Load();
    	$load_dispatch = new LLLT_Model_LoadMapper();
    	$auth = Zend_Auth::getInstance()->getIdentity();
    	
    	$load_obj->setLoad_id($load['load_id'])
    	->setDriver_id($load['driver_id'])
    	->setDelayed_dispatch($load['delayed_dispatch'])
    	//->setBill_rate($load['bill_rate'])
    	//->setFuel_surcharge($load['fuel_surcharge'])
    	->setLast_updated(date('Y-m-d H:i:s'))
    	->setLast_updated_by($auth['Employee']->getEmp_id())
    	->setDispatched($dispatch_status)
    	->setNotes($load['notes'])
    	->setLoad_date(date('Y-m-d H:i:s'))
    	->setDispatch_order($load['dispatch_order']);
    	
    	$load_dispatch->dispatchload($load_obj);
    }
    
    public function buildloadlog($load,$load_type){
    	$load_log_obj = new LLLT_Model_LoadLog();
    	$load_log = new LLLT_Model_LoadLogMapper();
    	$auth = Zend_Auth::getInstance()->getIdentity();
    	
    	$load_log_obj->setLoad_id($load['load_id'])
    	->setLoad_activity_type_id($load_type)
    	->setActivity_time(date('Y-m-d H:i:s'))
    	->setActivity_by($auth['Employee']->getEmp_id());
    	
    	$load_log->add($load_log_obj);
    }
    
    public function sendnavmanmessage($load_id,$driver_id){
    	$data = new LLLT_Model_NavmanDispatcher();
    	$data->setMessage_body($this->buildmessage($load_id));
    	$data->setDriver_id($this->getNavmanIdforDriver($driver_id));
    	$data->setMessage_type(0);
    	$messenager = new LLLT_Model_NavmandispatcherMapper();
    	$send = $messenager->DoSendTextMessage($data);
 		//$this->processnavmanreturn($send,$driver_id,$load_id);
    }
    
    public function send_load_delivered_message($order_num,$driver_id){
    	
    	$data = new LLLT_Model_NavmanDispatcher();
    	$data->setMessage_body('SYS: '.$order_num.' marked as delivered');
    	$data->setDriver_id($this->getNavmanIdforDriver($driver_id));
    	$data->setMessage_type(0);
    	$messenager = new LLLT_Model_NavmandispatcherMapper();
    	$send = $messenager->DoSendTextMessage($data);
    }
    
    public function processnavmanreturn($message_data,$driver_id,$load_id){
    	if($message_data->DoSendTextMessageResult->OperationStatus == 'true'){
    	$dispatch = new LLLT_Model_NavmanDispatch();
    	$dispatch->setMessage_id($message_data->DoSendTextMessageResult->MessageIds->guid)
    			->setEmp_id($driver_id)
    			->setLoad_id($load_id)
    			->setSent_date(date('Y-m-d H:i:s'));
    	$dispatch_log = new LLLT_Model_NavmanDispatchMapper();
    	$dispatch_log->add($dispatch);
    	}
    			

    }
    
    public function buildmessage($load_id){
    	//DISPATCH: Kansas Ethanol - Lyons KS -> Conoco Phillips - Jenks OK * Conoco  * 4354690
    	$loadinfo = $this->getloadinfo($load_id);
    	return 'DISPATCH: '.$loadinfo->getOrigin() .' -> '.$loadinfo->getDestination() . ' * '. $loadinfo->getCustomer(). ' * '. $loadinfo->getOrder_number();
    }

	public function getloadinfo($load_id){
		$load = new LLLT_Model_LoadMapper();
		$data = $load->find($load_id);
		return $data;
	}
	
	public function getNavmanIdforDriver($driver_id){
		$driver = new LLLT_Model_VemploadsMapper();
		$data = $driver->find($driver_id);
		return $data->getNavman_vehicle_id();
	}
	
}