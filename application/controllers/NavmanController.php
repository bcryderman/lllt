<?php
class NavmanController extends Zend_Controller_Action {
	protected $_emp_id;
	
    public function init() { 
    	$auth = Zend_Auth::getInstance()->getIdentity();
    	$this->emp_id = $auth['Employee']->getEmp_id();
    }
    
    public function indexAction(){
    	
    	 $this->_helper->viewRenderer->setNoRender(true);
    	 $dispatcher = $this->_helper->getHelper('loads');
		$this->dispatch_delayed_loads();
    }
    
    public function getmessagesAction(){
    	$seconds = array('seconds'=>3000);
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	$dispatcher = new LLLT_Model_NavmandispatcherMapper();
    	$dispatcher->updateNavmanMessageTime($seconds);
    	$messages = $dispatcher->GetMessages();
    	if (isset($messages->GetMessagesResult->Messages->BaseMessage)){
    				
    		$message_arr = array();
    		$disp_arr = array();
    		$cancel_arr = array();

			if(count($messages->GetMessagesResult->Messages->BaseMessage)>1)
			{
				foreach($messages->GetMessagesResult->Messages->BaseMessage as $row)
		    	{
		    		//Build obj for NavmanMessage
					$message = $this->buildNavmanMessagsobj($row);
					array_push($message_arr,$message);
					
					//Build obj for NavmanDispatch
					if($this->checkMessageDispatch($row->MessageBody)){
					$dispatch = $this->buildNavmanDispatchobj($row);
					array_push($disp_arr,$dispatch);
					}
					
		    		//Build obj for NavmanCancel
//					if($this->checkMessageCancel($row->MessageBody)){
//					$cancel = $this->buildNavmanCancelobj($row);
//					array_push($cancel_arr,$cancel);
//					}
				
				
				//Update Load with Net gallons and BOL
				if($row->IncomingMessage == 'true')
				{
					$this->updateMessageLoad($row->MessageBody);
					
				}
				
				
		    	}
			}
			else //called when only 1 BaseMessage is present
			{
				//Build obj for NavmanMessage
				$message = $this->buildNavmanMessagsobj($messages->GetMessagesResult->Messages->BaseMessage);
				array_push($message_arr,$message);
				
				//Build obj for NavmanDispatch
				if($this->checkMessageDispatch($messages->GetMessagesResult->Messages->BaseMessage)){
				
					$dispatch = $this->buildNavmanDispatchobj($messages->GetMessagesResult->Messages->BaseMessage);
					$array_push($disp_arr,$dispatch);
				}
					
//			    //Build obj for NavmanCancel
//				if(checkMessageCancel($row->MessageBody)){
//					$cancel = $this->buildNavmanCancelobj($messages->GetMessagesResult->Messages->BaseMessage);
//					$array_push($cancel_arr,$cancel);
//					}
//				}

				//Update Load with Net gallons and BOL
				$this->updateMessageLoad($messages->GetMessagesResult->Messages->BaseMessage->MessageBody);
			}
    		
    		
    		foreach($message_arr as $mes_row)
    		{
    			echo $mes_row->getMessage_id().'---'.$this->addtoNavmanMessage($mes_row).'<br>';
    			
    		}
    		foreach($disp_arr as $dsip_row)
    		{
    			$this->addtoNavmanDispatch($dsip_row);
    		}
    	   	foreach($cancel_arr as $canc_row)
    		{
    			$this->addtoNavmanCancel($canc_row);
    		}
    	
    		
    	}
    	//Send messages for delayed dispatching
    	$this->dispatch_delayed_loads();
    	
    	//Update the time data for the next run time	
    	$dispatcher->updateNavmanUtilTime();
    }
    
    public function addtoNavmanMessage($item){
    	$message = new LLLT_Model_NavmanMessageMapper();
    	return $message->add($item);
    }
    
    public function addtoNavmanDispatch($item){
    	$message = new LLLT_Model_NavmanDispatchMapper();
 		return $message->add($item);
    }
    
    public function addtoNavmanCancel($item){
    	$message = new LLLT_Model_NavmanCancelMapper();
    	return $message->add($item);
    }
    
    public function checkMessageDispatch($message){
    	//used to check and see if a message body has DISPATCH
    	
    	if(substr($message,0,9)=='DISPATCH:'){return true;}
    	else{return false;}
    }
    
    public function checkMessageCancel($message){
    	//used to check and see if a message body has CANCEL
    	echo substr($message,0,9).'<br>';
    	if(substr($message,0,7)=='CANCEL:'){return true;}
    	else{return false;}
    }
    
