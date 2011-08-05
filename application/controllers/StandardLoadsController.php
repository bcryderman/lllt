<?php

class StandardloadsController extends Zend_Controller_SecureAction {

    public function init() {
	
		$this->view->title = 'Standard Loads';
	}
    
    public function addAction() {
	
	 	$request = $this->getRequest();
    	$params = $request->getParams();

	    if ($request->isPost()) {

	    	//$errors = $this->validation($params);	

	    //Check if delayed dispatch is set, if not default the value to zero
		//this is done because if the value is not checked the field is not passed in post.
				if(!isset($params['delayed_dispatch']))
				{$params['delayed_dispatch']=0;}

		//Sets date to NULL if no date is given fro load and delivery dates.
	    if(strlen($params['load_date'] . ' ' .$params['load_time'])>9)
				{$params['load_date'] =$this->formattimes($params['load_date'] . ' ' .$params['load_time']);}
				else
				{$params['load_date']=null;}
				
	    if(strlen($params['delivery_date'] . ' ' .$params['delivery_time'])>9)
				{$params['delivery_date'] =$this->formattimes($params['delivery_date'] . ' ' .$params['delivery_time']);}
				else
				{$params['delivery_date']=null;}

		  	$orders = explode(',',$params['order_number']);
		  	
			foreach ($orders as $row) {
				$params['order_number']=$row;
				
				$load=$this->buildloadobj($params);	
				$loadMapper = new LLLT_Model_LoadMapper();				
				$loadMapper->add($load);
			}				

		    	
		    	//$this->_redirect('standardloads/view');
		   }

	
		
		$this->view->type = 'add';
		$this->view->params = $params;
		$this->renderScript('standardloads/form.phtml');
	}
	
	public function buildloadobj($params){
		
		$auth = Zend_Auth::getInstance()->getIdentity(); 
	    $date = date('Y-m-d H:i:s');
		$load = new LLLT_Model_Load();
							
		$load->setCarrier_id($params['carrier_id'])
			 ->setBill_to_id($params['bill_to_id'])
			 ->setShipper_id($params['shipper_id'])
			 ->setOrigin_id($params['origin_id'])
			 ->setCustomer_id($params['customer_id'])
			 ->setDestination_id($params['destination_id'])
			 ->setProduct_id($params['product_id'])
			 ->setDriver_id($params['driver_id'])
			 ->setDelayed_dispatch($params['delayed_dispatch'])
			 ->setLoad_date($params['load_date'], true)
			 ->setDelivery_date($params['delivery_date'], true)
			 ->setOrder_number($params['order_number'])
			 ->setBill_of_lading($params['bill_of_lading'])
			 ->setNet_gallons($params['net_gallons'])
			 ->setBill_rate($params['bill_rate'])
			 ->setFuel_surcharge($params['fuel_surcharge'])
			 ->setDiscount($params['discount'])
			 ->setInvoice_date(date('Y-m-d', strtotime($params['invoice_date'])))
			 ->setDispatched(0)
			 ->setDelivered(0)
			 ->setNotes(trim($params['notes']))
			 ->setLoad_locked(0)
			 ->setCreated($date)
			 ->setCreated_by($auth['Employee']->getEmp_id())
			 ->setLast_updated($date)
			 ->setLast_updated_by($auth['Employee']->getEmp_id())
			 ->setActive(1)
			 ->setDriver_compartment_number(1);
			 
		return $load;
	}
	
	public function deleteAction() {
		
		$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	$loadMapper = new LLLT_Model_LoadMapper();
	    $load = $loadMapper->find($params['load_id']);
	    	    	
    	if ($request->isPost()) {
    		
    		$loadMapper->delete($load);
	    	
	    	$this->_redirect('standardloads/view');
    	}    	
     	
    	$this->view->load = $load;	
    	$this->view->params = $params;
	}
	
