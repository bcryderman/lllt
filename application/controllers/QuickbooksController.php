<?php

class QuickbooksController extends Zend_Controller_SecureAction {
	
	private $emp_id;
	private $_params;
	
	public function init(){
		$this->view->title = 'Quickbooks';
		$auth = Zend_Auth::getInstance()->getIdentity(); 
		$this->emp_id =$auth['Employee']->getEmp_id();
		

	}
	
	public function indexAction(){
		
	}
	
	public function viewAction(){


	}
	
	public function buildwhere(){
		$wherearr =array();
		
		//Default Search params
		$wherearr['delivery_date']= ' IS NOT NULL ';
		
		
		
		if(isset($this->_params['carrier_id'])&& $this->_params['carrier_id']>0){
			$wherearr['carrier_id'] = ' = '.$this->_params['carrier_id'];
		}
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
		return rtrim($retval,' and ');
	}
	
	public function verifyloadsAction(){
		$request = $this->getRequest();
    	$params = $request->getParams();
    	$load = new LLLT_Model_LoadMapper();
    	
    	if(isset($params['search']))
    	{
    		$this->_params = $params;
    	}
		
    	$this->view->loads = $load->fetchAll($this->buildwhere());
	}
	
	public function updateloadAction(){
	
	    	$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$auth = Zend_Auth::getInstance()->getIdentity(); 
	    $date = date('Y-m-d H:i:s');
		$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$load = array();
    	$load_dispatch = new LLLT_Model_LoadMapper();
		$load['load_id']= $params['load_id'];
		$load['bill_of_lading']=$params['bill_of_lading'];
		$load['net_gallons']=$params['net_gallons'];
		$date1 =date_parse_from_format('m/d/Y',$params['delivery_date']);  
		$load['delivery_date']=date("Y-m-d", mktime($date1['hour'],$date1['minute'], 0, $date1['month'], $date1['day'], $date1['year']));
		$load_dispatch->updatedriverload($load, $load['load_id']);
		//reformat date for screen update only
		$load['delivery_date']=date("m/d/Y", mktime($date1['hour'],$date1['minute'], 0, $date1['month'], $date1['day'], $date1['year']));
		echo json_encode($load);

    	}
	
	
}