   	public function updateMessageLoad($message){
   		//use this to check and see if message is a driver retruning load out info
   		//5473343*30161*7882
   		//OrderNum*BOL*NetGals
   		$arr = explode('*',$message);

   		if(count($arr)==3){
   			$load = new LLLT_Model_LoadMapper();
   			$load_helper = $this->_helper->getHelper('loads');
   			
   			$load_obj = $load->orderexists($arr[0]);
   			//echo $arr[0];var_dump($load_obj);
   			if($load_obj)
   			{  	
   				$fs = $load_helper->getFuelSurcharge($load_obj->getLoad_id());
   				$rate = $load_helper->getRate($load_obj->getLoad_id());
   				$load_arr = array('bill_of_lading'=>$arr[1],
   								  'net_gallons'=>$arr[2],
   								  'fuel_surchage'=>$fs->getFuel_surcharge(),
   								  'bill_rate'=>$rate->getRate(),
   								  'last_updated'=>date('Y-m-d H:i:s'),
   								  'last_updated_by'=>$this->emp_id,
   								  'delivery_date'=>date('Y-m-d H:i'),
   								  'delivered'=>1);
   				$load->updatedriverload($load_arr, $load_obj->getLoad_id());
   				
   				//Send load deliverd message from loads controller helper
    			
   				$load_helper->send_load_delivered_message($load_obj->getOrder_number(),$load_obj->getDriver_id());
   				
   			}
   		}
   	}
   	
 
   	public function dispatch_delayed_loads(){
   		$v_emp_loads = new LLLT_Model_VemploadsMapper();
   		$loads = new LLLT_Model_LoadMapper();
   		$dispatcher = $this->_helper->getHelper('loads');
   		
   		$drivers = $v_emp_loads->fetchall('dispatched_loads = 0 and pending_loads >= 1');

   		foreach($drivers as $row)
   		{
   			$load = $loads->findnextloadfordispatch($row->getEmp_id());
   			$dispatcher->sendnavmanmessage($load->getLoad_id(),$load->getDriver_id());
			$loads->updatedriverload(array('delayed_dispatch'=>0,'dispatched'=>1),$load->getLoad_id());
			$dispatcher->buildloadlog($row,6);
   		}
   	}
   	
	public function buildNavmanCancelobj($row){
    	$load_id = explode('*',$row->MessageBody);
    	$date1 = date_parse_from_format('Y-m-d H:i:s.u',str_replace('T',' ',$row->SentDateTime));
    	
    	$dispobj = new LLLT_Model_NavmanCancel();
		
		//$dispobj->setLoad_id($str[count($str)-1]);
		$dispobj->setLoad_id(1);
		$dispobj->setSent_date(date("Y-m-d H:i:s.u", mktime($date1['hour']-5,$date1['minute'], $date1['second'], $date1['month'], $date1['day'], $date1['year'])));
		$dispobj->setMessage_id($row->MessageID);
		//$dispobj->setSystem_post_date();
		//$dispobj->setNavman_post_date();
		return $dispobj;
    }
    public function buildNavmanDispatchobj($row){
    	$load_id = explode('*',$row->MessageBody);
    	$date1 = date_parse_from_format('Y-m-d H:i:s.u',str_replace('T',' ',$row->SentDateTime));
    	
    	$dispobj = new LLLT_Model_NavmanDispatch();
		
		//$dispobj->setLoad_id($str[count($str)-1]);
		$dispobj->setLoad_id(1);
		$dispobj->setSent_date(date("Y-m-d H:i:s.u", mktime($date1['hour']-5,$date1['minute'], $date1['second'], $date1['month'], $date1['day'], $date1['year'])));
		$dispobj->setMessage_id($row->MessageID);
		//$dispobj->setSystem_post_date();
		//$dispobj->setNavman_post_date();
		return $dispobj;
    }
    
    public function buildNavmanMessagsobj($row){

    			$date1 = date_parse_from_format('Y-m-d H:i:s.u',str_replace('T',' ',$row->SentDateTime));
    			//date("Y-m-d H:i:s.u", mktime($date1['hour'],$date1['minute'], $date1['second'], $date1['month'], $date1['day'], $date1['year']));
    	
    		    $message = new LLLT_Model_NavmanMessage();
				$message->setMessage_body($row->MessageBody)
						->setMessage_id($row->MessageID);
				if(!isset($row->MessageThreadID)||$row->MessageThreadID==null)
				{$message->setMessage_thread_id(0);}
				else
				{$message->setMessage_thread_id($row->MessageThreadID);}
				$message->setNavman_vehicle_id($row->RecipientID)
						->setMessage_date(date("Y-m-d H:i:s.u", mktime($date1['hour']-5,$date1['minute'], $date1['second'], $date1['month'], $date1['day'], $date1['year'])));
				return $message;
    }
    
public function testAction(){
	    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->updateMessageLoad('9999992*111*222');
}
    
}