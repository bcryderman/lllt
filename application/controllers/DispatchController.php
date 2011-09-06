<?php

class DispatchController extends Zend_Controller_SecureAction {
	private $_params;
	private $_search;
	
    public function init() {
    	$auth = Zend_Auth::getInstance()->getIdentity();
    	$this->view->emp_id = $auth['Employee']->getEmp_id();
    	$search = new Zend_Session_Namespace('dispatchsearch');
    	$this->_search = $search;    	
    	
    	$this->defaultsearchsession();
    		   }

    public function indexAction() {
        $vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;
    	$employees = $vemploadsMapper->fetchAll($where,'last_name asc');

    	//$this->view->employees = $employees;
   // var_dump($employees);
    }
    
    public function getdriversAction(){
    	
    	$employeeMapper = new LLLT_Model_VemploadsMapper();
    	$employees = $employeeMapper->fetchAll(null, array('e.last_name asc', 'e.first_name asc'));

    	$this->view->employees = $employees;
    }
    
    public function dispatchmodalAction(){
    	$this->_helper->layout()->disableLayout();
    	$request = $this->getRequest();
    	$params = $this->_request->getParams();
    	//var_dump($params);
    	$fuelsurcharge = new LLLT_Model_FuelsurchargeMapper();
    	//var_dump($fuelsurcharge->getlatest(875));

    	if(isset($params['emp_id'])){
    		
    		if($params['delayed_dispatch']==0 && $params['multi_dispatch']==0)
    		{
    			$this->view->load_data = $params;
    		}
    	
    	}
    	//echo json_encode($params);
    }
    
    public function dispatchAction(){
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
    $request = $this->getRequest();
    $params = $request->getParams();
    
    //Instantiate loads helper
    $dispatcher = $this->_helper->getHelper('loads');
    
    foreach ($params['dispatch']as $row)
    {
    	
    	if($row['delayed_dispatch']==1)
    	{
    		$dispatcher->dispatchload($row,0);
    		$dispatcher->buildloadlog($row,7);
    	}
    	else
    	{
    		$dispatcher->dispatchload($row);
    		$dispatcher->buildloadlog($row,6);
    		$dispatcher->sendnavmanmessage($row['load_id'],$row['driver_id']);
    	}

    }
    //var_dump($params);
    //echo json_encode($params);
    
    }
    
