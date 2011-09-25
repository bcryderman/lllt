<?php
class LLLT_Model_NavmanDispatcherMapper {
	
	
	public $_wsdl = 'https://onlineavl2svc-us.navmanwireless.com/OnlineAVL/API/V1.0/Service.asmx?WSDL';
	public $_session_id;
	public $_owner_id;
	public $_request = array();
	public $_logoff;
	public $_data;
	public $_start_time;
	public $_end_time;
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
        	
            $this->setDbTable('LLLT_Model_DbTable_NavmanUtil');
        }
        
        return $this->_dbTable;
    }
		
	public function DoLogin() {
					
		$client = new Zend_Soap_Client($this->_wsdl, array('soapVersion' => SOAP_1_1 ,'encoding' => 'UTF-8'));
		$request = array('request'=>array('Session'=>array('SessionId'=>'00000000-0000-0000-0000-000000000000'),
					  'UserCredential'=>array('UserName'=>'apillltransport','Password'=>'45wSOTLK','ApplicationID'=>'00000000-0000-0000-0000-000000000000','ClientID'=>'00000000-0000-0000-0000-000000000000','ClientVersion'=>''),
						'ClockVerificationUtc'=>0));						
		$result = $client->DoLogin($request);
		$this->_session_id = $result->DoLoginResult->SecurityProfile->Session->SessionId;
		$this->_owner_id = $result->DoLoginResult->SecurityProfile->User->OwnerID;
	}

	public function DoLogoff(){
		$client = new Zend_Soap_Client($this->_wsdl, array('soapVersion' => SOAP_1_2 ,'encoding' => 'UTF-8'));
		$request['request']['Session']['SessionId']=$this->_session_id;
		$result = $client->DoLogoff($request);
		$this->_logoff = $result->DoLogoffResult->OperationStatus;
	}
	
	public function GetMessages(){
		$this->DoLogin();
		$client = new Zend_Soap_Client($this->_wsdl, array('soapVersion' => SOAP_1_2 ,'encoding' => 'UTF-8'));
		$request['request']['Session']['SessionId']=$this->_session_id;
		$request['request']['Version']=0;
		$request['request']['OwnerId']=$this->_owner_id;
		$request['request']['FromDateTime']=str_replace(' ','T',$this->_start_time);//'2011-08-01T10:00:00.000';
		$request['request']['ToDateTime']=str_replace(' ','T',$this->_end_time);//'2011-08-02T00:00:30.000000';
		$this->_data = $client->GetMessages($request);
		$this->DoLogoff();
		return $this->_data;
	}
	
	public function DoSendTextMessage(LLLT_Model_NavmanDispatcher $message){
		$this->DoLogin();
		$client = new Zend_Soap_Client($this->_wsdl, array('soapVersion' => SOAP_1_2 ,'encoding' => 'UTF-8'));
		$request['request']['Session']['SessionId']=$this->_session_id;
		$request['request']['OutgoingMessage']['RecipientIds']['guid']=$message->getDriver_id();
		$request['request']['OutgoingMessage']['MessageType']=$message->getMessage_type();
		$request['request']['OutgoingMessage']['MessageBody']=$message->getMessage_body();
		$request['request']['OutgoingMessage']['ReplyToMessageId']=$this->_owner_id;
		$request['request']['OutgoingMessage']['PriorityReadEnabled']='true';
		$this->_data = $client->DoSendTextMessage($request);
		$this->DoLogoff();
		return $this->_data;
	}
	
	public function GetDrivers(){
		$this->DoLogin();
		$client = new Zend_Soap_Client($this->_wsdl, array('soapVersion' => SOAP_1_2 ,'encoding' => 'UTF-8'));
		$request['request']['Session']['SessionId']=$this->_session_id;
		$request['request']['Version']=0;
		$request['request']['OwnerId']=$this->_owner_id;
		$this->_data = $client->GetDrivers($request);
		$this->DoLogoff();
		return $this->_data;
	}
	
	public function getNavmanUtil($id){

        $result = $this->getDbTable()->find($id);
        
        $row = $result->current();
              	
	    return $row['value'];
	}
	
	public function updateNavmanUtilTime(){
 	
    	$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('id = ?', 1);

		$this->getDbTable()
			 ->update(array('value'=>$this->_end_time), $where);
    }
    
    public function updateNavmanMessageTime($timearr=array('seconds'=>30)){
    	$currtime = $this->getNavmanUtil(1);
		//$currtime = date('Y-m-d H:i:s.u');
    	$date1 = date_parse_from_format('Y-m-d H:i:s.u',$currtime);
    	$this->_start_time = date("Y-m-d H:i:s.u", mktime($date1['hour'],$date1['minute'], $date1['second'], $date1['month'], $date1['day'], $date1['year']));
    	$this->_end_time = date("Y-m-d H:i:s.u", mktime($date1['hour'],$date1['minute'], $date1['second']+ $timearr['seconds'], $date1['month'], $date1['day'], $date1['year']));
    	//echo str_replace(' ','T',$starttime).'<br>'.str_replace(' ','T',$endtime);
    }

}
// <ns:request>
//            <!--Optional:-->
//            <ns:Session>
//               <ns:SessionId>8a2b05ff-bfdb-4683-bb80-dd0b571b5bb9</ns:SessionId>
//            </ns:Session>
//            <ns:Version>0</ns:Version>
//            <ns:OwnerId>8e8eed99-dd75-42b0-8d9a-46e8f50facbd</ns:OwnerId>
//            <ns:FromDateTime>2011-08-01T00:00:00.000</ns:FromDateTime>
//            <ns:ToDateTime>2011-08-02T00:00:00.000</ns:ToDateTime>
//</ns:request>

?>