<?php

class StandardloadsController extends Zend_Controller_SecureAction {

    public function init() {
	
		$this->view->title = 'Standard Loads';
	}
    
    public function addAction() {
	
	 	$request = $this->getRequest();
    	
	    if ($request->isPost()) {

	    	$params = $request->getParams();
	    	
	    	$errors = $this->validation($params);	    	

		    if (empty($errors)) {
		    	
		    	$auth = Zend_Auth::getInstance()->getIdentity(); 
	    		$date = date('Y-m-d H:i:s');
		    			    	
				$load = new LLLT_Model_Load();
								
				$load->setCarrier_id($params['row_id'])
					 ->setBill_to_id($params['bill_to_id'])
					 ->setShipper_id($params['shipper_id'])
					 ->setOrigin_id($params['origin_id'])
					 ->setCustomer_id($params['customer_id'])
					 ->setDestination_id($params['destination_id'])
					 ->setProduct_id($params['product_id'])
					 ->setDriver_id($params['driver_id'])
					 ->setDelayed_dispatch($params['delayed_dispatch'])
					 ->setLoad_date($params['load_date'])
					 ->setDelivery_date($params['delivery_date'])
					 ->setOrder_number($params['order_number'])
					 ->setBill_of_lading($params['bill_of_lading'])
					 ->setNet_gallons($params['net_gallons'])
					 ->setBill_rate($params['bill_rate'])
					 ->setFuel_surcharge($params['fuel_surcharge'])
					 ->setDiscount($params['discount'])
					 ->setInvoice_date($params['invoice_date'])
					 ->setDispatched(0)
					 ->setNotes(trim($params['notes']))
					 ->setLoad_locked(0)
					 ->setCreated($date)
					 ->setCreated_by($auth['Employee']->getEmp_id())
					 ->setLast_updated($date)
					 ->setLast_updated_by($auth['Employee']->getEmp_id())
					 ->setActive(1);
					
				$loadMapper = new LLLT_Model_LoadMapper();				
				$loadMapper->add($load);
		    	
		    	$this->_redirect('standardloads/view');
		    }
		    else {
		    	
		    	$this->view->errors = $errors;
		    	$this->view->params = $params;	
		
		var_dump($params);	    	
		    }
		}
    
    	$this->view->type = 'add';
    	$this->renderScript('standardloads/form.phtml');
	}
	
	public function tabulardataAction() {
		
		$this->_helper->layout()->disableLayout();
		
		$request = $this->getRequest();
    	$params = $request->getParams();

		$auth = Zend_Auth::getInstance()->getIdentity();

    	$loadMapper = new LLLT_Model_LoadMapper();
    	$loads = $loadMapper->fetchAll('active = 1', array($params['column'] . ' ' . $params['sort'], 'delivery_date asc'));

    	$this->view->loads = $loads;

		$this->renderScript('loads/tabulardata.phtml');
	}
   
    public function viewAction() {
    	
    	$loadMapper = new LLLT_Model_LoadMapper();
    	$loads = $loadMapper->fetchAll('active = 1', array('delivery_date asc'));
    	  	
    	$this->view->loads = $loads;
    }

	public function validation($params) {
    	
    	$errors = array();
		
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
		
		if (empty($params['driver_id'])) {
			
			$errors['driver_id'] = 'You must select a driver.';
		}
		
		if (!empty($params['load_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['load_date']));
			
			if (!$date->isValid()) {
				
				$errors['load_date'] = 'The date you entered is formatted incorrectly.';
			}
		}
		
		if (!empty($params['delivery_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['delivery_date']));
			
			if (!$date->isValid()) {
				
				$errors['delivery_date'] = 'The date you entered is formatted incorrectly.';
			}
		}
		
		/* CHECK NET_GALLONS IS VALID NUMBER */
		/* CHECK BILL_RATE IS VALID NUMBER */
		/* CHECK FUEL_SURCHARGE IS VALID NUMBER */
		/* CHECK DISCOUNT IS VALID NUMBER */
		
		if (!empty($params['invoice_date'])) {
			
			$date = new LLLT_Model_Date(array('date' => $params['invoice_date']));
			
			if (!$date->isValid()) {
				
				$errors['invoice_date'] = 'The date you entered is formatted incorrectly.';
			}
		}

		if (!empty($params['notes']) && strlen($params['notes']) > 1000) {
			
			$errors['notes'] = 'Notes cannot exceed 1,000 characters.';
		}
    	
    	return $errors;
    }
}