	public function editloadAction(){
		$request = $this->getRequest();
    	$params = $request->getParams();
    	
    	if($request->isPost())
    	{$this->_helper->viewRenderer->setNoRender(true);
    	var_dump($params);
    			$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');

				$load = new LLLT_Model_Load();
								
				$load->setLoad_id($params['load_id'])
					 ->setCarrier_id($params['carrier_id'])
					 ->setBill_to_id($params['bill_to_id'])
					 ->setShipper_id($params['shipper_id'])
					 ->setOrigin_id($params['origin_id'])
					 ->setCustomer_id($params['customer_id'])
					 ->setDestination_id($params['destination_id'])
					 ->setProduct_id($params['product_id'])
					 ->setDriver_id($params['driver_id'])
					 ->setDelayed_dispatch($params['delayed_dispatch'])
					 ->setLoad_date($this->formattimes($params['load_date'] . ' ' .$params['load_time']),true)
				     ->setDelivery_date($this->formattimes($params['delivery_date'] . ' ' .$params['delivery_time']),true)
					 //->setDelivery_date(date('Y-m-d', strtotime($params['delivery_date'])) . ' ' . $params['delivery_time'] . ':00', true)
					 ->setOrder_number($params['order_number'])
					 ->setBill_of_lading($params['bill_of_lading'])
					 ->setNet_gallons($params['net_gallons'])
					 ->setBill_rate($params['bill_rate'])
					 ->setFuel_surcharge($params['fuel_surcharge'])
					// ->setDiscount($params['discount'])
					 ->setInvoice_date(date('Y-m-d', strtotime($params['invoice_date'])))
					// ->setDispatched($params['dispatched'])
					 ->setNotes(trim($params['notes']))
					 ->setLast_updated($date)
					 ->setLast_updated_by($auth['Employee']->getEmp_id())
					 ->setActive($params['active']);
					
				$loadMapper = new LLLT_Model_LoadMapper();				
				$loadMapper->edit($load);
		    	
		    	$this->_redirect('standardloads/view');
    	}
    	else
    	{
    		if(isset($params['load_id']))
    		{
    			$request = $this->getRequest();
    			$params = $request->getParams();
    			$loadMapper = new LLLT_Model_LoadMapper();
    	
    			$this->view->load = $loadMapper->find($params['load_id']);
    		}
    		else//no load id
    		{
    		}
    	}
	}
	
//    public function editAction() {
//    
//		$request = $this->getRequest();
//    	$params = $request->getParams();
//    	
//	    if ($request->isPost()) {
//	    	
//	    	$errors = $this->validation($params);	    	
//
//		    if (empty($errors)) {
//		    	
//		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
//	    		$date = date('Y-m-d H:i:s');
//
//				$load = new LLLT_Model_Load();
//								
//				$load->setLoad_id($params['load_id'])
//					 ->setCarrier_id($params['carrier_id'])
//					 ->setBill_to_id($params['bill_to_id'])
//					 ->setShipper_id($params['shipper_id'])
//					 ->setOrigin_id($params['origin_id'])
//					 ->setCustomer_id($params['customer_id'])
//					 ->setDestination_id($params['destination_id'])
//					 ->setProduct_id($params['product_id'])
//					 ->setDriver_id($params['driver_id'])
//					 ->setDelayed_dispatch($params['delayed_dispatch'])
//					 ->setLoad_date(date('Y-m-d', strtotime($params['load_date'])) . ' ' . $params['load_time'] . ':00', true)
//					 ->setDelivery_date(date('Y-m-d', strtotime($params['delivery_date'])) . ' ' . $params['delivery_time'] . ':00', true)
//					 ->setOrder_number($params['order_number'])
//					 ->setBill_of_lading($params['bill_of_lading'])
//					 ->setNet_gallons($params['net_gallons'])
//					 ->setBill_rate($params['bill_rate'])
//					 ->setFuel_surcharge($params['fuel_surcharge'])
//					 ->setDiscount($params['discount'])
//					 ->setInvoice_date(date('Y-m-d', strtotime($params['invoice_date'])))
//					 ->setDispatched($params['dispatched'])
//					 ->setNotes(trim($params['notes']))
//					 ->setLoad_locked($params['load_locked'])
//					 ->setLast_updated($date)
//					 ->setLast_updated_by($auth['Employee']->getEmp_id())
//					 ->setActive($params['active']);
//					
//				$loadMapper = new LLLT_Model_LoadMapper();				
//				$loadMapper->edit($load);
//		    	
//		    	$this->_redirect('standardloads/view');
//		    }
//		    else {
//		    	
//		    	$this->view->errors = $errors;
//		    	$this->view->params = $params;	
//		    	$this->view->type = 'edit';	    	
//		    }
//		}		
//    	else {
//    		
//	    	$loadMapper = new LLLT_Model_LoadMapper();
//	    	//$load = (array) $loadMapper->find($params['load_id']);
//	    	$load = $loadMapper->find($params['load_id']);	
//	    	$fields = array();
//	    	
//	    	foreach ($load as $k => $v) {
//	  
//	    		$fields[substr($k, 4)] = $load[$k];
//	    	}
//	    	
//	    	$this->view->loadId = $params['load_id'];
//	    	//$this->view->params = $fields;
//	    	$$this->view->params = $load;  
//	    	$this->view->type = 'edit';
//    	}    	
//
//    	$this->renderScript('standardloads/form.phtml');
//    }
	
	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

		$auth = Zend_Auth::getInstance()->getIdentity();

    	$loadMapper = new LLLT_Model_LoadMapper();