    public function driverloadsAction(){
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	if(isset($params['driverid']))
    	{
    		$this->view->driverinfo = $this->getemployeedata($params['driverid']);
    		$loadMapper = new LLLT_Model_LoadMapper();
    		$this->view->loads = $loadMapper->fetchAll('e.emp_id = '.$params['driverid'], 'l.load_date desc');
    	}
    	
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
    
    public function updateload($load){
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
    	->setDispatched(0)
    	->setNotes($load['notes'])
    	->setLoad_date(date('Y-m-d H:i:s'));
    	
    	$load_dispatch->dispatchload($load_obj);
    	
    }
    
    public function updatedriverloadAction(){
    	$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$auth = Zend_Auth::getInstance()->getIdentity(); 
	    $date = date('Y-m-d H:i:s');
		$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$load_dispatch = new LLLT_Model_LoadMapper();
    	foreach($params['load_data']as $load){

			if(isset($load['delivery_date'])&& strlen($load['delivery_date'])>9)
			{
				$load['delivery_date']=$this->formatdrivertimes($load['delivery_date']);
			}
			else
			{
				unset($load['delivery_date']);
			}

			if(count($load)>1){
				$load_dispatch->updatedriverload($load, $load['load_id']);
			}
    	}
    	
    }
    
    public function formatdrivertimes($data){
    	$day = substr($data,0,2);
    	$month = substr($data,3,2);
    	$year = substr($data,6,4);
    	$hour = substr($data,11,2);
    	$minute = substr($data,14,2);
    	$date1 =date_parse_from_format('m/d/Y h:i A',$data);
    	$retval =  date("Y-m-d H:i:s", mktime($date1['hour'],$date1['minute'], 0, $date1['month'], $date1['day'], $date1['year']));
    	echo $retval;
    	return $retval;
    }
    
    
	public function emptabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();


    	$vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;

		if ($params['column'] === 'last_name') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'last_name ' . $params['sort']);
		}
		else if ($params['column'] === 'dispatched_loads') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'dispatched_loads ' . $params['sort']);
		}
		else if ($params['column'] === 'pending_loads') {
			
			$employees = $vemploadsMapper->fetchAll(null, 'pending_loads ' . $params['sort']);
		}
		else {
			
			$employees = $vemploadsMapper->fetchAll(null, 'last_name ' . $params['sort']);
		}

    	$this->view->data = $employees;
	}
	
	public function loadtabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		


		$request = $this->getRequest();
    	$params = $request->getParams();
		$this->buildsearchsession($params);

    	$loadMapper = new LLLT_Model_LoadMapper();
        $where= $this->buildwhere();

		if ($params['column'] === 'origin') {
			
			$loads = $loadMapper->fetchAll($where, 'c4.city ' . $params['sort'] . ', c4.state ' . $params['sort'] . ', c4.name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else if ($params['column'] === 'destination') {
			
			$loads = $loadMapper->fetchAll($where, 'c6.city ' . $params['sort'] . ', c6.state ' . $params['sort'] . ', c6.name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else if ($params['column'] === 'driver') {
			
			$loads = $loadMapper->fetchAll($where, 'e.last_name ' . $params['sort'] . ', e.first_name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else {
			
			$loads = $loadMapper->fetchAll($where, $params['column'] . ' ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}

    	$this->view->loads = $loads;
    	
	}
	
	public function lockloadAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$auth = Zend_Auth::getInstance()->getIdentity(); 
	    $date = date('Y-m-d H:i:s');
		$request = $this->getRequest();
    	$params = $request->getParams();
    	$load = new LLLT_Model_Load();
    	$load->setLoad_id($params['load_id'])
    	->setLoad_locked($params['load_locked'])
		->setLast_updated($date)
		->setLast_updated_by($auth['Employee']->getEmp_id())
		->setLocked_by($auth['Employee']->getEmp_id());
    	$loadMapper = new LLLT_Model_LoadMapper();

   		$locked = $loadMapper->find($params['load_id']);
   		
   		if($locked->getLoad_locked()==1&& $locked->getLocked_by()!=$auth['Employee']->getEmp_id())
   		{
   			//load is already locked by another employee
   			echo json_encode(array('lock_status'=>'3','locked_by'=>$locked->getLocked_by()));
   		}
   		else
   		{
   			$loadMapper->lockload($load);
   			echo json_encode(array('lock_status'=>$params['load_locked']));
   		}

    	
    	
    	
    	
    	//$loadMapper->edit($load);
	}
    
    public function viewAction() {
	
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$vemploadsMapper = new LLLT_Model_VemploadsMapper();
        $where= NULL;
    	$employees = $vemploadsMapper->fetchAll($where,'last_name asc');

    	$loadMapper = new LLLT_Model_LoadMapper();
    	$loads = $loadMapper->fetchAll(null, 'l.delivery_date asc');

		
    	$this->view->loads = $loads;
    	$this->view->loadsarray = $this->buildloadarray($loads);	
    	$this->view->data = $employees;
    	$this->view->params =$this->_search->dispatchsearch;
    }
    
    
    private function defaultsearchsession(){
    
    	if(!is_array($this->_search->dispatchsearch))
    	{
    		$searchfields=array();
    		$date = date('Y-m-d');
    		$startdate = date_parse_from_format('Y-m-d',$date);
		  	$enddate = date_parse_from_format('Y-m-d',$date);
		  	$searchfields['load_start_date'] = $startdate['year'].'-'.$startdate['month'].'-'.$startdate['day'];
		  	$searchfields['load_end_date'] = $enddate['year'].'-'.$enddate['month'].'-'.$enddate['day'];
		  	$this->_search->dispatchsearch=$searchfields;
    	}

    }
    
    private function buildsearchsession($params){
    	$this->_search->dispatchsearch=$params;
    }
    
    
    
    private function buildwhere(){
    	$this->_params = $this->_search->dsipatchsearch;
    	
    			$wherearr =array();
		

		if(isset($this->_params['shipper_id'])&& $this->_params['shipper_id']>0){
			$wherearr['shipper_id'] = ' = '.$this->_params['shipper_id'];
		}
		if(isset($this->_params['bill_to_id'])&& $this->_params['bill_to_id']>0){
			$wherearr['bill_to_id'] = ' = '.$this->_params['bill_to_id'];
		}
		if(isset($this->_params['customer_id'])&& $this->_params['customer_id']>0){
			$wherearr['customer_id'] = ' = '.$this->_params['customer_id'];
		}
		if(isset($this->_params['customer_id'])&& $this->_params['customer_id']>0){
			$wherearr['customer_id'] = ' = '.$this->_params['customer_id'];
		}
		if(isset($this->_params['origins_id'])&& $this->_params['origins_id']>0 && (!isset($this->_params['origin_id_location'])||strlen($this->_params['origin_id_location'])==0)){
			$wherearr['origins_id'] = ' = '.$this->_params['origins_id'];
		}
		if(isset($this->_params['origins_id_location'])&& $this->_params['origins_id_location']>0){
			$wherearr['origins_id'] = ' = '.$this->_params['origins_id_location'];
		}
		if(isset($this->_params['destination_id'])&& $this->_params['destination_id']>0 && (!isset($this->_params['destination_id_location'])||strlen($this->_params['destination_id_location'])==0)){
			$wherearr['destination_id'] = ' = '. $this->_params['destination_id'];
		}
		if(isset($this->_params['destination_id_location'])&& $this->_params['destination_id_location']>0){
			$wherearr['destination_id'] = ' = '. $this->_params['destination_id_location'];
		}
		if(isset($this->_params['order_number'])&& $this->_params['order_number']>0){
			$wherearr['order_number'] = ' = '. $this->_params['order_number'];
		}
		if(isset($this->_params['bill_of_lading'])&& $this->_params['bill_of_lading']>0){
			$wherearr['bill_of_lading'] = ' = '. $this->_params['bill_of_lading'];
		}
		//Both Net Gallons start and end have values greater than 0
		if(isset($this->_params['net_gallons_start'])&& $this->_params['net_gallons_start']>0 &&
		   isset($this->_params['net_gallons_end'])&& $this->_params['net_gallons_end']>0){
			$wherearr['net_gallons'] = ' >= '. $this->_params['net_gallons_start'].' and net_gallons <= '. $this->_params['net_gallons_end'];
		}
		//If only Net Gallons start has a value
		if(isset($this->_params['net_gallons_start'])&& $this->_params['net_gallons_start']>0 &&
		   (!isset($this->_params['net_gallons_end'])|| $this->_params['net_gallons_end']<= 0 )){
			$wherearr['net_gallons'] = ' = '.$this->_params['net_gallons_start'];
		}
		
		//If both Invoice start and end date have values.
		if(isset($this->_params['invoice_start_date'])&&strlen($this->_params['invoice_start_date'])>0
		  && isset($this->_params['invoice_end_date'])&&strlen($this->_params['invoice_end_date'])>0)
		  {
		  	$startdate = date_parse_from_format('m/d/Y',$this->_params['invoice_start_date']);
		  	$enddate = date_parse_from_format('m/d/Y',$this->_params['invoice_end_date']);
		  	$date1 = $startdate['year'].'-'.$startdate['month'].'-'.$startdate['day'];
		  	$date2 = $enddate['year'].'-'.$enddate['month'].'-'.$enddate['day'];
		  	$wherearr['invoice_date']= ' >= \''.$date1.'\' and invoice_date <= \''.$date2.'\'';
		  }
		//If only Invoice start date is set.  
		if(isset($this->_params['invoice_start_date'])&&strlen($this->_params['invoice_start_date'])>0
		  && (!isset($this->_params['invoice_end_date'])||strlen($this->_params['invoice_end_date'])<=0))
		  {
		  	$startdate = date_parse_from_format('m/d/Y',$this->_params['invoice_start_date']);
		  	$date1 = $startdate['year'].'-'.$startdate['month'].'-'.$startdate['day'];

		  	$wherearr['invoice_date']= ' = \''.$date1.'\'' ;
		  }
		  
			//If both Delivery start and end date have values.
		if(isset($this->_params['delivery_start_date'])&&strlen($this->_params['delivery_start_date'])>0
		  && isset($this->_params['delivery_end_date'])&&strlen($this->_params['delivery_end_date'])>0)
		  {
		  	$startdate = date_parse_from_format('m/d/Y',$this->_params['delivery_start_date']);
		  	$enddate = date_parse_from_format('m/d/Y',$this->_params['delivery_end_date']);
		  	$date1 = $startdate['year'].'-'.$startdate['month'].'-'.$startdate['day'];
		  	$date2 = $enddate['year'].'-'.$enddate['month'].'-'.$enddate['day'];
		  	$wherearr['delivery_date']= ' >= \''.$date1.'\' and delivery_date <= \''.$date2.'\'';
		  }
		//If only delivery start date is set.  
		if(isset($this->_params['delivery_start_date'])&&strlen($this->_params['delivery_start_date'])>0
		  && (!isset($this->_params['delivery_end_date'])||strlen($this->_params['delivery_end_date'])<=0))
		  {
		  	$startdate = date_parse_from_format('m/d/Y',$this->_params['delivery_start_date']);
		  	$date1 = $startdate['year'].'-'.$startdate['month'].'-'.$startdate['day'];

		  	$wherearr['delivery_date']= ' = \''.$date1.'\'' ;
		  }
		
			

		$retval='';
		foreach ($wherearr as $k=>$v)
		{
			$retval = $retval. 'l.'.$k .$v .' and ';
		}
		echo $retval;
		return null;
		//return rtrim($retval,' and ');
    }
    
    private function buildloadarray($loads){
        $loadsarray = array();
    	foreach ($loads as $item){
    		$loadsarray[$item->getLoad_id()]= array('bill_to_id'	=>$item->getBill_to_id(),
    												'shipper_id'	=>$item->getShipper_id(),
    												'destination_id'=>$item->getDestination_id(),
    												'origin_id'		=>$item->getOrigin_id(),
    												'order_number'	=>$item->getOrder_number(),
    												'customer_id'	=>$item->getCustomer_id(),
    												'load_id'		=>$item->getLoad_id());
    	}
    	return $loadsarray;
    }
    
    public function getemployeedata($emp_id){
    	$emp_data = new LLLT_Model_EmployeeMapper();
    	$retval = $emp_data->find($emp_id);

    	return $retval;
    }
    
}