		if ($params['column'] === 'origin') {
			
			$loads = $loadMapper->fetchAll(null, 'c4.city ' . $params['sort'] . ', c4.state ' . $params['sort'] . ', c4.name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else if ($params['column'] === 'destination') {
			
			$loads = $loadMapper->fetchAll(null, 'c6.city ' . $params['sort'] . ', c6.state ' . $params['sort'] . ', c6.name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else if ($params['column'] === 'driver') {
			
			$loads = $loadMapper->fetchAll(null, 'e.last_name ' . $params['sort'] . ', e.first_name ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}
		else {
			
			$loads = $loadMapper->fetchAll(null, $params['column'] . ' ' . $params['sort'] . ', l.delivery_date ' . $params['sort']);
		}

    	$this->view->loads = $loads;
	}
   
    public function viewAction() {
    	
    	$loadMapper = new LLLT_Model_LoadMapper();
    	$loads = $loadMapper->fetchAll(null, 'l.delivery_date asc');
    	  	
    	$this->view->loads = $loads;
    }
    
    public function viewloadAction(){
		$request = $this->getRequest();
    	$params = $request->getParams();
    	$loadMapper = new LLLT_Model_LoadMapper();
    	
    	$this->view->load = $loadMapper->find($params['load_id']);

    	
    }

	public function validation($params) {

    	$errors = array();

		if (empty($params['carrier_id'])) {
			
			$errors['carrier_id'] = 'You must select a carrier.';
		}

		if (empty($params['bill_to_id'])) {
			
			$errors['bill_to_id'] = 'You must select a bill to.';
		}
		
		if (empty($params['origin_id'])) {
			
			$errors['origin_id'] = 'You must select an origin.';
		}
		
		if (empty($params['customer_id'])) {
			
			$errors['customer_id'] = 'You must select a customer.';
		}
		
		if (empty($params['destination_id'])) {
			
			$errors['destination_id'] = 'You must select a destination.';
		}
		
		if (empty($params['shipper_id'])) {
			
			$errors['shipper_id'] = 'You must select a shipper.';
		}
		
		if (empty($params['product_id'])) {
			
			$errors['product_id'] = 'You must select a product type.';
		}
		
//		if (empty($params['driver_id'])) {
//			
//			$errors['driver_id'] = 'You must select a driver.';
//		}
		
		if (!empty($params['load_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['load_date']));
					
			if (!$date->isValid()) {
				
				$errors['load_date'] = 'Load Date is formatted incorrectly or an invalid date.';
			}
		}
		
		if (!empty($params['load_time'])) {
			
			$time = new LLLT_Model_Time(array('time' => $params['load_time']));
					
			if (!$time->isValid()) {
				
				$errors['load_time'] = 'Load Time is formatted incorrectly or an invalid time.';
			}
		}
		
		if (!empty($params['delivery_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['delivery_date']));
			
			if (!$date->isValid()) {
				
				$errors['delivery_date'] = 'Delivery Date is formatted incorrectly or an invalid date.';
			}
		}
		
		if (!empty($params['delivery_time'])) {
			
			$time = new LLLT_Model_Time(array('time' => $params['delivery_time']));
					
			if (!$time->isValid()) {
				
				$errors['delivery_time'] = 'Delivery Time is formatted incorrectly or an invalid time.';
			}
		}
		
		if (!empty($params['order_number']) && $params['multiple']) {
			
			$orderNumbers = explode(',', $params['order_number']);
			
			if ($orderNumbers[count($orderNumbers) - 1] === '') {
				
				array_pop($orderNumbers);
			}

			foreach ($orderNumbers as $key => $val) {
				
				if (!is_numeric($orderNumbers[$key])) {
					
					$errors['order_number'] = 'Order numbers must be separated by commas.';
					
					break;
				}
			}
			
			$params['order_number'] = $orderNumbers;
		}
		
		if (!empty($params['net_gallons']) && !is_numeric($params['net_gallons'])) {
			
			$errors['net_gallons'] = 'Net Gallons is formatted incorrectly.';
		}
		
		if (!empty($params['bill_rate']) && !is_numeric($params['bill_rate'])) {
			
			$errors['bill_rate'] = 'Bill Rate is formatted incorrectly.';
		}
		
		if (!empty($params['fuel_surcharge']) && !is_numeric($params['fuel_surcharge'])) {
			
			$errors['fuel_surcharge'] = 'Fuel Surcharge is formatted incorrectly.';
		}
		
		if (!empty($params['discount']) && !is_numeric($params['discount'])) {
			
			$errors['discount'] = 'Discount is formatted incorrectly.';
		}
		
		if (!empty($params['invoice_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['invoice_date']));
			
			if (!$date->isValid()) {
				
				$errors['invoice_date'] = 'Invoice Date is formatted incorrectly or an invalid date.';
			}
		}

		if (!empty($params['notes']) && strlen($params['notes']) > 1000) {
			
			$errors['notes'] = 'Notes cannot exceed 1,000 characters.';
		}
    	
//		if ($params['multiple']) {
//			
//			return array('errors' => $errors, 'params' => $params);	
//		}
    	
		return $errors;
    }
    
public function formattimes($data){
    
    	$date1 =date_parse_from_format('m/d/Y h:i A',$data);

    	$retval =  date("Y-m-d H:i:s", mktime($date1['hour'],$date1['minute'], 0, $date1['month'], $date1['day'], $date1['year']));

    	return $retval;
    }
}